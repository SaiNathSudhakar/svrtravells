<? 
include_once "includes/functions.php";
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";

$ticket = !empty($_GET['tin']) ? encrypt_decrypt('decrypt', $_GET['tin']) : $ticket;
$printit = !empty($_GET['printit']) ? encrypt_decrypt('decrypt', $_GET['printit']) : $printit;

$q = query("select ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_boarding_location, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_departure_time, ba_boarding_location, ba_email, ba_id_no, ba_id_proof, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_gender, ba_name, ba_age, ba_email, ba_mobile, ba_cancel_policy, ba_fare, ba_seat_status from svr_api_orders where ba_ticket_no='".$ticket."'");
$count = num_rows($q);
$fetch = fetch_array($q);

$bus_ord_id = getdata('svr_api_orders', 'ba_id', "ba_ticket_no ='".$ticket."'");
$hotel_ord_cnt = getdata('svr_hotel_booking', 'count(*)', "hb_ba_id_fk ='".$bus_ord_id."'");
if($hotel_ord_cnt > 0){ $hotel_ord_id = getdata('svr_hotel_booking', 'hb_ord_id_fk', "hb_ba_id_fk ='".$bus_ord_id."'"); }
if(!empty($hotel_ord_id)){
$hotel_details_qur = query("select * from svr_book_order as bo left join svr_hotel_fares as hf on hf.hfr_id=bo.ord_pkg_id where ord_id =".$hotel_ord_id );
$hotel_count = num_rows($hotel_details_qur);
$hotel_fetch = fetch_array($hotel_details_qur);
}

if($count > 0)
{	
	$seat_status = explode('|', $fetch['ba_seat_status']);
	$chkFullCanc = array_filter($seat_status);
	if(empty($chkFullCanc)) $seat_status = explode('|', str_replace('0', '1', $fetch['ba_seat_status']));
	$seats = explode('|', $fetch['ba_seat_no']);
	$co_seats = array_combine($seats, $seat_status);
	
	$fares = array_combine($seats, explode('|', $fetch['ba_fare']));
	$passengers = array_combine($seats, explode('|', $fetch['ba_name']));
	$gender = array_combine($seats, explode('|', $fetch['ba_gender']));
	$age = array_combine($seats, explode('|', $fetch['ba_age']));
	
	$result = getTicket($fetch['ba_ticket_no']);
	$result2 = json_decode($result);
	
	foreach ($result2 as $key => $values) 
	{	
		if(!strcmp($key,'pickUpContactNo')) $pickUpContactNo = $values;
		if(!strcmp($key,'cancellationPolicy')) $canpoly = $values;
		if(!strcmp($key,'partialCancellationAllowed')) $partcan = $values;
		if(!strcmp($key,'pickupLocation')) $pickupLocation = $values;
		if(!strcmp($key,'pickUpLocationAddress')) $pickUpLocationAddress = $values;
		if(!strcmp($key,'pickupLocationLandmark')) $pickupLocationLandmark = $values;
	}
}
?>

