<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('busbook',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

$len = 10; $start = 0;
$link = "manage_bus_booking.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
 
$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['cb_search']);
	unset($_SESSION['cb_agent']);
	unset($_SESSION['cb_req_status']);
	header("location:manage_bus_booking.php");
}
if(!empty($_GET['req_status']))
{
	$_SESSION['cb_req_status'] = $_GET['req_status'];
	header('location:manage_bus_booking.php');
}
$cond .= (isset($_SESSION['cb_req_status'])) ? " and ba_order_status = '".$_SESSION['cb_req_status']."'" : "";

if(!empty($_GET['ag_id']))
{
	$_SESSION['cb_agent'] = $_GET['ag_id'];
	header('location:manage_bus_booking.php');
}
$cond .= (!empty($_SESSION['cb_agent'])) ? " and ag_id = '".$_SESSION['cb_agent']."'" : "";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$_SESSION['cb_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	header('location:manage_bus_booking.php');
}

if(!empty($_SESSION['cb_search'])){
	$search = array('ba_unique_id', 'ba_trip_id', 'ba_ticket_no', 'ba_source_name', 'ba_destination_name', 'ba_travels_name', 'ba_travels_type', 'ba_boarding_location', 'ba_boarding_time', 'ba_total_fare', 'ba_arrival_time', 'ba_departure_time', 'ba_address', 'ba_email', 'ba_mobile', 'ba_id_no', 'ba_id_proof', 'ba_name');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".trim($_SESSION['cb_search'])."%')" ;
	}
	$cond.=')';
}

$page_query = mysql_query("select ba_id from svr_api_orders	where $cond and ba_status = 1");
$total = mysql_num_rows($page_query);
$result = mysql_query("select * from svr_api_orders	where $cond and ba_status = 1 order by ba_id desc limit $start, $len"); //ba_request_status = 1

