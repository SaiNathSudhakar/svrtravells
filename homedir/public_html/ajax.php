<?
ob_start();
//session_start();
include_once("includes/functions.php");

////////////SEARCH TRACKER//////////// ?>

<? if(!empty($_POST['fares_cat']) && !empty($_POST['from']) && !empty($_POST['search_tracker']) && $_POST['fares_cat'] == 1) { 
	$svr_query = query("select distinct(tloc_id), tloc_name from svr_to_locations as tloc
		left join svr_from_locations as floc on tloc.tloc_floc_id = floc.floc_id
			where tloc_status = 1 and tloc_floc_id = '".$_POST['from']."' and cat_id_fk = '".$_POST['fares_cat']."' order by tloc_orderby"); ?>
	<select name="fdtoloc" id="fdtoloc" class="ml30" style="width:180px;">
    	<option value="">--- Select Arrival City ---</option>
	   	<?php while($row = fetch_array($svr_query)){ ?>
	   	<option value="<?=$row['tloc_id'];?>"><?=ucwords(strtolower($row['tloc_name']));?></option>
	   	<? }?>
	</select>
<? } if(!empty($_POST['fares_cat']) && !empty($_POST['from']) && !empty($_POST['search_tracker']) && $_POST['fares_cat'] == 2) { 
	$svr_query = query("select distinct(tloc_id), tloc_name from svr_to_locations as tloc
		left join svr_from_locations as floc on tloc.tloc_floc_id = floc.floc_id
			where tloc_status = 1 and tloc_floc_id = '".$_POST['from']."' and cat_id_fk = '".$_POST['fares_cat']."' order by tloc_orderby"); ?>
	<select name="hptoloc" id="hptoloc" class="ml30" style="width:180px;">
    	<option value="">--- Select Arrival City ---</option>
	   	<?php while($row = fetch_array($svr_query)){ ?>
	   	<option value="<?=$row['tloc_id'];?>"><?=ucwords(strtolower($row['tloc_name']));?></option>
	   	<? }?>
	</select>
	
<? } if(!empty($_POST['to']) && !empty($_POST['avail_tracker'])) { 
	
	$qur_pkg = query("select pkg_id, pkg_date, ((pkg_ac_seats + pkg_nac_seats)-COALESCE(sum(bot_no_of_persons), 0)) as avail_seats from svr_packages as pkg 
		left join svr_book_order_temp as bot on bot.bot_pkg_id = pkg.pkg_id AND 
			(bot_request_status = 1 or bot_added_date > subtime('".$now_time."', '".$ftime_span."') and bot_request_status = 0)
				where pkg_date > CURDATE() and pkg_to_id = ".$_POST['to']." group by pkg_id having avail_seats > 0");
	
	while($row_pkg = fetch_array($qur_pkg)) $avail_dates[] = date('d-m-Y',strtotime($row_pkg['pkg_date']));
	
	echo implode(",", $avail_dates);
	
} if(!empty($_POST['get_pax'])) { 
	$loc = $_POST['loc']; $room_type = $_POST['room_type']; $vehicle = $_POST['vehicle'];
	$data = get_min_max_pax($loc, $room_type, $vehicle); 
	list($min, $max) = explode("#", $data);?>
	<select name="pax" id="pax" class="list">
		<option value="">Select</option>
        <? for($i = 1; $i <= $max; $i++){?><option value="<?=$i?>"><?=$i?></option><? }?>
	</select>
    #
    <?=$min?>
    
<? } if(!empty($_POST['get_fares']) && $_POST['get_fares'] == 1) { 
	$loc = $_POST['loc']; $room_type = $_POST['room_type']; $vehicle = $_POST['vehicle']; 
	$pax = $_POST['pax']; $min_pax = $_POST['min_pax']; $nights = $_POST['nights']; $days = $_POST['days']; 
	
	$data = get_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days); 
	list($tax, $fare) = explode("#", $data);?>
	<?=$tax?>#<?=$fare?>#
    <select name="adults_occ" id="adults_occ">
		<option value="">Select</option>
        <? for($i = 1; $i <= $pax; $i++) {?><option value="<?=$i?>"><?=$i?></option><? }?>
	</select>#
	<select name="child_bed" id="child_bed">
		<option value="">Select</option>
        <? for($i = 1; $i <= $pax; $i++) {?><option value="<?=$i?>"><?=$i?></option><? }?>
	</select>
	#
	<select name="child_nobed" id="child_nobed">
		<option value="">Select</option>
        <? for($i = 1; $i <= $pax; $i++) {?><option value="<?=$i?>"><?=$i?></option><? }?>
	</select>
    
<? } if(!empty($_POST['get_fares']) && $_POST['get_fares'] == 2) { 

	$loc = $_POST['loc']; $room_type = $_POST['room_type'];	$vehicle = $_POST['vehicle'];	
	$pax = $_POST['pax']; $min_pax = $_POST['min_pax']; $hotel_name = $_POST['hotel_name'];
	$nights = $_POST['nights']; $days = $_POST['days'];  $new_pax = $_POST['new_pax']; 
	
	$data = get_additional_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $hotel_name);
	
	list($tax, $fare, $hotel_charges, $additional_fare, $pax_left) = explode("#", $data);?>
	
	<?=$tax?>#<?=$fare?>#<?=$hotel_charges?>#<?=$additional_fare?>
    
 <? } if(!empty($_POST['get_fares']) && $_POST['get_fares'] == 3) { 
 
	$loc = $_POST['loc']; $room_type = $_POST['room_type'];	$vehicle = $_POST['vehicle'];	
	$pax = $_POST['pax']; $min_pax = $_POST['min_pax']; $nights = $_POST['nights']; $days = $_POST['days'];$hotel_name = $_POST['hotel_name']; 
	$new_pax = $_POST['new_pax']; $childbed_pax = $_POST['childbed_pax']; $childnobed_pax = $_POST['childnobed_pax'];
	$data = get_fares_childbed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax, $hotel_name);
	
	list($tax, $fare, $hotel_charges, $additional_fare, $pax_left) = explode("#", $data); ?>
	
	<?=$tax?>#<?=$fare?>#<?=$hotel_charges?>#<?=$additional_fare?>
    
<? } if(!empty($_POST['get_fares']) && $_POST['get_fares'] == 4) { 

	$loc = $_POST['loc']; $room_type = $_POST['room_type'];	$vehicle = $_POST['vehicle']; $get_fares = 4;
	$pax = $_POST['pax']; $min_pax = $_POST['min_pax']; $nights = $_POST['nights']; $days = $_POST['days'];$hotel_name = $_POST['hotel_name']; 
	$new_pax = $_POST['new_pax']; $childbed_pax = $_POST['childbed_pax']; $childnobed_pax = $_POST['childnobed_pax'];
	
	$data = get_fares_childnobed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax, $get_fares, $hotel_name);
	
	list($tax, $fare, $hotel_charges, $additional_fare, $pax_left) = explode("#", $data); ?>
	
	<?=$tax?>#<?=$fare?>#<?=$hotel_charges?>#<?=$additional_fare?>
    
