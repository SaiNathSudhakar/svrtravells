<?
ob_start();
include_once("includes/functions.php");

if(!empty($_SESSION[$svra.'ag_id'])) { agent_login_check(); } else { cust_login_check(); }

$q = "select ag_fname, ag_lname, ba_ag_id, ba_id, ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_fare, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_departure_time, ba_arrival_time, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_name, ba_age, ba_mobile, ba_email, ba_address, ba_id_proof, ba_id_no, ba_order_status, ba_seat_status, ba_refund_amount, ba_cancel_charges from svr_api_orders as ba
	left join svr_agents as ag on ag.ag_id = ba.ba_ag_id 
		where ba_id = '".$_GET['id']."'"; //echo $q; exit;
$qur = query($q); $row = fetch_array($qur);

if(!empty($_SESSION[$svra.'ag_id'])){ 
	if($row['ba_ag_id'] != 0 && $row['ba_ag_id'] != $_SESSION[$svra.'ag_id'])
		header('location:agent-account.php');
} else { 
	if($row['ba_cust_id'] != 0 && $row['ba_cust_id'] != $_SESSION[$svr.'cust_id'])
		header('location:customer-account.php');
}
if($row['ba_journey_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') { 
	$jdate = date('F d, Y',strtotime($row['ba_journey_date'])); } else { $jdate = ''; }

?>
<style type="text/css">
body,td,th{font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;}
.mb10{ margin-bottom:10px; } .mt10{ margin-top:10px;}
</style>
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" class="curve-border">
	  <tr>
        <td width="25" colspan="2" valign="top" align="center">
		<h2><?=$row['ba_source_name'];?> &rarr; <?=$row['ba_destination_name'];?></h2>
		<? if($row['ba_ticket_no'] != '' || $row['ba_total_fare'] != ''){?>
		<div class="mb10"><b><?=($row['ba_ticket_no'] != '') ? 'Ticket: '.$row['ba_ticket_no'] : '';?>
		<?=($row['ba_total_fare'] != '') ? 'Fare: Rs. '.$row['ba_total_fare'] : '';?></b></div><? }?>
		On <?=$jdate;?> at <?=$row['ba_departure_time'];?>
		</td>
      </tr>
	  <tr>
        <td width="25%" colspan="2" valign="top" align="center"></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Passenger Name </strong></td>
        <td valign="top" bgcolor="#F3F3F3"><? $cust = explode('|', $row['ba_name']); echo ucwords(strtolower($cust[0]));?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Passenger E-Mail</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_email'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Passenger Mobile</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_mobile'];?></td>
      </tr>
	  <? if($row['ba_ag_id']){?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Agent</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_fname'].' '.$row['ag_lname'];?></td>
      </tr>
	  <? } if($row['ba_ticket_no'] != ''){?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Ticket No</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_ticket_no'];?></td>
      </tr>
	  <? } if($row['ba_travels_name'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Bus Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_travels_name'];?></td>
      </tr>
	  <? } if($row['ba_travels_type'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Bus Type</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_travels_type'];?></td>
      </tr>
	  <? } ?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Status</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$api_order_status[$row['ba_order_status']];?></td>
      </tr>
	  <? $seats = explode('|', $row['ba_seat_no']);
		$seat_status = explode('|', $row['ba_seat_status']);
		if($row['ba_seat_no'] != '') {
	  	if($row['ba_order_status'] != 5) {
			$seats_arr = array();
	  		$seats = str_replace('|', ', ', $row['ba_seat_no']); 
			$seats_arr = explode(', ', $seats);
		} else {
			$canc_seats_arr = $booked_seats_arr = $canc_fare_arr = $booked_fare_arr = array();
			
			$all_seats = array_combine($seats, $seat_status); 
			foreach($all_seats as $seat => $status) {
				if($status == 0) $canc_seats_arr[] = $seat;
				if($status == 1) $booked_seats_arr[] = $seat;
			}
			$canc_seats = implode(', ', $canc_seats_arr); 
			$booked_seats = implode(', ', $booked_seats_arr); 
			
			$all_fares = array_combine(explode('|', $row['ba_fare']), $seat_status); 
			foreach($all_fares as $fare => $status) {
				//if($status == 0) $canc_fare_arr[] = $fare;
				if($status == 1) $booked_fare_arr[] = $fare;
			}
			//$canc_fare = array_sum($canc_fare_arr); 
			$booked_fare = array_sum($booked_fare_arr);
			$canc_fare = array_sum(explode('|', $row['ba_cancel_charges'])); 
			$refund_fare = array_sum(explode('|', $row['ba_refund_amount']));
		}
		$all_passengers = array_combine(explode('|', $row['ba_name']), $seat_status); 
		foreach($all_passengers as $pass => $status) {
			if($status == 0) $canc_pass_arr[] = $pass;
			if($status == 1) $booked_pass_arr[] = $pass;
		}
	  ?>
      <? if($row['ba_order_status'] != 5) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat(s) Count</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=count($seats_arr);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat No.s</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$seats;?></td>
      </tr>
      <? } if($row['ba_order_status'] == 5) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat(s) Count</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Booked: '.count($booked_seats_arr).' Cancelled: '.count($canc_seats_arr);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat No.s</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Booked: '.$booked_seats.' Cancelled: '.$canc_seats;?></td>
      </tr>
	  <? }}?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>From Location</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_source_name'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>To Location</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_destination_name'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Total Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><!--<span class="rupee">&#x20B9;</span>--> 
        <?  /*if($row['ba_order_status'] != 5) {
				echo 'Rs. '.number_format($row['ba_total_fare'], 2);
			} else {
				echo 'Booked: Rs. '.$booked_fare.'<br>Cancel: Rs. '.$canc_fare.'<br>Refund: Rs. '.$refund_fare;
			}*/ echo 'Rs. '.number_format($row['ba_total_fare'], 2);
		?></td>
      </tr>
      <? if($row['ba_order_status'] == 5) {?>
      <!--<tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Cancelled Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs. '.$booked_fare;?></td>
      </tr>-->
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Cancel Charges</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs. '.$canc_fare;?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Refund Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs. '.$refund_fare;?></td>
      </tr>
      <? }?>
      <? if($row['ba_order_status'] == 4) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Refund Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs. '.array_sum(explode('|', $row['ba_refund_amount']));;?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Cancel Charges</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs. '.array_sum(explode('|', $row['ba_cancel_charges']));?></td>
      </tr>
      <? }?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>No. of Persons</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><? if($row['ba_order_status'] != 5) { $per = $row['ba_no_passenger']; } else {
				$per = 'Booked: '.count($booked_seats_arr).'&nbsp;Cancelled: '.count($canc_seats_arr); }
				echo $per; ?>
		<? //echo sizeof($booked_pass_arr).' ('.implode(', ', $booked_pass_arr).')'; 
		//=$row['ba_no_passenger']; //echo ' ('.(str_replace('|', ', ', ucwords(strtolower($row['ba_name'])))).')';?></td>
      </tr>	  
	  <? if($jdate != '' ) {?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Journey Date</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$jdate;?></td>
      </tr>
	  <? } if($row['ba_departure_time'] != '') {?>
	  <tr>
	    <td valign="top" bgcolor="#F3F3F3"><strong>Departure Time</strong></td>
	    <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_departure_time'];?></td>
	  </tr>
	  <? } if($row['ba_arrival_time'] != '') {?>
	  <tr>
	    <td valign="top" bgcolor="#F3F3F3"><strong>Arrival Time</strong></td>
	    <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_arrival_time'];?></td>
	  </tr>
	 <? } if($row['ba_boarding_location'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Boarding Location</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_boarding_location'];?></td>
      </tr>  
	  <? } if($row['ba_address'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Passenger Address</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_address'];?></td>
      </tr>
	  <? } if($row['ba_id_proof'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Passenger ID Proof</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_id_proof'];?></td>
      </tr>
	  <? } if($row['ba_id_no'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Passenger ID Number</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ba_id_no'];?></td>
      </tr>
	  <? }?>
    </table></td>
  </tr>
</table>