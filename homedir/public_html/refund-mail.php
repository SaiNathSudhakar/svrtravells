		 $mail_body .= "<table width='100%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
			  <tr>
			    <td colspan=3>Dear Customer,</td>
			  </tr>
			  <tr>
			    <td colspan=3>We have noticed that you were trying to place an order for ".$row['ba_source_name']." to  ".$row['ba_destination_name']." on ".date('F d, Y',strtotime($row['ba_journey_date']))." at ".date('H:i A',strtotime($row['ba_journey_date'])).". <strong>Your payment of Rs. ".number_format($row['ba_amount'], 2)." has been deducted</strong> but due to a technical issue the ticket could not be issued.</td>
			  </tr>
			  <tr>
			    <td colspan=3>Your trip id is: ".$row['ba_trip_id'].". Please quote this trip id for all futher communication.</td>
			  </tr>
			  <tr>
			    <td colspan=3>Please do not worry - your money would be <strong>refunded</strong> within <strong>7 working days.</strong> You can now check the refund status of your transaction online <a href="http://www.redbus.in/checkrefundstatus.aspx" target="_blank">here</a> </td>
			  </tr>
			  <tr>
			    <td colspan=3>We suggest that you go ahead and book another ticket.</td>
			  </tr>
			  <tr>
			    <td colspan=3>Best regards,</td>
			  </tr>
			  <tr>
			    <td colspan=3>---</td>
			  </tr>
			  <tr>
			    <td colspan=3>Your friends at SVR Travels</td>
			  </tr>
			  <tr>
			    <td colspan=3><div><em>E-mail us:<a href='mailto:support@svrtraveslindia.com' target='_blank'>support@svrtraveslindia.com</a></em></div>
		          <div><em>Call us: XXXXXX.</em></div></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td align='center'>&nbsp;</td>
			    <td align='left'>&nbsp;</td>
			  </tr>
			  <tr>
				<td width='15%'><strong>Trip ID</strong></td>
				<td width='3%' align='center'><strong>:</strong></td>
				<td align='left'>".$row['ba_trip_id']."</td>
			  </tr>
			  <tr>
				<td nowrap='nowrap'><strong>Journey</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['ba_source_name']." --> ".$row['ba_destination_name']." ".date('F d, Y',strtotime($row['ba_journey_date']))</td>
			  </tr>
              
			  <tr>
				<td ><strong>Fare</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>Rs. ".number_format(($row['ba_total_fare']/$row['ba_no_passenger']), 2)."</td>
			  </tr>
			  <tr>
				<td><strong>No. of Persons</strong></td>
				<td align='center'><strong>:</strong></td>
				<td align='left'>".$row['ba_no_passenger']."</td>
			  </tr>
			  <tr>
			    <td><strong>Total Fare</strong></td>
			    <td align='center'><strong>:</strong></td>
			    <td align='left'>Rs. ".number_format($row['ba_total_fare'], 2)."</td>
			  </tr>
			  <tr>
			    <td><strong>Travel</strong></td>
			    <td align='center'><strong>:</strong></td>
			    <td align='left'>".$row['ba_travels_name']." ".$row['ba_travels_type']."</td>
			  </tr>
			  <tr>
			    <td><strong>Boarding Details</strong></td>
			    <td align='center'><strong>:</strong></td>
			    <td align='left'>Boarding from ".$row['ba_boarding_location']." - ".$row['ba_boarding_time']</td>
			  </tr>
			  <tr>
			    <td><strong>Seat(s)</strong></td>
			    <td align='center'><strong>:</strong></td>
			    <td align='left'>".$row['ba_seat_no']."</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td align='center'>&nbsp;</td>
			    <td align='left'>&nbsp;</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td align='center'>&nbsp;</td>
			    <td align='left'>&nbsp;</td>
			  </tr></table>";
		
		$mailbody = "<style type='text/css'>
			table, td, th { font-family: Verdana; font-size:12px; }
			.clr { color: #FFFFFF; font-weight: bold; }</style>
		<table width='500' border='0' align='center' cellpadding='5' cellspacing='0' style='border-bottom:2px solid #aaa'>	
		  <tr>
			<td height='30' align='center' valign='middle' bgcolor='#F2F2F2'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td align='center' valign='top'><a href='http://www.svrtravelsindia.com/' target='_blank'>
					<img src='http://www.svrtravelsindia.com/images/svr-travels.jpg' alt='svrtravelsindia' border='0' /></a></td>
				  </tr>
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
			<td align='center' valign='top' bgcolor='#F2F2F2'>".$mail_body."</td>
		  </tr>
		</table>