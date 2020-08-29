<script>
function printDiv() {
//alert("hi");     
     var printContents = document.getElementById('print_div_area').innerHTML;
	 var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>
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

<? if($row['ord_request_status'] == 1){ ?>
	<h1>Payment Success</h1>
	<p>Congratulations! You have successfully completed transaction.</p>
	<?	
		$content = "
			<table width='100%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
			  <tr>
				<td width='15%'><strong>Order ID</strong></td>
				<td width='3%' align='center'><strong>:</strong></td>
				<td align='left'>".$row['ord_order_id']."</td>
			  </tr>
			  <tr>
				<td width='15%'><strong>Type</strong></td>
				<td width='3%' align='center'><strong>:</strong></td>
				<td align='left'>".$row['cat_name']."</td>
			  </tr>
			  <tr>
				<td><strong>Name</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['cust_fname']." ".$row['cust_lname']."</td>
			  </tr>
			  <tr>
				<td ><strong>Mobile Phone</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['cust_mobile']."</td>
			  </tr>";
			  
			  if($row['cust_landline'] != ''){
			   $content.="<tr>
				<td ><strong>Land Phone No.</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['cust_landline']."</td>
			  </tr>";
			  }
			  
			  $content.="<tr>
				<td><strong>E-Mail</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['cust_email']."</td>
			  </tr>
			  <tr>
				<td nowrap='nowrap'><strong>From Location </strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['floc_name']."</td>
			  </tr>";
			  
			if($qurcount == 1) {
			
			  $content .= "<tr>
				<td><strong>To Location</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$product_info."</td>
			  </tr>
			  
			  <tr>
				<td ><strong>Amount</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>Rs. ".number_format($row['ord_amount'], 2)."</td>
			  </tr>
			  
			  <tr>
				<td nowrap='nowrap'><strong>No. of Persons</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['ord_no_of_persons']."&nbsp;&nbsp;Adults (".$row['ord_tot_adult'].")&nbsp;&nbsp;Children (".$row['ord_tot_child'].")</td>
			  </tr>";
			  
			} else {
			
			  $content .= "<tr><td colspan='3'><table border='1' cellpadding='5' cellspacing='0' bordercolor='#999999' style='border-collapse:collapse;'>
				<tr>
					<td align='left' height='25'>Tour Name</td>
					<td align='left'>No. of Persons</td>
					<td align='left' nowrap='nowrap'>Seat No.</td>
					<td align='right'>Amount</td>
				</tr>";
				
				$ord_sel = query("select tloc_name, ord_id, ord_order_id, ord_no_of_persons, ord_tot_adult, ord_tot_child, ord_seat_number, ord_amount, ord_total_amount from svr_book_order as ord
					left join svr_to_locations as loc on loc.tloc_id = ord.ord_tloc_id
						where ord_order_id = '".$row['ord_order_id']."'");
				while($cs_row = fetch_array($ord_sel)){ 
				   $content.="<tr>
					<td align='left'>".$cs_row['tloc_name']."</td>
					<td align='left'>".$cs_row['ord_no_of_persons']." Adults (".$cs_row['ord_tot_adult'].") Children (".$cs_row['ord_tot_child'].")</td>
					<td align='left'>".$cs_row['ord_seat_number']."</td>
					<td align='right'>Rs. ".number_format($cs_row['ord_amount'], 2)."</td>
				  </tr>";
				   }
								   
				   $content.="<tr>
					 <td colspan='3' align='right' valign='top'>Total</td>						  
					 <td align='right'>Rs. ".number_format($row['ord_total_amount'], 2)."</td>
				  </tr>";
				$content.="</table></td></tr>";

			}
			
			if($row['ord_type'] == 2){
			
	 		 if($row['ord_pickup_from'] != '' && $row['ord_pickup_place'] != '' && $row['ord_pickup_place_detail'] != '' && $row['ord_pickup_time'] != ''){
			 
			  $content.="<tr>
					<td align='left' height='30' colspan='3'><strong>Pickup Information (".$pickup_drop[$row['ord_pickup_from']].")</strong></td>
			  </tr>";
				
			  } switch($row['ord_pickup_from']) {
			  		
					case 1 : $pickup_place = 'Airport'; $pickup_place_details = 'Flight No'; break;
					case 2 : $pickup_place = 'Railway Station'; $pickup_place_details = 'Train No'; break;
					case 3 : $pickup_place = 'Address'; $pickup_place_details = 'Street No'; break;
					
			  } if($row['ord_pickup_place'] != '') {
				
			  $content.="<tr>
					<td><strong>".$pickup_place."</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$row['ord_pickup_place']."</td>
			  </tr>";
				
			  } if($row['ord_pickup_place_detail'] != '') {
			  
			  $content.="<tr>
					<td><strong>".$pickup_place_details."</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$row['ord_pickup_place_detail']."</td>
			  </tr>";
			  
			  } if($row['ord_pickup_time'] != '') {
				 
			  $content.="<tr>
					<td nowrap='nowrap'><strong>Expected Arrival Time</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$row['ord_pickup_time']."</td>
			  </tr>";
			  	  
			  } switch($row['ord_pickup_from']) {
					case 1 : $drop_place = 'Airport'; $drop_place_details = 'Flight No'; break;
					case 2 : $drop_place = 'Railway Station'; $drop_place_details = 'Train No'; break;
					case 3 : $drop_place = 'Address'; $drop_place_details = 'Street No'; break;
			  }
			  
			  if(!empty($row['ord_drop_at']) && $row['ord_drop_place'] != '' && $row['ord_drop_place_detail'] != '' && $row['ord_drop_time'] != ''){
			  
			  $content.="<tr>
					<td align='left' colspan='3' height='30'><strong>Drop Information (".$pickup_drop[$row['ord_drop_at']].") </strong></td>
			  </tr>";
				
			  } if($row['ord_drop_place'] != ''){
			  
			  $content.="<tr>
					<td ><strong>".$drop_place."</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left' >".$row['ord_drop_place']."</td>
			  </tr>";
			  
			 } if($row['ord_drop_place_detail'] != '') {
			 
			  $content.="<tr>
					<td ><strong>".$drop_place_details."</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left' >".$row['ord_drop_place_detail']."</td>
			  </tr>";
					  
			 } if($row['ord_drop_time'] != ''){
			
			  $content.="<tr>
					<td nowrap='nowrap'><strong>Departure Time</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$row['ord_drop_time']."</td>
			  </tr>";	
				  
			 } if($row['ord_room_type'] != ''){
				
			  $content.="<tr>
					<td><strong>Room Type</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$room_type[$row['ord_room_type']]."</td>
			  </tr>";		  
			  }
			}
			
			if($row['ord_type'] == 1){	  
			  $content.="<tr>
					<td><strong>Bus Type</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".$accomodation_type[$row['ord_acc_type']]."</td>
			  </tr>";		  
					  
			} if($row['ord_journey_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') {
			
			  $content.="<tr>
					<td><strong>Journey Date</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".date('F d, Y',strtotime($row['ord_journey_date']))."</td>
			  </tr>";
			  	  
			 } if($row['ord_return_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') {
			 		  
			  $content.="<tr>
					<td><strong>Return Date</strong></td>
					<td align='center'><strong>:</strong></td>
					<td align='left'>".date('F d, Y',strtotime($row['ord_return_date']))."</td>
			  </tr>";		  
			}	  	
		$content.="</table>";
		
		$data['subject'] = 'SVR Travels India  - '.$row['cat_name'].' Ticket Booked';
		$data['content'] = $content;
		$data['to_email'] = $row['cust_email'].((!empty($_SESSION[$svra.'ag_id'])) ? ','.$_SESSION['ag_email'] : '');
		send_email($data);
		
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
						<td height='40' align='center' valign='middle'><span class='clr'>Booking Details From svrtravelsindia.com</span></td>
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
?>
<div id="print_div_area"><?=$table;?></div>
<? } else if($row['ord_request_status'] == 2) { ?>
	
	<h1>Payment Failure</h1>
	<p>Sorry! Transaction was unsuccessful.</p>
	
<?php /*?><? } else if($_GET['id'] == 3) { ?>

	<h1>Payment Failure</h1>
	<p>Sorry! You do not have sufficient deposit to complete this transaction.</p>
	
	<p><a href="agent-deposits.php">Click here to top up you account.</a></p><?php */?>
	
<? }?>
</div>
<div style="text-align:center; padding-bottom:10px;text-align:left; text-align:center"><span class="ml10 mb20"><input type="button" name="bookingother" id="bookingother" value="Book Another Package" onclick="location.href='destination.php?sid=24'">&nbsp;<input type="button" class="btn" onclick="printDiv('print_div_content',<?=$row['ba_order_status']?>)" value="Print"></span></div>	


<!-- mid content End-->
<br /><br />