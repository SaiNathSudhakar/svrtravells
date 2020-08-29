<? 
include("includes/functions.php");
if(!empty($_SESSION[$svra.'ag_id'])) { agent_login_check(); } else { cust_login_check(); }

$cond = '1';
$cond .= (!empty($_SESSION[$svra.'ag_id'])) ? " and ord_ag_id = '".$_SESSION[$svra.'ag_id']."'" : " and ord_cust_id = '".$_SESSION[$svr.'cust_id']."'";

$page_query = mysql_query("select ord_id from svr_book_order as ord
	left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
		left join svr_categories as cat on cat.cat_id = ord.ord_type
			where $cond and ord_status = 1 and ord_request_status = 1");
$total = mysql_num_rows($page_query);

$len=10; $start=0;
$link="orders.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$q = mysql_query("select cat_name, ord_id, ord_order_id, ord_tmp_id, ord_amount, ord_total_amount, ord_journey_date, ord_added_date, ord_ag_id, tloc_name from svr_book_order as ord
	left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
		left join svr_categories as cat on cat.cat_id = ord.ord_type
			where $cond and ord_status = 1 and ord_request_status = 1 order by ord_journey_date desc limit $start, $len");
$count = mysql_num_rows($q);

$designFILE="design/orders.php";
include_once("includes/svrtravels-template.php");
?>