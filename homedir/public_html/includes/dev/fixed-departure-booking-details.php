<? ob_start();
include_once("includes/functions.php");

if(!empty($_SESSION[$svr.'fixed_order_id']))
{	
	$adult = $child = 0;
	//Query to get order details
	$q = mysql_query("select bot_id, bot_journey_date, bot_return_date, bot_amount, bot_acc_type, bot_no_of_persons, bot_tot_adult, bot_tot_child, bot_seat_number, bot_pickup_place, bot_pickup_time, tloc_name, tloc_time from svr_book_order_temp as bot
		left join svr_to_locations as loc on loc.tloc_id = bot.bot_tloc_id
			where bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_added_date > subtime('".$now_time."', '".$ftime_span."')");			
	$count = mysql_num_rows($q); 
	while($row = mysql_fetch_array($q)) { 
		$order[] = $row;
		$adult += $row['bot_tot_adult'];
		$child += $row['bot_tot_child'];
	}
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{	//echo str_replace(',', '', $_POST['amount']).' > '.$_SESSION[$svra.'ag_deposit']; exit;
	if(!empty($_SESSION[$svra.'ag_id']) && (str_replace(',', '', $_POST['amount']) > $_SESSION[$svra.'ag_deposit'])) {
		//header('location:agentpay.php?id=3');
		header('location:agent-insufficient-balance.php');
	} else {
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
		
		if(empty($_POST['customer']))
		{	
			$addedby = (empty($_SESSION[$svra.'ag_id'])) ? 0 : 1;
			$agid = (!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_id'] : 0;
			mysql_query("insert into svr_customers(cust_id, cust_title, cust_fname, cust_lname, cust_dob, cust_mobile, cust_landline, cust_email ,cust_password, cust_address_1, cust_address_2, cust_city, cust_country, cust_state, cust_pincode, cust_status, cust_added_by, cust_added_date, cust_ag_id)values('', '".$title."', '".$fname."', '".$lname."', '".$dob."', '".$mobile."', '".$phone."', '".$email."', '".md5($password)."', '".$address1."', '".$address2."', '".$city."', '".$country."', '".$state."', '".$pin."', 1, '".$addedby."', '".$now_time."', '".$agid."')");
			$customer = mysql_insert_id();
			
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
		
		mysql_query("update svr_book_order_temp set `bot_total_amount` = '".$total_amount."', `bot_cust_id` = '".$customer."', `bot_comments` = '".$comments."', `bot_emergency_number` = '".$emergency."' where bot_order_id = '".$_SESSION[$svr.'fixed_order_id']."' and bot_added_date > subtime('".$now_time."','".$ftime_span."')");
		
		//P A Y M E N T   G A T E W A Y
		if(!empty($_SESSION[$svra.'ag_id'])){
			header("location:agentpay.php?type=1&order_id=".$_SESSION[$svr.'fixed_order_id']);
		} else if(!empty($_SESSION[$svr.'cust_id'])){
			header("location:svrpay.php?type=1&order_id=".$_SESSION[$svr.'fixed_order_id']);
		}
	}	
}

if(!empty($_GET['id']))
{	
	mysql_query("delete from svr_book_order_temp where bot_id=".$_GET['id']);
	header("location:fixed-departure-booking-details.php");
}

$designFILE = "design/fixed-departure-booking-details.php";
include_once("includes/svrtravels-template.php");
?>