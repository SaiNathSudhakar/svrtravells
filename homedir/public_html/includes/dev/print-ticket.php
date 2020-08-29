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
		mysql_query("update ".$tablename." set ag_password='".md5($_POST['newpass'])."' where ag_id = ".$_SESSION[$svra.'ag_id']);
		$msg = "Your Password Changed Successfully!";
	}
}

$designFILE="design/print-ticket.php";
include_once("includes/svrtravels-template.php");
?>