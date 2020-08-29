<? ob_start();
//include_once("includes/conn.php");
include_once("includes/functions.php");
if(isset($_SESSION[$svr.'cust_id'])) header('location:customer-account.php');
$tablename="svr_customers";
$pageTitle="Reset Password";
$pageName="Reset Password";

$yp=mysql_query("select cust_id from ".$tablename." where cust_fg_password ='".$_GET['rid']."'");
$yp_cnt=mysql_num_rows($yp);
$yp_fetch=mysql_fetch_array($yp);

if($_SERVER['REQUEST_METHOD']=="POST")
{
	if($yp_cnt==0) { $invmsg="You provided invalid information."; }
	
	if(!empty($_POST['reset_password']) || $yp_fetch['cust_id']==$_GET['rid']){
		mysql_query("update ".$tablename." set cust_password ='".md5($_POST['new_pwd'])."' where cust_fg_password='".$_GET['rid']."'");
		header("location:customer-reset-password.php?rmsg=reset_pwd_login");
	}
}
$designFILE = "design/customer-reset-password.php";
include_once("includes/svrtravels-template.php");
?>