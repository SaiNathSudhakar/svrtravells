<? 
include("includes/functions.php");
$pageName="Print Ticket";
$pageTitle="Print Ticket";
$tablename="svr_agents";

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['newpass']))
{	
	$msg = '';
	if(!empty($_POST['oldpass'])) { $oldpwd = getdata("svr_agents", "ag_password", "ag_id = ".$_SESSION[$svra.'ag_id']); }
	if($oldpwd != md5($_POST['oldpass'])){ 
		$msg = "Old Password is Incorrect. Try Again!";
	} else {
		query("update ".$tablename." set ag_password='".md5($_POST['newpass'])."' where ag_id = ".$_SESSION[$svra.'ag_id']);
		$msg = "Your Password Changed Successfully!";
	}
}

$meta_title ="Print Ticket | Tour and Travel Agency in Hyderabad SVR Travels India";
$meta_keywords ="Tours and travels, volvo bus booking, best holiday packages, book flights online, online bus ticket booking sites";
$meta_description ="eastern india tours, students industrial tours, KASHMIR TOUR PACKAGES, NORTH INDIA TOURS PACKAGES, Eastern India Holiday Pacakges";

$designFILE="design/print-ticket.php";
include_once("includes/svrtravels-template.php");
?>