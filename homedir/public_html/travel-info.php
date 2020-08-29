<? 
$sourceName = $_SESSION['sourceName']; //getSourceName($_SESSION['sourceList']);
$destinationName = $_SESSION['destinationName']; //getDestinationName($_SESSION['sourceList'], $_SESSION['destinationList']);
$jdate = date('l, F d, Y', strtotime($_SESSION['datepicker']));
$indate = date('l, F d, Y', strtotime($_SESSION['frmdatepicker']));
$outdate = date('l, F d, Y', strtotime($_SESSION['todatepicker']));
$chosen = $_SESSION['chosenone'];

if(!empty($chosen)){
//$op = getBusDetails($chosen, $_SESSION['sourceList'], $_SESSION['destinationList'], $_SESSION['datepicker']);
//list($travelName, $arrivalTime, $departureTime, $travelType) = explode('#', $op);
$travelName = $_SESSION['travelName'];
$arrivalTime = $_SESSION['arrivalTime'];
$departureTime = $_SESSION['departureTime'];
$travelType = $_SESSION['travelType'];
}?>
<script>
function goBack() {
    window.history.back();
}
</script>
<div class='mt 10 mb10' style="padding-bottom:10px; border-bottom:1px solid #e2e2e2;">

<table border='0' style='border-collapse:collapse' width='100%'>
  <tr>
    <td align="left"><h3 style="margin-bottom:10px; padding-bottom:10px;">TRAVEL INFORMATION</h3></td><td style="float:right; " > <span class="ml10 mb20">
    <input type='button' class="btn" onclick="goBack()" value='Back'></span></td>
  </tr>
  <tr><td align="center">
<table width="60%" align='center' cellpadding=5 cellspacing=0 class="travelinfo" >
<tbody>
  <tr class="<?=(empty($seatschosen) && empty($chosen)) ? 'last' : '';?>">
	<td colspan="4">
	<div style="font-size:22px">
		<b><? echo $sourceName;?></b> &emsp;to&emsp;<b><? echo $destinationName;?></b>&emsp;<?=$jdate?>
	</div>
	</td>
  </tr>
<? if(!empty($chosen)){ ?>
  <tr class="<?=(empty($seatschosen)) ? 'last' : '';?>">
	<td>
	  <p><? echo $travelName;?></p> 
	  <span><? echo $travelType;?></span>
	</td>
	<td>
		<p><? echo $arrivalTime;?></p>
		<span>Reporting time</span>  
	</td>
	<td>
		<p><? echo $departureTime;?></p>
		<span>Departure time</span>  
	</td>
	<td><? if(!empty($seatschosen)){?>
		<p><? echo $seatschosen;?></p>
		<span>Seat numbers</span> <? }?>
	</td>
  </tr>
  <? }if(!empty($seatschosen)){?>
  <tr class="last">
	<td>
		<p><? echo 'Rs. '; echo $fare?></p>
		<span>Total Fare</span>
	</td>
	<td>
		<p><? echo $boardingLoc;?></p>
		<span>Boarding Location</span>  
	</td>
	<td>
		<p><? echo $boardingTime;?></p>
		<span>Boarding Time</span>  
	</td>
	<td>
		<p><? echo $sourceName;?></p>
	</td>
  </tr>
  <? }?>
</tbody>
</table>
</td>
</tr></table>

<? if(!empty($_SESSION['frmdatepicker']) && !empty($_SESSION['actual_hfare']) && !empty($_SESSION['hpersons']) && !empty($seatschosen) && ($_SESSION['sourceList']== 6) && ($_SESSION['destinationList']== 635)){ ?>
<br><br>
<table border='0' style='border-collapse:collapse' width='90%'>
  <tr>
    <td align="left"><h3 style="margin-bottom:10px; padding-bottom:10px;">HOTEL INFORMATION</h3></td>
  </tr>
  <tr><td align="center">
<table width="60%" align='center' cellpadding=5 cellspacing=0 class="travelinfo" >
<tbody>
  <tr>
	<td colspan="4">
	<div style="font-size:22px">
		<b>Hotel Booking Confirmation Details</b>
	</div>
	</td>
  </tr>
  <tr>
	<td>
    	<p><? echo $hotel_name;?></p>
		<span>Hotel</span>	
    </td>
    <td>
		<p><? echo $indate;?></p>
		<span>Check-In Date</span>  
	</td>
    <td>
		<p><? echo $outdate;?></p>
		<span>Check-Out Date</span>  
	</td>
  </tr>
  <tr>
  	<td><p>Rs. <? echo number_format($_SESSION['actual_hfare'],2);?></p>
		<span>Total Cost </span> 
	</td>
    <td>
	  <p><? echo $_SESSION['hpersons'];?></p> 
	  <span>Number Of Persons</span>
	</td>
    <? if($indate == $outdate){?>
    <td>Same Day Check-Out</td>
    <? } else {?>
    <td>
	  <p><? echo $_SESSION['hdays'];?></p>
	  <span>Number Of Nights</span>
	</td><? }?>
  </tr>
 </tbody>
</table>
</td>
</tr></table>
<? }?>

</div>
<style>
.travelinfo tr{ margin:0;padding:0; }
.travelinfo td{ white-space:nowrap; font-size:14px; margin:0;padding:10px;border-bottom:1px solid #e0e0e0;vertical-align:middle; }
.travelinfo span{ font-size:12px;color:#999;margin:0;padding:0; }
.travelinfo p{ font-weight:700;margin:0 0 5px;padding:0;text-transform:capitalize; }
.travelinfo tr.last td{ border-bottom:none; }
</style>