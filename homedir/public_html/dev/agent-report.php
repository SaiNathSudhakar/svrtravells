<?
ob_start();
include("includes/functions.php");
$pageName="Agent Report";
agent_login_check();

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['ar_ag_id']);
	unset($_SESSION['ar_from_date']);
	unset($_SESSION['ar_to_date']);
	header("location:agent-report.php");
}

$len=15; $start=0; $cond = "ar_ag_id = '".$_SESSION[$svra.'ag_id']."'";
$link="agent-report.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
$cond_ord = " order by ar_id desc";

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	$_SESSION['ar_from_date'] = $_POST['ar_from_date']; 
	$_SESSION['ar_to_date'] = $_POST['ar_to_date'];
	header('location:agent-report.php');
}
	
$from = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['ar_from_date'])));
$to = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['ar_to_date'])));

if($from != '0000-00-00' && $to != '0000-00-00' && $from != '1970-01-01' && $to != '1970-01-01') { 
	$cond .= " and ar_date_time between '".$from."' and '".$to."'"; 
	$cond_ord = " order by ar_id asc";
}

$page_query = query("select ar_id from svr_agent_reports as ar
	left join svr_agents as ag on ar.ar_ag_id = ag.ag_id
		where $cond $cond_ord");
$total = num_rows($page_query);

$result = query("select ar.*, ag.ag_fname, ag.ag_lname from svr_agent_reports as ar
	left join svr_agents as ag on ar.ar_ag_id = ag.ag_id
		where $cond $cond_ord limit $start, $len");
$count_order = num_rows($result);

$search = (empty($_SESSION['ar_ag_id']) && empty($_SESSION['ar_from_date']) && empty($_SESSION['ar_to_date'])) ? '0' : '1';

$designFILE="design/agent-report.php";
include_once("includes/svrtravels-template.php");
?>