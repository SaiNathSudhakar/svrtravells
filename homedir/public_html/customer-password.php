<? 
include("includes/functions.php");
cust_login_check();
$pageName="Change Password";
$pageTitle="Change Password";
$tablename="svr_customers";

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['newpass']))
{	
	$msg = '';
	if(!empty($_POST['oldpass'])) { $oldpwd = getdata("svr_customers", "cust_password", "cust_id = ".$_SESSION[$svr.'cust_id']); }
	if($oldpwd != md5($_POST['oldpass'])){ 
		$msg = "Old Password is Incorrect. Try Again!";
	} else {
		query("update ".$tablename." set cust_password='".md5($_POST['newpass'])."' where cust_id = ".$_SESSION[$svr.'cust_id']);
		$msg = "Your Password Changed Successfully!";
	}
}

$terms_content = getdata("svr_content_pages", "cnt_content", "cnt_id = 2");

$designFILE="design/customer-password.php";
include_once("includes/svrtravels-template.php");
?>