if(!empty($_GET['o_id'])){
	$confirm_update = mysql_query("update svr_api_orders set ba_status=2 where ba_id='".$_GET['o_id']."'");
	header("location:orders.php");
}
if(!empty($_GET['c_id'])){
	$cancel_update = mysql_query("update svr_api_orders set ba_status=3 where book_id='".$_GET['c_id']."'");
	$cancel_update_reload = mysql_query("update svr_packages set pkg_seats_available=pkg_seats_available+".$_GET['seats']." where pkg_id='".$_GET['pkgid']."'");
	header("location:orders.php");
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
			  <strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Agents &raquo; Online Bus Bookings</strong></td>
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
				  <select name="agent" id="agent" onchange="javascript:window.location='manage_bus_booking.php?ag_id='+this.value">
                    <option value="">Select Agent</option>
                    <? 	$q = mysql_query("select ag_id, ag_fname, ag_lname from svr_agents where ag_status = 1");
                        while($fetch = mysql_fetch_array($q)){ ?>
                    <option value="<?=$fetch['ag_id'];?>"
                    <? if($_SESSION['cb_agent'] == $fetch['ag_id']){?>selected<? }?>>
                    <?=$fetch['ag_fname'].' '.$fetch['ag_lname']; ?></option><? }?>
                  </select>
                  <input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['cb_search'])){ echo $_SESSION['cb_search'];}?>" size="20"/>
				  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
				  <? if($_SESSION['cb_search'] != '' || $_SESSION['cb_agent'] != '' || $_SESSION['cb_req_status'] != ''){ ?>
					  <img src="images/reset.png" onclick="javascript:window.location='manage_bus_booking.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
					<? }?>
                    <div class="fr">
                    <select name="req_status" id="req_status" onchange="javascript:window.location='manage_bus_booking.php?req_status='+this.value">
                        <option value=" ">Select Status</option>
                        <? 	foreach($api_order_status as $key => $value){ 
						if($key != 0 && $key != 3){?>
                        <option value="<?=$key;?>"
                        <? if(isset($_SESSION['cb_req_status']) && $_SESSION['cb_req_status'] == $key){?>selected<? }?>>
                        <?=$value;?></option><? }}?>
                    </select>
                    </div>
                    </td>
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
			<!--<td align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>-->
			<!--<td align="center" class="tablehead">Cancel</td>-->
		  </tr>
		  </thead>
		  
		  <?php 
			$count_order = mysql_num_rows($result);
		  	$sno = $start; if($count_order>0){
		    while($fetch=mysql_fetch_array($result)){
		    $sno++;
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td height="25" align="left" valign="top"><?=$sno;?>.</td>
			<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="21%"><strong>Name</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><? $baname=explode('|', $fetch['ba_name']); echo $baname[0];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>E-Mail</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ba_email'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>Mobile</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ba_mobile'];?></td>
              </tr>
              <tr>
                <td><strong>Status</strong></td>
                <td align="center"><strong>:</strong></td>
                <td><strong>
				<? switch($fetch['ba_order_status']){ 
						case '0': $color = 'orange'; break;
						case '1': $color = 'blue'; break;
						case '2': $color = 'green'; break;
						case '3': $color = 'magenta'; break;
						case '4': $color = 'red'; break;
						case '5': $color = 'orange'; break;
				   }?>
				<span style="color:<?=$color?>"><?=$api_order_status[$fetch['ba_order_status']];?></span>
				</strong></td>
              </tr>
            </table></td>
			<td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="21%"><strong>From</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=$fetch['ba_source_name'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong>To</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=$fetch['ba_destination_name'];?></td>
              </tr>
              <tr>
                <td width="21%"><strong> Journey</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=date('M d, Y',strtotime($fetch['ba_journey_date']));?></td>
              </tr>
              <tr>
                <td width="21%"><strong> Issue</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><?=date('M d, Y',strtotime($fetch['ba_addeddate']));?></td>
              </tr>
            </table></td>
			<td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td nowrap="nowrap"><strong>Ticket No (PNR)</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td width=""><?=($fetch['ba_ticket_no'] != '') ? $fetch['ba_ticket_no'] : 'Not Available';?></td>
              </tr>
              <tr>
                <td><strong>Bus Type</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td nowrap="nowrap"><? $bttype = $fetch['ba_travels_type'];
				$btravel_type = (strlen($bttype)>20) ? substr($bttype, 0, 20).'...' : $bttype;
				$bttype_hover = (strlen($bttype)>20) ? $bttype : ''; echo "<span title='".$bttype_hover."'>".$btravel_type."</span>";?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>Travels</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><? $tname = $fetch['ba_travels_name'];
				$travel_name = (strlen($tname)>20) ? substr($tname, 0, 20).'...' : $tname;
				$tname_hover = (strlen($tname)>20) ? $tname : ''; echo "<span title='".$tname_hover."'>".$travel_name."</span>";?></td>
              </tr>
              <tr>
                <td nowrap="nowrap"><strong>Seat Nos</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td>
				<? if($fetch['ba_order_status'] != 5) {
					$seats = str_replace('|', ', ', $fetch['ba_seat_no']); 
					$seat_nos = (strlen($seats)>10) ? substr($seats, 0, 7).'...' : $seats;
					$seat_hover = (strlen($seats)>10) ? $seats : ''; 
					?>
					<span title="<?=$seat_hover?>"><?=$seat_nos;?></span>
				<? } else { 
					$canc_seats_arr = $booked_seats_arr = $canc_fare_arr = $booked_fare_arr = array();
					$seats = explode('|', $fetch['ba_seat_no']);
					$seat_status = explode('|', $fetch['ba_seat_status']);
					$all_seats = array_combine($seats, $seat_status); 
					foreach($all_seats as $seat => $status) {
						if($status == 0) $canc_seats_arr[] = $seat;
						if($status == 1) $booked_seats_arr[] = $seat;
					}
					$canc_seats = implode(', ', $canc_seats_arr); 
					$booked_seats = implode(', ', $booked_seats_arr); 
					
					$all_fares = array_combine(explode('|', $fetch['ba_fare']), $seat_status); 
					foreach($all_fares as $fare => $status) {
						if($status == 0) $canc_fare_arr[] = $fare;
						if($status == 1) $booked_fare_arr[] = $fare;
					}
					$canc_fare = array_sum($canc_fare_arr); 
					$booked_fare = array_sum( $booked_fare_arr);
                 	echo 'Booked: '.$booked_seats.'<br>Cancelled: '.$canc_seats;
				}?>
                </td>
              </tr>
            </table></td>
			<td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="14%"><strong>Amount</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td width="">
                <?  if($fetch['ba_order_status'] != 5) {
						echo 'Rs. '.number_format($fetch['ba_total_fare'], 2);
					} else {
						echo 'Rs.'.$booked_fare.'(Booked)<br>Rs.'.$canc_fare.'(Cancel)';
					}
				?>
				<? //='Rs.'.number_format($fetch['ba_total_fare'], 2, '.', '');?></td>
              </tr>
              <tr>
                <td width="14%"><strong> Persons </strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><? if($fetch['ba_order_status'] != 5) { $per = $fetch['ba_no_passenger']; } else {
				$per = 'Booked: '.count($booked_seats_arr).'<br>Cancelled: '.count($canc_seats_arr); }
				echo $per; ?></td>
              </tr>
              <tr>
                <td width="14%" nowrap="nowrap"><strong>Pickup Loc</strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><? $ploc = $fetch['ba_boarding_location'];
				$pickup_loc = (strlen($ploc)>10) ? substr($ploc, 0, 10).'...' : $ploc;
				$ploc_hover = (strlen($ploc)>10) ? $ploc : '';
				echo "<span title='".$ploc_hover."'>".$pickup_loc."</span>";?></td>
              </tr>
              <tr>
                <td width="14%" nowrap="nowrap"><strong> Pickup Time </strong></td>
                <td width="1%" align="center"><strong>:</strong></td>
                <td><?=$fetch['ba_departure_time'];?></td>
              </tr>
            </table></td>
			<!--<td width="3%" align="center"><a href="javascript:;" onClick="popupwindow('view_orders.php?t_id=<?=$fetch['ba_id'];?>', 'Title', '750', '550')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>-->
			<!--<td width="6%" align="center">
			<? if(dateDiff(date('Y-m-d'), $fetch['ba_journey_date']) >= $cancel_before){?>
			<a href="orders.php?c_id=<?=$fetch['ba_id'];?>&seats=<?=$fetch['ba_no_of_persons'];?>&pkgid=<?=$fetch['floc_id'];?>">Cancel</a>
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