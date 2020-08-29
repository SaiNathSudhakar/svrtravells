<!--<script src="js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>-->
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!--<script src="js/navmenu.js" type="text/javascript"></script>
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Bus Cancellation</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
<div class="fl"><h1>My Bus Cancellation</h1></div>
<div class="fr"><h2>Welcome: <span><?=(!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_fname'] : $_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<? 
//echo 'T E S T I N G: <br>'; echo $query;
if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>

<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <thead>
  	<tr bgcolor="#F7F7F7">
	  <th align="left" width="3%">#</th>
	  <th align="left">Route</th>
	  <th align="left">Amount</th><th align="left" width="15%">Customer / Seats</th>
	  <th align="left" width="25%">Date</th>	  </tr>
  </thead>
  <tbody>
  	<? if($count > 0){ $i = 0; while($fetch = fetch_array($q)){ $i++;
	$seats_status = explode('|', $fetch['ba_seat_status']);?>
  	<tr bgcolor="<?=($i%2 == 0) ? '#F7F7F7' : '';?>">
  	  <td><?=$i;?></td>
	  <td><a href="view-bus-booking-order-details.php?id=<?=$fetch['ba_id'];?>" class="various" data-fancybox-type="iframe"><?=$fetch['ba_source_name'];?> &rarr; <?=$fetch['ba_destination_name'];?></a>
      <br>
      <strong>Ticket</strong>: <?=$fetch['ba_ticket_no'];?> 
      <strong>Amount</strong>: <span class="rupee">&#x20B9;</span> 
	  <? $fares = array(); $all_fares = explode('|', $fetch['ba_fare']);  
	  foreach($all_fares as $key => $value) if($seats_status[$key] == 0) $fares[] = $value;
	  echo number_format(array_sum($fares), 2);?></td>
	  <td><?='Refund Amount: <span class="rupee">&#x20B9;</span>'.array_sum(explode('|', $fetch['ba_refund_amount']));?><br>
      <?='Cancel Charges: <span class="rupee">&#x20B9;</span>'.array_sum(explode('|', $fetch['ba_cancel_charges']));?></td>
	  <td><div><? $name = explode('|', $fetch['ba_name']); echo ucwords(strtolower($name[0]));?></div>
	  <? $seats = array(); $all_seats = explode('|', $fetch['ba_seat_no']); 
	  foreach($all_seats as $key => $value) if($seats_status[$key] == 0) $seats[] = $value;  
	  echo implode(', ', $seats); ?></td>
	  <td>Journey: <?=date('d/m/Y', strtotime($fetch['ba_journey_date'])).' '.$fetch['ba_departure_time'];?>
      <br>
      Cancellation:<? $all_dates = explode('|', $fetch['ba_cancel_dates']); 
	  foreach($all_dates as $key => $value) if($seats_status[$key] == 0) $canc_dates[] = $value;  
	  echo implode(', ', array_unique($canc_dates)); ?> </td>
	  </tr>
  	<? }} elseif($count == 0){?>
	<tr height="50" align="center"><td valign="middle" colspan="5">No Records Found</td></tr>
	<? }?>
	<? if($total>$len){ ?>
	<tr>
	  <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td><? page_Navigation_front($start,$total,$link); ?></td>
		  </tr>
		</table></td>
	</tr>
<? }?>
  </tbody>
</table>

</div>
<div class="clear"></div>
</div>
<script language="javascript">
function cancel_ticket(id,amt,jdate,oid)
{	
	if(confirm("Are you sure to cancel Ticket?")){ 
		window.location='cancellations.php?id='+id+'&amount='+amt+'&jdate='+jdate+'&orderid='+oid;
	}
}
</script>