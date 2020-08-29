<? 
include "includes/api-header.php";
include_once "includes/api-functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	//echo "hii"; exit;
	
	/*$Sql = "select ba_unique_id, ba_trip_id, ba_ticket_no, ba_source, ba_destination, ba_source_name, ba_destination_name, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_total_fare, ba_arrival_time, ba_departure_time, ba_boarding_point, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_gender, ba_address, ba_email, ba_mobile, ba_id_no, ba_id_proof, ba_journey_date, ba_cancel_policy, ba_cancel_charges, ba_cancel_date, ba_order_status from svr_api_orders where ba_id = '".$_POST['orderid']."'";*/
	
	$Sql = "select ba_journey_date, ba_departure_time from svr_api_orders where ba_id = '".$_POST['orderid']."'";
	$query = mysql_query($Sql);
	$fetch = mysql_fetch_array($query);
	
	$journey_date = $fetch['ba_journey_date'].' '.$fetch['ba_departure_time'];
	
	$result = getTicketInformation('KD6DT2');
	$result2 = json_decode($result);
	//var_dump($result2); exit;
	foreach ($result2 as $key => $values) 
	{	
		if(!strcmp($key,'cancellationPolicy'))
		{
			$canpoly = $values;
		}
		if(!strcmp($key,'partialCancellationAllowed'))
		{
			$partcan = $values;
		}
	}
	echo cancelPolicy($canpoly, $doj, '', ''); exit;
	
	$doj = date('Y-m-d H:i:s', strtotime($journey_date));
	$doc = date('Y-m-d H:i:s');
	if(($doc > $doj)){
		echo "Date Expired."; exit;
	} else {
		$canCharges = canCharges($canpoly, $doj, $doc);
		echo $canCharges; exit;
	}
	
	//$result = getTicket('CUJJVN');
	//$result2 = json_decode($result);
	//var_dump($result2); exit;
	
	//$result = getTicket('CUJJVN');//6H2U27
	//$result2 = json_decode($result);
	//var_dump($result2); exit;
	
	//$result = getCancellationData('CUJJVN');
	//$result2 = json_decode($result);
	//print_r($result2); exit;
	
	/*//{"tin":"S436228AS3","seatsToCancel":["12A","12B"]}
	//cancelTicket(makeCancellationRequest);
	
	$cancelRequest = '';*/
	header('location:CancelBooking.php');
}
?>
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<div class="navigation">
	<div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">Cancel Bus Booking</span></div>
</div>
<!--<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/validation.js"></script>-->
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.fancybox.js" type="text/javascript"></script>
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".various").fancybox({
		/*maxWidth	: 800,
		maxHeight	: 600,*/
		fitToView	: true,
		width		: '600px',
		/*width		: '70%',
		height		: '70%',*/
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterClose  : function() { 
            window.location.reload();
        }
	});/*$('fancybox').fancybox();*/
});
</script>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />

<table cellpadding="10" cellspacing="1" border="0" style="border:1px solid #eaeaea;" width="100%">
<tr bgcolor="#F4F4F4"><td><h2>Cancel Bus Ticket</h2></td></tr>
<tr><td align="left">
<div class="inner_content">                  
<div class="enquiry" align="left">              	
<h2>Cancel Ticket</h2>
<form method='post' name='cancel_booking_1' id='cancel_booking_1'>
	<div class="form_styles form_wrapper">
	<h4 id="txtErrMsg" style="display:none">Ticket with this Email ID does not Exist</h4>
	<h4 id="agErrMsg" style="display:none">Please Login as agent to Cancel This Ticket</h4>
    <div class="fl mb5">Ticket Number</div>
	<input name="ticket" type="text" id="ticket" placeholder="Enter Ticket Number" autocomplete="off">
	<div class="clear" style="line-height:5px">&nbsp;</div>
    <div class="fl mb5">Email ID</div>
	<input name="email" type="text" id="email" placeholder="Enter Email ID" autocomplete="off">
    <div class="fr">(The E-mail ID used while booking)</div>
   	<div class="clear" style="line-height:5px">&nbsp;</div>
	<!--<p class='submit_button'><input name="sumbit_cancel_ticket" type="button1" value="Get Ticket Details" id="sumbit_cancel_ticket" class="submit" /></p>-->
	<input name="sumbit_cancel_ticket" id="sumbit_cancel_ticket" type="button" class="btn_cancel" value="Get Ticket Details" />
	<div class="clear" style="line-height:5px;">&nbsp;</div>
	</div>
</form>
<form method='post' name='cancel_booking_2' id='cancel_booking_2' style="display:none">
	<div class="form_styles form_wrapper" align="center">
	<h4 id="txtErrMsg" style="display:none">Ticket with this Email ID does not Exist</h4>
    <table width="80%" border="0">
      <tr>
        <td align="left">Route</td>
        <td align="left" id="route">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">Travels</td>
        <td align="left" id="travels">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">Journey Date</td>
        <td align="left" id="journey_date">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">Amount</td>
        <td align="left" id="amount">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="hidden" name="orderid" id="orderid">
        <a href="CancelBusBooking.php" class="various" data-fancybox-type="iframe" id="canch">
        <input name="cancel_ticket" id="cancel_ticket" type="submit" class="submit" value="Proceed to Cancellation" />
		</a><!--<input name="cancel_action" id="cancel_action" type="button" class="btn_cancel" value="Cancel" onclick="window.location.href='index.php'" />--></td>
      </tr>
    </table>

    <!--<div class="fl mb5 mr30">Route</div><div id="route" class="ml30 fl">H to B</div>
	<div class="clear" style="line-height:5px">&nbsp;</div>
    <div class="fl mb5 mr30">Travels</div>&nbsp;<div id="travels" class="ml20 fl">O</div>
    <div class="clear" style="line-height:5px">&nbsp;</div>
    <div class="fl mb5 mr20">Journey Date</div><div id="journey_date" class="fl">10-10-10</div>
   	<div class="clear" style="line-height:5px">&nbsp;</div>
    <div class="fl mb5 mr30">Amount</div><div id="amount" class="ml20 fl">1000</div>
   	<div class="clear" style="line-height:5px">&nbsp;</div>-->
	<!--<p class='submit_button'><input name="cancel_ticket" id="cancel_ticket" type="submit" value="Cancel Ticket" class="submit" /></p>-->
	<!--<input name="cancel_ticket" id="cancel_ticket" type="submit" class="submit" value="Cancel Ticket" />
	<div class="clear" style="line-height:5px;">&nbsp;</div>-->
	</div>
</form>
</div>
<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4>(For monitoring purpose we are storing your IP)</div>
</div>
</td></tr></table><br /><br />
<? include('includes/api-footer.php');?>