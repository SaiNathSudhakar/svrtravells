<? 
include_once("includes/functions.php");
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";

$q = mysql_query("select ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_departure_time, ba_boarding_location, ba_email, ba_id_no, ba_id_proof, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_email, ba_mobile, ba_cancel_policy from svr_api_orders where ba_ticket_no='".$ticket."'");
$count = mysql_num_rows($q);
$fetch = mysql_fetch_array($q);

if($count > 0){
	$result = getTicket($fetch['ba_ticket_no']);
	$result2 = json_decode($result);
	//var_dump($result2); exit;
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
<table class="mt10"><? if($count != '') { ?><tr><td>
<!--<div id="printableArea">-->
      <!-- start of container -->
<div style="width:750px; margin:auto; border:2px solid #ccc; padding:10px;" id="printableArea">
<style>.mt10{margin-top:10px;}.mb10{margin-bottom:10px;}</style>
 <!-- start of span_24 -->
 <div style="width:450px; float:left;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;">
	   <tr>
		  <td colspan="2"><img src="images/svr-travels.jpg" width="300" /></td>
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
					  <td height="20"> <?=$fetch['ba_ticket_no'];?></td>
				   </tr>
				   <tr>
					  <td>Seat (s)</td>
					  <td height="20"><?=str_replace('|', ', ', $fetch['ba_seat_no']);?></td>
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
		  <td width="34%" height="30" valign="middle"><strong>Passenger Name</strong></td>
		  <td width="12%" valign="middle"><strong>Age</strong></td>
		  <td width="22%" valign="middle"><strong>Seat Name</strong></td>
		  <td width="22%" valign="middle"><strong>Mobile</strong></td>
		  <? if($fetch['ba_email'] != ''){?>
		  <td width="22%" valign="middle"><strong>Email</strong></td><? }?>
	   </tr>
	   <? 
	   $seats = explode('|', $fetch['ba_seat_no']);
	   $title = explode('|', $fetch['ba_title']);
	   $name = explode('|', $fetch['ba_name']);
	   $age = explode('|', $fetch['ba_age']);
	   $gender = explode('|', $fetch['ba_gender']);
	   foreach($seats as $key => $value) {?>
	   <tr>
		  <td height="30"><?=$title[$key].' '.(ucwords(strtolower($name[$key])));?></td>
		  <td height="30"><?=$age[$key];?></td>
		  <td><strong><?=$value;?></strong></td>
		  <td><?=($key == 0) ? $fetch['ba_mobile'] : '';?></td>
		  <? if($fetch['ba_email'] != ''){?>
		  <td><?=($key == 0) ? $fetch['ba_email'] : '';?></td><? }?>
	   </tr>
	   <? }?>
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
          	<strong>Location :</strong> <?=$pickupLocation;?><br>
            <strong>Address :</strong> <?=$pickUpLocationAddress;?><br>
            <strong>Landmark :</strong> <?=$pickupLocationLandmark;?>
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
		<td><? if($fetch['ba_id_no']){?><u><strong>ID Number </strong></u><? }?></td>
		</tr>
	   <tr>
		<td><?=$fetch['ba_total_fare'];?></td>
		<td><?=$fetch['ba_id_proof'];?></td>
		<td><?=$fetch['ba_id_no'];?></td>	 
		</tr>
   	   <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
	</table>
 </div>
 <div style="margin:0; padding:0;color:#333;font:normal 13px Arial, Helvetica, sans-serif;margin-top:10px;">
	<u><strong>Terms and conditions </strong></u>
	<div style="text-align:justify;" class="mt10"><strong>SVR Travels India*</strong> is only a bus ticket agent. It does not operate bus services of its own. In order to provide a comprehensive choice of bus operators, departure times and prices to customers, it has tied up with many bus operators. SVR Travels India advice to customers is to choose bus operators they are aware of and whose service they are comfortable with. </div>
	<div style="text-align:justify;" class="mt10 mb10"><strong>Any issues or grievances related to travel or operator will be entertained within 10 days of post journey. In any case the liability will not be more than the ticket fare.</strong></div>
	<div style="clear:both;"></div>
	<div style="<? if(!empty($canpoly)){ ?>width:350px<? }?>; float:left; line-height:20px;">
	   <u><strong>SeatSeller is responsible for</strong></u><br />
	   (1) Issuing a valid ticket (a ticket that will be accepted by the bus operator) for its' network of bus operators.<br />
	   (2) Providing refund and support in the event of cancellation<br />
	   (3) Providing customer support and information in case of any delays / inconvenience<br />
	   <br />
	   <u><strong>SeatSeller is not responsible for</strong></u><br />
	   (1) The bus operator's bus not departing / reaching on time<br />
	   (2) The bus operator's employees being rude<br />
	   (3) The bus operator's bus seats etc not being up to the customer's expectation<br />
	   (4) The bus operator canceling the trip due to unavoidable reasons 
	</div>
	<? if(!empty($canpoly)){ ?>
	<div style="width:375px; float:right;">
	   <u><strong>Cancellation Policy</strong></u><br />
	   <? 	$journey_date = $fetch['ba_journey_date'].' '.$fetch['ba_departure_time'];
	   		$doj = date('Y-m-d H:i:s', strtotime($journey_date)); ?>
	   <?=cancelPolicy($canpoly, $doj, $partcan,'plain');?>
	</div>
	<? }?>
 </div>
 <div style="clear:both;"></div>
</div>
<!--</div>-->
</td></tr>
<tr><td align="center"><input type="button" class="submit-btn" onclick="printDiv('printableArea')" value="Print Ticket"> </td></tr>
<? } else { ?>
<tr><td align="center" class="msg">No Records Found</td></tr>
<? }?>
</table>
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