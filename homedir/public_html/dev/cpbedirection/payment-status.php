<?php
ob_start();
include_once("../includes/functions.php");

$ord_qur=query("select ord_order_id from svr_book_order where ord_id=".$_SESSION['ord_id']);

$ord_res=mysqli_fetch_row($ord_qur);
	$qur=query("select ord_journey_date, ord_return_date, cat_name, floc_name, floc_id, ord_id, ord_order_id, ord_journey_date, ord_return_date, ord_pkg_id, ord_amount, ord_type, ord_acc_type, ord_request_status, ord_room_type, ord_vehicle_type, ord_fc_qty, ord_tot_adult, ord_tot_child, ord_no_of_persons, ord_seat_number, ord_pickup_from, ord_pickup_place, ord_pickup_place_detail, ord_pickup_time, ord_drop_at, ord_drop_place, ord_drop_place_detail, ord_drop_time, ord_emergency_number, ord_comments, ord_total_amount, ord_request_status, tloc_name, tloc_code, tloc_room_type, tloc_type, cust_fname, cust_lname, cust_email, cust_mobile, cust_address_1, cust_address_2, cust_city, cust_state, cust_country, cust_pincode, group_concat(fc.fc_id) as fc_ids, ord_fc_qty as fc_qtys, veh.vp_name as vehicle from svr_book_order as ord
	left join svr_categories as cat on cat.cat_id = ord.ord_type
		left join svr_fare_category as fc on FIND_IN_SET(fc.fc_id, ord.ord_fc_id)
			left join svr_vehicles_pax as veh on veh.vp_id = ord.ord_room_type
				left join svr_customers as cust on cust.cust_id = ord.ord_cust_id
					left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
						left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id 
							where ord_order_id='".$ord_res[0]."' group by ord_id");
							
			
	$qurcount = num_rows($qur);
	$row = fetch_array($qur);
	$code = ($row['tloc_code'] != '') ? ' ('.$row['tloc_code'].') ' : ' ';
	list($nights, $days) = (!empty($row['tloc_type'])) ? explode('|', $row['tloc_type']) : array_fill(0, 2, '');
	$day_night = $nights.' Nights / '.$days.' Days';
	$product_info = $row['tloc_name'].$code.$day_night;
	
$designFILE = "design/payment-status.php";
include_once("includes/svrtravels-template.php");
?>