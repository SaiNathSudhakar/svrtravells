<!-- Banner Start-->
<div class="banner_inner">
  <img src="images/booknow.jpg" alt="About SVR Travels" />
</div>
<!-- Banner end-->

<!-- Navigation Start-->
<div class="navigation">
  <div class="bg">
    <a href="index.php">Home</a>
    <span class="divied"></span>
    <span class="pagename">Fixed Departure Booking</span>
  </div>
</div>
<!-- Navigation end-->
<? 
$display = (isset($_SESSION[$svr.'cust_id'])) ? '' : 'none';
if(isset($_SESSION[$svr.'cust_id']))
{	
	$atrributes = 'readonly'; $disabled = 'disabled';
	if($title != '') $title_disabled = 'disabled';
	if($state != '') $state_disabled = 'disabled';
} else {
	$customer = $title = $fname = $lname = $email = $addr = $mobile = $city = $state = $country = '';
	$atrributes = $disabled = '';
}
?>
<!-- Mid Content Start -->		  
<div class="inner_content">
<form name="fixedbookingform" id="fixedbookingform" method="post" action="">
<input type="hidden" name="category" id="category" value="1">
<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
<? if($count > 0){?>
  <tr>
    <td colspan="2" align="left" valign="middle" bgcolor="#F9F9F9">Booking Date: <?=date('l, F j, Y');?></td>
    <td align="left" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#F9F9F9">Adults : <?=$adult;?></td>
    <td align="left" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">Children: <?=$child;?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
  </tr>
<? }?>  
  <tr class="heading">
    <td align="left" valign="middle" bgcolor="#F2F2F2">Tour Name</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Journey Date</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Return Date</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Departure Time</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Bus Type</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Seats Numbers</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2">Amount</td>
    <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="images/unchecked.gif" /></td>
  </tr>
  <? $total = 0; if($count > 0){ foreach($order as $row){
	  list($deptime, $rettime) = (!empty($row['tloc_time'])) ? explode('|', $row['tloc_time']) : array_fill(0, 2, '');
	  $total += $row['bot_amount'];?>
  <tr>
    <td align="left" valign="middle" bgcolor="#F9F9F9"><?=$row['tloc_name'];?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=date('d-M-Y', strtotime($row['bot_journey_date']));?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=date('d-M-Y', strtotime($row['bot_return_date']));?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=$deptime;?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=$accomodation_type[$row['bot_acc_type']];?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=$row['bot_seat_number'];?></td>
    <td align="right" valign="middle" bgcolor="#F9F9F9"><?=number_format($row['bot_amount'], 2);?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">
    <a href="javascript:;" onclick="window.location='fixed-departure-booking-details.php?id='+<?=$row['bot_id'];?>"><img src="images/unchecked.gif" /></a></td>
  </tr>
  <? }?> 
  <tr>
    <td align="left" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#F9F9F9" class="heading">Total Amount</td>
    <td align="right" valign="middle" bgcolor="#F9F9F9" class="heading">
	<input type="hidden" name="totalfare" id="totalfare" value="<?=$total;?>" />
	<input type="hidden" name="amount" value="<?=number_format($total, 2);?>"><?=number_format($total, 2);?></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9">&nbsp;</td>
  </tr>
  <? } else {?>
  <tr>
    <td align="center" height="90" valign="middle" colspan="8" bgcolor="#F9F9F9">No Orders Found</td>
  </tr>
  <? }?>
</table>
<? if($count > 0){?>
	<br><? include('design/quick-customer-registration.php');?>
	<br><? include('design/quick-payment.php');?>
<? }?>
</form>
<? if($row['cnt_content'] != '') { ?>
<br /><h3>*<a href="#dealit" rel="facebox"> Terms & Conditions</a></h3>
<? }?>
</div>

<div id="dealit">
	<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
	<div style="padding:20px;" class="facebox">
		<?=$row['cnt_content'];?>
	</div>
</div>