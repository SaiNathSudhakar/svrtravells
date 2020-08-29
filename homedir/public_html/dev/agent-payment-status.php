<?php
include_once("includes/functions.php");
agent_login_check();

if(isset($_GET['status']))
{	
	query("update svr_agent_deposits_temp set adt_req_status = '".$_GET['status']."' where adt_order_id = '".$_GET['order_id']."'");
	
	if($_GET['status'] == '1')
	{	
		query("INSERT INTO `svr_agent_deposits` (`ad_order_id`, `ad_ag_id`, `ad_amount`, `ad_req_status`, `ad_type`, `ad_status`, `ad_addeddate`)
		SELECT `adt_order_id`, `adt_ag_id` ,`adt_amount`, `adt_req_status`, `adt_type`, `adt_status`, `adt_addeddate` from svr_agent_deposits_temp WHERE adt_order_id = '".$_GET['order_id']."' ");
		$fkid = insert_id();
		//$amt = getdata("svr_agent_deposits", "ad_amount", "ad_ag_id = '".$_SESSION[$svra.'ag_id']."' and ad_order_id='".$_GET['order_id']."'");
		
		$qur = query("select ag_fname, ag_lname, ag_mobile, ag_address, ag_email, ag_city, ag_state, ag_country, ag_pincode, ad_ag_id, ad_amount, ad_order_id, ad_id, ad_ag_id, ad_type from svr_agent_deposits as ad
		left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
			where ad_req_status = 1 and ad_order_id='".$_GET['order_id']."' and ad_ag_id='".$_SESSION[$svra.'ag_id']."' group by ad_order_id");
		
		$amtcount = num_rows($qur);
		$row = fetch_array($qur);
		
		$amt = $row['ad_amount'];
		
		$amt = number_format($amt, 2, '.', '');
		query("update svr_agents set ag_deposit = (ag_deposit + ".$amt.") where ag_id = '".$_SESSION[$svra.'ag_id']."'");
		
		$_SESSION[$svra.'ag_deposit'] = $_SESSION[$svra.'ag_deposit'] + $amt;
		
		$transc = 'Deposit';	
		$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
		$op_bal = number_format($op_bal, 2, '.', '');
		$cl_bal = number_format($op_bal + $amt, 2, '.', ''); 
		$net = number_format($amt, 2, '.', '');
		
		$ref_id = rand(1000000, 9999999);
		query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$_SESSION[$svra.'ag_id']."', '".$ref_id."', '".$_GET['order_id']."', '', '".$transc."', '".$op_bal."', '".$amt."', '', '".$net."', '".$cl_bal."', '1', '".$fkid."', '".$now_time."')");
		
		$content = "
		<table width='100%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
		  <tr>
			<td width='15%'><strong>Order ID</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$row['ad_order_id']."</td>
		  </tr>
	
		  <tr>
			<td><strong>Name</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_fname']." ".$row['ag_lname']."</td>
		  </tr>
		  <tr>
			<td ><strong>Mobile Phone</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_mobile']."</td>
		  </tr>
					  
		  <tr>
			<td><strong> E-Mail</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_email']."</td>
		  </tr>
		  
		  <tr>
			<td nowrap='nowrap'><strong>Amount </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>Rs.".number_format($row['ad_amount'], 2)."</td>
		  </tr>
		  
		  <tr>
			<td nowrap='nowrap'><strong>Address </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_address']."</td>
		  </tr>
		  
		  <tr>
			<td nowrap='nowrap'><strong>City </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_city']."</td>
		  </tr>
		  <tr>
			<td nowrap='nowrap'><strong>State </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$states[$row['ag_state']]."</td>
		  </tr>
		  
		  <tr>
			<td nowrap='nowrap'><strong>Country </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_country']."</td>
		  </tr>
		  
		  <tr>
			<td nowrap='nowrap'><strong>Pincode </strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$row['ag_pincode']."</td>
		  </tr>
		</table>";
		
		$data['subject'] = 'Instant Recharge Response From SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $row['ag_email'];
		send_email($data);
	}
	//header("location:agent-payment-status.php?id=".$_GET['status']."&oid=".$_GET['order_id']);
	header("location:agent-payment-status.php?oid=".$_GET['order_id']);
	
} else if(!empty($_GET['oid'])){
	
	$qur=query("select ag_fname, ag_lname, ag_mobile, ag_address, ag_email, ag_city, ag_state, ag_country, ag_pincode, adt_ag_id, adt_amount, adt_mobile, adt_order_id, adt_id, adt_ag_id, adt_type, adt_req_status from svr_agent_deposits_temp as ad
	left join svr_agents as ag on ag.ag_id = ad.adt_ag_id
			where adt_order_id='".$_GET['oid']."' and adt_ag_id='".$_SESSION[$svra.'ag_id']."' group by adt_order_id");
	
	$qurcount = num_rows($qur);
	if($qurcount <= 0) header('location:index.php');
	$row = fetch_array($qur);
}

$designFILE = "design/agent-payment-status.php";
include_once("includes/svrtravels-template.php");
?>