<?
//ob_start(); include_once("functions.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{
	if(!empty($_POST['txt_nl_email']))
	{
		$qur=query("select count(nl_email) as eml_cnt from svr_nl where nl_email='".$_POST['txt_nl_email']."'");
		$row=fetch_assoc($qur);
		if($row['eml_cnt']==1)
		{	
			header('Location:index.php?msgtyp=exists');
		}
		else
		{	
			$qur="INSERT INTO `svr_nl`(`nl_email`,`nl_dateadded` )VALUES ('".$_POST['txt_nl_email']."','".$now_time."')";
			query($qur);
			header('Location:index.php?msg=success');
		}
	}
}
?>
<script language="javascript" type="text/javascript">
function chk_nl()
{
	var d = document.form_nl;
	if(d.txt_nl_email.value==''){alert("Please Enter your E-Mail Address"); d.txt_nl_email.value=""; d.txt_nl_email.focus(); return false; }
	if(!validEmail(d.txt_nl_email.value)){ alert("Please Enter Correct E-Mail Address"); d.txt_nl_email.value=""; d.txt_nl_email.focus(); return false; }
	d.submit();
}
</script>

 <div class="clear"></div>
</div>
<div id="svr-footer">
<div id="newsletter_subscribe">
	<div class="mid_section">
		<div class="center"><div style="float:left;" class="mr20">
		<div class="subscribe fl"><h1>Sign Up for more Holiday Deals & Offers</h1>
		</div></div>
		<form name="form_nl" method="post" action="">
		<div class="search fr">
		<span>
		<input name="txt_nl_email" type="text" id="txt_nl_email" onfocus="if(this.value == 'Enter your E-Mail Id here') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Enter your E-Mail Id here'; }" value="Enter your E-Mail Id here" style="border:none" />
		<a href="#x" title="Sign Up" class="newsletter" onclick="return chk_nl();"><img src="images/btn_go.gif" height="28" width="75" alt="Search" /></a>
		</span>
		</div>
		</form>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div style="padding:15px 0 15px 0">
  <div id="mid_section">
	<div align="center" class="mb20">
		<a href="index.php" class="flinks1">Home</a>
		<span class="fl-div1">|</span> 
		<a href="cms-page.php?cmsid=1" class="flinks1">About Us</a> 
		<span class="fl-div1">|</span> 
		<a href="#x" class="flinks1">Hotels</a> 
		<span class="fl-div1">|</span> 
		<a href="cms-page.php?cmsid=6" class="flinks1">Disclaimer</a> 
		<span class="fl-div1">|</span> 
		<a href="cms-page.php?cmsid=5" class="flinks1">Refund & Return Policies</a> 
		<span class="fl-div1">|</span> 
		<a href="cms-page.php?cmsid=4" class="flinks1">Privacy Policy</a> 
		<span class="fl-div1">|</span> 
		<a href="cms-page.php?cmsid=3" class="flinks1">Cancellation Policy</a> 
		<span class="fl-div1">|</span>
		<a href="terms-conditions.php" class="flinks1">Terms &amp; Conditions</a>
		<span class="fl-div1">|</span> 
		<a href="testimonials.php" class="flinks1">Testimonials</a>
		<span class="fl-div1">|</span> 
		<a href="contact.php" class="flinks1">Contact Us</a>
	</div>
	<div class="mb10" style="height:36px;">
		<div class="fl ml20"><img src="images/cards.gif" height="36" width="410" alt="Cards" /></div>
		<div class="fr mt10">
			<div class="fr mr20 mb10">
				<div class="fl social">
					<img src="images/social-icon.gif" alt="Connect With Us" border="0" usemap="#Map2" />
					<map name="Map2" id="Map2">
						<area shape="rect" coords="-198,-1,24,108" href="https://www.facebook.com/pages/Svr-Travels-India-Pvt-Ltd/801158113229443" target="_blank" />
						<area shape="rect" coords="27,0,51,34" href="https://plus.google.com/114314555485017243235/posts" target="_blank" />
					</map>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<div>
<div id="footerwrap">
	<div class="footer">
		<div class="copyright">
			<span class="fl" style="margin:0px 0 0 0">Copyright &copy <?php echo date('Y');?> SVR Travels India (P) Ltd. All Rights Reserverd.</span>
			<span class="fr" style="margin:0px 0 0 0">Designed By <a target="_blank" title="Website Design, Development, Maintenance &amp; Powered by BitraNet Pvt. Ltd.," href="http://www.bitranet.com/"><strong>BitraNet</strong></a></span>			
		</div>
	<div class="clear"></div>
	</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
<? if(!empty($_GET['msg'])) { ?>
	setTimeout( function () { alert("Thank you,\n We will update with Holiday Deals & Offers"); }, 500);
<? } if(!empty($_GET['msgtyp'])) { ?>
	setTimeout( function () { alert("E-Mail ID Already Exists, Please try with Another"); }, 500);
<? } ?>
</script>