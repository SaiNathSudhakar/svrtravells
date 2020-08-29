<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../includes/script_valid.js"></script>
<script language="javascript" src="js/jquery-1.7.2.min.js"></script>
<!--<script language="javascript" src="../js/ajax.js"></script>-->
</head>
<body>
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><img src="images/spacer.gif" border="0" height="5" /></td>
		</tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
			  <td valign="middle" width="50%">
			  	<img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Packages</strong>
			  </td>
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			 		<td valign="top" class="grn_subhead" align="right">&nbsp;</td>
				</tr></table></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>


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
    <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="../images/unchecked.gif" /></td>
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
    <a href="javascript:;" onclick="window.location='fixed-departure-booking-details.php?id='+<?=$row['bot_id'];?>"><img src="../images/unchecked.gif" /></a></td>
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
<? if($count > 0){ ?>
	<br><? include('quick-customer-registration.php');?>
	
<? }?>
</form>

</td>
		</tr>
		<tr>
		  <td align="center">&nbsp;</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</body>
</html> 