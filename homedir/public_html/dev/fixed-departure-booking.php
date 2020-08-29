<?
ob_start();
include_once("includes/functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	//var_dump($_POST); exit;
	$to_location = $_POST['hid_toloc'];
	$journey_date = $_POST['hid_date'];
	$days = $_POST['hid_days'];
	$return_date = date('Y-m-d', strtotime($journey_date. ' + '.($days-1).' days'));
	$pkg_id = $_POST['hid_pkg_id'];
	$amount = $_POST['totamount'];
	$amount = $amount + (($service_tax * $amount)/100);
	$cust_id = isset($_SESSION[$svr.'cust_id']) ? $_SESSION[$svr.'cust_id'] : '';
	$bus_type = $_POST['bustype'];
	
	$fare_cats = explode(',', $_POST['hid_fare_cats']);
	foreach($fare_cats as $fare_cat)
	{	
		$fare_cat_ids[] = $fare_cat;
		$fare_cat_qty[] = $_POST['qty'.$fare_cat];
	}
	$fare_cat_ids = implode(',', $fare_cat_ids);
	$fare_cat_qty = implode(',', $fare_cat_qty);
	
	$no_of_persons = $_POST['totqty'];
	$tot_adult = $_POST['totadult'];
	$tot_child = $_POST['totchild'];
	$seat_nos = trim($_POST['optedSeatNos'], ',');
	$pickup_from = '';
	$pickup_place = $_POST['PickUpPoint'];
	$pickup_detail = $_POST['PickUpDetail'];
	$pickup_time = $_POST['PickUpTime'];
	$drop_at = $drop_place = $drop_place_detail = $drop_time = '';
	
	if(empty($_SESSION[$svr.'fixed_order_id']))
	{	
		$_SESSION[$svr.'fixed_order_id'] = 'SVRO'.rand(10000, 99999);
		$count = 0;
	} else {
		$q = query("select bot_id, bot_amount, bot_fc_id, bot_fc_qty, bot_no_of_persons, bot_tot_adult, bot_tot_child, bot_seat_number from svr_book_order_temp where bot_pkg_id='".$pkg_id."' and bot_acc_type = '".$bus_type."' and bot_pickup_place = '".$pickup_place."' and bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_added_date > subtime('".$now_time."','1:0:0')");
		$count = num_rows($q);
	}
	
	if($count == 0)
	{	
		$addedby = (empty($_SESSION[$svra.'ag_id'])) ? 0 : 1;
		$agid = (!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_id'] : 0;
		query("insert into svr_book_order_temp (`bot_id`, `bot_order_id`, `bot_tloc_id`, `bot_journey_date`, `bot_return_date`, `bot_pkg_id`, `bot_amount`, `bot_cust_id`, `bot_type`, `bot_acc_type`, `bot_fc_id`, `bot_fc_qty`, `bot_no_of_persons`, `bot_tot_adult`, `bot_tot_child`, `bot_seat_number`, `bot_pickup_from`, `bot_pickup_place`, `bot_pickup_place_detail`, `bot_pickup_time`, `bot_drop_at`, `bot_drop_place`, `bot_drop_place_detail`, `bot_drop_time`, `bot_request_status`, `bot_status`, `bot_added_by`, `bot_added_date`, `bot_ag_id`)  values ('', '".$_SESSION[$svr.'fixed_order_id']."', '".$to_location."', '".$journey_date."', '".$return_date."', '".$pkg_id."', '".$amount."', '".$cust_id."', '1', '".$bus_type."', '".$fare_cat_ids."', '".$fare_cat_qty."', '".$no_of_persons."', '".$tot_adult."', '".$tot_child."', '".$seat_nos."', '".$pickup_from."', '".$pickup_place."', '".$pickup_detail."', '".$pickup_time."', '".$drop_at."', '".$drop_place."', '".$drop_place_detail."', '".$drop_time."', '0', '1', '".$addedby."', '".$now_time."', '".$agid."')");
				
	} else {
		
		$fetch = fetch_array($q);
		$amount = $_POST['totamount'];
		$amount = $fetch['bot_amount'] + $amount + (($service_tax * $amount)/100);		
		
		$fare_cats = explode(',', $_POST['hid_fare_cats']);
		$db_cat_ids = explode(',', $fetch['bot_fc_id']);
		$db_cat_qty = explode(',', $fetch['bot_fc_qty']);
		
		foreach($fare_cats as $key => $fare_cat)
		{	
			$fc_ids[] = $fare_cat;
			if($db_cat_ids[$key] == $fare_cat)
				$fc_qty[] = $_POST['qty'.$fare_cat] + $db_cat_qty[$key];
			else
				$fc_qty[] = $_POST['qty'.$fare_cat];	
		}
		$fare_cat_ids = implode(',', $fc_ids);
		$fare_cat_qty = implode(',', $fc_qty);
		
		$no_of_persons = $fetch['bot_no_of_persons'] + $_POST['totqty'];
		$tot_adult = $fetch['bot_tot_adult'] + $_POST['totadult'];
		$tot_child = $fetch['bot_tot_child'] + $_POST['totchild'];
		$seat_nos = $fetch['bot_seat_number'].','.trim($_POST['optedSeatNos'], ',');
		
		query("update svr_book_order_temp set `bot_amount` = '".$amount."', `bot_fc_id` = '".$fare_cat_ids."', `bot_fc_qty` = '".$fare_cat_qty."', `bot_no_of_persons` = '".$no_of_persons."', `bot_tot_adult` = '".$tot_adult."', `bot_tot_child` = '".$tot_child."', `bot_seat_number` = '".$seat_nos."' where bot_id = '".$fetch['bot_id']."' and bot_added_date > subtime('".$now_time."', '".$ftime_span."')");
		
	}
	header('location:fixed-departure-booking-details.php');
	

} else {

if(!empty($_GET['lid']))
{

//echo "------"; exit;
	//Query to get location details
	$prq = query("select loc.cat_id_fk, tloc_id, tloc_type, tloc_floc_id, tloc_transport, tloc_code, tloc_pickup_point, cat_name, tloc_status, tloc_time, tloc_ref_no, tloc_banner_image, loc.subcat_id_fk, subcat_name, tloc_id, tloc_name, tloc_places_covered, tloc_notes, tloc_cost_includes, tloc_cost_excludes, tloc_acc_type, tloc_pickup_place, cnt_content, fc_name, fc_multiple, fc_adult_child, fr_fc_id, fr_acc_type, fr_data, pkg_id,pkg_ac_seats, pkg_nac_seats, pkg_date, GROUP_CONCAT(pick.pick_id SEPARATOR '|') AS pickup_ids, GROUP_CONCAT(pick.pick_name SEPARATOR '|') AS pickup_points from svr_fares as fr
	left join svr_fare_category as fc on fr.fr_fc_id = fc.fc_id
		left join svr_to_locations as loc on loc.tloc_id =  fr.fr_loc_id
			left join svr_categories as cat on loc.cat_id_fk = cat.cat_id left join svr_content_pages on cnt_id = 2
				left join svr_subcategories as subcat on loc.subcat_id_fk = subcat.subcat_id 
					left join svr_pickup_points as pick on pick.tloc_id_fk = loc.tloc_id and pick.pick_status = 1
						left join svr_packages as pkg on pkg.pkg_to_id = loc.tloc_id and pkg_date = '".db_date($_GET['date'])."'
							where fr_status = 1 and ('".date('Y-m-d', strtotime($_GET['date']))."' between fr_from_date and fr_to_date) and tloc_id=".$_GET['lid']." group by fr_fc_id, fr_acc_type order by fc.fc_orderby");					
	$pcount = num_rows($prq);
//echo $pcount; exit;
}

while($fare = fetch_array($prq)) 
{ 	
	$row_loc = $fare;
	$acc[] = $fare['fr_acc_type']; 
	$fare_cat[] = $fare['fr_fc_id'];
	$farecatnames[$fare['fr_fc_id']] = $fare['fc_name'];
	$multiples[$fare['fr_fc_id']] = $fare['fc_multiple'];
	$adultchild[$fare['fr_fc_id']] = $fare['fc_adult_child'];
	$fixed_fares[$fare['fr_fc_id']][$fare['fr_acc_type']] = $fare['fr_data']; 
}

list($deptime, $rettime) = (!empty($row_loc['tloc_time'])) ? explode('|', $row_loc['tloc_time']) : array_fill(0, 2, '');
list($night, $day) = (!empty($row_loc['tloc_type'])) ? explode('|', $row_loc['tloc_type']) : array_fill(0, 2, '');
$pickup_points = array_filter(array_combine(explode("|", $row_loc['pickup_ids']), explode("|", $row_loc['pickup_points'])));

//Populate Accomodation / Room Types
$acc = ($pcount != 0) ? array_unique($acc) : '';

//Fare Month Array
$fare_mon = get_fare_months($_GET['lid']);

//Fare Cat Array
$fare_cats = ($pcount != 0) ? array_unique($fare_cat) : '';	

//Query to get Seats Available
$q = "select pkg_id, pkg_to_id, pkg_date, pkg_ac_seats, pkg_nac_seats, (pkg_ac_seats + pkg_nac_seats) AS tot_seats, 
group_concat(bot_seat_number) as booked_seat_nos, ((pkg_ac_seats + pkg_nac_seats)-COALESCE(sum(bot_no_of_persons), 0)) as avail_seats, pkg_ac_seats - COALESCE((CASE WHEN bot_acc_type = 1 THEN sum(bot_no_of_persons) ELSE 0 END), 0) as avail_ac_seats, pkg_nac_seats-COALESCE((CASE WHEN bot_acc_type = 2 THEN sum(bot_no_of_persons) ELSE 0 END), 0) as avail_nac_seats from svr_packages as pkg 
	left join svr_book_order_temp as bot on bot.bot_pkg_id = pkg.pkg_id and 
		(bot_request_status = 1 or bot_added_date > subtime('".$now_time."','".$ftime_span."') and bot_request_status = 0)
			where pkg_to_id = ".$_GET['lid']." and pkg_date = '".db_date($_GET['date'])."' group by pkg_id having avail_seats > 0";
		
//echo $q; exit;
$qur_pkg = query($q);
$row_pkg = fetch_array($qur_pkg);

$bookedseatnos = $row_pkg['booked_seat_nos'];
$booked_seat_nos = explode(',', $bookedseatnos);

$avail_seat_count[1] = $row_pkg['avail_ac_seats'];
$avail_seat_count[2] = $row_pkg['avail_nac_seats'];

if($row_pkg['tot_seats'] == $row_pkg['avail_seats']){
	$avail_seat_count[1] = $row_pkg['pkg_ac_seats']; 
	$avail_seat_count[2] = $row_pkg['pkg_nac_seats'];
}

$date = date('d-m-Y', strtotime($_GET['date']));
if($pcount <= 0 || empty($_GET['date'])) //|| empty($package_id[db_date($_GET['date'])]) 
	header("location:destination-details.php?lid=".$_GET['lid']);
}

$designFILE = "design/fixed-departure-booking.php";
include_once("includes/svrtravels-template.php");
?>