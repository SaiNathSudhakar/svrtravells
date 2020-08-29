<? 
include("includes/conn.php");

unset($_SESSION[$svr.'user_id']);
unset($_SESSION[$svr.'user_title']);

unset($_SESSION[$svr.'user_fname']);
unset($_SESSION[$svr.'user_lname']);
unset($_SESSION[$svr.'user_email']);
unset($_SESSION[$svr.'user_addr']);
unset($_SESSION[$svr.'user_mobile']);
unset($_SESSION[$svr.'user_landline']);
session_destroy();
header("location:index.php");
?>
