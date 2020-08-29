<script src="js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<!--<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Orders</span></div></div>
<!-- Navigation End-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
<div class="fl"><h1>My Orders</h1></div>
<div class="fr"><h2>Welcome: <span><?=(!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_fname'] : $_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; }?>

<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <thead>
  	<tr bgcolor="#F7F7F7">
	  <th align="left" width="3%">#</th>
	  <th align="left">Tour Name</th>
	  <th align="left" width="15%">Type</th>
	  <th align="left" width="18%">Date</th>
	  <th align="left">Added By</th>
	  <th align="left" width="3%">Cancel</th>
  	</tr>
  </thead>
  <tbody>
  	<? if($count > 0){ $i = 0; while($fetch = fetch_array($q)){ $i++;?>
  	<tr bgcolor="<?=($i%2 == 0) ? '#F7F7F7' : '';?>">
  	  <td><?=$i;?></td>
	  <td><a href="view-order-details.php?id=<?=$fetch['ord_id'];?>" class="various" data-fancybox-type="iframe"><?=$fetch['tloc_name'];?></a>
      <br><strong>Order ID</strong>: <?=$fetch['ord_order_id'];?> <strong>Amount</strong>: <span class="rupee">&#x20B9;</span> <?=number_format($fetch['ord_amount'], 2);?></td>
	  <td><?=$fetch['cat_name'];?></td>
	  <td>Order: <?=date('d-M-Y', strtotime($fetch['ord_added_date']));?>
      <br>Journey: <?=date('d-M-Y', strtotime($fetch['ord_journey_date']));?></td>
	  <td><?=($fetch['ord_ag_id'] != 0) ? 'Agent' : 'Customer';?></td>
	  <td>
	  <? if(($fetch['ord_ag_id'] == 0) || ($fetch['ord_ag_id'] != 0 && $fetch['ord_ag_id'] == $_SESSION[$svra.'ag_id'])){?>
		  <? if(dateDiff(date('Y-m-d'), $fetch['ord_journey_date']) >= $cancel_before){?>
		  <a href="javascript:;" onclick="cancel_ticket('<?=$fetch['ord_id'];?>', '<?=$fetch['ord_tmp_id'];?>', '<?=$fetch['ord_amount'];?>', '<?=$fetch['ord_journey_date'];?>', '<?=$fetch['ord_order_id'];?>');">Cancel</a>
		  <? }?>
	  <? }?>	  </td>
  	</tr>
  	<? }} elseif($count == 0){?>
	<tr height="50" align="center"><td valign="middle" colspan="6">No Records Found</td></tr>
	<? }?>
	<? if($total>$len){ ?>
	<tr>
	  <td colspan="6"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td><? page_Navigation_front($start,$total,$link);?></td>
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
function cancel_ticket(id,tid,amt,jdate,oid)
{	
	if(confirm("Are you sure to cancel Ticket?")){ 
		window.location='cancellations.php?id='+id+'&tid='+tid+'&amount='+amt+'&jdate='+jdate+'&orderid='+oid;
	}
}
</script>