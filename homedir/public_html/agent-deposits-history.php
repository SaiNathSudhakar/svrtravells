<? ob_start();
include("includes/functions.php");
agent_login_check();
$pageName="Deposit History";
$tablename="svr_agent_deposits";

$len=10; $start=0;
$link="agent-deposits-history.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$cq_datepicker = '0000-00-00 00:00:00';

$page_query = query("select ad_id from ".$tablename." as ad
	left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
		left join svr_content_pages on cnt_id = 2
			where ad_status=1 and ad_ag_id='".$_SESSION[$svra.'ag_id']."'");
$total = num_rows($page_query);

$result = query("select ag_fname, ad_id, ad_order_id, ad_ag_id, ad_amount, ad_transaction, ad_bank, ad_drawn, ad_chq_issue_date, ad_dd_no, ad_acc_holder, ad_attach_slip, ad_type, ad_addeddate, ad_req_status, cnt_content from ".$tablename." as ad 
	left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
		left join svr_content_pages on cnt_id = 2
			where ad_status=1 and ad_ag_id='".$_SESSION[$svra.'ag_id']."' order by ad_id desc limit $start, $len");
$count_order = num_rows($result);

if(!empty($_GET['del'])){
	query("delete from svr_agent_deposits where ad_id='".$_GET['del']."'");
	header("location:agent-deposits-history.php?msg=del");
}
if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	query("update svr_agent_deposits set ad_status=".$status." where ad_id='".$_GET['sid']."'");
	header("location:agent-deposits-history.php");
}

$designFILE="design/agent-deposits-history.php";
include_once("includes/svrtravels-template.php");
?>