<? if(empty($mailit) && !empty($printit)){ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
	<head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title><?=$fetch['ba_source_name'];?> &rarr; <?=$fetch['ba_destination_name'];?> on <?=date('d-m-Y', strtotime($fetch['ba_journey_date']));?></title>
   </head>
    <body onLoad="window.print();">
<? }?>
<table class="mt10">
<? if($count != '') { ?>

<? if(!empty($mailit) && empty($printit)){
$mytin = encrypt_decrypt('encrypt', $fetch['ba_ticket_no']); 
$printit = encrypt_decrypt('encrypt', 'true');?>
<tr>
<td colspan="6"> 
    <div style="background-color:#f1f1f1;width:98%;padding:10px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;overflow:hidden">
         <a href="<?=$site_url;?>print_ticket.php?tin=<?=$mytin?>&printit=<?=$printit?>" style="border-radius:5px;padding:5px 20px 6px;font-size:14px;color:#666;border:1px solid #ccc;background:rgb(255,255,255);background:-moz-linear-gradient(top,rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);background:-webkit-linear-gradient(top,rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);background:-o-linear-gradient(top,rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);background:-ms-linear-gradient(top,rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);background:linear-gradient(to bottom,rgba(255,255,255,1) 0%,rgba(221,221,221,1) 100%);text-decoration:none;float:right;margin-right:20px" target="_blank">
         Print Ticket
        </a>
    </div>
</td>
</tr>
<? }?>

<tr><td>
<!--<div id="printableArea">-->
<!-- start of container -->
<div style="width:750px; margin:auto; border:2px solid #ccc; padding:10px;" id="printableArea">
<style>.mt10{margin-top:10px;}.mb10{margin-bottom:10px;}</style>
 <!-- start of span_24 -->
 <div style="width:450px; float:left;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td colspan="2"><img src="http://www.svrtravelsindia.com/images/svr-travels.jpg" width="300" /></td>
	   </tr>
	   <tr>
		  <td colspan="2">&nbsp;</td>
	   </tr>
	   <tr>
		  <td width="25%"><strong>Route</strong></td>
		  <td width="75%" height="25"><strong><?=$fetch['ba_source_name'];?> &rarr; <?=$fetch['ba_destination_name'];?></strong></td>
	   </tr>
	   <tr>
	     <td height="25"><strong>Date</strong></td>
	     <td align="left"><strong><?=date('d-m-Y', strtotime($fetch['ba_journey_date']));?></strong></td>
	     </tr>
	   <tr>
		  <td height="25"><strong>Bus Operator</strong></td>
		  <td align="left" style="font-size:15px;font-weight:bold;color:#333;"><?=$fetch['ba_travels_name'];?></td>
	   </tr> 
       <? if(!empty($pickUpContactNo)){?>
       <tr>
		  <td height="25"><strong>Contact</strong></td>
		  <td align="left" style="font-size:15px;font-weight:bold;color:#333;"><?=$pickUpContactNo;?></td>
	   </tr>
       <? }?>
	</table>
 </div>
 <div style="width:300px; float:right;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td height="25"><span style="font-size:15px;font-weight:bold;color:#0099cc;">SVR Travels India Private Limited</span></td>
	   </tr>
	   <tr>
		  <td><strong>Contact No. 040-6999 8289, 040-6550 4140</strong></td>
	   </tr>
	   <tr>
		  <td>
			 <div style="width:275px;padding:5px;margin-top:15px;border:3px double #ccc;">
				<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
				   <tr>
					  <td width="39%">PNR # </td>
					  <td width="61%" height="20"> <strong><?=$fetch['ba_ticket_no'];?></strong></td>
				   </tr>
				   <tr>
					  <td>Ticket #</td>
					  <td height="20"><?=$fetch['ba_ticket_no'];?></td>
				   </tr>
				   <tr>
					  <td>Seat (s)</td>
					  <td height="20"><? $new_seats = array_filter($co_seats); echo implode(', ', array_keys($new_seats));;?></td>
				   </tr>
				</table>
			 </div>
		  </td>
	   </tr>
	</table>
 </div>
 <div style="clear:both;"></div>
 <div style="width:750px;margin-top:15px;padding:5px;height:auto;background:#fcfce1;border-top:1px solid #ffcc00;border-bottom:1px solid #ffcc00;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td width="" height="30" valign="middle"><strong>Passenger Name</strong></td>
		  <td width="" valign="middle"><strong>Age</strong></td>
		  <td width="" valign="middle"><strong>Seat Name</strong></td>
		  <td width="" valign="middle"><strong>Amount</strong></td>
		  <td width="" valign="middle"><strong>Mobile</strong></td>
		  <? if($fetch['ba_email'] != ''){?>
		  <td width="" valign="middle"><strong>Email</strong></td><? }?>
	   </tr>
	   <? 	$j = 0; foreach($co_seats as $seat => $status) { if($status == 1){
	   		$utitle = ($gender[$seat] == 'male') ? 'Mr.' : 'Ms.';?>
	   <tr>
		  <td height="30"><?=$utitle.' '.(ucwords(strtolower($passengers[$seat])));?></td>
		  <td height="30"><?=$age[$seat];?></td>
		  <td><strong><?=$seat;?></strong></td>
		  <td>Rs. <?=$fares[$seat];?></td>
		  <td><?=($j == 0) ? $fetch['ba_mobile'] : '';?></td>
		  <? if($fetch['ba_email'] != ''){?>
		  <td><?=($j == 0) ? strtolower($fetch['ba_email']) : '';?></td><? }?>
	   </tr>
	   <? $j++;}}?>
	</table>
 </div>
 <div style="width:750px;margin-top:15px;padding:5px 5px 15px 5px;height:auto;border-bottom:2px solid #ccc;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td width="23%" height="30"><u><strong>Bus Type</strong></u></td>
		  <td width="25%" align="center"><u><strong>Reporting Time</strong></u></td>
		  <td width="24%" align="center"><u><strong>Departure time</strong></u></td>
		  <td width="28%"><strong>Boarding Point Address</strong></td>
	   </tr>
	   <tr>
		  <td height="18"><?=$fetch['ba_travels_type'];?></td>
		  <td align="center"><?=date('h:i A', strtotime('-30 minutes', strtotime($fetch['ba_boarding_time'])));?></td>
		  <td align="center"><?=$fetch['ba_boarding_time'];?></td>
		  <td rowspan="5" valign="top" style="line-height:20px;">
		  <? if(!empty($pickupLocation)){?>
		  	<strong>Location :</strong> <?=$pickupLocation;?><br>
		  <? } else {?> 
		  	<strong>Location :</strong> <?=$fetch['ba_boarding_location'];?><br>
		  <? }?>
          <? if(!empty($pickUpLocationAddress)){?><strong>Address :</strong> <?=$pickUpLocationAddress;?><br><? }?>
          <? if(!empty($pickupLocationLandmark)){?><strong>Landmark :</strong> <?=$pickupLocationLandmark;?><? }?>
          </td>
	   </tr>
	   <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	   </tr>
	   <tr>
			<td height="30"><u><strong>Total Fare(Rs.)</strong></u></td>
			<td><u><strong>ID Proof </strong></u></td>
			<td><? if($fetch['ba_id_no']){?><u><strong>ID Number</strong></u><? }?></td>
	   </tr>
	   <tr>
			<td><? $fares = array(); $all_fares = explode('|', $fetch['ba_fare']);  
				  foreach($all_fares as $key => $value) if($seat_status[$key] == 1) $fares[] = $value;
				  echo number_format(array_sum($fares), 2);?></td>
			<td><?=$fetch['ba_id_proof'];?></td>
			<td><?=$fetch['ba_id_no'];?></td>	 
	   </tr>
   	   <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	   </tr>
	</table>
    <? if($hotel_count>0){?>
    <hr noshade color="#ffffff" size="0" style="border-bottom: 1px dashed #CCCCCC;">
    <h2 style="color:#000000 !important;"><u>Hotel Details</u></h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td width="20%" align="left" height="28"><u><strong>Hotel Name</strong></u></td>
          <td width="15%" align="left"><u><strong>Check-In Date</strong></u></td>
		  <td width="15%" align="center"><u><strong>Check-Out Date</strong></u></td>
		  <td width="12%" align="center"><u><strong>Persons</strong></u></td>
          <? if($hotel_fetch['ord_seat_number']==0){?>
		  <td width="20%" align="center"><u><strong>Same Day Check-Out</strong></u></td>
		  <? } else {?>
		  <td width="15%" align="center"><u><strong>No. of Nights</strong></u></td>
          <? }?>
          <td width="28%" align="center"><u><strong>Hotel Charge</strong></u></td>
	   </tr>
	   <tr>
       	  <td align="left"><?=$hotel_fetch['hfr_ht_name'];?></td>
		  <td align="left"><?=$hotel_fetch['ord_journey_date'];?></td>
		  <td align="center"><?=$hotel_fetch['ord_return_date'];?></td>
		  <td align="center"><?=$hotel_fetch['ord_no_of_persons'];?></td>
          <? if($hotel_fetch['ord_seat_number']==0){?>
          <td align="center">07:00 AM To 07:00 PM</td>
           <? } else {?>
		  <td align="center"><?=$hotel_fetch['ord_seat_number'];?></td>
          <? } ?>
          <td align="center">Rs. <?=number_format($hotel_fetch['ord_amount'],2);?></td>
	   </tr>
	</table><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
        <tr>
        	<hr noshade color="#ffffff" size="0" style="border-bottom: 1px dashed #CCCCCC;">
           <td width="50%" align="left" height="28"><u><strong>Total Fare (Bus Fare + Hotel Charge)</strong></u></td> 
        </tr>
        <tr>
           <td align="left"><? $fares = array(); $all_fares = explode('|', $fetch['ba_fare']);  
				  foreach($all_fares as $key => $value) if($seat_status[$key] == 1) $fares[] = $value;?>
				  <b><? echo "Rs. "; echo number_format((array_sum($fares) + $hotel_fetch['ord_amount']), 2);?></b>
           </td>
        </tr>	
    </table>
    <? }?>
 </div>
 <div style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;margin-top:10px;">
	<u><strong>Terms and conditions </strong></u>
	<div style="text-align:justify;" class="mt10"><strong>SVR Travels India*</strong> is only a bus ticket agent. It does not operate bus services of its own. In order to provide a comprehensive choice of bus operators, departure times and prices to customers, it has tied up with many bus operators. SVR Travels India advice to customers is to choose bus operators they are aware of and whose service they are comfortable with.</div>
	<div style="text-align:justify;" class="mt10 mb10"><strong>Any issues or grievances related to travel or operator will be entertained within 10 days of post journey. In any case the liability will not be more than the ticket fare.</strong></div>
	<div style="clear:both;"></div>
	<div style="<? if(!empty($canpoly)){ ?>width:350px<? }?>; float:left; line-height:20px;">
	   <u><strong>SVR Travels India is responsible for</strong></u><br />
	   (1) Issuing a valid ticket (a ticket that will be accepted by the bus operator) for its' network of bus operators.<br />
	   (2) Providing refund and support in the event of cancellation<br />
	   (3) Providing customer support and information in case of any delays / inconvenience<br />
	   <br />
	   <u><strong>SVR Travels India is not responsible for</strong></u><br />
	   (1) The bus operator's bus not departing / reaching on time<br />
	   (2) The bus operator's employees being rude<br />
	   (3) The bus operator's bus seats etc not being up to the customer's expectation<br />
	   (4) The bus operator canceling the trip due to unavoidable reasons 
	</div>
	<? if(!empty($canpoly)){ ?>
	<div style="width:375px;float:right;margin:0;padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;margin-top:10px;">
	   <u><strong>Cancellation Policy</strong></u><br />
	   <style>table{font:13px Arial, Helvetica, sans-serif;}</style>
	   <? $journey_date = $fetch['ba_journey_date'].' '.$fetch['ba_departure_time'];
	   	$doj = date('Y-m-d H:i:s', strtotime($journey_date)); ?>
	   <?=cancelPolicy($canpoly, $doj, $partcan,'plain');?>
	</div>
	<? }?>
 </div>
 <div style="clear:both;"></div>
</div>
<!--</div>-->
</td></tr>

<? if(empty($mailit) && empty($printit)){ ?>
<tr><td align="center"><input type="button" class="submit-btn" onClick="printDiv('printableArea')" value="Print Ticket"> </td></tr>
<? }?>

<? } else { ?>
<tr><td align="center" class="msg">No Records Found</td></tr>
<? }?>
</table>

<? if(empty($mailit) && !empty($printit)){ ?>
</body></html>
<? }?>

<? if(empty($mailit) && empty($printit)){ ?>
<script>
/* print
------------------------------*/
function printDiv(divName) {
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}
</script>
<? }?>