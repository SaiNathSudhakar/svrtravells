<? 
include_once("includes/functions.php");
$tablename = "svr_agents";
$pageTitle = "Reset Password";
$pageName = "Reset Password";

$yp = mysql_query("select ag_id from ".$tablename." where ag_fg_password ='".$_GET['rid']."'");
$yp_cnt = mysql_num_rows($yp);
$yp_fetch = mysql_fetch_array($yp);

if($_SERVER['REQUEST_METHOD']=="POST")
{
	if($yp_cnt == 0) { $invmsg = "You provided invalid information."; }
	if(!empty($_POST['reset_password']) || $yp_fetch['ag_id']==$_GET['rid']){
		mysql_query("update ".$tablename." set ag_password ='".md5($_POST['new_pwd'])."' where ag_fg_password='".$_GET['rid']."'");
		header("location:agent-reset-password.php?rmsg=reset_pwd_login");
	}
}
$designFILE = "design/agent-reset-password.php";
include_once("includes/svrtravels-template.php");
?>