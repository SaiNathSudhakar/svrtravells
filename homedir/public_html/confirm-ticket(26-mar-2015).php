<? ob_start();
include("includes/api-header.php");
include_once("includes/functions.php");
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";
?>
<link rel="stylesheet" href="api/css/generateForm.css" />
<link rel="stylesheet" href="css/form-styls.css" type="text/css" />
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<div class="navigation">
	<div class="bg">
        <a href="index.php">Home</a>
        <span class="divied"></span>
        <a href="BusBooking.php">Bus Booking</a>
        <span class="divied"></span>
        <span class="pagename">Ticket Status</span>
    </div>
</div>
<? //include('travel-info.php');?>
<?php
if(isset($_GET['status']) && !empty($_GET['orderid']))
{	
	$flag = 0; $con = ''; // Pending
	if($_GET['status'] == '1') 
	{	
		$json = $_SESSION[$svr.'jsonobject'];
		$json_2 = json_encode($json);
		$key = blockTicket($json_2);
		//echo 'block key = '.$key;
		$con = confirmTicket($key);
	}
	//echo '<br>con = '.startsWith($con, 'Error'); exit;
	
	if($_GET['status'] == 1){
		if(startsWith($con, 'Error') == 1){
			$flag = 1; //No Ticket; Payment - Refund
		} else {
			//echo "Your Ticket is: ".$con."<br />";
			$flag = 2; //Ticket; Payment - Success
		}
	} else {
		//echo "Payment Failed!";
		$flag = 3; //No Ticket; No Payment - Failure
	}
	$con = ($flag == 2) ? " ba_ticket_no = '".$con."', " : "";
	
	//$flag = 2; $con = " ba_ticket_no = 'TEST', ";
	
	query("update svr_api_orders_temp set $con ba_order_status = '".$flag."' where ba_id = '".$_GET['orderid']."'");
		
	query("INSERT INTO `svr_api_orders` (ba_temp_id, ba_unique_id, ba_trip_id, ba_ticket_no, ba_source, ba_destination, ba_source_name, ba_destination_name, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_total_fare, ba_arrival_time, ba_departure_time, ba_boarding_point, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_gender, ba_address, ba_email, ba_mobile, ba_id_no, ba_id_proof, ba_journey_date, ba_order_status, ba_cust_id, ba_ag_id, ba_added_by, ba_updated_by, ba_addeddate, ba_updateddate, ba_status, ba_cancel_policy, ba_fare, ba_seat_status, ba_refund_amount, ba_cancel_dates, ba_cancel_charges) 
	
		SELECT ba_id, ba_unique_id, ba_trip_id, ba_ticket_no, ba_source, ba_destination, ba_source_name, ba_destination_name, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_total_fare, ba_arrival_time, ba_departure_time, ba_boarding_point, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_gender, ba_address, ba_email, ba_mobile, ba_id_no, ba_id_proof, ba_journey_date, ba_order_status, ba_cust_id, ba_ag_id, ba_added_by, ba_updated_by, ba_addeddate, ba_updateddate, ba_status, ba_cancel_policy, ba_fare, ba_seat_status, ba_refund_amount, ba_cancel_dates, ba_cancel_charges from svr_api_orders_temp WHERE ba_id = '".$_GET['orderid']."' and ba_order_status = 2");
		
	$fkid = insert_id();
		
	unset($_SESSION[$svr.'busbook']);
	unset($_SESSION['order_id']);
	unset($_SESSION['datepicker']);
	unset($_SESSION['chosenone']);
	unset($_SESSION['sourceList']);
	unset($_SESSION['sourceName']);
	unset($_SESSION['destinationList']); 
	unset($_SESSION['destinationName']);
	unset($_SESSION['chkchk']);
	unset($_SESSION['boardingpointsList']);
	unset($_SESSION['boardingTime']);
	unset($_SESSION['boardingLoc']);
	unset($_SESSION['seatnames']);
	unset($_SESSION['fare']);
	unset($_SESSION['canPolicy']);
	unset($_SESSION[$svr.'jsonobject']);
	unset($_SESSION['busrowid']);
	unset($_SESSION['travelName']);
	unset($_SESSION['arrivalTime']);
	unset($_SESSION['departureTime']);
	unset($_SESSION['travelType']);
	unset($_SESSION['canPolicy']);
	
	//$uid = getdata('svr_api_orders', 'ba_unique_id, ba_total_fare', "ba_id='".$_GET['orderid']."'", 'array');
	$q = query("select ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_email, ba_updateddate, ba_addeddate from svr_api_orders_temp where ba_id='".$_GET['orderid']."'");
	$fetch = fetch_array($q);
	
	$booking_date = ($row['ba_updateddate'] != '0000-00-00 00:00:00' && $row['ba_updateddate'] != '1970-01-01 05:00:00') ? $row['ba_updateddate'] : $row['ba_addeddate'];
	if(!empty($_SESSION[$svra.'ag_id']) && $flag == 2)
	{	
		$transc = 'BusBooking';	
		$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
		$op_bal = number_format($op_bal, 2, '.', '');
		$comm = $agent_commission * $fetch['ba_total_fare']; $comm = number_format($comm, 2, '.', ''); 
		$net = number_format($fetch['ba_total_fare'] - $comm, 2, '.', '');
		$cl_bal = number_format($op_bal - $net, 2, '.', ''); 
		
		$ref_id = rand(1000000, 9999999);
		
		//Update Agent Amount
		//query("update svr_agents set ag_deposit = (ag_deposit-".$fetch['ba_total_fare'].") where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		query("update svr_agents set ag_deposit = '".$cl_bal."' where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		$_SESSION[$svra.'ag_deposit'] = $cl_bal; //getdata('svr_agents', 'ag_deposit', "ag_id = '".$_SESSION[$svra.'ag_id']."'");
		
		//Update Agent Report //$fetch['ba_unique_id']
		query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$_SESSION[$svra.'ag_id']."', '".$ref_id."', '".$fetch['ba_ticket_no']."', '', '".$transc."', '".$op_bal."', '".$fetch['ba_total_fare']."', '".$comm."', '".$net."', '".$cl_bal."', '1', '".$fkid."', '".$now_time."')");
		
	}
	$booking_date = ($fetch['ba_updateddate'] != '0000-00-00 00:00:00' && $fetch['ba_updateddate'] != '1970-01-01 05:00:00') ? $fetch['ba_updateddate'] : $fetch['ba_addeddate'];
	
	if($fetch['ba_order_status'] == 1)
	{	
		$data['subject'] = "Your transaction at SVR Travels India has failed";
		
		$data['content'] = "<table width='100%' border='0' align='center' cellpadding='3' cellspacing='2' style='margin:10px;'>
		  <tr>
			<td colspan=3>Dear Customer,</td>
		  </tr>
		  <tr>
			<td colspan=3>We have noticed that you were trying to place an order for ".$fetch['ba_source_name']." to ".$fetch['ba_destination_name']." on ".date('F d, Y',strtotime($booking_date))." at ".date('h:i A',strtotime($booking_date)).". <strong>Your payment of Rs. ".number_format($fetch['ba_total_fare'], 2)." has been deducted</strong> but due to a technical issue the ticket could not be issued.</td>
		  </tr>
		  <tr>
			<td colspan=3>Your trip id is: <u>".$fetch['ba_trip_id']."</u>. Please quote this trip id for all further communication.</td>
		  </tr>
		  <tr>
			<td colspan=3>Please do not worry - your money would be <strong>refunded</strong> within <strong>7 working days.</strong></td>
		  </tr>
		  <tr>
			<td colspan=3>We suggest that you go ahead and book another ticket.</td>
		  </tr>";
		  
	} else if($fetch['ba_order_status'] == 2){
	
		$data['subject'] = "SVR Travels India Ticket - ".$fetch['ba_ticket_no']; 
		
		$data['content'] = "<table width='100%' border='0' align='center' cellpadding='3' cellspacing='2' style='margin:10px;'>
		  <tr>
			<td colspan=3>Dear Customer,</td>
		  </tr>
		  <tr>
			<td colspan=3>Congratulations! Your ticket for ".$fetch['ba_source_name']." to ".$fetch['ba_destination_name']." on ".date('F d, Y',strtotime($booking_date))." at ".date('h:i A',strtotime($booking_date))." has been confirmed.</td>
		  </tr>
		  <tr>
			<td width='15%'><strong>Ticket No</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$fetch['ba_ticket_no']."</td>
		  </tr>";
	}
	
	$data['content'] .= "<tr>
		<td width='15%'><strong>Trip ID</strong></td>
		<td width='3%' align='center'><strong>:</strong></td>
		<td align='left'>".$fetch['ba_trip_id']."</td>
	  </tr>
	  <tr>
		<td nowrap='nowrap'><strong>Journey</strong></td>
		<td align='center'><strong>:</strong></td>
		<td nowrap='nowrap' align='left'>".$fetch['ba_source_name']." --> ".$fetch['ba_destination_name'].", ".(date('F d, Y',strtotime($fetch['ba_journey_date'])))." ".$fetch['ba_boarding_time']."</td>
	  </tr>
	  <tr>
		<td><strong>No. of Persons</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$fetch['ba_no_passenger']."</td>
	  </tr>
	  <tr>
		<td><strong>Seat(s)</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".str_replace('|', ', ', $fetch['ba_seat_no'])."</td>
	  </tr>
	  <tr>
		<td><strong>Total Fare</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>Rs. ".number_format($fetch['ba_total_fare'], 2)."</td>
	  </tr>
	  <tr>
		<td><strong>Travel</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$fetch['ba_travels_name']." ".$fetch['ba_travels_type']."</td>
	  </tr>
	  <tr>
		<td nowrap=nowrap><strong>Boarding Details</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>Boarding from ".$fetch['ba_boarding_location']." - ".$fetch['ba_boarding_time']."</td>
	  </tr>
	  <tr>
		<td colspan=3>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan=3>Best Regards,<br>---<br>Your friends at SVR Travels</td>
	  </tr>
	  <tr>
		<td colspan=3><div><em>E-mail us: <a href='mailto:support@svrtraveslindia.com' target='_blank'>support@svrtraveslindia.com</a></em></div>
		  <div><em>Call us: 040-6999 8289 / 040-6550 4140.</em></div></td>
	  </tr>
	</table>";
	
	$data['to_email'] = $fetch['ba_email'];
	if($fetch['ba_order_status'] == 1 || $fetch['ba_order_status'] == 2){ send_email($data); }
	
	header("location:confirm-ticket.php?uid=".$fetch['ba_unique_id']); //."&oid=".$_GET['orderid']
	
} else if(!empty($_GET['uid'])){ 

	$q = query("select ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_email, ba_updateddate, ba_addeddate from svr_api_orders_temp where ba_unique_id='".$_GET['uid']."'"); //ba_id = '".$_GET['oid']."' and
	$row = fetch_array($q); $num = num_rows($q); if($num <= 0) header('location:BusBooking.php');
	$booking_date = ($row['ba_updateddate'] != '0000-00-00 00:00:00' && $row['ba_updateddate'] != '1970-01-01 05:00:00') ? $row['ba_updateddate'] : $row['ba_addeddate'];
	
} ?>

