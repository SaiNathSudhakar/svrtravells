<? 
include("includes/conn.php");

unset($_SESSION[$svr.'cust_id']);
unset($_SESSION[$svr.'cust_title']);
unset($_SESSION[$svr.'cust_fname']);
unset($_SESSION[$svr.'cust_lname']);
unset($_SESSION[$svr.'cust_email']);
unset($_SESSION[$svr.'cust_addr']);
unset($_SESSION[$svr.'cust_mobile']);
unset($_SESSION[$svr.'cust_city']);
unset($_SESSION[$svr.'cust_state']);
unset($_SESSION[$svr.'cust_landline']);
unset($_SESSION[$svr.'cust_country']);
unset($_SESSION[$svr.'fixed_order_id']);
unset($_SESSION[$svr.'tour_order_id']);
//session_destroy();
if(empty($_GET['redirect']))
	header("location:index.php");
$_GET['redirect'] = '';
?>
