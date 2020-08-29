<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['new_orders_manage']) && $_SESSION['new_orders_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

$len=10; $start=0;
$link="agent_bookings.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
 
$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['ab_search']);
	unset($_SESSION['cb_agent']);
	unset($_SESSION['ab_to_date']);
	unset($_SESSION['ab_from_date']);
	unset($_SESSION['ab_ag_id']);
	
	header("location:agent_bookings.php");
}
if(!empty($_GET['ag_id']))
{
	$_SESSION['ab_agent'] = $_GET['ag_id'];
	header('location:agent_bookings.php');
}
if(!empty($_SESSION['ab_agent']))
{ 	
	$cond .= " and ag_id = '".$_SESSION['ab_agent']."'";
}
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$_SESSION['ab_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	$_SESSION['ab_ag_id'] = $_POST['agent'];
	$_SESSION['ab_from_date'] = $_POST['ar_from_date']; 
	$_SESSION['ab_to_date'] = $_POST['ar_to_date'];
	
	header('location:agent_bookings.php');
}
$from = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['ab_from_date'])));
$to = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['ab_to_date'])));

if(!empty($_SESSION['ab_ag_id'])) { 
	$cond .= " and ar_ag_id = '".$_SESSION['ab_ag_id']."'"; 

}
if($from != '0000-00-00' && $to != '0000-00-00' && $from != '1970-01-01' && $to != '1970-01-01') { 
	$cond .= " and ord_added_date between '".$from."' and '".$to."'"; 

}

if(!empty($_SESSION['ab_search'])){
	$search = array('ord_order_id', 'tloc_name', 'ord_amount', 'ag_fname', 'ag_lname', 'cust_fname', 'cust_lname', 'cust_email', 'cust_mobile', 'cust_address_1', 'cust_city', 'cust_state', 'cust_country', 'cust_pincode', 'cat_name', 'ord_seat_number', 'ord_pickup_from', 'ord_pickup_place', 'ord_pickup_place_detail', 'ord_drop_place', 'ord_drop_place_detail', 'ord_emergency_number');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".trim($_SESSION['ab_search'])."%')" ;
	}
	$cond.=')';
}

