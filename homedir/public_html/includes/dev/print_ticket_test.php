<? 
include_once("includes/functions.php");
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";

/*$q = mysql_query("select ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_total_fare, ba_trip_id, ba_order_status, ba_ticket_no, ba_journey_date, ba_boarding_time, ba_no_passenger, ba_seat_no, ba_travels_name, ba_travels_type, ba_departure_time, ba_boarding_location, ba_email, ba_id_no, ba_id_proof, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_email, ba_mobile, ba_cancel_policy from svr_api_orders_temp where ba_ticket_no='".$ticket."'");
$count = mysql_num_rows($q);
$fetch = mysql_fetch_array($q);*/

/*stdClass Object ( 
[busType] => Volvo A/C Seater (2+2) 
[cancellationPolicy] => 0:12:100:0;12:-1:10:0 
[dateOfIssue] => 2015-03-03T18:34:39+05:30 
[destinationCityId] => 6 
[doj] => 2015-03-08T00:00:00+05:30 
[inventoryId] => 100438915270504052 
[inventoryItems] => Array ( 
	[0] => stdClass Object ( 
		[fare] => 1850.00 
		[ladiesSeat] => false 
		[passenger] => stdClass Object ( 
			[address] => Dilsukh nagar 
			[age] => 21 
			[email] => dsnr@svrtravelsindia.com 
			[gender] => MALE 
			[idNumber] => ZTS3372414 
			[idType] => NONE [mobile] => 9052224449 
			[name] => KARTHIK 
			[primary] => true 
			[title] => Mr 
		) 
		[seatName] => D2 
	) 
	[1] => stdClass Object ( 
		[fare] => 1850.00 
		[ladiesSeat] => false 
		[passenger] => stdClass Object ( 
			[age] => 20 
			[gender] => MALE 
			[name] => SAHITH 
			[primary] => false 
			[title] => Mr 
		) 
		[seatName] => E2 
	) 
	[2] => stdClass Object ( 
		[fare] => 1850.00 
		[ladiesSeat] => false 
		[passenger] => stdClass Object ( 
			[age] => 21 
			[gender] => MALE 
			[name] => VIPIN 
			[primary] => false 
			[title] => Mr 
		) 
		[seatName] => D1 
	) 
	[3] => stdClass Object ( 
		[fare] => 1850.00 
		[ladiesSeat] => false 
		[passenger] => stdClass Object ( 
			[age] => 20 
			[gender] => MALE 
			[name] => ARJUN 
			[primary] => false 
			[title] => Mr 
		) 
		[seatName] => E1 
	) 
) 
[partialCancellationAllowed] => false 
[pickUpContactNo] => 
[pickUpLocationAddress] => Behind KTC Busstand EDC complex 040-64649544/9644 
[pickupLocation] => Behind KTC Busstand EDC complex 040-64649544/9644 
[pickupLocationId] => 998420 
[pickupLocationLandmark] => Panjim 
[pickupTime] => 1020 
[pnr] => DAN5733-MARK -3 
[sourceCityId] => 615 
[status] => BOOKED 
[tin] => KD6DT2 
[travels] => Dhanunjaya Bus
)*/

