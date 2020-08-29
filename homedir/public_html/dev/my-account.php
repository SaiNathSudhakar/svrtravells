<? 
include("includes/functions.php");
login_check();

$pageName="My Account";
$pageTitle="My Account";
$tablename="svr_customers";

$sam=query("select * from ".$tablename." where cust_status=1 and cust_id='".$_SESSION[$svr.'user_id']."'");
$fetch_sam=fetch_array($sam);

$designFILE="design/my-account.php";
include_once("includes/svrtravels-template.php");
?>