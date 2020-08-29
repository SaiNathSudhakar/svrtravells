<? 
include("includes/conn.php");

unset($_SESSION[$svra.'ag_id']);
unset($_SESSION[$svra.'ag_gender']);
unset($_SESSION[$svra.'ag_fname']);
unset($_SESSION[$svra.'ag_lname']);
unset($_SESSION[$svra.'ag_email']);
unset($_SESSION[$svra.'ag_addr']);
unset($_SESSION[$svra.'ag_mobile']);
unset($_SESSION[$svra.'ag_city']);
unset($_SESSION[$svra.'ag_state']);
unset($_SESSION[$svra.'ag_country']);
unset($_SESSION[$svra.'fixed_order_id']);
unset($_SESSION[$svra.'tour_order_id']);
//session_destroy();
header("location:index.php");
?>
