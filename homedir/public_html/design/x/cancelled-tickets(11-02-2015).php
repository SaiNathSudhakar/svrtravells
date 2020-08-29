<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>

<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Account</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
<div class="fl"><h1>My Cancelled Tickets</h1></div>
<div class="fr"><h2>Welcome: <span><?=(!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_fname'] : $_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>

<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <thead>
  	<tr bgcolor="#F7F7F7">
	  <th align="left" width="3%">#</th>
	  <th align="left">Tour Name</th>
	  <th align="left" width="20%">Type</th>
	  <th align="left" width="15%">Cancelled On</th>
  	</tr>
  </thead>
  <tbody>
  	<? if($count > 0){ $i = 0; while($fetch = mysql_fetch_array($q)){ $i++;?>
  	<tr bgcolor="<?=($i%2 == 0) ? '#F7F7F7' : '';?>">
  	  <td><?=$i;?></td>
	  <td><a href="view-order-details.php?id=<?=$fetch['ord_id'];?>" class="flinks1"><?=$fetch['tloc_name'];?></a>
      <br><strong>Order ID</strong>: <?=$fetch['ord_order_id'];?> <strong>Amount</strong>: <span class="rupee">&#x20B9;</span> <?=number_format($fetch['ord_total_amount'], 2);?>
      </td>
	  <td><?=$fetch['cat_name'];?></td>
	  <td><?=date('d-M-Y', strtotime($fetch['ord_updated_date']));?></td>
	</tr>
  	<? }} else{?>
	<tr height="50" align="center"><td valign="middle" colspan="4">No Records Found</td></tr>
	<? }?>
  </tbody>
</table>

</div>
<div class="clear"></div>
</div>

<script language="javascript">
function cancel_ticket(id)
{
	if(confirm("Are you sure to cancel Ticket?")){
		window.location='fixed-departure-tickets.php?id='+id;
	}
}
</script>