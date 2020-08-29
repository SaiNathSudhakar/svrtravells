<!-- Banner Start-->
<? $images = $path = '';
if(!empty($_GET['lid']) && $row_loc['tloc_banner_image'] != '') { 
	$images = explode('|', $row_loc['tloc_banner_image']);
	$path = 'uploads/destination_locations/'.$row_loc['tloc_ref_no'].'/';
} gallery_images($images, $path); ?>
<!-- Banner End-->
<? //echo $row_loc['pkg_ac_seats'];echo $row_loc['pkg_nac_seats'];exit; ?>
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
<h1>
	<?=$row_loc['tloc_code'].": ".$row_loc['tloc_name'];?>
	<span style="font-size:16px">
		<? if(!empty($row_loc['tloc_transport'])) {
			echo "( ".$row_loc['tloc_transport']." ) ".(($row_loc['tloc_pickup_point'] != '') ? "Ex: ".$row_loc['tloc_pickup_point'] : '');
		}?>
	</span>
</h1>

<div class="clear"></div>   
<? $cat = $row_loc['cat_id_fk']; $from = $row_loc['tloc_floc_id']; $to = $row_loc['tloc_id'];?>
<div><? include("design/search-tracker.php"); //search_tracker($cat, $from, $to, $avail_dates);?></div>
<div class="clear"></div>
<div id="mid_position"></div>
<? if(empty($row_pkg['avail_ac_seats'])){?><br><br> <div style="border-style: solid; border-width: thin; color:#DDDDDD"><br><br>
<h1 align="center" style="color:#E4002E;font-weight:100">Sold Out..!</h1><br></div> <? } else{ ?>
<form name="fixedbookingform" id="fixedbookingform" method="post" action="">
<? if(sizeof($pickup_points) > 0) include("design/pickup-points.php");?>

<!-- ////////////////// FIXED DEPARTURES FARES - BEGIN ////////////////// -->
<? if($row_loc['cat_id_fk'] == 1) { ?>
<div class="mt30">
	<!--<div class="col-3">
		<h3>Places Covered: <span><?=$row_loc['tloc_places_covered'];?></span></h3>
	</div>-->
	<div><!--col-4-->
		<? 
		if(!empty($fixed_fares) && !empty($fare_cats) && $row_loc['cat_id_fk'] == 1){
		  if(!empty($fixed_fares) && !empty($fare_cats)){ ?>
		  <table style="border:1px solid #eaeaea;" cellpadding="10" cellspacing="1" width="100%">
			<tbody>
			  <tr>
				<td align="center" bgcolor="#F4F4F4" valign="middle"><span class="red_heading">Category</span></td>
				<? $j = 0; foreach($acc as $ac){ 
				$seats = ($avail_seat_count[$ac] != '') ? ' ('.$avail_seat_count[$ac].')' : ''; ?>
				<td align="center" valign="middle" bgcolor="#F4F4F4"><span class="red_heading">
				<input type="radio" name="ac_radio" id="ac<?=$j?>" width="<?=$ac?>" class="ac_radio" value="<?=$j?>" autocomplete="off" <?=($seats == ' (0)') ? 'disabled' : '';?>>
				<input type="hidden" name="seatsavailable<?=$j?>" id="seatsavailable<?=$j?>" value="<?=$avail_seat_count[$ac]?>" >
				<?=$accomodation_type[$ac].$seats;?></span></td>
			    <? $j++; }?>
				<td align="center" valign="middle" bgcolor="#F4F4F4">No. of Persons</td>
			    <td align="center" valign="middle" bgcolor="#F4F4F4">Fare Person</td>
			    <td align="center" valign="middle" bgcolor="#F4F4F4">Calculated Amount</td>
			  </tr>
			  <? $i = 0; foreach($fare_cats as $fare_cat){
			  if(!empty($fixed_fares[$fare_cat][$ac])){ ?>
			  <tr bgcolor="<?=($i % 2 == 0) ? '#FFFFFF' : '#F4F4F4';?>">
				<td align="left" valign="middle" nowrap="nowrap"><?=$farecatnames[$fare_cat];?></td>
				<? $j = 0; foreach($acc as $ac){?>
				<td align="center" valign="middle" nowrap="nowrap">
                <input type="hidden" name="fare<?=$i.$j;?>" id="fare<?=$i.$j;?>" value="<?=$fixed_fares[$fare_cat][$ac];?>">
				<span class="rupee">&#x20B9;</span> <?=$fixed_fares[$fare_cat][$ac].'/-';?></td>
				<? $j++; }?>
				<td align="center" valign="middle" nowrap="nowrap">
				<input name="multiple<?=$i?>" id="multiple<?=$i?>" type="hidden" value="<?=$multiples[$fare_cat];?>">
				<input name="adultchild<?=$i?>" id="adultchild<?=$i?>" type="hidden" value="<?=$adultchild[$fare_cat];?>">
				<input name="qty<?=$fare_cat?>" type="text" class="qty" value="0" onkeypress="return chkNumeric(event);" autocomplete="off" style="width:35px;text-align:center"/> x</td>
			    <td align="center" valign="middle"><div id="fare_person<?=$i?>" class="fare_person">0 =</div></td>
			    <td align="center" valign="middle"><div id="calc_amount<?=$i?>" class="calc_amount">0</div></td>
			  </tr>
			  <? $i++; }}?>
			  <tr>
				<td align="left" valign="middle" nowrap="nowrap" bgcolor="#F4F4F4"></td>
				<? foreach($acc as $ac){?>
				<td align="center" valign="middle" nowrap="nowrap" bgcolor="#F4F4F4">&nbsp;</td>
				<? }?>
				<td align="center" valign="middle" nowrap="nowrap" bgcolor="#F4F4F4"></td>
			    <td align="center" valign="middle" bgcolor="#F4F4F4">Total:</td>
			    <td align="center" valign="middle" bgcolor="#F4F4F4"><div id="total_amount">0</div>
				<input type="hidden" name="ag_dp" id="ag_dp" data-num="<?=(!empty($_SESSION[$svra.'ag_id']) && $_SESSION[$svra.'ag_deposit'] != 0.00) ? '1' : '';?>" value="<?=(!empty($_SESSION[$svra.'ag_deposit'])) ? $_SESSION[$svra.'ag_deposit'] : '';?>" />
				</td>
			  </tr>
			</tbody>
		  </table>
		  <? }?>
		<div class="clear"></div><br />
		<div>
			<h5>Note : <span>The fares indicated against package tours displayed on this website are subject to seasonal variations. The fare will be charged prevailing at the time of booking. Customers may please check the change in the fares / tariff through e.mail / fax/ phone.</span></h5>
			<center>
			<input name="check_availability" id="check_availability" type="button" class="submit-btn" value="Check Availability" />
			<input name="reset" id="fixed_booking_reset" type="button" class="submit-btn" value="Reset" onclick="return resetSelection()" /></center>
		</div>
		<? }?>
	</div>
</div>
<div class="clear"></div>
<br />
<? }?>
<!-- ////////////////// FIXED DEPARTURES FARES - END ////////////////// -->

<!-- ////////////////// BUS LAYOUT - BEGIN ////////////////// -->
<div id="bus_layout" style="display:none">
<? include('design/bus-layout.php'); ?>
<input type="submit" name="btnContinuee" id="btnContinuee" value="Continue Booking" onclick="return checkseats();" class="submit-btn">
</div>
<!-- ////////////////// BUS LAYOUT - END ////////////////// -->

<input type="hidden" name="totamount" id="totamount" autocomplete="off">
<input type="hidden" name="totqty" id="totqty" autocomplete="off">
<input type="hidden" name="totchild" id="totchild" autocomplete="off">
<input type="hidden" name="totadult" id="totadult" autocomplete="off">
<input type="hidden" name="totbustype" id="totbustype" value="<?=sizeof($acc);?>" autocomplete="off">
<input type="hidden" name="bustype" id="bustype" autocomplete="off">
<input type="hidden" name="hid_toloc" id="hid_toloc" value="<?=$row_loc['tloc_id'];?>" autocomplete="off" />
<input type="hidden" name="hid_days" id="hid_days" value="<?=$day;?>" autocomplete="off">
<input type="hidden" name="hid_date" id="hid_date" value="<?=$row_loc['pkg_date'];?>" autocomplete="off" />
<input type="hidden" name="hid_pkg_id" id="hid_pkg_id" value="<?=$row_loc['pkg_id'];?>" autocomplete="off" />
<input type="hidden" name="hid_fare_cats" id="hid_fare_cats" value="<?=implode(',', $fare_cats);?>" autocomplete="off" />
<input type="hidden" name="PickUpDetail" id="PickUpDetail">
<input type="hidden" name="PickUpTime" id="PickUpTime">
<input type="hidden" name="hid_pick_detail" id="hid_pick_detail" value="">
<input type="hidden" name="hid_pick_time" id="hid_pick_time" value="<?=$deptime;?>">

<input type="hidden" name="maxSeatAllowed" id="maxSeatAllowed" autocomplete="off" />
<input type="hidden" name="optedSeatNos" id="optedSeatNos" autocomplete="off" />
<input type="hidden" name="NoSeatsSel" id="NoSeatsSel" autocomplete="off" />

</form>
<? }?>
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

<script language="javascript">
$(document).ready(function(){ 
	<? if(sizeof($acc) == 1){ ?>
		$('.ac_radio').attr('checked', true);
		$('#bustype').val($('input:radio[name=ac_radio]:checked').attr('width'));
		$('.qty').trigger("keyup");
	<? }?>
});
</script>
<script language="javascript" src="js/tourbooking.js" type="text/javascript"></script>