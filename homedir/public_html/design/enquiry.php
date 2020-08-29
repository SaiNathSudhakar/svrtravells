<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- Banner Start-->
<div class="banner_inner"><img src="images/enquiry-banner.jpg" alt="" /> </div>               
<!-- Banner end-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">Enquiry</span></div>
</div>
<!-- Navigation end-->

<!-- mid content Start-->
<div class="inner_content">
<div class="enquiry" align="center">
<? if(!empty($_GET['st'])){ ?>
<h1>Enquiry Success</h1>
<p>Thanks for your Mail, We will get back to you shortly.</p>
<? } else { ?>
<h2>Enquiry</h2>
<p>Send us your queries and comments. All fields are mandatory.</p>
<?=($error != '') ? '<p class="error">'.$error.'</p>' : ''; ?>
<form name="enquiry" id="enquiry" method="post" action="">
	<div class="form_styles form_wrapper">
	<input name="txt_name" type="text" id="txt_name" maxlength="75" placeholder="Name *">
	<input name="txt_phone" type="text" id="txt_phone" maxlength="13" placeholder="Phone *">
	<input name="txt_email" type="text" id="txt_email" maxlength="100" placeholder="E-Mail *">
	<input name="txt_areaint" type="text" id="txt_areaint" maxlength="100" placeholder="Area of Interest *">
	<textarea name="text_enquiry" id="text_enquiry" placeholder="Enquiry *"></textarea>
	<table border="0" cellpadding="0" cellspacing="0" class="captd">
		<tr>
		<td>Security Question:</td>
		<td><strong><span class="star" id="rndnumber"></span></strong></td>
		<td>&nbsp;</td>
		<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="left"><input name="rnd1" class="input-text" id="rnd1" placeholder="Result?" size="20" maxlength="5" type="text" />
		<input name="cap_sum" id="cap_sum" value="9" type="hidden" /></td>
		<td width="20" align="left"><span class="ml10 mt5 fl"><img src="images/refresh.gif" width="16" height="16" align="absmiddle" style="cursor:pointer;" title="Click Here To Reload Captcha" onClick="return captcha();"/></span></td>
		</tr>
		</table>
		</td>
		</tr>
	</table>
	<input name="submit" type="submit" class="sbmt_btn" value="submit" onClick="return validate_enquiry()" />
	</div>
</form>
<br />
<h4>Your IP: 49.204.248.213</h4>
<p>(For monitoring purpose we are storing your IP)</p>
<? }?>
</div>
</div>

<script type="text/javascript">
$("#txt_phone").keypress(function (e) { var n=this.id; if (e.which != 8 && e.which != 0 && (e.which < 43 || e.which > 57)) { return false; }});
/*function captcha()
{
	var a=Math.floor(Math.random()*10);
	var b=Math.floor(Math.random()*10);
	c=a+b;
	document.getElementById("cap_sum").value=c;
	document.getElementById("rndnumber").innerHTML=a+'+'+b+'=';
}
function isEmail( string ) {
	if(string.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
	return true;	else		return false;	
}
function validate_enquiry()
{
	d=document.enquiry;
	if(d.txt_name.value==""){alert("Please Enter Your Name");d.txt_name.focus(); return false;}
	
	if(isNaN(d.txt_phone.value) || d.txt_phone.value==""){alert("Please Enter Only Numbers");  d.txt_phone.focus(); return false;}
	
	if(isEmail(d.txt_email.value)==false){alert("Please Enter A Valid E-Mail ID "); d.txt_email.focus(); return false;}
	if(d.txt_phone.value==""){ alert("Please Enter Your Phone Number"); d.txt_phone.focus(); return false;}
	if(d.txt_areaint.value==""){alert("Please Enter Area of Interest");d.txt_areaint.focus(); return false;}
	if(d.text_enquiry.value==""){alert("Please Enter Message");d.text_enquiry.focus(); return false;}
	if (d.rnd1.value=="" || d.rnd1.value=='Result?'){ alert("Please Enter the Sum of Two Numbers !"); d.rnd1.value=""; d.rnd1.focus(); return false; }
	if (d.rnd1.value!=c){ alert("Please Enter Correct Result !"); d.rnd1.value=""; d.rnd1.focus(); return false; }
	return true;
}*/
//window.onload=captcha;
</script>