<? } if(!empty($_POST['email']) && $_POST['tour_email'] == 1) {
	
	  $q = query("select cust_password, cust_id, cust_title, cust_fname, cust_lname, cust_email, cust_address_1, cust_mobile, cust_city, cust_state, cust_country from svr_customers where cust_email = '".$_POST['email']."'");
	  $count = num_rows($q); $row = fetch_assoc($q);
	  
	  echo $count.'#'.$row['cust_password'].'#'.implode('|', $row);
	  
 } if(!empty($_POST['info']) && $_POST['tour_session'] == 1) {
	 
	  list($pwd, $id, $title, $fname, $lname, $email, $addr, $mobile, $city, $state, $country) = explode('|', $_POST['info']);
	  $_SESSION[$svr.'cust_id'] = $id;
	  $_SESSION[$svr.'cust_title'] = $title;
	  $_SESSION[$svr.'cust_fname'] = $fname;
	  $_SESSION[$svr.'cust_lname'] = $lname;
	  $_SESSION[$svr.'cust_email'] = $email;
	  $_SESSION[$svr.'cust_addr'] = $addr;
	  $_SESSION[$svr.'cust_mobile'] = $mobile;
	  $_SESSION[$svr.'cust_city'] = $city;
	  $_SESSION[$svr.'cust_state'] = $state;
	  $_SESSION[$svr.'cust_country'] = $country;
	  
} if(!empty($_POST['pick_id']) && $_POST['pickup_point'] == 1) {
	
	$q = query("select pick_time, pick_note from svr_pickup_points where pick_id = '".$_POST['pick_id']."'");
	$row = fetch_array($q);
	
	echo $row['pick_time'].'#'.$row['pick_note'];
	
} if(!empty($_POST['email']) && !empty($_POST['ticket']) && !empty($_POST['cancel_ticket'])) {
	
	$q = query("select ba_source_name, ba_destination_name, ba_travels_name, ba_total_fare, ba_id, ba_ag_id, ba_journey_date, ba_order_status from svr_api_orders where ba_email = '".$_POST['email']."' and ba_ticket_no = '".$_POST['ticket']."'");
	$count = num_rows($q); $row = fetch_assoc($q);
	
	/*include_once "api/library/OAuthStore.php";
	include_once "api/library/OAuthRequester.php";
	include_once "SSAPICaller.php";
	$cancldata = getCancellationData($row['ba_ticket_no']);
	$cancldata = json_decode($cancldata);
	foreach ($cancldata as $key => $value){if(!strcmp($key,'cancellable')) $cancellable = $value;}*/
	if($count > 0){
		if(!empty($row['ba_ag_id']) && empty($_SESSION[$svra.'ag_id'])) 
			$count = '-1'; //Login as Agent to Cancel
		else if(empty($row['ba_ag_id']) && !empty($_SESSION[$svra.'ag_id'])) 
			$count = '-2'; //This ticket was not Booked by Agent.
		else if(!empty($row['ba_ag_id']) && !empty($_SESSION[$svra.'ag_id']) && $_SESSION[$svra.'ag_id'] <> $row['ba_ag_id']) 
			$count = '-3'; //This ticket was booked by another agent
	}
	
	$jdate = date('d/m/Y', strtotime($row['ba_journey_date'])); //implode('|', $row);
	echo $count.'#'.$row['ba_order_status'].'#'.$row['ba_id'].'#'.$jdate.'#'.$row['ba_source_name'].'#'.$row['ba_destination_name'].'#'.$row['ba_travels_name'].'#'.$row['ba_total_fare'].'#'.$_POST['ticket'].'#'.$error;
	  
 }

if(!empty($_POST['search_bus_tracker']) && $_POST['search_bus_tracker'] == 1) {
	include('search-bus-booking.php');
}

if(!empty($_POST['ticket']) && $_POST['printit'] == 1) {
	$ticket = $_POST['ticket'];$printit = $_POST['printit'];
	include('print_ticket.php');
}


if(!empty($_POST['hotel_id'])) {
	
	$q = query("select hfr_fare, hfr_fu_fare from svr_hotel_fares where hfr_id = '".$_POST['hotel_id']."'");
	$row = fetch_array($q);
	
	echo $row['hfr_fare'].'#'.$row['hfr_fu_fare'];
	
} 
?>	