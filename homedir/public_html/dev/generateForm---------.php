<? ob_start();
include("includes/api-header.php");
include_once("includes/functions.php");
include_once "includes/api-functions.php";
if(empty($_SESSION[$svr.'busbook'])) { header('location:BusBooking.php'); }

if($_SERVER['REQUEST_METHOD'] == "POST")
{	//var_dump($_POST); exit;
	$json=array();
	$user_name=array();
	$user_gender=array();
	$user_age=array();
	$user_primary=array();
	$user_title=array();
	$inventoryItems=array(array());
	$passenger=array(array());
	
	$journeydate=$_POST['datepicker'];
	$chosenbusid=$_POST['chosenone'];
	$sourceid=$_POST['sourceList'];
	$destinationid=$_POST['destinationList'];
	$boardingpointid=$_POST['boardingpointsList'];
	$checkbox_no=$_POST['chkchk'];
	$arrivalTime=$_POST['arrivalTime'];
	$departureTime=$_POST['departureTime'];
	$boardingLoc=$_POST['boardingLoc'];
	$boardingTime=$_POST['boardingTime'];
	
	$sourceName = $_POST['sourceName'];
	$destinationName = $_POST['destinationName'];
	$travelName = $_POST['travelName'];
	$travelType = $_POST['travelType'];
	
	for($i=0; $i<$checkbox_no; $i++) 
	{ 
		$user_name[$i]=addslashes($_POST['fname'.$i.'']);
	  	$user_gender[$i]=addslashes($_POST['sex'.$i.'']);
	  	$user_age[$i]=addslashes($_POST['age'.$i.'']);
	  	$user_title[$i]=($_POST['sex'.$i.''] == 'male') ? 'Mr.' : 'Ms.'; //$_POST['Title'.$i.''];
	}
	
	$user_mobile = addslashes($_POST['mobile']);
	$user_email = addslashes($_POST['email_id']);
	$user_address = addslashes($_POST['address']);
	$user_id_no = addslashes($_POST['id_no']);
	$user_idproof_type = addslashes($_POST['id_proof']);
	$canPolicy = $_POST['canPolicy'];
	
	for ($i=0; $i < $checkbox_no; $i++) 
	{ 
	  if ($i==0) 
	  {
		$user_primary[$i]='true';
	  }
	  else
	  { 
		$user_primary[$i]='false'; 
	  }
	}
	
	$tripdetails = getTripDetails($chosenbusid);
	$tripdetails2 = json_decode($tripdetails); //var_dump($tripdetails2); exit;
	$seatschosen = $_POST['seatnames'];
	$seats = explode(",", $seatschosen);
	
	for ($i=0; $i <$checkbox_no; $i++) 
	{ 
	  foreach ($tripdetails2 as $key => $value) 
	  {
		 if (is_array($value))
		 {
		   foreach ($value as $k => $v) 
		   {         
			 foreach ($v as $k1 => $v1)
			 {
			   if (isset($v->name))
			   {
				  if (!strcmp($v->name, $seats[$i]))
				  {	
					$passenger[$i]['age']=$user_age[$i];
					$passenger[$i]['primary']=$user_primary[$i];
					$passenger[$i]['name']=$user_name[$i];
					$passenger[$i]['title']=$user_title[$i];
					$passenger[$i]['gender']=$user_gender[$i];
					if ($i==0) 
					{
						$passenger[$i]['idType']=$user_idproof_type;
						$passenger[$i]['email']=$user_email;
						$passenger[$i]['idNumber']=$user_id_no;
						$passenger[$i]['address']=$user_address;
						$passenger[$i]['mobile']=$user_mobile;
					}
					$inventoryItems[$i]['seatName']=$v->name;
					$inventoryItems[$i]['ladiesSeat']=$v->ladiesSeat;
					$inventoryItems[$i]['passenger']=$passenger[$i];
					$inventoryItems[$i]['fare']=$v->fare;
				 }
			   }
			 }
		  }
		}
	  }
	}
	$json['availableTripId']=$chosenbusid;
	$json['boardingPointId']=$boardingpointid;
	$json['destination']=$destinationid;
	$json['inventoryItems']=$inventoryItems;
	$json['source']=$sourceid;
	
	$_SESSION[$svr.'jsonobject']= $json;
	
	if(isset($_SESSION[$svr.'busbook']))
	{	
		$order_id = getdata("svr_api_orders_temp", "ba_id", "ba_unique_id = '".$_SESSION[$svr.'busbook']."'"); //ba_trip_id='".$chosenbusid."' &&
		//$fare = $inventoryItems[0]['fare'];
		//$totalfare = $fare * $checkbox_no;
		$totalfare = $_POST['fare'];
		
		for($key=0; $key<$checkbox_no; $key++){
			$seat_name .= $inventoryItems[$key]['seatName'].'|';
			$ladies_seat .= $inventoryItems[$key]['ladiesSeat'].'|';
			$farez .= $inventoryItems[$key]['fare'].'|';
			$seatstatus .= '1|';
				$canccharges .= '0|';
				$refundamt .= '0|';
				$cancdates .= '0|';
			$usertitle .= $user_title[$key].'|';
			$username .= $user_name[$key].'|';
			$userage .= $user_age[$key].'|';
			$usergender .= $user_gender[$key].'|';
		}
		$seat_no = substr($seat_name, 0, -1);
		$ladies_seat = substr($ladies_seat, 0, -1);
		$farez = substr($farez, 0, -1);
		$seatstatus = substr($seatstatus, 0, -1);
			$canccharges = substr($refundamt, 0, -1);
			$refundamt = substr($refundamt, 0, -1);
			$cancdates = substr($cancdates, 0, -1);
		$usertitle = substr($usertitle, 0, -1);
		$username = substr($username, 0, -1);
		$userage = substr($userage, 0, -1);
		$usergender = substr($usergender, 0, -1);
		
		$cust_id = (!empty($_SESSION[$svr.'cust_id'])) ? $_SESSION[$svr.'cust_id'] : 0;
		$agid = (!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_id'] : 0;

		if(empty($order_id))
		{	
			$addedby = (!empty($_SESSION[$svra.'ag_id'])) ? 1 : 0; 
			query("insert into svr_api_orders_temp(ba_id, ba_unique_id, ba_trip_id, ba_source, ba_destination, ba_source_name, ba_destination_name, ba_travels_name, ba_travels_type, ba_boarding_location, ba_boarding_time, ba_boarding_point, ba_total_fare, ba_arrival_time, ba_departure_time, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title, ba_name, ba_age, ba_gender, ba_address, ba_email, ba_mobile, ba_id_proof, ba_id_no, ba_journey_date, ba_status, ba_addeddate, ba_added_by, ba_cust_id, ba_ag_id, ba_cancel_policy, ba_fare, ba_seat_status, ba_refund_amount, ba_cancel_dates, ba_cancel_charges) values ('', '".$_SESSION[$svr.'busbook']."', '".$chosenbusid."', '".$sourceid."', '".$destinationid."', '".$sourceName."', '".$destinationName."', '".$travelName."', '".$travelType."', '".$boardingLoc."', '".$boardingTime."', '".$boardingpointid."', '".$totalfare."', '".$arrivalTime."', '".$departureTime."', '".$checkbox_no."', '".$seat_no."', '".$ladies_seat."', '".$usertitle."', '".$username."', '".$userage."', '".$usergender."', '".$user_address."', '".$user_email."', '".$user_mobile."', '".$user_idproof_type."', '".$user_id_no."', '".$journeydate."', 1, '".$now_time."', '".$addedby."', '".$cust_id."', '".$agid."', '".$canPolicy."', '".$farez."', '".$seatstatus."', '".$refundamt."', '".$cancdates."', '".$canccharges."')");
			
			$order_id = $_SESSION[$svr.'order_id'] = insert_id();
			$_SESSION['order_id'] = $order_id;
		
		} else {
			$updatedby = (!empty($_SESSION[$svra.'ag_id'])) ? 1 : 0;
			query("update svr_api_orders_temp set ba_unique_id = '".$_SESSION[$svr.'busbook']."', ba_trip_id = '".$chosenbusid."', ba_source = '".$sourceid."', ba_destination = '".$destinationid."', ba_source_name = '".$sourceName."', ba_destination_name = '".$destinationName."', ba_travels_name = '".$travelName."', ba_travels_type = '".$travelType."', ba_boarding_location = '".$boardingLoc."', ba_boarding_time = '".$boardingTime."', ba_boarding_point = '".$boardingpointid."', ba_total_fare = '".$totalfare."', ba_arrival_time = '".$arrivalTime."', ba_departure_time = '".$departureTime."', ba_no_passenger = '".$checkbox_no."', ba_seat_no = '".$seat_no."', ba_ladies_seat = '".$ladies_seat."', ba_title = '".$usertitle."', ba_name = '".$username."', ba_age = '".$userage."', ba_gender = '".$usergender."', ba_address = '".$user_address."', ba_email = '".$user_email."', ba_mobile = '".$user_mobile."', ba_id_proof = '".$user_idproof_type."', ba_journey_date = '".$journeydate."', ba_updateddate = '".$now_time."', ba_id_no = '".$user_id_no."', ba_updated_by = '".$updatedby."', ba_cust_id = '".$cust_id."', ba_ag_id = '".$agid."', ba_cancel_policy = '".$canPolicy."', ba_fare = '".$farez."', ba_seat_status = '".$seatstatus."', ba_refund_amount = '".$refundamt."', ba_cancel_dates = '".$cancdates."', ba_cancel_charges = '".$canccharges."' where ba_id = '".$_SESSION['order_id']."'");
		}
	}
	//error_reporting(E_ALL); ini_set('display_errors', 'On');
	if(!empty($_SESSION[$svra.'ag_id'])){
		//header("location:agentpayticket.php?order_id=".$_SESSION['order_id']);
		$bill = getdata('svr_api_orders_temp', 'ba_total_fare', "ba_unique_id='".$_SESSION['order_id']."'");
		$bill = number_format($bill, 2, '.', ''); 
		//echo $_SESSION[$svr.'ag_deposit'].' > '.$bill; exit;
		if($_SESSION[$svra.'ag_deposit'] > $bill)
		{	
			header("location:confirm-ticket.php?status=1&orderid=".$_SESSION['order_id']);
		} else { // less desposit
			header("location:agent-insufficient-balance.php");
		}
	}else{
		header("location:payticket.php?order_id=".$_SESSION['order_id']);
	}
} 
$date=$_SESSION['datepicker'];
$chosenbusid=$_SESSION['chosenone'];
$sourceid=$_SESSION['sourceList'];
$destinationid=$_SESSION['destinationList'];
$checkbox_no=$_SESSION['chkchk'];
$boardingpointid=$_SESSION['boardingpointsList'];
$boardingTime=$_SESSION['boardingTime'];
$boardingLoc=$_SESSION['boardingLoc'];
$seatschosen=$_SESSION['seatnames'];
$seatnames=$_SESSION['seatnames'];
$fare=$_SESSION['fare'];
$canPolicy = $_SESSION['canPolicy'];
?>
<link rel="stylesheet" href="api/css/generateForm.css" />
<link rel="stylesheet" href="css/form-styls.css" type="text/css" />
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<title>Customer Details</title>
<div class="navigation">
	<div class="bg">
        <a href="index.php">Home</a><span class="divied"></span>
        <a href="BusBooking.php">Bus Booking</a><span class="divied"></span>
        <a href="BusServiceList.php">Bus Service List</a><span class="divied"></span>
		<a href="SeatLayout.php">Seat Layout</a><span class="divied"></span>
		<span class="pagename">Customer Details</span>
    </div>
</div>
<? include('travel-info.php');?>
<?php
echo "<form method='post' action='' name='form4' onSubmit=''>";
echo "<table cellpadding=10 cellspacing=1 border=0 style='border:1px solid #eaeaea;' width='100%'>
<tr bgcolor='#F4F4F4'><td><h2>Customer Information</h2></td></tr>
<tr><td>";
echo "<table cellpadding=10 cellspacing=1 border=0 width='98%'>";

echo "<tr><td align='center'><table><tr><td>";
for ($i=0; $i <$checkbox_no; $i++) 
{ 
	echo "<tr>";
	/*echo "<td>Title ".($i+1)." <span class='error'>*</span>: </td><td><select name='Title".$i."' class='input2' style='width:70px'>
			<option value='-1'>Select</option>
			<option value='Mr'>Mr.</option>
			<option value='Mrs'>Mrs.</option>
			<option value='Ms'>Ms.</option>
		</select></td><td width=20px>&nbsp;</td>";*/
	echo "<td nowrap='nowrap'>Name ".($i+1)." <span class='error'>*</span>: </td><td><input type='text' name='fname".$i."' class='input2' size='15px'></td>
	<td width=20px>&nbsp;</td><td>Gender ".($i+1)." <span class='error'>*</span>:</td>
	<td><input type='radio' name='sex".$i."' class='input2' value='male'>Male</td>
	<td><input type='radio' name='sex".$i."' value='female'>Female</td><td width=20px>&nbsp;</td>";
	echo "<td>Age ".($i+1)." <span class='error'>*</span>: </td><td><input type='text' name='age".$i."' class='input2' size='10px'></td></tr>";
}
echo "</td></tr></table></td></tr>";
echo "</table>";
echo "</td></tr>";
echo "<tr bgcolor='#F4F4F4'><td><h2>Contact Details</h2></td></tr>
<tr><td align=center>";
echo "<table cellpadding=5 cellspacing=2 border=0><tr><td>";
//echo "<tr><td><h4 align='left'>Contact Details</h4></td></tr>";
$mob = (!empty($_SESSION[$svr.'cust_id'])) ? $_SESSION[$svr.'cust_mobile'] : '';
$mail = (!empty($_SESSION[$svr.'cust_id'])) ? $_SESSION[$svr.'cust_email'] : '';
$addr = (!empty($_SESSION[$svr.'cust_id'])) ? $_SESSION[$svr.'cust_addr'] : '';
echo "<tr><td><label for='mobile'>Mobile No. <span class='error'>*</span>:</label></td><td><input type='text' name='mobile' class='input2' value='".$mob."'></td></tr>";
echo "<tr><td><label for='email_id'>Email id <span class='error'>*</span>:</label></td><td><input type='text' name='email_id' class='input2' value='".$mail."'></td></tr>";
echo "<tr><td><label for='address'>Address <span class='error'>*</span>:</label></td><td><textarea name='address' class='input2'>".$addr."</textarea></td></tr>";
echo "<tr><td><label for='id_proof'>ID Proof Type <span class='error'>*</span>:</label></td><td><select name='id_proof' class='input2'>
		<option value='-1'>-- Select --</option>
		<option value='Pan Card'>Pan Card</option>
		<option value='Driving Licence'>Driving License</option>
		<option value='Voting Card'>Voting Card</option>
		<option value='Aadhar Card'>Aadhar Card</option>
	 </select></td></tr>";
//echo "<tr><td>&nbsp;</td><td><input type='checkbox' name='discount_coupon' class='btnclass' />I have discount code </td></tr>";
//echo "<tr><td>&nbsp;</td><td><input type='checkbox' name='travel_insurance' class='btnclass' />I have Travel insurance </td></tr>";
echo "<tr><td><label for='id_no'>Id-no. <span class='error'>*</span>:</label></td><td><input type='text' name='id_no' class='input2'></td></tr>";
echo "<tr><td>";
echo "<input type='hidden' name='datepicker' class='btnclass' value='".$date."' />";
echo "<input type='hidden' name='sourceList' class='btnclass' value='".$sourceid."' />";
echo "<input type='hidden' name='destinationList' class='btnclass' value='".$destinationid."' />";
echo "<input type='hidden' name='chosenone' class='btnclass' value='".$chosenbusid."' />";
echo "<input type='hidden' name='boardingpointsList' class='btnclass' value='".$boardingpointid."' />";
echo "<input type='hidden' name='arrivalTime' class='btnclass' value='".$arrivalTime."' />";
echo "<input type='hidden' name='departureTime' class='btnclass' value='".$departureTime."' />";
echo "<input type='hidden' name='chkchk' class='btnclass' value='".$checkbox_no."' />";
echo "<input type='hidden' name='seatnames' class='btnclass' value='".$seatschosen."' />";
echo "<input type='hidden' name='boardingLoc' id='boardingLoc' class='btnclass' value='".$boardingLoc."' />";
echo "<input type='hidden' name='boardingTime' id='boardingTime' class='btnclass' value='".$boardingTime."' />";
echo "<input type='hidden' name='sourceName' id='sourceName' class='btnclass' value='".$sourceName."' />";
echo "<input type='hidden' name='destinationName' id='destinationName' class='btnclass' value='".$destinationName."' />";
echo "<input type='hidden' name='travelName' id='travelName' class='btnclass' value='".$travelName."' />";
echo "<input type='hidden' name='travelType' id='travelType' class='btnclass' value='".$travelType."' />";
echo "<input type='hidden' name='fare' id='fare' class='btnclass' value='".$fare."' />";
echo "<input type='hidden' name='canPolicy' id='canPolicy' class='btnclass' value='".$canPolicy."' />";
echo "<label>&nbsp;</label></td>";
echo "<td id='submit_button'><input type='submit' value='Proceed to Pay (Rs.".$fare.")' class='submit' onClick='return validation()' /></td>";
echo "<td id='button_replacement' style='display:none;'><input type='submit' value='Proceeding to Pay...' class='submit' onclick='return false;' /></td>";
//echo "</td></tr></table></td></tr>";
echo "</tr></table>";
echo "</td></tr></table></form><br>";

include("includes/api-footer.php");?>
<script type="text/javascript">
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
var chk_phone=/^\d{10}$/;
function validation(){
	var flag = 0;
	var d=document.form4;
	<? for ($i=0; $i <$checkbox_no; $i++) {?>
		//if(d.Title<?=$i?>.value=="-1"){alert("Please select Title<?=$i+1?>");d.Title<?=$i?>.focus();return false; flag++; } else { flag--; }
		if(d.fname<?=$i?>.value==""){alert("Please enter Name<?=$i+1?>");d.fname<?=$i?>.focus();return false; }
		if(d.sex<?=$i?>[0].checked==false && d.sex<?=$i?>[1].checked==false){ alert("Please select gender<?=$i+1?>"); d.sex<?=$i?>[0].focus(); return false; } 
		if(d.age<?=$i?>.value==""){alert("Please enter Age<?=$i+1?>");d.age<?=$i?>.focus();return false; }
		if(isNaN(d.age<?=$i?>.value)){alert("Please enter Valid Age<?=$i+1?>");d.age<?=$i?>.focus();return false; }
	<? }?>
	if(!chk_phone.test(d.mobile.value)){alert("Please enter Valid Mobile Number");d.mobile.focus(); return false; } 
	if(!chk_email.test(d.email_id.value)){alert("Please enter Valid Email Address");d.email_id.focus();return false; } 
	if(d.address.value==""){alert("Please enter your Address");d.address.focus();return false; }
	if(d.id_proof.value=="-1"){alert("Please select ID Proof");d.id_proof.focus();return false; }
	if(d.id_no.value==""){alert("Please enter ID No.");d.id_no.focus();return false; }
	//redir();
	document.getElementById("submit_button").style.display = "none";
	document.getElementById("button_replacement").style.display = "";
}
function redir(){
	document.getElementById("submit_button").style.display = "none";
	document.getElementById("button_replacement").style.display = "";
}
</script>