if($ticket != ''){
	$result = getTicket($ticket); //print_r($result); exit;
	$result2 = json_decode($result);
	//var_dump($result2); exit;
	foreach ($result2 as $key => $values) 
	{	
		if(!strcmp($key,'sourceCityId')) { $source = $values; }
		if(!strcmp($key,'destinationCityId')) $destination = $values;
		if(!strcmp($key,'cancellationPolicy')) $canpoly = $values;
		if(!strcmp($key,'partialCancellationAllowed')) $partcan = $values;
		if(!strcmp($key,'pickUpLocationAddress')) $pickUpLocationAddress = $values;
		if(!strcmp($key,'pickupLocation')) $pickupLocation = $values;
		if(!strcmp($key,'pickupLocationLandmark')) $pickupLocationLandmark = $values;
		if(!strcmp($key,'pickupTime')) $pickupTime = date('h:i A', mktime(0,$values));
		if(!strcmp($key,'status')) $status = $values;
		if(!strcmp($key,'tin')) $tin = $values;
		if(!strcmp($key,'busType')) $busType = $values;
		if(!strcmp($key,'travels')) $travels = $values;
		if(!strcmp($key,'dateOfIssue')) {
			list($dateOfIssue, $timeofIssue) = explode('T', $values);
		} if(!strcmp($key,'doj')) {
			list($doj, $toj) = explode('T', $values);
		}
		if(!strcmp($key, 'inventoryItems')) {
			$inventoryItems = $values;
		}
	}
}
//echo sizeof($inventoryItems); exit;
//var_dump($inventoryItems); exit;
  foreach ($inventoryItems as $key => $values) 
  {   
	  if(is_object($values)){
		  foreach ($values as $k => $v)
		  { 
			if(!strcmp($k, 'fare'))
			{
				/*if(is_array($v))
				{
					foreach($v as $k1=> $v1)
					{
						$fare[][$k1]=$v1;
					}
				}
				else
				{ */ 
					$fare[]=$v;
				//}
			}
			if(!strcmp($k, 'ladiesSeat')) $ladiesSeat[]=$v;
			if(!strcmp($k, 'seatName'))	$seatName[]=$v;
			if(!strcmp($k, 'passenger'))
			{
				if(is_object($v))
				{
					foreach($v as $k1 => $v1)
					{
						$passenger[][$k1]=$v1;
					}
				}
				/*else
				{  
					$passenger[]=$v;
				}*/
			}
		  }
	 
	  }  else {
	  
	  	if(!strcmp($key, 'fare')){ $fare[] = $values; }
		if(!strcmp($key, 'ladiesSeat')){ $ladiesSeat[] = $values; }
		if(!strcmp($key, 'passenger')){ 
			if(is_object($values))
			{
				foreach($values as $k1 => $v1)
				{
					$passenger[][$k1]=$v1;
				}
			}
			else
			{  
				$passenger[]=$values;
			}
		}
		if(!strcmp($key, 'seatName')){ $seatName[] = $values; }
	  }
	   //print_r($value); exit;
	   /*foreach ($value as $k => $v) 
	   {         
		 foreach ($v as $k1 => $v1)
		 {
		   if(isset($v->name))
		   {
				$user_age[$i] = $passenger[$i]['age'];
				$user_primary[$i] = $passenger[$i]['primary'];
				$user_name[$i] = $passenger[$i]['name'];
				$user_title[$i] = $passenger[$i]['title'];
				$user_gender[$i] = $passenger[$i]['gender'];
				if ($i==0) 
				{
					$user_idproof_type = $passenger[$i]['idType'];
					$user_email = $passenger[$i]['email'];
					$user_id_no = $passenger[$i]['idNumber'];
					$user_address = $passenger[$i]['address'];
					$user_mobile = $passenger[$i]['mobile'];
				}
				$user_seatName[$i] = $inventoryItems[$i]['seatName'];
				$user_ladiesSeat[$i] = $inventoryItems[$i]['ladiesSeat'];
				$passenger[$i] = $inventoryItems[$i]['passenger'];
				$user_fare[i] = $inventoryItems[$i]['fare'];
		   }
		 }
	  }*/
  }
  var_dump($fare); exit;
?>
<table class="mt10"><? if($tin != '') { ?><tr><td>
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
		  <td width="75%" height="25"><strong><?=getSourceName($source);?> &rarr; <?=getDestinationName($source, $destination);?></strong></td>
	   </tr>
	   <tr>
	     <td height="25"><strong>Date</strong></td>
	     <td align="left"><strong><?=date('d-m-Y', strtotime($doj));?></strong></td>
	     </tr>
	   <tr>
		  <td height="25"><strong>Bus Operator</strong></td>
		  <td align="left" style="font-size:15px;font-weight:bold;color:#333;"><?=$travels;?></td>
	   </tr>
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
					  <td width="61%" height="20"> <strong><?=$tin;?></strong></td>
				   </tr>
				   <tr>
					  <td>Ticket #</td>
					  <td height="20"> <?=$tin;?></td>
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
		  <td width="22%" valign="middle"><strong>Age</strong></td>
		  <td width="22%" valign="middle"><strong>Seat Name</strong></td>
		  <td width="22%" valign="middle"><strong>Contact Number</strong></td>
	   </tr>
	   <? 
	   $seats = explode('|', $fetch['ba_seat_no']);
	   $title = explode('|', $fetch['ba_title']);
	   $name = explode('|', $fetch['ba_name']);
	   $age = explode('|', $fetch['ba_age']);
	   $gender = explode('|', $fetch['ba_gender']);
	   foreach($seats as $key => $value) {?>
	   <tr>
		  <td height="30"><?=$title[$key].' '.$name[$key];?></td>
		  <td height="30"><?=$age[$key];?></td>
		  <td><strong><?=$value;?></strong></td>
		  <td><?=($key == 0) ? $fetch['ba_mobile'] : '';?></td>
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
		  <td height="18"><?=$travels;?></td>
		  <td align="center"><?=date('h:i A', strtotime('-30 minutes', strtotime($pickupTime)));?></td>
		  <td align="center"><?=$pickupTime;?></td>
		  <td rowspan="5" valign="top" style="line-height:20px;">
		  <strong>Location :</strong> <?=$pickupLocation;?><br>
		  <strong>Landmark :</strong> <?=$pickupLocationLandmark;?><br>
		  <strong>Address :</strong> <?=$pickUpLocationAddress;?><br>
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
		<td><? //=$fetch['ba_total_fare'];?></td>
		<td><? //=$fetch['ba_id_proof'];?></td>
		<td><? //=$fetch['ba_id_no'];?></td>	 
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
	   <? 	$journey_date = $doj.' '.$pickupTime;
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