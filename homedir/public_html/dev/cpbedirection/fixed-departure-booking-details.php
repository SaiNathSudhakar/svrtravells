<? ob_start();
include_once("../includes/functions.php");

if(!empty($_SESSION[$svr.'fixed_order_id']))
{	
	$adult = $child = 0;
	//Query to get order details
	$q = query("select bot_id, bot_journey_date, bot_return_date, bot_amount, bot_acc_type, bot_no_of_persons, bot_tot_adult, bot_tot_child, bot_seat_number, bot_pickup_place, bot_pickup_time, tloc_name, tloc_time from svr_book_order_temp as bot
		left join svr_to_locations as loc on loc.tloc_id = bot.bot_tloc_id
			where bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_added_date > subtime('".$now_time."', '".$ftime_span."')");		

				
	$count = num_rows($q); 
	while($row = fetch_array($q)) { 
		$order[] = $row;
		$adult += $row['bot_tot_adult'];
		$child += $row['bot_tot_child'];
	}
}
$email_qur=query("select * from svr_customers where cust_email='".$_POST['email']."'");
$cnt=mysqli_num_rows($email_qur);
if($_SERVER['REQUEST_METHOD'] == "POST")
{
		$customer = $_POST['customer'];
		$total_amount = str_replace(',', '', $_POST['amount']);
		$total_amount = number_format($total_amount, 2, '.', '');
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
		
		if($cnt==0)
		{	
			
			query("insert into svr_customers(cust_id, cust_title, cust_fname, cust_lname, cust_dob, cust_mobile, cust_landline, cust_email ,cust_password, cust_address_1, cust_address_2, cust_city, cust_country, cust_state, cust_pincode, cust_status, cust_added_by, cust_added_date, cust_ag_id)values('', '".$title."', '".$fname."', '".$lname."', '".$dob."', '".$mobile."', '".$phone."', '".$email."', '".md5($password)."', '".$address1."', '".$address2."', '".$city."', '".$country."', '".$state."', '".$pin."', 1, '".$addedby."', '".$now_time."', '".$agid."')");
			
			$customer = insert_id();
			
			$_SESSION[$svr.'cust_id'] = $customer;
		} else {
				$dbcust_id=fetch_array($email_qur);
				$customer=$dbcust_id['cust_id'];
				$_SESSION[$svr.'cust_id'] = $dbcust_id['cust_id'];
			}
		
		query("update svr_book_order_temp set `bot_total_amount` = '".$total_amount."', `bot_cust_id` = '".$customer."', `bot_comments` = '".$comments."', `bot_emergency_number` = '".$emergency."' where bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_added_date > subtime('".$now_time."','".$ftime_span."')");
		
	
	query("INSERT INTO `svr_book_order` (`ord_tmp_id`, `ord_order_id`, `ord_tloc_id`, `ord_journey_date`, `ord_return_date`, `ord_pkg_id`, `ord_amount`, `ord_cust_id`, `ord_type`, `ord_acc_type`, `ord_room_type`, `ord_vehicle_type`, `ord_fc_id`, `ord_fc_qty`, `ord_tot_adult`, `ord_tot_child`, `ord_no_of_persons`, `ord_seat_number`, `ord_pickup_from`, `ord_pickup_place`, `ord_pickup_place_detail`, `ord_pickup_time`, `ord_drop_at`, `ord_drop_place`, `ord_drop_place_detail`, `ord_drop_time`, `ord_emergency_number`, `ord_comments`, `ord_total_amount`, `ord_request_status`, `ord_status`, `ord_added_date`, `ord_added_by`, `ord_ag_id`) 
			
			SELECT `bot_id`, `bot_order_id`, `bot_tloc_id`, `bot_journey_date`, `bot_return_date`, `bot_pkg_id`, `bot_amount`, `bot_cust_id`, `bot_type`, `bot_acc_type`, `bot_room_type`, `bot_vehicle_type`, `bot_fc_id`, `bot_fc_qty`, `bot_tot_adult`, `bot_tot_child`, `bot_no_of_persons`, `bot_seat_number`, `bot_pickup_from`, `bot_pickup_place`, `bot_pickup_place_detail`, `bot_pickup_time`, `bot_drop_at`, `bot_drop_place`, `bot_drop_place_detail`, `bot_drop_time`, `bot_emergency_number`, `bot_comments`, `bot_total_amount`, `bot_request_status`, `bot_status`, `bot_added_date`, `bot_added_by`, `bot_ag_id` from svr_book_order_temp WHERE bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_request_status = 1");
			
		$last_id=mysqli_insert_id($conn); $_SESSION['ord_id']=$last_id;
		query("update svr_book_order SET ord_booked_from=1, ord_payment_det='".$_POST['ord_payment_det']."' where ord_id=".$last_id);
		header("location:payment-status.php");
}

if(!empty($_GET['id']))
{	
	query("delete from svr_book_order_temp where bot_id=".$_GET['id']);
	header("location:fixed-departure-booking-details.php");
}

$designFILE = "design/fixed-departure-booking-details.php";
include_once("includes/svrtravels-template.php");
?>