<?php


ob_start();

include_once("includes/functions.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if(!isset($_GET['lid'])) header("location:index.php");

$query = query('SET group_concat_max_len=15000');

//echo "destination-details.php";


///////// FARES TABLE - BEGIN /////////

// Fare Prices Array
$prq = query("select floc_name, loc.cat_id_fk, tloc_id, tloc_floc_id, tloc_transport, tloc_type, tloc_code, tloc_pickup_point, cat_name, tloc_status, tloc_time, tloc_ref_no, tloc_banner_image, loc.subcat_id_fk, subcat_name, tloc_id, tloc_name, tloc_places_covered, tloc_notes2, tloc_cost_includes, tloc_cost_excludes, tloc_acc_type, tloc_pickup_place, cnt_content, fr_id, fr_type, fr_fc_id, fr_room_type, fr_data, veh.vp_id as vehicle_id, veh.vp_name as vehicle_name, concat(veh.vp_name, ' ', pax.vp_title, ' PAX') as vehicle, GROUP_CONCAT(pick.pick_id SEPARATOR '|') AS pickup_ids, GROUP_CONCAT(pick.pick_name SEPARATOR '|') AS pickup_points from svr_fares as fr
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


$pcount = num_rows($prq);


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


$hotel_names_qur=query("select ht_id, ht_name from svr_hotels where 1");
while($hotel_names_row=fetch_array($hotel_names_qur)){ $hotel_names[$hotel_names_row['ht_id']]= $hotel_names_row['ht_name'];}
$hfr = query("select * from svr_hotel_category as hc
			left join svr_hotel_location as loc on loc.ht_loc_id=hc.hc_ht_loc_id
			where hc_location = '".$_GET['lid']."' and hc_status = 1 order by hc_id");
$hcount = num_rows($hfr);
while($hfare = fetch_array($hfr)){
	$hacc[] = $hfare['hc_room_type']; // Room Type
	$hloc_ids[] = $hfare['hc_ht_loc_id']; // Hotel Loc
	$hloc_names[$hfare['hc_ht_loc_id']] = $hfare['ht_loc_name']; // Hotel Location Names
	$hotel_ids[$hfare['hc_ht_loc_id']][$hfare['hc_room_type']]= $hfare['hc_ht_ids'];
}

list($deptime, $rettime) = (!empty($row_loc['tloc_time'])) ? explode('|', $row_loc['tloc_time']) : array_fill(0, 2, '');
list($nights, $days) = (!empty($row_loc['tloc_type'])) ? explode('|', $row_loc['tloc_type']) : array_fill(0, 2, '');
$pickup_points = array_filter(array_combine(explode("|", $row_loc['pickup_ids']), explode("|", $row_loc['pickup_points'])));

//Populate Accomodation / Room Types
$acc = ($pcount != 0) ? array_unique($acc) : '';
$hacc = ($hcount != 0) ? array_unique($hacc) : '';

//Fare Cat Array
$fare_cats = ($pcount != 0) ? array_unique($fare_cat) : '';
$hloc_ids = ($hcount != 0) ? array_unique($hloc_ids) : '';

///////// FARES TABLE - END /////////

//Query to get location details

$qur_loc = query("select loc.cat_id_fk,tloc_pdf,tloc_ref_no, tloc_meta_title, tloc_meta_keywords, tloc_meta_description, tloc_type, tloc_international, tloc_id, tloc_code, tloc_floc_id, tloc_transport, tloc_pickup_point, cat_name, tloc_status, tloc_time, tloc_ref_no, tloc_banner_image, loc.subcat_id_fk, subcat_name, loc.subsubcat_id_fk, subsubcat_name, tloc_id, tloc_name, tloc_places_covered, tloc_notes, tloc_cost_includes, tloc_cost_excludes, tloc_acc_type, cnt_content, GROUP_CONCAT(pc.place_name SEPARATOR '|') AS place_name, GROUP_CONCAT(pc.place_thumb) AS place_thumb, GROUP_CONCAT(pc.place_ref_no) AS place_ref_no, GROUP_CONCAT(pc.place_small_desc SEPARATOR '|') AS place_small_desc from

svr_to_locations as loc

left join svr_categories as cat on loc.cat_id_fk = cat.cat_id left join svr_content_pages on cnt_id = 2

left join svr_subcategories as subcat on loc.subcat_id_fk = subcat.subcat_id

left join svr_subsubcategories as subsubcat on loc.subsubcat_id_fk = subsubcat.subsubcat_id

left outer join svr_places_covered as pc on pc.tloc_id_fk = loc.tloc_id and pc.place_status = 1

where tloc_id=".$_GET['lid']." group by pc.tloc_id_fk");

$row_loc = fetch_array($qur_loc);

//print_r($row_loc);exit;


list($deptime, $rettime) = (!empty($row_loc['tloc_time'])) ? explode('|', $row_loc['tloc_time']) : array_fill(0, 2, '');

list($night, $day) = (!empty($row_loc['tloc_type'])) ? explode('|', $row_loc['tloc_type']) : array_fill(0, 2, '');



if($row_loc['cat_id_fk'] == 1)

	list($fare_cats, $farecatnames, $acc, $fixed_fares, $fare_mon) = fares_table($row_loc['cat_id_fk']);

if(isset($row_loc->cat_id_fk) && $row_loc->cat_id_fk == 2)

	list($fare_cats, $farecatnames, $acc, $tour_fares) = fares_table($row_loc['cat_id_fk']);

$meta_title = $row_loc['tloc_meta_title'];

$meta_keywords = $row_loc['tloc_meta_keywords'];

$meta_description = $row_loc['tloc_meta_description'];

$designFILE = "design/destination-details-new.php";

include_once("includes/svrtravels-template-new.php");

?>
