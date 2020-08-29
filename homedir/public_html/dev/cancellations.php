<? 
include("includes/functions.php");
if(!empty($_SESSION[$svra.'ag_id'])) { agent_login_check(); } else { cust_login_check(); }

if(!empty($_GET['id']) && !empty($_GET['tid']) && !empty($_GET['amount']) && !empty($_GET['orderid']))
{	
	$refund_amount = refund_amount($_GET['jdate'], $now, $_GET['amount']);
	$cancel_charges = cancel_amount($_GET['jdate'], $now, $_GET['amount']);
	$cancel_by = (!empty($_SESSION[$svra.'ag_id'])) ? ', ord_cancel_by = 1' : ', ord_cancel_by = 0';
	
	query("update svr_book_order_temp set bot_request_status = 2 where bot_id = ".$_GET['tid']);
	query("update svr_book_order set ord_request_status = 2, ord_cancel_charges = '".$cancel_charges."', ord_cancel_date = '".$now_time."' $cancel_by where ord_id = ".$_GET['id']);
	
	$transc = 'Cancellation';
	$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
	$op_bal = number_format($op_bal, 2, '.', '');
	$comm = $agent_commission * $_GET['amount']; 
	$comm = number_format($comm, 2, '.', '');
	$net = number_format($_GET['amount'] - $cancel_charges - $comm, 2, '.', '');
	$cl_bal = number_format($op_bal + $net, 2, '.', ''); 
	
	$ref_id = rand(1000000, 9999999); $fkid = $_GET['id'];
	
	if(!empty($_SESSION[$svra.'ag_id'])){
		//query("update svr_agents set ag_deposit = (ag_deposit+".$_GET['amount'].") where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		query("update svr_agents set ag_deposit = '".$cl_bal."' where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		$_SESSION[$svra.'ag_deposit'] = $cl_bal; //getdata('svr_agents', 'ag_deposit', "ag_id = '".$_SESSION[$svra.'ag_id']."'");
		$cancel_by = $_SESSION[$svra.'ag_fname'].' (Agent)';
		$email = $_SESSION[$svra.'ag_email'];
	} else {
		$cancel_by = $_SESSION[$svr.'cust_fname'].' (Customer)';
		$email = $_SESSION[$svr.'cust_email'];
	}
	$cancel_charges = number_format($cancel_charges, 2, '.', '');
	
	if(!empty($_SESSION[$svra.'ag_id'])){
		query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_cancel_charges, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$_SESSION[$svra.'ag_id']."', '".$ref_id."', '".$_GET['orderid']."', '', '".$transc."', '".$op_bal."', '".$_GET['amount']."', '".$comm."', '".$cancel_charges."', '".$net."', '".$cl_bal."', '2', '".$fkid."', '".$now_time."')");
	}
	$data['subject'] = 'Ticket Cancellation';
	$data['content'] = "<table align='left'><tr><td>Dear Sir,</td></tr><tr><td>&nbsp;</td></tr>
	<tr><td>Ticket with Order ID ".$_GET['orderid']." has been cancelled by ".$cancel_by." with Rs.".$cancel_charges." cancellation charges and Rs.".$refund_amount." as refund amount.</td></tr>
	<tr><td>&nbsp;</td></tr><tr><td>Thanks & Regards, <br>SVR Tours and Travels</td></tr></table>";
	
	$data['to_email'] = $email;
	send_email($data);
	
	header("location:cancellations.php");
	
} else {
	
	$cond = '1';
	$cond .= (!empty($_SESSION[$svra.'ag_id'])) ? " and ord_ag_id = '".$_SESSION[$svra.'ag_id']."'" : " and ord_cust_id = '".$_SESSION[$svr.'cust_id']."'";
	
	$page_query = query("select ord_id from svr_book_order as ord
	left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
		left join svr_categories as cat on cat.cat_id = ord.ord_type
			where $cond and ord_status = 1 and ord_request_status = 2");
	$total = num_rows($page_query);
	
	$len=10; $start=0;
	$link = "cancellations.php?a=a";
	if(!empty($_GET['start'])) { $start=$_GET['start']; }
	
	$q = query("select ord_id, ord_order_id, ord_total_amount, ord_tmp_id, ord_journey_date, ord_updated_date, ord_cancel_charges, ord_cancel_date, ord_ag_id, tloc_name, cat_name from svr_book_order as ord
	left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
		left join svr_categories as cat on cat.cat_id = ord.ord_type
			where $cond and ord_status = 1 and ord_request_status = 2 order by ord_id desc limit $start, $len");
	
	$count = num_rows($q);
	
	$designFILE="design/cancellations.php";
	include_once("includes/svrtravels-template.php");
}
?>