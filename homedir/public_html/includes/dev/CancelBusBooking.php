<? ob_start();
include("includes/functions.php");;
include_once "includes/api-functions.php";

if(!empty($_GET['success'])){
	//$goto = (!empty($_GET['url'])) ? 'BusCancellations.php' : 'index.php';
	if($_GET['success'] == 'true'){ 
		$close = '<table align="center" height="100%"><tr><td align="center" valign="middle"><table><tr><td>Cancellation Successful.</td></tr></table></td></tr></table>'; 
	} else {
		$close = '<table align="center" height="100%"><tr><td align="center" valign="middle"><table><tr><td>Cancellation cannot be performed.</td></tr><tr><td align="center"><a href="javascript:parent.$.fancybox.close();">Close me</a></td></tr></table></td></tr></table>';
	}
	//echo '<body onload="setTimeout(closed(\''.$goto.'\'), 1500);">'.$close.'</body>';
	echo '<body onload="setTimeout (\'parent.$.fancybox.close()\',1500); ">'.$close.'</body>';
}

if(!empty($_GET['tin']))
{
$msg = '';

$Sql = "select ba_id, ba_ag_id, ba_journey_date, ba_departure_time, ba_ticket_no, ba_name, ba_email, ba_mobile, ba_source_name, ba_destination_name, ba_travels_name, ba_travels_type, ba_seat_no, ba_seat_status, ba_fare, ba_total_fare, ba_cancel_charges, ba_refund_amount, ba_cancel_dates, ba_cancel_policy, ba_cust_id, ba_order_status from svr_api_orders where ba_ticket_no = '".$_GET['tin']."'"; //echo $Sql; exit;
$query = mysql_query($Sql); $count = mysql_num_rows($query);

$fetch = mysql_fetch_array($query);
if(!empty($fetch['ba_ag_id']) && empty($_SESSION[$svra.'ag_id'])) {
	echo "<center>Login as Agent to Cancel.</center>";
	echo '<body onload="setTimeout (\'parent.$.fancybox.close ()\',1500);">'.$close.'</body>'; exit;
} if(empty($fetch['ba_cust_id']) && !empty($_SESSION[$svr.'cust_id'])) {
	echo "<center>This ticket was not booked by customer.</center>";
	echo '<body onload="setTimeout (\'parent.$.fancybox.close ()\',1500);">'.$close.'</body>'; exit;
} if(empty($fetch['ba_ag_id']) && !empty($_SESSION[$svra.'ag_id'])) {
	echo "<center>This ticket was not booked by Agent.</center>";
	echo '<body onload="setTimeout (\'parent.$.fancybox.close ()\',1500);">'.$close.'</body>'; exit;	
} if(!empty($fetch['ba_ag_id']) && !empty($_SESSION[$svra.'ag_id']) && $_SESSION[$svra.'ag_id'] <> $fetch['ba_ag_id']) {
	echo "<center>This ticket was booked by another agent.</center>";
	echo '<body onload="setTimeout (\'parent.$.fancybox.close ()\',1500);">'.$close.'</body>'; exit;
}

$old_seats = explode('|', $fetch['ba_seat_no']);
$old_passengers = explode('|', $fetch['ba_name']);
$old_seat_status = explode('|', $fetch['ba_seat_status']);
$old_fare = explode('|', $fetch['ba_fare']);
$old_cancel_charges = explode('|', $fetch['ba_cancel_charges']);
$old_refund_amount = explode('|', $fetch['ba_refund_amount']);
$old_cancel_dates = explode('|', $fetch['ba_cancel_dates']);

$primary_seat = $old_seats[0];  
//$already_canc = array_count_values_of('0', $old_seat_status);
//$not_yet_canc = array_count_values_of('1', $old_seat_status);

$my_seats = array_combine($old_seats, $old_seat_status);
$my_passengers = array_combine($old_seats, $old_passengers);
$db_seat_status = array_combine($old_seats, $old_seat_status);
$db_fare = array_combine($old_seats, $old_fare);
$db_cancel_charges = array_combine($old_seats, $old_cancel_charges);
$db_refund_amount = array_combine($old_seats, $old_refund_amount);
$db_cancel_dates = array_combine($old_seats, $old_cancel_dates);

$db_cancel_type = $fetch['ba_order_status'];

$journey_date = $fetch['ba_journey_date'].' '.$fetch['ba_departure_time'];
$doj = date('Y-m-d H:i:s', strtotime($journey_date));

$doc = date('Y-m-d H:i:s');

$result = getTicket($fetch['ba_ticket_no']);
$result2 = json_decode($result);
//var_dump($result2); exit;
foreach ($result2 as $key => $values) 
{	
	if(!strcmp($key,'cancellationPolicy')) $canpoly = $values;
	if(!strcmp($key,'partialCancellationAllowed')) $partcan = $values;
	if(!strcmp($key,'status')) $canstatus = $values;
}
if(($doc < $doj)) //&& $canstatus <> 'CANCELLED'
{	
	//P4GTNR//KD6DT2//$fetch['ba_ticket_no']
	$cancldata = getCancellationData($fetch['ba_ticket_no']);
	$cancldata = json_decode($cancldata);
	//print_r($cancldata); exit;
	foreach ($cancldata as $key => $value) 
	{	
		if(!strcmp($key,'cancellable')) $cancellable = $value;
		if(!strcmp($key,'cancellationCharges')) { $cancellationCharges = $value;
			foreach($value as $val){
			  if(is_array($val)){
				foreach($val as $v){
					$seats[] = $v->key;
					$charges[] = $v->value;
				}
			  } else {
				$seats[] = $val->key;
				$charges[] = $val->value;
			  }	
			}
		}
		if(!strcmp($key,'fares')) { $fares = $value;
			foreach($value as $val){
			  if(is_array($val)){
				foreach($val as $v){
					$farez[] = $v->value;
				}
			  } else {
				$farez[] = $val->value;
			  }	
			}
		}
	}
}

$partcan = true; $cancellable = true;
$canpoly = $fetch['ba_cancel_policy'];

$seats = array("3");
$charges = array("0");
$farez = array("300.00");

/*$seats = array("4", "3", "6", "5");
$charges = array("0","0","0","0");
$farez = array("300.00", "300.00", "300.00", "300.00");*/

//TEST
/*$seats = array("6");
$charges = array("0");
$farez = array("300.00");*/

//TEST-1
/*$seats = array("3");
$charges = array("30.00");
$farez = array("300.00");*/

$api_seats = array_combine($seats, $seats);
$api_charges = array_combine($seats, $charges);
$api_farez = array_combine($seats, $farez);

//print_r($farez);
if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$sel_seats = $_POST['canc']; //echo $primary_seat; exit;//print_r($sel_seats); exit;
	if(sizeof($api_seats) > 1 && $partcan && sizeof($sel_seats) == 0) {
		$msg = 'Please select seats to be cancelled.';
	}else if(sizeof($api_seats) > 1 && $partcan && sizeof($sel_seats) != sizeof($api_seats)) {
		if(in_array($primary_seat, $sel_seats)) 
			$msg = "Primary passenger can not be cancelled";
	} 
	$url = (!empty($_POST['url'])) ? '&url=1' : '';
	if($msg == '') {
		
		if($partcan) {
			$cancel_type = ((sizeof($sel_seats) == sizeof($old_seats)) || sizeof($api_seats) == 1) ? 4 : 5;
			$ct = ($cancel_type == 4 && $_POST['db_cancel_type'] == 5) ? 'p2f' : ''; //partial to full
		} else {
			$cancel_type = 4;
		}
		$new_seat_status = $new_cancel_charges = $new_refund_amount = $new_cancel_dates = array();
		$seats_to_cancel = $_POST['seatstocancel'];
		$fare_amount = $_POST['fareamount'];
		$cancel_charges = $_POST['cancelcharges'];
		$refund_amount = $_POST['refundamount'];
		$cancel_dates = $_POST['canceldates'];
		//print_r($seats_to_cancel); exit;
		if($cancel_type == 5 || $ct == 'p2f')
		{	
			foreach($my_seats as $k => $v){
				if($sel_seats[$k] == true){
					$par_seat_status[$k] = '0';
					$par_cancel_charges[$k] = $cancel_charges[$k];
					$par_refund_amount[$k] = $refund_amount[$k];
					$par_cancel_dates[$k] = $cancel_dates[$k];
					
					$now_seats_to_cancel[$k] = $seats_to_cancel[$k];
					$now_cancel_charges[$k] = $cancel_charges[$k];
					$now_refund_amount[$k] = $refund_amount[$k];
					$now_fare_amount[$k] = $fare_amount[$k];
				} else {
					$par_seat_status[$k] = $db_seat_status[$k];
					$par_cancel_charges[$k] = $db_cancel_charges[$k];
					$par_refund_amount[$k] = $db_refund_amount[$k];
					$par_cancel_dates[$k] = $db_cancel_dates[$k];
				} 
			}
			$new_seat_status = implode('|', $par_seat_status);
			$new_cancel_charges = implode('|', $par_cancel_charges);
			$new_refund_amount = implode('|', $par_refund_amount);
			$new_cancel_dates = implode('|', $par_cancel_dates);
			
			$now_seats_to_cancel_arr = $now_seats_to_cancel;
			$now_seats_to_cancel = implode('|', $now_seats_to_cancel);
			$now_cancel_charges_arr = $now_cancel_charges;
			$now_cancel_charges = implode('|', $now_cancel_charges);
			$now_refund_amount_arr = $now_refund_amount;
			$now_refund_amount = implode('|', $now_refund_amount);
			$now_fare_amount_arr = $now_fare_amount;
			$now_fare_amount = implode('|', $now_fare_amount);

		} else { 
			$new_cancel_charges = implode('|', $cancel_charges);
			$new_refund_amount = implode('|', $refund_amount);
			foreach($old_seat_status as $key => $value){
				$new_seat_status[] = '0';
				$new_cancel_dates[] = date('d/m/Y h:i A');
			}
			$new_seat_status = implode('|', $new_seat_status);
			$new_cancel_dates = implode('|', $new_cancel_dates);
			
			$now_seats_to_cancel_arr = $seats_to_cancel;
			$now_seats_to_cancel = implode('|', $seats_to_cancel); //echo implode(",", $avail_dates);
			$now_cancel_charges_arr = $cancel_charges;
			$now_cancel_charges = implode('|', $cancel_charges);
			$now_refund_amount_arr = $refund_amount;
			$now_refund_amount = implode('|', $refund_amount);
			$now_fare_amount_arr = $fare_amount;
			$now_fare_amount = implode('|', $fare_amount);
		}
		
		$seats2cancel = '['.((!empty($now_seats_to_cancel_arr)) ? '"'.implode('","',  $now_seats_to_cancel_arr ).'"' : '').']';
		
		//echo $cancel_type.'<br>seat status: '.$new_seat_status.'<br>canc charges: '.$new_cancel_charges.'<br>refund amount: '.$new_refund_amount.'<br>canc dates: '.$new_cancel_dates.'<br>now canc charges: '.$now_cancel_charges.'<br>now canc amount: '.$now_refund_amount.'<br>now seats to canc: '.$now_seats_to_cancel.'<br>seats2cancel: '.$seats2cancel.'<br>fare amount: '.$now_fare_amount; exit;
		
		//{"tin":"S436228AS3","seatsToCancel":["12A","12B"]}
		//cancelTicket(makeCancellationRequest); 
		//echo "tin:'".$fetch['ba_ticket_no']."', seatsToCancel: '".$seats2cancel."'"; exit;
		
		$flag = 0;
		$makeCancellationRequest = '{"tin":"'.$fetch["ba_ticket_no"].'","seatsToCancel":'.$seats2cancel.'}';
		////$cancel_it = cancelTicket($makeCancellationRequest); //sarah
		
		//$out = startsWith($cancel_it, 'Error'); echo $out; exit;
		
		if(startsWith($cancel_it, 'Error') == 1){
			//Not Cancelled
			header('location:CancelBusBooking.php?success=false');
		} else {
			$flag = 1; //Cancelled
		}
		
		if($flag == 1)
		{
			mysql_query("update svr_api_orders set ba_order_status = '".$cancel_type."', ba_seat_status = '".$new_seat_status."', ba_cancel_charges = '".$new_cancel_charges."', ba_refund_amount = '".$new_refund_amount."', ba_cancel_dates = '".$new_cancel_dates."' where ba_id = ".$fetch['ba_id']);
			
			$rpt_amount = array_sum($now_fare_amount_arr);
			$rtp_refund_amount = array_sum($now_refund_amount_arr); 
			$rpt_cancel_charges = array_sum($now_cancel_charges_arr); 
			$rpt_commission = '';
			
			if(!empty($_SESSION[$svra.'ag_id'])){
				/*$transc = 'Cancellation';*/ 
				$transc = (sizeof($sel_seats) == sizeof($old_seats)) ? 'Full Bus Cancellation' : 'Partial Bus Cancellation'; //echo $transc; exit;
				$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
				$op_bal = number_format($op_bal, 2, '.', '');
				//$comm = $agent_commission * $rpt_amount; 
				//$comm = number_format($comm, 2, '.', ''); - $comm
				$comm = '';
				$net = number_format($rpt_amount - $rpt_cancel_charges, 2, '.', '');
				$cl_bal = number_format($op_bal + $net, 2, '.', ''); 
				//echo ' OP: '.$op_bal.'<br>Amt: '.$rpt_amount.'<br>Canc: '.$rpt_cancel_charges.'<br>Net: '.$net.'<br>CB: '.$cl_bal; exit; 
				$ref_id = rand(1000000, 9999999); $fkid = $fetch['ba_id'];
				
				//if(!empty($_SESSION[$svra.'ag_id'])){
				mysql_query("update svr_agents set ag_deposit = '".$cl_bal."' where ag_id = '".$_SESSION[$svra.'ag_id']."'");
				$_SESSION[$svra.'ag_deposit'] = $cl_bal;
				$cancel_by = $_SESSION[$svra.'ag_fname']; //.' (Agent)'
				$email = $_SESSION[$svra.'ag_email'];
			} else {
				$cancel_by = $_SESSION[$svr.'cust_fname']; //.' (Customer)'
				$email = $_SESSION[$svr.'cust_email'];
			}
			$cancel_charges = number_format($rpt_cancel_charges, 2, '.', '');
			$refund_amount = number_format($rtp_refund_amount, 2, '.', '');
			
			if(!empty($_SESSION[$svra.'ag_id'])){
				mysql_query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_cancel_charges, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time, ar_remarks) values( '', '".$_SESSION[$svra.'ag_id']."', '".$ref_id."', '".$fetch['ba_ticket_no']."', '', '".$transc."', '".$op_bal."', '".$rpt_amount."', '".$comm."', '".$cancel_charges."', '".$net."', '".$cl_bal."', '2', '".$fkid."', '".$now_time."', '".$now_seats_to_cancel."')");
			}
			$seatz = str_replace('|', ',', $now_seats_to_cancel);
			$data['subject'] = 'Bus Ticket Cancellation';
			$data['content'] = "<table align='left'><tr><td>Dear Sir,</td></tr><tr><td>&nbsp;</td></tr>
			<tr><td>Ticket Seats (".$seatz.") with TIN: ".$fetch['ba_ticket_no']." have been cancelled by ".$cancel_by." with Rs.".$cancel_charges." cancellation charges and Rs.".$refund_amount." as refund amount.</td></tr>
			<tr><td>&nbsp;</td></tr><tr><td>Thanks & Regards, <br>SVR Tours and Travels</td></tr></table>";
			
			$data['to_email'] = $email;
			send_email($data);
			header('location:CancelBusBooking.php?success=true'.$url);
		} else{
			header('location:CancelBusBooking.php?success=false');
		}
	}
} 
}
?>

