<?php
include_once("includes/functions.php");
agent_login_check();

if(!empty($_GET['order_id']))
{	
	$order_id = $_GET['order_id']; $message = '';
	$bill = getdata('svr_api_orders_temp', 'ba_total_fare', "ba_unique_id='".$_GET['order_id']."'");
	$bill = number_format($bill, 2, '.', ''); 
	
	if($_SESSION[$svr.'ag_deposit'] > $bill)
	{	
		header("location:confirm-ticket.php?status=1&orderid=".$_GET['order_id']);
	} else { // less desposit
		//header("location:confirm-ticket.php?id=5");
		header('location:agent-insufficient-balance.php');
	}
}
?>