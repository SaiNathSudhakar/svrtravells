<?php ob_start();
include_once("includes/functions.php");
agent_login_check();

if(!empty($_GET['type']) && !empty($_GET['order_id']))
{	
	$order_id = $_GET['order_id']; $message = '';
	$bill = getdata('svr_book_order_temp', 'sum(bot_amount)', "bot_order_id='".$_GET['order_id']."'");
	$bill = number_format($bill, 2, '.', '');
	
	if($_GET['type'] == 1) unset($_SESSION[$svr.'fixed_order_id']); else unset($_SESSION[$svr.'tour_order_id']);
	
	if($_SESSION[$svra.'ag_deposit'] > $bill)
	{	
		mysql_query("update svr_book_order_temp set bot_request_status = 1 where bot_order_id = '".$_GET['order_id']."'");
		
		mysql_query("INSERT INTO `svr_book_order` (`ord_tmp_id`, `ord_order_id`, `ord_tloc_id`, `ord_journey_date`, `ord_return_date`, `ord_pkg_id`, `ord_amount`, `ord_cust_id`, `ord_type`, `ord_acc_type`, `ord_room_type`, `ord_vehicle_type`, `ord_fc_id`, `ord_fc_qty`, `ord_tot_adult`, `ord_tot_child`, `ord_no_of_persons`, `ord_seat_number`, `ord_pickup_from`, `ord_pickup_place`, `ord_pickup_place_detail`, `ord_pickup_time`, `ord_drop_at`, `ord_drop_place`, `ord_drop_place_detail`, `ord_drop_time`, `ord_emergency_number`, `ord_comments`, `ord_total_amount`, `ord_request_status`, `ord_status`, `ord_added_date`, `ord_added_by`, `ord_ag_id`) 
			
			SELECT `bot_id`, `bot_order_id`, `bot_tloc_id`, `bot_journey_date`, `bot_return_date`, `bot_pkg_id`, `bot_amount`, `bot_cust_id`, `bot_type`, `bot_acc_type`, `bot_room_type`, `bot_vehicle_type`, `bot_fc_id`, `bot_fc_qty`, `bot_tot_adult`, `bot_tot_child`, `bot_no_of_persons`, `bot_seat_number`, `bot_pickup_from`, `bot_pickup_place`, `bot_pickup_place_detail`, `bot_pickup_time`, `bot_drop_at`, `bot_drop_place`, `bot_drop_place_detail`, `bot_drop_time`, `bot_emergency_number`, `bot_comments`, `bot_total_amount`, `bot_request_status`, `bot_status`, `bot_added_date`, `bot_added_by`, `bot_ag_id` from svr_book_order_temp WHERE bot_order_id = '".$_GET['order_id']."' and bot_request_status = 1");
		$fkid = mysql_insert_id();
		
		$transc = 'Booking';	
		$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
		$op_bal = number_format($op_bal, 2, '.', '');
		$comm = $agent_commission * $bill; $comm = number_format($comm, 2, '.', ''); 
		$net = number_format($bill - $comm, 2, '.', '');
		$cl_bal = number_format($op_bal - $net, 2, '.', ''); 
		
		$ref_id = rand(1000000, 9999999);
		
		//Update Agent Amount
		//mysql_query("update svr_agents set ag_deposit = (ag_deposit-".$bill.") where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		mysql_query("update svr_agents set ag_deposit = '".$cl_bal."' where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		$_SESSION[$svra.'ag_deposit'] = $cl_bal; //getdata('svr_agents', 'ag_deposit', "ag_id = '".$_SESSION[$svra.'ag_id']."'");
		
		//Update Agent Report
		mysql_query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$_SESSION[$svra.'ag_id']."', '".$ref_id."', '".$_GET['order_id']."', '', '".$transc."', '".$op_bal."', '".$bill."', '".$comm."', '".$net."', '".$cl_bal."', '1', '".$fkid."', '".$now_time."')");
				
		header("location:agentpay.php?id=1&oid=".$_GET['order_id']);
	} else { // less desposit
		//header("location:agentpay.php?id=3");
		header('location:agent-insufficient-balance.php');
	}
	
} else if(!empty($_GET['oid'])){

 $_GET['redirect'] = 'no'; include('customer-logout.php');
 $qur=mysql_query("select ord_journey_date, ord_return_date, cat_name, floc_name, floc_id, ord_id, ord_order_id, ord_journey_date, ord_return_date, ord_pkg_id, ord_amount, ord_type, ord_acc_type, ord_room_type, ord_vehicle_type, ord_fc_qty, ord_tot_adult, ord_tot_child, ord_no_of_persons, ord_seat_number, ord_pickup_from, ord_pickup_place, ord_pickup_place_detail, ord_pickup_time, ord_drop_at, ord_drop_place, ord_drop_place_detail, ord_drop_time, ord_emergency_number, ord_comments, ord_total_amount, ord_request_status, tloc_name, tloc_code, tloc_room_type, tloc_type, cust_fname, cust_lname, cust_email, cust_mobile, cust_address_1, cust_address_2, cust_city, cust_state, cust_country, cust_pincode, group_concat(fc.fc_id) as fc_ids, ord_fc_qty as fc_qtys, veh.vp_name as vehicle from svr_book_order as ord
		left join svr_categories as cat on cat.cat_id = ord.ord_type
			left join svr_fare_category as fc on FIND_IN_SET(fc.fc_id, ord.ord_fc_id)
				left join svr_vehicles_pax as veh on veh.vp_id = ord.ord_room_type
					left join svr_customers as cust on cust.cust_id = ord.ord_cust_id
						left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
							left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id 
								where ord_request_status = 1 and ord_order_id='".$_GET['oid']."' group by ord_id");
	$qurcount = mysql_num_rows($qur);
	$row = mysql_fetch_array($qur);
	$code = ($row['tloc_code'] != '') ? ' ('.$row['tloc_code'].') ' : ' ';
	list($nights, $days) = (!empty($row['tloc_type'])) ? explode('|', $row['tloc_type']) : array_fill(0, 2, '');
	$day_night = $nights.' Nights / '.$days.' Days';
	$product_info = $row['tloc_name'].$code.$day_night;

}

$designFILE = "design/payment-status.php";
include_once("includes/svrtravels-template.php");
?>