<style type="text/css">
body,td,th{font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;}
.error { color:#FF0000;}
</style>
<script type="text/javascript" src="js/jquery-1.js"></script>
<script>$(document).ready(function() {setTimeout( "jQuery('.msg').fadeOut('slow');", 5000 );});</script>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<? if($_GET['tin']){?>
<table cellpadding="10" cellspacing="1" border="0" style="border:1px solid #eaeaea;" width="100%">
<tr bgcolor="#F4F4F4"><th>Cancel Bus Ticket <?='('.$fetch['ba_ticket_no'].')'?></th></tr>
<? if($msg != ''){?><tr bgcolor="#FFFFFF"><td align="center" class="msg error"><?=$msg?></td></tr><? }?>
<tr><td align="left">
<div class="inner_content">                  
<div class="enquiry" align="left">              	
<form method='post' name='cancel_booking_2' id='cancel_booking_2'>
	<div class="form_styles form_wrapper" align="center">
    <table width="100%" border="0"><tr><td width="60%">
    <table width="100%" border="0">
      <tr>
        <td align="left" width="20%">Route</td>
        <td align="left" width="2%">:</td>
        <td align="left"><?=$fetch['ba_source_name'];?> &rarr; <?=$fetch['ba_destination_name'];?></td>
      </tr>
      <tr>
        <td align="left" nowrap="nowrap">Journey Date</td>
        <td align="left">:</td>
        <td align="left"><?=date('d/m/Y h:i A', strtotime($journey_date));?></td>
      </tr>
      <tr>
        <td align="left">Travels</td>
        <td align="left">:</td>
        <td align="left"><?=$fetch['ba_travels_name'];?></td>
      </tr>
      <tr>
        <td align="left">Bus Type</td>
        <td align="left">:</td>
        <td align="left"><?=$fetch['ba_travels_type'];?></td>
      </tr>
      <tr>
        <td align="left">Amount</td>
        <td align="left">:</td>
        <td align="left">Rs. <?=$fetch['ba_total_fare'];?></td>
      </tr>
    </table>
    </td>
        <td>
        <table border="0">
      <tr>
        <td align="left" width="20%">Name</td>
        <td align="left" width="2%">:</td>
        <td align="left" id="route"><?=$old_passengers[0];?></td>
      </tr>
      <tr>
        <td align="left" nowrap="nowrap">Email</td>
        <td align="left">:</td>
        <td align="left"><?=$fetch['ba_email'];?></td>
      </tr>
      <tr>
        <td align="left">Phone</td>
        <td align="left">:</td>
        <td align="left"><?=$fetch['ba_mobile'];?></td>
      </tr>
      <tr>
        <td align="left">Seats</td>
        <td align="left">:</td>
        <td align="left"><?=str_replace('|', ', ', $fetch['ba_seat_no']);?></td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
    </table></td>
    </tr></table>
	</div>
    <div>
    <table border="0" class="mt10" width="100%">
      <tr>
        <td align="center"><? echo cancelPolicy($canpoly, $doj, $partcan, 'plain');?></td>
        </tr>
      <tr><td></td></tr>
      <? if($cancellable && count($api_seats) > 0){?>
      <tr><td>
     <table width="100%" border="0" class="mt10" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="6" align="center">
        	<table width="100%" border="1" class="mt10" cellpadding="5" cellspacing="5" style="border-collapse:collapse">
             <tr>
				<? if(($partcan && sizeof($api_seats) > 1)){?><th align="left">&nbsp;</th><? } //|| sizeof($my_seats) > 1?>
                <th align="left">Seat</th>
                <th align="left">Passenger</th>
                <th align="left">Fare</th>
                <th align="left">Charges</th>
                <th align="left">Refund Amount</th>
              </tr>
              <? foreach($my_seats as $seatno => $status){?>
              <tr>
                <? if($status == 1){ 
				if(($partcan && sizeof($api_seats) > 1)){ //|| sizeof($my_seats) > 1?>
                <td align="left"><input type="checkbox" name="canc[<?=$seatno?>]" id="canc[<?=$seatno?>]" value="<?=$seatno?>" ></td>
				<? } else {?><input type="hidden" name="canc[<?=$seatno?>]" id="canc[<?=$seatno?>]" value="<?=$seatno?>" ><? }?>
                <td align="left"><?=$seatno?><input type="hidden" name="seatstocancel[<?=$seatno?>]" value="<?=$seatno?>"></td>
                <td align="left"><?=$my_passengers[$seatno]?></td>
                <td align="left"><?=$api_farez[$seatno]?><input type="hidden" name="fareamount[<?=$seatno?>]" value="<?=$api_farez[$seatno]?>"></td>
                <td align="left"><?=$api_charges[$seatno]?><input type="hidden" name="cancelcharges[<?=$seatno?>]" value="<?=$api_charges[$seatno]?>"></td>
                <td align="left"><? $refnd = number_format($api_farez[$seatno]-$api_charges[$seatno], 2, '.', ''); echo $refnd;?>
                <input type="hidden" name="refundamount[<?=$seatno?>]" value="<?=$refnd;?>">
				<input type="hidden" name="canceldates[<?=$seatno?>]" value="<?=date('d/m/Y h:i A');?>">
				</td>
                <? }?>
              </tr>
              <? }?>
            </table>
        </td>
      </tr>
      <tr>
        <td colspan="6" align="center">
		<input type="hidden" name="db_cancel_type" value="<?=$db_cancel_type?>"><input type="hidden" name="url" value="<?=$_GET['url'];?>">
		<input name="cancel_ticket" id="cancel_ticket" type="submit" class="submit" value="Cancel Ticket" /></td>
      </tr>
    </table></td>
      </tr>
      <? } else {?>
      <tr align="center">
        <td class="error">This Ticket is not Cancellable</td>
      </tr>
      <? }?>
    </table>
    </div>
</form>
</div>
</div>
</td></tr></table><br /><br />
<? }?>
<script>
function closed(url){ 
    parent.$.fancybox.close();
    window.location.href = '<?=$site_url;?>'+url; 
}
</script>