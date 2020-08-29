<?
ob_start();
include_once("includes/functions_dev.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	//var_dump($_POST); exit;
	if(!empty($_SESSION[$svra.'ag_id']) && ($_POST['totalfare'] > $_SESSION[$svra.'ag_deposit'])) {
		//header('location:agentpay.php?id=3');
		header('location:agent-insufficient-balance.php');
	} else {
		$to_location = $_POST['loc'];
		$journey_date = db_date($_POST['hid_date']);
		$days = $_POST['days'];
		$return_date = date('Y-m-d', strtotime($journey_date. ' + '.($days-1).' days'));
		$amount = number_format($_POST['totalfare'], 2, '.', '');
		//$amount = $amount + (($service_tax * $amount)/100);
		$cust_id = isset($_SESSION[$svr.'cust_id']) ? $_SESSION[$svr.'cust_id'] : '';
		$room_type = $_POST['room_type'];
		$vehicle_type = $_POST['vehicle'];
		
		$no_of_persons = $_POST['pax'];
		//$occupancy = $_POST['adults_occ'].','.$_POST['child_bed'].','.$_POST['child_nobed'];
		$tot_child = $_POST['child_bed'] + $_POST['child_nobed'];
		$tot_adult = $no_of_persons - $tot_child;
		
		$tot_adult2sharing = $no_of_persons - ($_POST['adults_occ'] + $_POST['child_bed'] + $_POST['child_nobed']);
		//1-adults_occ; 2-child_bed; 3-child_nobed
		$room_occupancy = array('' => 'Select', '1' => 'Single Adult in a Room', '2' => 'Child with Bed', '3' => 'Child without Bed', '4' => 'Adult on Twin Sharing');
		
		$fare_cat_ids = implode(',', array_filter(array_keys($room_occupancy)));
		$fare_cat_qty = $_POST['adults_occ'].','.$_POST['child_bed'].','.$_POST['child_nobed'].','.$tot_adult2sharing;
		
		$pickup_from = $_POST['pickup'];
		$pickup_place = $_POST['place'];
		$pickup_detail = $_POST['place_detail'];
		$pickup_time = $_POST['time'];
		
		$drop_at = $_POST['drop'];
		$drop_place = $_POST['place1'];
		$drop_place_detail = $_POST['place_detail1'];
		$drop_time = $_POST['time1'];
		
		$customer = $_POST['customer'];
		$total_amount = $_POST['amount'];
		$emergency = $_POST['emergency'];
		$comments = $_POST['comments'];
		
		$title = $_POST['title'];
		$fname = $_POST['fname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$address1 = $_POST['address'];
		$mobile = $_POST['mobile'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		
		$_SESSION[$svr.'tour_order_id'] = 'SVRO'.rand(10000, 99999);
		$addedby = (empty($_SESSION[$svra.'ag_id'])) ? 0 : 1;
		$agid = (!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_id'] : 0;
		
		query("insert into svr_book_order_temp (`bot_id`, `bot_order_id`, `bot_tloc_id`, `bot_journey_date`, `bot_return_date`, `bot_pkg_id`, `bot_amount`, `bot_cust_id`, `bot_type`, `bot_room_type`, `bot_vehicle_type`, `bot_fc_id`, `bot_fc_qty`, `bot_no_of_persons`, `bot_tot_adult`, `bot_tot_child`, `bot_pickup_from`, `bot_pickup_place`, `bot_pickup_place_detail`, `bot_pickup_time`, `bot_drop_at`, `bot_drop_place`, `bot_drop_place_detail`, `bot_drop_time`, `bot_request_status`, `bot_status`, `bot_added_by`, `bot_added_date`, `bot_ag_id`)  values ('', '".$_SESSION[$svr.'tour_order_id']."', '".$to_location."', '".$journey_date."', '".$return_date."', '".$pkg_id."', '".$amount."', '".$cust_id."', '2', '".$room_type."', '".$vehicle_type."',  '".$fare_cat_ids."', '".$fare_cat_qty."', '".$no_of_persons."', '".$tot_adult."', '".$tot_child."', '".$pickup_from."', '".$pickup_place."', '".$pickup_detail."', '".$pickup_time."', '".$drop_at."', '".$drop_place."', '".$drop_place_detail."', '".$drop_time."', '0', '1', '".$addedby."', '".$now_time."', '".$agid."')");
		
		if(empty($_POST['customer']))
		{	
			//$addedby = (empty($svra.$_SESSION['ag_id'])) ? 0 : 1;
			query("insert into svr_customers(cust_id, cust_title, cust_fname, cust_lname, cust_dob, cust_mobile, cust_landline, cust_email ,cust_password, cust_address_1, cust_address_2, cust_city, cust_country, cust_state, cust_pincode, cust_status, cust_added_by, cust_added_date, cust_ag_id)values('', '".$title."', '".$fname."', '".$lname."', '".$dob."', '".$mobile."', '".$phone."', '".$email."', '".md5($password)."', '".$address1."', '".$address2."', '".$city."', '".$country."', '".$state."', '".$pin."', 1, '".$addedby."', '".$now_time."', '".$_SESSION[$svra.'ag_id']."')");
			$customer = insert_id();
			
			$_SESSION[$svr.'cust_id'] = $customer;
			$_SESSION[$svr.'cust_title'] = $title;
			$_SESSION[$svr.'cust_fname'] = $fname;
			$_SESSION[$svr.'cust_lname'] = $lname;
			$_SESSION[$svr.'cust_email'] = $email;
			$_SESSION[$svr.'cust_addr'] = $address1;
			$_SESSION[$svr.'cust_mobile'] = $mobile;
			$_SESSION[$svr.'cust_city'] = $city;
			$_SESSION[$svr.'cust_state'] = $state;
			$_SESSION[$svr.'cust_country'] = $country;
		} 
		query("update svr_book_order_temp set `bot_total_amount` = '".$amount."', `bot_cust_id` = '".$customer."', `bot_comments` = '".$comments."', `bot_emergency_number` = '".$emergency."' where bot_order_id = '".$_SESSION[$svr.'tour_order_id']."'");
		
		//P A Y M E N T   G A T E W A Y
		if(!empty($_SESSION[$svra.'ag_id'])){
			header("location:agentpay.php?type=1&order_id=".$_SESSION[$svr.'tour_order_id']);
		} else if(!empty($_SESSION[$svr.'cust_id'])){
			header("location:svrpay.php?type=2&order_id=".$_SESSION[$svr.'tour_order_id']);
		}
	}
}
else 
{

///////// FARES TABLE - BEGIN /////////

// Fare Prices Array
$prq = query("select floc_name, loc.cat_id_fk, tloc_id, tloc_floc_id, tloc_transport, tloc_type, tloc_code, tloc_pickup_point, cat_name, tloc_status, tloc_time, tloc_ref_no, tloc_banner_image, loc.subcat_id_fk, subcat_name, tloc_id, tloc_name, tloc_places_covered, tloc_notes2, tloc_cost_includes, tloc_cost_excludes, tloc_acc_type, tloc_pickup_place, cnt_content, fr_id, fr_type, fr_fc_id, fr_room_type, fr_data, veh.vp_id as vehicle_id, veh.vp_name as vehicle_name, concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle, GROUP_CONCAT(pick.pick_id SEPARATOR '|') AS pickup_ids, GROUP_CONCAT(pick.pick_name SEPARATOR '|') AS pickup_points from svr_fares as fr
left join svr_fare_category as fc on fr.fr_fc_id = fc.fc_id
	left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
		left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
			left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
				left join svr_to_locations as loc on loc.tloc_id =  fr.fr_loc_id
					left join svr_from_locations as floc on floc.floc_id = loc.tloc_floc_id
						left join svr_categories as cat on loc.cat_id_fk = cat.cat_id left join svr_content_pages on cnt_id = 2
							left join svr_subcategories as subcat on loc.subcat_id_fk = subcat.subcat_id 
								left outer join svr_pickup_points as pick on pick.tloc_id_fk = loc.tloc_id
									where tloc_id = '".$_GET['lid']."' and fr_status = 1 group by fr_fc_id, fr_room_type"); 
									
	$hfr = query("select * from svr_hotel_fares as hf
					left join svr_hotel_category as hc on hc.hc_id=hf.hfr_fc_id
						left join svr_hotels as h on h.ht_id=hf.hfr_ht_id
							where hfr_loc_id = '".$_GET['lid']."' and hfr_status = 1 group by hfr_ht_id,hfr_room_type order by hfr_id");	
															
$pcount = num_rows($prq);
$hcount = num_rows($hfr); 

while($fare = fetch_array($prq)) 
{ 	
	$row_loc = $fare;
	$acc[] = $fare['fr_room_type']; 
	$fare_cat[] = $fare['fr_fc_id'];
	$farecatnames[$fare['fr_fc_id']] = $fare['vehicle'];
	$vehicles[] = $fare['vehicle_id'];
	$vehicle_names[$fare['vehicle_id']] = $fare['vehicle_name'];
	$tour_fares[$fare['fr_fc_id']][$fare['fr_room_type']] = $fare['fr_data']; 
}

while($hfare = fetch_array($hfr))
{
	$hacc[] = $hfare['hfr_room_type'];
	$hfare_cat[] = $hfare['hfr_ht_id'];
	$hfarecatnames[$hfare['hfr_ht_id']] = $hfare['ht_name'];
	$hotel_fares[$hfare['hfr_ht_id']][$hfare['hfr_room_type']] = $hfare['hfr_data'];
}
list($deptime, $rettime) = (!empty($row_loc['tloc_time'])) ? explode('|', $row_loc['tloc_time']) : array_fill(0, 2, '');
list($nights, $days) = (!empty($row_loc['tloc_type'])) ? explode('|', $row_loc['tloc_type']) : array_fill(0, 2, '');
$pickup_points = array_filter(array_combine(explode("|", $row_loc['pickup_ids']), explode("|", $row_loc['pickup_points'])));

//Populate Accomodation / Room Types
$acc = ($pcount != 0) ? array_unique($acc) : '';
$hacc = ($hcount != 0) ? array_unique($hacc) : '';

//Fare Cat Array
$fare_cats = ($pcount != 0) ? array_unique($fare_cat) : '';
$hfare_cats = ($hcount != 0) ? array_unique($hfare_cat) : '';

///////// FARES TABLE - END /////////

$date = date('d-m-Y', strtotime($_GET['date']));
if($pcount <= 0 || $row_loc['cat_id_fk'] == 1 || empty($_GET['date']))
	header("location:destination-details.php?lid=".$_GET['lid']);
}

$designFILE = "design/tour-package-booking-dev.php";
include_once("includes/svrtravels-template.php");
?>