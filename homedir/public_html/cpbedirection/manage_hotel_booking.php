<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('busbook',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

$len = 10; $start = 0;
$link = "manage_hotel_booking.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
 
$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['ar_ag_id']);
	unset($_SESSION['cb_search']);
	unset($_SESSION['cb_agent']);
	unset($_SESSION['cb_req_status']);
	header("location:manage_hotel_booking.php");
}
if(!empty($_GET['req_status']))
{
	$_SESSION['cb_req_status'] = $_GET['req_status'];
	header('location:manage_hotel_booking.php');
}
$cond .= (isset($_SESSION['cb_req_status'])) ? " and ba_order_status = '".$_SESSION['cb_req_status']."'" : "";

if(!empty($_GET['ag_id']))
{
	$_SESSION['cb_agent'] = $_GET['ag_id'];
	header('location:manage_hotel_booking.php');
}
$cond .= (!empty($_SESSION['cb_agent'])) ? " and ag_id = '".$_SESSION['cb_agent']."'" : "";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$_SESSION['cb_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	header('location:manage_hotel_booking.php');
}

if(!empty($_SESSION['cb_search'])){
	$search = array('ba_unique_id', 'ord_order_id', 'ord_journey_date', 'ord_return_date', 'ba_name', 'ba_mobile');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".trim($_SESSION['cb_search'])."%')";
	}
	$cond.=')';
}

$page_query = query("select * from svr_hotel_booking as hb
					left join svr_book_order as bo on bo.ord_id=hb.hb_ord_id_fk
						left join svr_api_orders as api on api.ba_id = hb.hb_ba_id_fk 
							where 1 and $cond ");
$total = num_rows($page_query);
$result = query("select * from svr_hotel_booking as hb
					left join svr_book_order as bo on bo.ord_id=hb.hb_ord_id_fk
						left join svr_api_orders as api on api.ba_id = hb.hb_ba_id_fk 
							where 1 and $cond order by hb_added_date desc limit $start, $len"); //ba_request_status = 1

if(!empty($_GET['o_id'])){
	$confirm_update = query("update svr_book_order set ord_status=2 where ord_id='".$_GET['o_id']."'");
	header("location:manage_hotel_booking.php");
}
if(!empty($_GET['c_id'])){
	$cancel_update = query("update svr_book_order set ord_status=3 where ord_id='".$_GET['c_id']."'");
	$cancel_update_reload = query("update svr_packages set pkg_seats_available=pkg_seats_available+".$_GET['seats']." where pkg_id='".$_GET['pkgid']."'");
	header("location:manage_hotel_booking.php");
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
<script language="javascript" src="../js/script.js"></script></head>
<body>
<form name="yellow_cat" id="yellow_cat" method="post" action="">
<table width="92%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
			  <strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo;  Bus Bookings  &raquo; Hotels &raquo; Bookings Summary</strong></td>
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
		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		    <tr>
		      <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
				<tr>
				  <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
				  <td width="0" align="left" valign="middle">
				  
                  <input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['cb_search'])){ echo $_SESSION['cb_search'];}?>" size="20"/>
				  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
				  <? if($_SESSION['cb_search'] != '' || $_SESSION['cb_agent'] != '' || $_SESSION['cb_req_status'] != ''){ ?>
					  <img src="images/reset.png" onclick="javascript:window.location='manage_hotel_booking.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
					<? }?>
                    
                    </td>
				</tr>
                </table></td>
		      </tr>
		    <tr><td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="2%" height="20" class="tablehead">S.No</td>
            <td class="tablehead">Customer Details</td>
			<td class="tablehead" >Bus Order Id</td>
			<td align="center" class="tablehead">Hotel Order Id</td>
            <td align="center" class="tablehead">Bus Fare</td>
            <td align="center" class="tablehead">Hotel Charge</td>
			<td align="center" class="tablehead">Total Amount</td>
            <td align="center" class="tablehead">Added Date</td>
			<!--<td align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<td align="center" class="tablehead">Cancel</td>-->
		  </tr>
		  </thead>
		  
		  <?php 
			$count_order = num_rows($result);
		  	$sno = $start; if($count_order>0){
		    while($fetch=fetch_array($result)){
		    $sno++;
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td height="25" align="left" valign="top"><?=$sno;?>.</td>
            <td align="left" valign="top">Name: <? $baname=explode('|', $fetch['ba_name']); echo $baname[0];?><br>Mobile: <?=$fetch['ba_mobile'];?></td>
			<td align="left" valign="top"><a href="javascript:;" onClick="popupwindow('view_bus_booking.php?id=<?=$fetch['ba_id'];?>', 'Title', '750', '550')">
            <?=$fetch['ba_unique_id']?></a></td>
			<td align="center" valign="top"><?=$fetch['ord_order_id']?></td>
			<td align="center" valign="top"><?=number_format($fetch['hb_bus_fare'],2)?></td>
            <td align="center" valign="top"><?=number_format($fetch['hb_hotel_fare'],2)?></td>
            <td align="center" valign="top"><?=number_format($fetch['hb_total_fare'],2)?></td>
            <td align="center" valign="top"><?=date('M d, Y', strtotime($fetch['hb_added_date']));?></td>
			<!--<td width="3%" align="center"><a href="javascript:;" onClick="popupwindow('view_hotel_booking.php?id=<?=$fetch['ord_id'];?>', 'Title', '750', '550')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>-->
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