<? include("includes/api-header.php"); 
include("includes/functions.php");
@session_start();
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";?>
<link rel="stylesheet" href="api/css/generateForm.css" />
<link rel="stylesheet" href="css/form-styls.css" type="text/css" />
<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>
<!--<div class="navigation"><div class="bg"><a href="../index.php">Home</a><span class="divied"></span><span class="pagename">Customer Details</span></div></div>-->
<div class="navigation">
	<div class="bg">
        <a href="index.php">Home</a>
        <span class="divied"></span>
        <a href="BusBooking.php">Bus Booking</a>
        <span class="divied"></span>
        <span class="pagename">Customer Details</span>
    </div>
</div>
<? include('travel-info.php');?>
<?php
$json=array();
$user_name=array();
$user_gender=array();
$user_age=array();
$user_primary=array();
$user_title=array();
$inventoryItems=array(array());
$passenger=array(array());

$journeydate=$_GET['datepicker'];
$chosenbusid=$_GET['chosenone'];
$sourceid=$_GET['sourceList'];
$destinationid=$_GET['destinationList'];
$boardingpointid=$_GET['boardingpointsList'];
$checkbox_no=$_GET['chkchk'];

for($i=0; $i<$checkbox_no; $i++) 
{ 
  $user_name[$i]=$_GET['fname'.$i.''];
  $user_gender[$i]=$_GET['sex'.$i.''];
  $user_age[$i]=$_GET['age'.$i.''];
  $user_title[$i]=$_GET['Title'.$i.''];
}

$user_mobile=$_GET['mobile'];
$user_email=$_GET['email_id'];
$user_address=$_GET['address'];
$user_id_no=$_GET['id_no'];
$user_idproof_type=$_GET['id_proof'];

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
$tripdetails2 = json_decode($tripdetails);

$seatschosen=$_GET['seatnames'];
$seats=explode(",", $seatschosen);

for ($i=0; $i <$checkbox_no ; $i++) 
{ 
  foreach ($tripdetails2 as $key => $value) 
  {
  	 if(is_array($value))
  	 {
  	   foreach ($value as $k => $v) 
       {         
         foreach ($v as $k1 => $v1)
         {
  	 	   if(isset($v->name))
           {
  	     	 if(!strcmp($v->name, $seats[$i]))
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

if(isset($_SESSION[$svr.'busbook']))
{

$order_id = getdata("svr_api_orders", "ba_id", "ba_trip_id='".$chosenbusid."' && ba_unique_id = ".$_SESSION[$svr.'busbook']);

$fare = $inventoryItems[0]['fare'];
$totalfare = $fare * $checkbox_no;

for($key=0; $key<$checkbox_no; $key++){
	$seat_name .= $inventoryItems[$key]['seatName'].'#';
	$ladies_seat .= $inventoryItems[$key]['ladiesSeat'].'#';
	$usertitle .= $user_title[$key].'#';
	$username .= $user_name[$key].'#';
	$userage .= $user_age[$key].'#';
	$usergender .= $user_gender[$key].'#';
}
$seat_no = substr($seat_name, 0, -1);
$ladies_seat = substr($ladies_seat, 0, -1);
$usertitle = substr($usertitle, 0, -1);
$username = substr($username, 0, -1);
$userage = substr($userage, 0, -1);
$usergender = substr($usergender, 0, -1);

if(empty($order_id))
{	
	mysql_query("insert into svr_api_orders(ba_id, ba_unique_id, ba_trip_id, ba_source, ba_destination, ba_total_fare, ba_no_passenger, ba_seat_no, ba_ladies_seat, ba_title,	ba_name, ba_age, ba_gender, ba_address, ba_email, ba_mobile, ba_id_proof, ba_journey_date, ba_status, ba_addeddate) values ('', '".$_SESSION[$svr.'busbook']."', '".$chosenbusid."', '".$sourceid."', '".$destinationid."', '".$totalfare."', '".$checkbox_no."', '".$seat_no."', '".$ladies_seat."', '".$usertitle."', '".$username."', '".$userage."', '".$usergender."', '".$user_address."', '".$user_email."', '".$user_mobile."', '".$user_idproof_type."', '".$journeydate."', 1, '".$now_time."')");
	
	$order_id = $_SESSION[$svr.'order_id'] = mysql_insert_id();
	
	/*for($key=0; $key<$checkbox_no; $key++){
		mysql_query("insert into svr_api_passengers(pass_id, pass_ba_id, pass_seat_name, pass_ladies_seat, pass_title, pass_name, pass_age, pass_gender, pass_journey_date, pass_status, pass_addeddate) values ('', '".$order_id."', '".$inventoryItems[$key]['seatName']."', '".$inventoryItems[$key]['ladiesSeat']."', '".$user_title[$key]."', '".$user_name[$key]."', '".$user_age[$key]."', '".$user_gender[$key]."', '".$journeydate."', 1, '".$now_time."')");
	}*/
}
}
echo "<form method='post' action='' name='form4' onSubmit=''>";
//echo "This is the json output for the block request <br><br> ".json_encode($json); 
echo "<table cellpadding=10 cellspacing=1 border=0 style='border:1px solid #eaeaea;' width='100%'>
<tr bgcolor='#F4F4F4'><td><h2>Customer Information</h2></td></tr>
<tr><td>";
echo "<table cellpadding=10 cellspacing=1 border=0 width='98%'>";
echo "<tr><td><table width='50%'>";
echo "<tr><td><strong>SNo</strong></td>
		<td><strong>Title</strong></td>
		<td><strong>Name</strong></td>
		<td><strong>Gender</strong></td>
		<td><strong>Age</strong></td></tr>";
for ($i=0; $i<$checkbox_no; $i++) 
{ 
	echo "<tr><td>".($i+1)."</td>";
	echo "<td>".$user_title[$i]."</td>";
	echo "<td>".$user_name[$i]."</td>";
	echo "<td>".$user_gender[$i]."</td>";
	echo "<td>".$user_age[$i]."</td></tr>";
}
echo "</table></td></tr>";
echo "</table>";
echo "</td></tr>";
echo "<tr bgcolor='#F4F4F4'><td><h2>Contact Details</h2></td></tr><tr><td align=left>";
echo "<table cellpadding=5 cellspacing=2 border=0><tr><td>";
echo "<tr><td>Mobile No.</td><td>:</td><td>".$user_mobile."</td></tr>";
echo "<tr><td>Email id</td><td>:</td><td>".$user_email."</td></tr>";
echo "<tr><td>Address</td><td>:</td><td>".$user_address."</td></tr>";
echo "<tr><td>Id-no.</td><td>:</td><td>".$user_id_no."</td></tr>";
echo "<tr><td>ID Proof Type</td><td>:</td><td>".$user_idproof_type."</td></tr>";
echo "<tr><td><label>&nbsp;</label><input type='submit' value='Proceed to Pay' onclick='return pay(".$order_id.")'></td></tr>";
echo "</table>";
echo "</td></tr></table><br>";

echo "<input type='hidden' name='blockreq' id='blockreq' value='blockrequest'>";
$_SESSION[$svr.'jsonobject']= $json;
$json = $_SESSION[$svr.'jsonobject'];
$json_2 = json_encode($json);
//$blockkey = blockTicket($json_2);
//echo $key;
//$con = confirmTicket($blockkey);
//echo $con;
echo "</form>";
include("includes/api-footer.php");
?>

<script type="text/javascript">
function pay(id){ 
	window.location.href = "payticket.php?order_id="+id;
	return false;
}
</script>