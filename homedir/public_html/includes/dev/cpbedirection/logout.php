<?
ob_start();
session_start();
include_once("../includes/functions.php");

if(isset($_SESSION['tm_type']))
{
	mysql_query("update `tm_logindetails` set `out_time`='".$now_onlytime."',`logouttime`='".$now_time."' where login_id='".$_SESSION['logd_id']."' and login_regid='".$_SESSION['tm_id']."' ");

	unset($_SESSION["tm_id"]);
	unset($_SESSION["tm_mail"]);
	unset($_SESSION["tm_dispname"]);
	unset($_SESSION["tm_type"]);
	//session_destroy();
	header("location:index.php");
}
else
{
	header("location:index.php");
}
?>