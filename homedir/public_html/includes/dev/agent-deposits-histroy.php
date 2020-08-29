<? ob_start();
include("includes/functions.php");
$pageName="Deposit Histroy";
$tablename="svr_agent_deposits";

$len=10; $start=0;
$link="agent-deposits-histroy.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$cq_datepicker = '0000-00-00 00:00:00';

$page_query = mysql_query("select ad_id from ".$tablename." as ad
	left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
		left join svr_content_pages on cnt_id = 2
			where ad_status=1 and ad_ag_id='".$_SESSION[$svra.'ag_id']."'");
$total = mysql_num_rows($page_query);

$result = mysql_query("select ag_fname, ad_id, ad_order_id, ad_ag_id,ad_amount, ad_mobile, ad_transaction, ad_bank, ad_drawn, ad_chq_issue_date, ad_dd_no, ad_acc_holder, ad_attach_slip, ad_type, ad_addeddate, ad_req_status, cnt_content from ".$tablename." as ad 
	left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
		left join svr_content_pages on cnt_id = 2
			where ad_status=1 and ad_ag_id='".$_SESSION[$svra.'ag_id']."' order by ad_id desc limit $start, $len");
$count_order = mysql_num_rows($result);

if(!empty($_GET['del'])){
	mysql_query("delete from svr_agent_deposits where ad_id='".$_GET['del']."'");
	header("location:agent-deposits-histroy.php?msg=del");
}
if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	mysql_query("update svr_agent_deposits set ad_status=".$status." where ad_id='".$_GET['sid']."'");
	header("location:agent-deposits-histroy.php");
}

$designFILE="design/agent-deposits-histroy.php";
include_once("includes/svrtravels-template.php");
?>
