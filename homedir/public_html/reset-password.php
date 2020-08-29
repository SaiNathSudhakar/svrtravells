<? ob_start();
//include_once("includes/conn.php");
include_once("includes/functions.php");
$tablename="svr_customers";
$pageTitle="Reset Password";
$pageName="Reset Password";

$yp=query("select * from ".$tablename." where cust_fg_password ='".$_GET['rid']."'");
$yp_cnt=num_rows($yp);
if($yp_cnt==0){header("location:forgot-password.php?msg=inv_rid");}

if($_SERVER['REQUEST_METHOD']=="POST"){
	if(!empty($_POST['reset_password']) || $_POST['pwd_reset']==$_GET['rid']){
		$yp=query("select * from ".$tablename." where cust_fg_password ='".$_POST['pwd_reset']."'");
		$yp_cnt=num_rows($yp);
		if($yp_cnt==0) { $invmsg="You provided invalid information."; }
		if($yp_cnt!=0) { 
			$yp_fetch=fetch_array($yp);
			//echo "update ".$tablename." set cust_password ='".md5($_POST['new_pwd'])."' where cust_fg_password='".$_GET['rid']."'";exit;
			query("update ".$tablename." set cust_password ='".md5($_POST['new_pwd'])."' where cust_fg_password='".$_GET['rid']."'");
			//header("location:index.php?msg=reset_pwd_login");
			header("location:reset-password.php?rmsg=reset_pwd_login");
		}
	}
}
$designFILE = "design/reset-password.php";
include_once("includes/svrtravels-template.php");
?>
