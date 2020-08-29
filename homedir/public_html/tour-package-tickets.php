<? 
include("includes/functions.php");
if(!empty($_SESSION[$svra.'ag_id'])) { agent_login_check(); } else { cust_login_check(); }

$cond = '1';
$cond .= (!empty($_SESSION[$svra.'ag_id'])) ? " and ord_ag_id = '".$_SESSION[$svra.'ag_id']."'" : " and ord_cust_id = '".$_SESSION[$svr.'cust_id']."'";

$q = query("select ord_id, ord_order_id, ord_tmp_id, ord_total_amount, ord_journey_date, ord_added_date, tloc_name from svr_book_order as ord
left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
	where $cond and ord_status = 1 and ord_request_status = 1 and ord_type = 2");
$count = num_rows($q);

$designFILE="design/tour-package-tickets.php";
include_once("includes/svrtravels-template.php");
?>