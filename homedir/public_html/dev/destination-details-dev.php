<?php

ob_start();

include_once("includes/functions_dev.php");

if(!isset($_GET['lid'])) header("location:index.php");

$query = query('SET group_concat_max_len=15000');

//echo "destination-details.php";


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

if($row_loc->cat_id_fk == 2)

	list($fare_cats, $farecatnames, $acc, $tour_fares) = fares_table($row_loc['cat_id_fk']);

$meta_title = $row_loc['tloc_meta_title'];

$meta_keywords = $row_loc['tloc_meta_keywords'];

$meta_description = $row_loc['tloc_meta_description'];

$designFILE = "design/destination-details-dev.php";

include_once("includes/svrtravels-template.php");

?>