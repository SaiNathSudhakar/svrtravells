<!-- Banner Start-->
<? $images = $path = '';
if(!empty($_GET['lid']) && $row_loc['tloc_banner_image'] != '') { 
	$images = explode('|', $row_loc['tloc_banner_image']);
	$path = 'uploads/destination_locations/'.$row_loc['tloc_ref_no'].'/';
} gallery_images($images, $path); ?>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
  <div class="bg">
    <a href="index.php">Home</a>
    <span class="divied"></span>
    <a><?=$row_loc['cat_name'];?></a>
    <? if($row_loc['cat_id_fk'] == 2){?>
     <span class="divied"></span>
     <span class="pagename"><a href="destination.php?sid=<?=$row_loc['subcat_id_fk'];?>"><?=$row_loc['subcat_name']?></a></span>
    <? }?>
    <span class="divied"></span>
    <span class="pagename"><?=$row_loc['tloc_name'];?></span>
  </div>
</div>
<!-- Navigation end-->

<!-- Mid Content Start-->		  
<div class="inner_content">
<h1><?=$row_loc['tloc_code'].": ".$row_loc['tloc_name'];?>
<span style="font-size:16px">
    <? if(!empty($row_loc['tloc_transport'])) {
        echo "( ".$row_loc['tloc_transport']." ) ".(($row_loc['tloc_pickup_point'] != '') ? "Ex: ".$row_loc['tloc_pickup_point'] : '');
    }?>
</span></h1>
<h2><?=$nights;?> Nights / <?=$days;?> Days</h2>

<? $notes = explode("|", $row_loc['tloc_notes2']);?>
<div class="clear"></div>   
<? $cat = $row_loc['cat_id_fk']; $from = $row_loc['tloc_floc_id']; $to = $row_loc['tloc_id'];?>
<div><? include("design/search-tracker.php"); //search_tracker($cat, $from, $to);?></div>
<div class="clear"></div>

<? //if(sizeof($pickup_points) > 0){ include("design/pickup-points.php"); echo "<br />"; }?>

