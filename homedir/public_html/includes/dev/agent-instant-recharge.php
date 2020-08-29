<? 
include("includes/functions.php");
agent_login_check();
$pageName="Instant Recharge";
$tablename="svr_agent_deposits_temp";

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$_SESSION[$svra.'ag_order_id'] = 'SVRO'.rand(10000, 99999);
	$amt = str_replace(',', '', $_POST['amount']);
	$amount = number_format($amt, 2, '.', '');
	mysql_query("insert into svr_agent_deposits_temp(adt_id, adt_order_id, adt_ag_id, adt_amount, adt_mobile, adt_type, adt_status, adt_addeddate)values('','".$_SESSION[$svra.'ag_order_id']."','".$_SESSION[$svra.'ag_id']."','".$amount."','".$_SESSION[$svra.'ag_mobile']."',4,1,'".$now_time."')");
	
	//P A Y M E N T   G A T E W A Y
	header("location:agent-payment.php?order_id=".$_SESSION[$svra.'ag_order_id']);
}

$sam = mysql_query("select adt_id, adt_ag_id, adt_amount, adt_mobile, adt_type, cnt_content from ".$tablename." 
		left join svr_content_pages on cnt_id = 2
			where adt_status=1 and adt_id='".$_SESSION[$svra.'ag_id']."'");
$fetch_sam = mysql_fetch_array($sam);

$designFILE="design/agent-instant-recharge.php";
include_once("includes/svrtravels-template.php");
?>