$result = mysql_query("select concat(ag_fname, ' ', ag_lname) as agent_name, ord_journey_date, ord_return_date, floc_name, floc_id, ord_id, ord_order_id, ord_journey_date, ord_return_date, ord_pkg_id, ord_amount, ord_type, ord_acc_type, ord_room_type, ord_vehicle_type, ord_fc_qty, ord_tot_adult, ord_tot_child, ord_no_of_persons, ord_seat_number, ord_pickup_from, ord_pickup_place, ord_pickup_place_detail, ord_pickup_time, ord_drop_at, ord_drop_place, ord_drop_place_detail, ord_drop_time, ord_emergency_number, ord_comments, ord_total_amount, ord_request_status, ord_added_date, tloc_name, tloc_code, tloc_type, cust_fname, cust_lname, cust_email, cust_mobile, cust_address_1, cust_address_2, cust_city, cust_state, cust_country, cust_pincode, cat_name from svr_book_order as ord
left join svr_agents as ag on ag.ag_id = ord.ord_ag_id
	left join svr_categories as cat on ord.ord_type = cat.cat_id
		left join svr_customers as cust on cust.cust_id = ord.ord_cust_id
			left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
				left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id
					where $cond and ord_request_status = 1 and ord_added_by=1 order by ord_journey_date desc limit $start, $len");

$page_query = mysql_query("select concat(ag_fname, ' ',ag_lname) as agent_name,ord_journey_date, ord_return_date, floc_name, floc_id, ord_id, ord_order_id, ord_journey_date, ord_return_date, ord_pkg_id, ord_amount, ord_type, ord_acc_type, ord_room_type, ord_vehicle_type, ord_fc_qty, ord_tot_adult, ord_tot_child, ord_no_of_persons, ord_seat_number, ord_pickup_from, ord_pickup_place, ord_pickup_place_detail, ord_pickup_time, ord_drop_at, ord_drop_place, ord_drop_place_detail, ord_drop_time, ord_emergency_number, ord_comments, ord_total_amount, ord_request_status, ord_added_date, tloc_name, tloc_code, tloc_type, cust_fname, cust_lname, cust_email, cust_mobile, cust_address_1, cust_address_2, cust_city, cust_state, cust_country, cust_pincode, cat_name from svr_book_order as ord
left join svr_agents as ag on ag.ag_id = ord.ord_ag_id
	left join svr_categories as cat on ord.ord_type = cat.cat_id
		left join svr_customers as cust on cust.cust_id = ord.ord_cust_id
			left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
				left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id
					where $cond and ord_request_status = 1 and ord_added_by=1 order by ord_journey_date desc");
$total=mysql_num_rows($page_query);

if(!empty($_GET['o_id'])){
	$confirm_update = mysql_query("update svr_book_order set ord_status=2 where ord_id='".$_GET['o_id']."'");
	header("location:agent_bookings.php");
}
if(!empty($_GET['c_id'])){
	$cancel_update = mysql_query("update svr_book_order set ord_status=3 where book_id='".$_GET['c_id']."'");
	$cancel_update_reload = mysql_query("update svr_packages set pkg_seats_available=pkg_seats_available+".$_GET['seats']." where pkg_id='".$_GET['pkgid']."'");
	header("location:agent_bookings.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script src="js/script.js" language="javascript"></script>
<script src="../js/script.js" language="javascript"></script>

</head>
<body>
<form name="yellow_cat" id="yellow_cat" method="post" action="">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><img src="images/spacer.gif" border="0" height="5" /></td>
		</tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" />
			  <strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Agents &raquo; Confirmed Bookings</strong></td>
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			  <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
				</tr></table></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>
		  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
		    <tr>
		      <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
					  <td><input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['ab_search'])){ echo $_SESSION['ab_search'];}?>" size="20"/></td>
                      <td width="0" align="left" valign="middle">
					  Agent :
					  <select name="agent" id="agent" onchange="javascript:window.location='agent_bookings.php?ag_id='+this.value">
						<option value="">Select Agent</option>
						<? 	$q = mysql_query("select ag_id, ag_fname, ag_lname from svr_agents where ag_status = 1");
							while($fetch = mysql_fetch_array($q)){ ?>
						<option value="<?=$fetch['ag_id'];?>"
						<? if($_SESSION['ab_agent'] == $fetch['ag_id']){?>selected<? }?>>
						<?=$fetch['ag_fname'].' '.$fetch['ag_lname']; ?></option><? }?>
					  </select>
					  <td> From : </td> <td valign="bottom">
                      <input name="ar_from_date" type="text" class="input fl" id="ar_from_date" style="width:120px;" onfocus="this.placeholder=''" onblur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ab_from_date'])){echo $_SESSION['ab_from_date'];}?>" />
					  </td><td> To : </td> <td valign="middle">
                      <input name="ar_to_date" type="text" class="input fl" id="ar_to_date" style="width:120px;" onfocus="this.placeholder=''" onblur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ab_to_date'])){echo $_SESSION['ab_to_date'];}?>" />
					  </td>
					 <td> <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/></td>
					  
					  <? if(!empty($_SESSION['ab_ag_id']) || !empty($_SESSION['ab_from_date']) || !empty($_SESSION['ab_to_date']) || $_SESSION['ab_search'] != '' || $_SESSION['ab_agent'] != ''){ ?>
                         <td><img src="images/reset.png" onclick="javascript:window.location='agent_bookings.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
                        <? }?></td>
                    </tr>
                </table></td>
		      </tr>
		    <tr><td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="2%" height="20" class="tablehead">S.No</td>
			<td class="tablehead">User Details</td>
			<td class="tablehead">Package Details</td>
			<td align="center" class="tablehead">Order No.</td>
			<td align="center" class="tablehead">Details</td>
			<td align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<!--<td align="center" class="tablehead">Cancel</td>-->
		  </tr>
		  </thead>
		  
		  <?php 
			$count_order = mysql_num_rows($result);
		  	$sno = $start; if($count_order>0){
		    while($fetch=mysql_fetch_array($result)){
		    $sno++;
			list($nights, $days) = (!empty($fetch['tloc_type'])) ? explode('|', $fetch['tloc_type']) : array_fill(0, 2, '');
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td height="25" align="left" valign="top"><?=$sno;?>.</td>
			<td align="left" valign="top"><table border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td><strong>Agent </strong></td>
                <td align="center"><strong>:</strong></td>
                <td><?=$fetch['agent_name']?></td>
              </tr>
              <tr>
                <td width="21%"><strong>Name</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['cust_fname']." ".$fetch['cust_lname'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>E-Mail</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['cust_email'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>Mobile</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['cust_mobile'];?></td>
              </tr>
              <tr>
                <td><strong>City</strong></td>
                <td align="center"><strong>:</strong></td>
                <td><?=$fetch['cust_city'];?></td>
              </tr>
            </table></td>
			<td align="center" valign="top">
			<table border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="21%"><strong>From</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=$fetch['floc_name'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>To</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=$fetch['tloc_name'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>Journey</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=date('M d, Y',strtotime($fetch['ord_journey_date']));?></td>
              </tr>
              <tr>
                <td width="21%"><strong>Return</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=date('M d, Y',strtotime($fetch['ord_return_date']));?></td>
              </tr>
            </table></td>
			<td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td nowrap="nowrap"><strong>Order No</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td width=""><?=$fetch['ord_order_id'];?></td>
              </tr>
              <tr>
                <td><strong>Type</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=$fetch['cat_name'];?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>Package</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=round($days).' Days / '.round($nights).' Nights';?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>Date</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=date('M d, Y', strtotime($fetch['ord_added_date']));?></td>
              </tr>
            </table></td>
			<td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="16%"><strong>Amount</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td width=""><?=$fetch['ord_amount'];?></td>
              </tr>
              <tr>
                <td width="16%"><strong> Persons </strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ord_no_of_persons'];?></td>
              </tr>
              <tr>
                <td width="16%" nowrap="nowrap"><strong>Adults</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ord_tot_adult'];?></td>
              </tr>
              <tr>
                <td width="16%" nowrap="nowrap"><strong> Children </strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ord_tot_child'];?></td>
              </tr>
            </table></td>
			<td width="3%" align="center"><a href="javascript:;" onClick="popupwindow('view_agent_bookings.php?t_id=<?=$fetch['ord_id'];?>', 'Title', '750', '550')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<!--<td width="6%" align="center">
			<? if(dateDiff(date('Y-m-d'), $fetch['ord_journey_date']) >= $cancel_before){?>
			<a href="orders.php?c_id=<?=$fetch['ord_id'];?>&seats=<?=$fetch['ord_no_of_persons'];?>&pkgid=<?=$fetch['floc_id'];?>">Cancel</a>
			<? }?>
			</td>-->
		  </tr>
		  <? 
		  }}
		  else if($count_order == 0){?>
		  <tr><td colspan="13" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
		  <? } ?>
		  </table>
		  </td></tr></table>
		  </td>
		</tr>
		<? if($total > $len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? }?>
		<tr>
		  <td align="center">&nbsp;</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</form>
</body>
</html>