<? if(!empty($tour_fares) && !empty($fare_cats) && $row_loc['cat_id_fk'] == 2 ){ ?>
<h3>Package Cost Per Person in INR (<span class="rupee bold red">&#x20B9;</span>)</h3>
<? tour_fares_table($fare_cats, $farecatnames, $acc, $tour_fares); }?>
<div class="clear"></div>
<br />
	<? if(!empty($notes[0])) {?><h5 class="fl">Note <span>: <?=$notes[0]?></span></h5><? }?>
<br />
<form name="tourbookingform" id="tourbookingform" method="post" action="">
<input type="hidden" name="nights" id="nights" value="<?=intval($nights);?>">
<input type="hidden" name="days" id="days" value="<?=intval($days);?>">
<input type="hidden" name="totroomtype" id="totroomtype" value="<?=sizeof($acc);?>" autocomplete="off">
<input type="hidden" name="loc" id="loc" value="<?=$row_loc['tloc_id'];?>">
<input type="hidden" name="hid_date" id="hid_date" value="<?=$_GET['date'];?>">
<input type="hidden" name="category" id="category" value="2">
<input type="hidden" name="PickUpDetail" id="PickUpDetail">
<input type="hidden" name="PickUpTime" id="PickUpTime">
<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#E9E9E9"><div class="head">Tour Details</div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tour Name</td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><?=$row_loc['tloc_name'];?></td>
    <td align="right" valign="middle">Number of Pax <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle" id="pax_div">
	<select name="pax" id="pax" class="list">
		<option selected="selected" value="0">Select</option>
	</select>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#F7F7F7">Journey Date</td>
    <td align="center" valign="top" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="top" bgcolor="#F7F7F7"><?=date('l F d, Y', strtotime($_GET['date']))?><input type="hidden" name="min_pax" id="min_pax"></td>
    <td colspan="3" align="left" valign="top" bgcolor="#F7F7F7">
     <div class="occ_div">
     	<input name="room_occ_check" type="checkbox" id="room_occ_check" />* Single Adult In a Room #For single occupancy 
        <div id="room_occ_div_2" style="display:none">
			<span id="adults_occ_div"> <select name="adults_occ" id="adults_occ"><option value="">Select</option></select> </span>
			@ 
			<input type="text" name="adults_occ_fare" id="adults_occ_fare" size="4" readonly>
			= 
			<input type="text" name="adults_occ_total" id="adults_occ_total" size="4" readonly>
        </div>
     </div>
	 <div class="occ_div">
     	<input name="child_bed_check" type="checkbox" id="child_bed_check" />* Children with bed 
        <div id="child_bed_div_2" style="display:none">
			<span id="child_bed_div"> <select name="child_bed" id="child_bed"><option value="">Select</option></select> </span>
			@ 
			<input type="text" name="child_bed_fare" id="child_bed_fare" size="4" readonly>
			= 
			<input type="text" name="child_bed_total" id="child_bed_total" size="4" readonly>
        </div>
     </div>
	 <div class="occ_div">
     	<input name="child_nobed_check" type="checkbox" id="child_nobed_check" />* Children without bed 
        <div id="child_nobed_div_2" style="display:none">
			<span id="child_nobed_div"> <select name="child_nobed" id="child_nobed"><option value="">Select</option></select> </span>
			@ 
			<input type="text" name="child_nobed_fare" id="child_nobed_fare" size="4" readonly>
			= 
			<input type="text" name="child_nobed_total" id="child_nobed_total" size="4" readonly>
        </div>
		<input type="hidden" id="clear">
     </div>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Hotel Type <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle">
	  <div class="col13">
        <? foreach($acc as $key => $room){?>
        <input name="room_type" id="room_type_<?=$key?>" value="<?=$room?>" class="RB" type="radio"><?=$room_type[$room];?>
        <? }?>
	  </div>	</td>
    <td align="right" valign="middle">Tax & Service Charge</td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input type="text" name="tax" id="tax" readonly /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#F7F7F7">Car Type <span class="star">*</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7" id="vehicle_div">
    <select name="vehicle" id="vehicle" class="list">
      <option value="">Select</option>
      <? foreach($vehicle_names as $key => $vehicle){ ?>
      <option value="<?=$key?>"><?=$vehicle;?></option>
      <? }?>
	</select>
	</td>
    <td align="right" valign="middle" bgcolor="#F7F7F7">Total Fare</td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7">
	<!--<input type="hidden" name="ag_dp" id="ag_dp" value="<?=(!empty($_SESSION[$svra.'ag_deposit'])) ? $_SESSION[$svra.'ag_deposit'] : '';?>" />-->
	<input type="text" name="totalfare" id="totalfare" readonly /></td>
  </tr>
</table>
<br />
<? if(!empty($notes[1])) { ?><p><?=$notes[1]?></p><? }?>
<? if(!empty($notes[2])) { ?><p><?=$notes[2]?></p><? }?>
<? 
$display = (isset($_SESSION[$svr.'cust_id'])) ? '' : 'none';
if(isset($_SESSION[$svr.'cust_id']))
{	
	$atrributes = 'readonly'; $disabled = 'disabled';
	if($title != '') $title_disabled = 'disabled';
	if($state != '') $state_disabled = 'disabled';
} else {
	$customer = $title = $fname = $lname = $email = $addr = $mobile = $city = $state = $country = '';
	$atrributes = $disabled = '';
}
include('design/quick-customer-registration.php');?>
<br />
<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2" id="pickup_drop_table" class="reg_row" style="display:<?=$display;?>">
  <tr>
	<td width="300" colspan="3" align="left" valign="middle" bgcolor="#E9E9E9">
	<input name="pickup_check" type="checkbox" id="pickup_check" /> PickUp Information Not Yet Decided</td>
	<td colspan="3" align="left" valign="middle" bgcolor="#E9E9E9">
	<input name="drop_check" type="checkbox" id="drop_check" /> Drop Information Same As PickUp Address</td>
  </tr>
  <tr>
    <td align="left" valign="middle" width="120">PickUp From </td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle">
		<input value="1" name="pickup" type="radio" id="RadFlight" class="pickup" checked="checked" /> Flight
      	<input value="2" name="pickup" type="radio" id="RadTrain" class="pickup" /> Train
      	<input value="3" name="pickup" type="radio" id="RadBus" class="pickup" /> Address/Location	
	</td>
    <td align="left" valign="middle" width="80">Drop At</td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle">
		<input value="1" name="drop" type="radio" id="RadFlight1" class="drop" checked="checked" /> Flight
      	<input value="2" name="drop" type="radio" id="RadTrain1" class="drop" /> Train
      	<input value="3" name="drop" type="radio" id="RadBus1" class="drop" /> Address/Location	
	</td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#F7F7F7">City</td>
    <td align="center" valign="top" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="top" bgcolor="#F7F7F7"><?=$row_loc['floc_name'];?></td>
    <td valign="top" bgcolor="#F7F7F7">&nbsp;</td>
    <td align="center" valign="top" bgcolor="#F7F7F7">&nbsp;</td>
    <td valign="top" bgcolor="#F7F7F7">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><span id="place_caption">Airport</span> <!--<span class="star">*</span>--></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top"><input type="text" name="place" id="place" class="textbox pickup" /></td>
    <td valign="top"><span id="place1_caption">Airport</span></td>
    <td align="center" valign="top">:</td>
    <td valign="top"><input type="text" name="place1" id="place1" class="textbox drop" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><span id="place_detail_caption">Flight No</span> <!--<span class="star">*</span>--></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="place_detail" type="text" class="textbox pickup" id="place_detail" /></td>
    <td valign="middle" bgcolor="#F7F7F7"><span id="place_detail1_caption">Flight No</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="place_detail1" type="text" class="textbox drop" id="place_detail1" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span id="time_caption">Expected Arrival Time</span> <!--<span class="star">*</span>--></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input type="text" name="time" id="time" class="textbox pickup" readonly /></td>
    <td valign="middle"><span id="time1_caption">Departure Time</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><div id="sample2"><input type="text" name="time1" id="time1" class="textbox drop" readonly /></div></td>
  </tr>
</table>
<br />
<? include('design/quick-payment.php');?>
</form>

<? include('design/quick-password.php');?>

<div class="clear"></div>
<? if($row_loc['cnt_content'] != '') { ?>
<br /><h3>*<a href="#dealit" rel="facebox"> Terms & Conditions</a></h3>
<? }?>
</div>

<div id="dealit">
	<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
	<div style="padding:20px;" class="facebox">
		<?=$row_loc['cnt_content'];?>
	</div>
</div>

<link href="css/jquery.ui.timepicker.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.ui.timepicker.js"></script>
<script language="javascript">
$(document).ready(function(){
	$('#time, #time1').timepicker({
		showNowButton: true,
		showDeselectButton: true,
		showLeadingZero: false,
		showPeriod: true,
		defaultTime: '',  // removes the highlighted time for when the input is empty.
		showCloseButton: true
	});
});
</script>