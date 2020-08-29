<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/site.css" rel="stylesheet" type="text/css">
<!--<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->

<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$pageName?></span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
	<div class="fl"><h1><?=$pageName?></h1></div>
	<div class="fr"><h2>Welcome: <span><?=(!empty($fetch['ag_fname'])) ? $fetch['ag_fname'] : $_SESSION[$svra.'ag_fname']?></span></h2></div>
	<div class="clear"></div>
</div>
<div class="enquiry" align="center">
<? //if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.'</h3>'; }?>
<form name="recharge" id="recharge" method="post" enctype="multipart/form-data">
<div class="col">
<div class="form_styles form_wrapper">
<table width="100%" cellpadding="3" cellspacing="5"><tr><td align="center">
<table width="" cellpadding="0" cellspacing="0">
<tr><td colspan="2"><? if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.'</h3>'; }?></td></tr>
<tr><td width="50"><strong>Amount</strong></td>
<td><input type="text" name="amount" size="60"/></td></tr>
<tr>
  <td valign="middle">&nbsp;</td>
  <td>(Minimum Amount for deposit recharge <span class="rupee bold red">&#x20B9;</span> 1000)</td>
</tr>
<tr><td colspan="2" align="center"><input name="submit" type="submit" class="sbmt_btn" value="Recharge" onClick="return validation()"/></td></tr>
</table>
</td></tr></table>
</div>

</div>
</form>
</div>
</div>
<div class="clear"></div>
<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
<div class="clear"></div>
<!--<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>-->
</div>
<!--<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$fetch_sam['cnt_content'];?></div>	
</div>-->
<!--expandable meuu scripts-->
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>
<script>
var numbers = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,4})?)$/;
function validation()
{
	var d = document.recharge;	
	if(d.amount.value==""){ alert("Please Enter Amount"); d.amount.focus(); return false; }
	if(!numbers.test(d.amount.value)){ alert("Please Enter Numeric Characters Only"); d.amount.focus(); return false; }
	else if(d.amount.value <1000){ alert("Minimum Amount for deposit is 1000");	d.amount.focus(); return false; }
}
</script>