<div class="inner_content" style="margin-left:0">

<? if($row['ba_order_status'] == 1){ ?>
	<h1>Oops, we could not book seats for your journey. <br>(Trip id : <?=$row['ba_trip_id']?>)</h1>
	<p>Due to some technical reasons we were not able to complete your booking and we have already received an amount of Rs. <?=number_format($row['ba_total_fare'], 2)?></p>
    <p>Don't worry we will try and call you to help complete your booking with trip id : <?=$row['ba_trip_id']?>. Please use this trip id for further communication regarding this booking.</p>
			
<? } else if($row['ba_order_status'] == 2) { ?>
      
	<h1>Congratulations!</h1>
	<p>Your ticket has been confirmed.</p>
	
<? } else if($row['ba_order_status'] == 3) { ?>
	
	<h1>Payment Failure</h1>
	<p>Sorry! Transaction was unsuccessful.</p>
    <p style="height:150px"></p>
	
<? } else if($row['ba_order_status'] == 4) {?>

	<h1>Payment Cancellation</h1>
	<p style="height:150px"></p>
    
<? }?>

<? 
if($row['ba_order_status'] == 1 || $row['ba_order_status'] == 2) {?>
<table width='100%' border='0' align='center' cellpadding='3' cellspacing='2' style='margin:10px;'>
  <tr>
    <th width='15%' colspan='3' align='left'><h2>Travel Details</h2></th>
  </tr>
<? if($row['ba_order_status'] == 2) {?>
  <tr>
    <td width='15%'><strong>Ticket No</strong></td>
    <td width='3%' align='center'><strong>:</strong></td>
    <td align='left'><?=$row['ba_ticket_no']?></td>
  </tr>
<? }?>
  <tr>
    <td width='15%'><strong>Trip ID</strong></td>
    <td width='3%' align='center'><strong>:</strong></td>
    <td align='left'><?=$row['ba_trip_id']?></td>
  </tr>
  <tr>
    <td nowrap='nowrap'><strong>Journey</strong></td>
    <td align='center'><strong>:</strong></td>
    <td nowrap='nowrap' align='left'><?=$row['ba_source_name']." --> ".$row['ba_destination_name'].", ".(date('F d, Y',strtotime($row['ba_journey_date'])))." ".$row['ba_boarding_time']?></td>
  </tr>
  <tr style="display:none">
    <td ><strong>Fare</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'>Rs. <?=number_format(($row['ba_total_fare']/$row['ba_no_passenger']), 2)?></td>
  </tr>
  <tr>
    <td><strong>No. of Persons</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'><?=$row['ba_no_passenger']?></td>
  </tr>
  <tr>
    <td><strong>Seat(s)</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'><?=str_replace('|', ', ', $row['ba_seat_no'])?></td>
  </tr>
  <tr>
    <td><strong>Total Fare</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'>Rs. <?=number_format($row['ba_total_fare'], 2)?></td>
  </tr>
  <tr>
    <td><strong>Travel</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'><?=$row['ba_travels_name']." ".$row['ba_travels_type']?></td>
  </tr>
  <tr>
    <td nowrap=nowrap><strong>Boarding Details</strong></td>
    <td align='center'><strong>:</strong></td>
    <td align='left'>Boarding from <?=$row['ba_boarding_location']." - ".$row['ba_boarding_time']?></td>
  </tr>
</table>

<?  }?>
</div>
<? include("includes/api-footer.php"); ?>