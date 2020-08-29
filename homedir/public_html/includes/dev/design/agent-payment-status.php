<!-- Banner Start-->
<div class="banner_inner">
	<img src="images/customer-login-banner.jpg" alt="About SVR Travels" />
</div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="index.php">Home</a>
	<span class="divied"></span><span class="pagename">Payment Status</span></div>
</div>
<!-- Navigation End-->

<!-- mid content Start-->
<div class="inner_content">
<? if($row['adt_req_status'] == 1){ ?>
	<h1>Payment Success</h1>
	<p>Congratulations! You have successfully completed transaction.</p>
	<?	
		$content = "
			<table width='100%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
			  <tr>
				<td width='15%'><strong>Order ID</strong></td>
				<td width='3%' align='center'><strong>:</strong></td>
				<td align='left'>".$row['adt_order_id']."</td>
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
				<td align='left'>Rs.".number_format($row['adt_amount'], 2)."</td>
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
		
		$table = "<style type='text/css'>
			table, td, th { font-family: Verdana; font-size:12px; }
			.clr { color: #FFFFFF; font-weight: bold; }</style>
		<table width='700' border='0' align='center' cellpadding='5' cellspacing='0' style='border-bottom:2px solid #aaa'>	
		  <tr>
			<td height='30' align='center' valign='middle' bgcolor='#F2F2F2'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td align='center' valign='middle' bgcolor='#D50000'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td height='40' align='center' valign='middle'><span class='clr'>Instant Recharge From svrtravelsindia.com</span></td>
					  </tr>
					</table>			  
					</td>
				  </tr>
				</table>			
			</td>
		  </tr>
		  <tr>
			<td align='center' valign='top' bgcolor='#F2F2F2'>".$content."</td>
		  </tr>
		</table>";
		
		echo $table;
		
		?>
		
<? } else if($row['adt_req_status'] == 2) { ?>
	
	<h1>Payment Failure</h1>
	<p>Sorry! Transaction was unsuccessful.</p>

<? }?>
</div>
<!-- mid content End-->
<br /><br />