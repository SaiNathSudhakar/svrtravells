<!--<script src="js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>-->
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!--<script src="js/navmenu.js" type="text/javascript"></script>
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Bus Booking Orders</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
<div class="fl"><h1>My Bus Booking Orders</h1></div>
<div class="fr"><h2>Welcome: <span><?=(!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_fname'] : $_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".canc").fancybox({
		fitToView	: true,
		width		: '600px',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterClose  : function() { 
            window.location.reload();
        }
	});
});
</script>
<? 
//echo 'T E S T I N G: <br>'; echo $query;
if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>

<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <thead>
  	<tr bgcolor="#F7F7F7">
	  <th align="left" width="3%">#</th>
	  <th align="left">Route</th>
	  <th align="left" width="15%">Customer / Seats</th>
	  <th align="left" width="18%">Date</th>
	  <th align="left" width="3%">Cancel</th>
  	</tr>
  </thead>
  <tbody>
  	<? if($count > 0){ $i = 0; while($fetch = mysql_fetch_array($q)){ $i++;
	$seat_status = explode('|', $fetch['ba_seat_status']); ?>
  	<tr bgcolor="<?=($i%2 == 0) ? '#F7F7F7' : '';?>">
  	  <td><?=$i;?></td>
	  <td><a href="view-bus-booking-order-details.php?id=<?=$fetch['ba_id'];?>" class="various" data-fancybox-type="iframe"><?=$fetch['ba_source_name'];?> &rarr; <?=$fetch['ba_destination_name'];?></a>
      <br>
      <strong>Ticket</strong>: <?=$fetch['ba_ticket_no'];?> 
      <strong>Amount</strong>: <span class="rupee">&#x20B9;</span> 
       <? $fares = array(); $all_fares = explode('|', $fetch['ba_fare']);  
	  foreach($all_fares as $key => $value) if($seat_status[$key] == 1) $fares[] = $value;
	  echo number_format(array_sum($fares), 2);?>
	  <? //=number_format($fetch['ba_total_fare'], 2);?></td>
	  <td><div><? $name = explode('|', $fetch['ba_name']); echo ucwords(strtolower($name[0]));?></div>
	  <? $new_seats = array_combine(explode('|', $fetch['ba_seat_no']), $seat_status); 
	  $new_seats = array_filter($new_seats); echo implode(', ', array_keys($new_seats));?></td>
	  <td>Order: <?=date('d-M-Y', strtotime($fetch['ba_addeddate']));?>
      <br>Journey: <?=date('d-M-Y', strtotime($fetch['ba_journey_date']));?></td>
	  <td>
	  <? if(($fetch['ba_ag_id'] == 0) || ($fetch['ba_ag_id'] != 0 && $fetch['ba_ag_id'] == $_SESSION[$svra.'ag_id'])){?>
		  <? if(dateDiff(date('Y-m-d'), $fetch['ba_journey_date']) >= 0){?>
		  <a href="CancelBusBooking.php?tin=<?=$fetch['ba_ticket_no'];?>" class="canc" data-fancybox-type="iframe" id="canch">Cancel</a>
		  <? }?>
	  <? }?>	  
	  </td>
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