<? 
include("includes/functions.php");
if(!empty($_SESSION[$svra.'ag_id'])) { agent_login_check(); } else { cust_login_check(); }

$cond = '1';
$cond .= (!empty($_SESSION[$svra.'ag_id'])) ? " and ba_ag_id = ".$_SESSION[$svra.'ag_id'] : " and ba_cust_id = ".$_SESSION[$svr.'cust_id'];

$page_query = query("select ba_id from svr_api_orders where $cond and ba_status = 1 and ba_order_status = 2");
$total = num_rows($page_query);
$len = 10; $start = 0;
$link="orders.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

//0-pending;1-refund; 2-success; 3-failure; 4-cancel; 5-partially cancel			
$query = "select ba_id, ba_name, ba_unique_id, ba_source_name, ba_destination_name, ba_ticket_no, ba_fare, ba_total_fare, ba_trip_id, ba_seat_status, ba_order_status, ba_ticket_no, ba_journey_date, ba_departure_time, ba_cancel_dates, ba_no_passenger, ba_seat_no, ba_refund_amount, ba_cancel_charges from svr_api_orders where $cond and ba_status = 1 and (ba_order_status = 4 or ba_order_status = 5) order by ba_id desc limit $start, $len"; //echo $query; exit;
$q = query($query);
$count = num_rows($q);

$designFILE="design/BusCancellations.php";
include_once("includes/svrtravels-template.php");
?>