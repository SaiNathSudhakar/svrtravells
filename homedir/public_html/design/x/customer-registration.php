<link rel="stylesheet" href="css/anytime.5.0.5.css">
<script language="javascript" src="js/anytime.5.0.5.js"></script>
<script>
$(document).ready(function() {
	(function tabOverSetup() {
	$('#tabOverInput').
	  click( function(e) { $(this).off('click').AnyTime_picker({format: "%M %D, %Y %H:%i"}).focus(); } ).
	  keydown(
		function(e) { 
		  var key = e.keyCode || e.which;
		  if ( ( key != 16 ) && ( key != 9 ) ) { // shift, del, tab
			$(this).off('keydown').AnyTime_picker().focus();
			e.preventDefault();
			}
		  } );
	$('#tabOverClear').
	  click(
		function() {
		  $('#tabOverInput').AnyTime_noPicker().val('');
		  tabOverSetup();
		  } );
	})();
});
var chk_phone=/^\d{10}$/;
</script>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- Banner Start-->
<div class="banner_inner">
	<img src="images/customer-login-banner.jpg" alt="Customer Registration" />
</div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="../index.php">Home</a><span class="divied"></span><span class="pagename">Customer Registration</span></div>
</div>
<!-- Navigation End-->

<!-- Mid content Start-->
<div class="inner_content">                  
<div class="enquiry" align="left">              	
<h2>Customer Registration Form</h2>
<?=($error != '') ? '<p class="error">'.$error.'</p>' : ''; ?>
<form action="" name="customer_registration_form" id="customer_registration_form" method="post">
	<div class="form_styles form_wrapper">
	<select name="title" id="title">
		<? foreach($titles as $key => $title){?>
			<option value="<?=$key?>"><?=$title?></option>
		<? }?>
	</select>
	<input name="fname" type="text" id="fname" maxlength="75" placeholder="First Name" value="<?=$fname?>">
	<input name="lname" type="text" id="lname" maxlength="75" placeholder="Last Name" value="<?=$lname?>">
	<input name="dob" type="text" id="tabOverInput" placeholder="Date of Birth" value="<?=$dob?>">
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="address1" type="text" id="address1" maxlength="75" placeholder="Address: Line 1 here" value="<?=$address1?>">
	<input name="address2" type="text" id="address2" maxlength="75" placeholder="Address: Line 2 here" value="<?=$address2?>">
	<input name="city" type="text" id="city" maxlength="75" placeholder="City" value="<?=$city?>">

	<div class="clear" style="line-height:5px">&nbsp;</div>
 	<select name="state" id="state">
		<? foreach($states as $key => $value){?><option value="<?=$key?>" <? if($state == $key) echo 'selected';?>><?=$value?></option><? }?>
	</select> 
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="country" type="text" id="country" maxlength="75" placeholder="Country" value="<?=$country?>">
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="pincode" type="text" id="pincode" maxlength="75" placeholder="Pin Code" value="<?=$pin?>">
	<input name="mobile" type="text" id="mobile" maxlength="75" placeholder="Mobile" value="<?=$mobile?>">
	<input name="landline" type="text" id="landline" maxlength="75" placeholder="Land Line*" value="<?=$phone?>">
	<input name="email" type="text" id="email" maxlength="75" placeholder="E-Mail" value="<?=$email?>">
	<input name="conemail" type="text" id="conemail" maxlength="75" placeholder="Confirm E-Mail" value="<?=$email?>">
	<input name="password" type="password" id="password" maxlength="12" placeholder="Password">
	<input name="conpass" type="password" id="conpass" maxlength="12" placeholder="Confirm Password">
    <input name="tnc" type="checkbox" value="" checked="checked" /><span>I would like to be informed of special promotions and offers by SVR Travels India (P) Ltd.</span>
    <div class="clear"></div>
	    <input name="Check Box" type="checkbox" value="" /><span>Send me offers from carefully selected third parties.Please un-tick if you'd prefer not to receive offers</span>
    <div class="clear"></div>
	<table border="0" cellpadding="0" cellspacing="0" class="captd">
      <tr>
        <td>Security Question:</td>
        <td><strong><span class="star" id="rndnumber"></span></strong></td>
        <td></td>
        <td><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left">
			  	<input name="rnd1" class="input-text" id="rnd1" placeholder="Result?" size="20" maxlength="5" type="text" />
                <input name="cap_sum" id="cap_sum" value="9" type="hidden" />
              </td>
              <td width="20" align="left"><span class="ml10 mt5 fl"><img src="images/refresh.gif" width="16" height="16" align="absmiddle" style="cursor:pointer;" title="Click Here To Reload Captcha" onclick="return captcha();"/></span></td>
            </tr>
        </table></td>
      </tr>
    </table>
	<input name="submit" type="submit" class="sbmt_btn" value="submit" onClick="return validation()" />
	</div>
</form>
</div><br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>
<!-- Mid Content End-->
<script>
function validation()
{
	var d = document.customer_registration_form;	
	if(d.title.value==""){ alert("Please select Title");d.title.focus(); return false;}
	if(d.fname.value==""){ alert("Please Enter First Name");d.fname.focus(); return false;}
	if(d.lname.value==""){ alert("Please Enter Last Name");d.lname.focus(); return false;}
	if(d.dob.value==""){ alert("Please select DOB");d.dob.focus(); return false;}
	if(d.address1.value==""){ alert("Please enter Address");d.address1.focus(); return false;}
	if(d.city.value==""){ alert("Please Enter City");d.city.focus(); return false;}
	<!--if(d.state.value==""){ alert("Please select State ");d.state.focus(); return false;}-->
	if(d.country.value==""){ alert("Please enter Country Name");d.country.focus(); return false;}
	if(d.pincode.value==""){ alert("Please enter Pincode");d.pincode.focus(); return false;}
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid mobile number");d.mobile.focus(); return false;}
	if(isNaN(d.landline.value) || d.landline.value==""){alert("Please Enter valid phone number"); d.landline.focus(); return false;}
	//if(!chk_email.test(d.email.value)){alert("Please Enter Valid Email Address");d.email.focus();return false;}
	if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.conemail.value != d.email.value){alert("Email doesn't match");d.conemail.focus();return false;}
	if(d.password.value==""){ alert("Please Enter Password");d.password.focus(); return false;}
	if(d.conpass.value != d.password.value){alert("Password doesn't match");d.conpass.focus();return false;}
	<!--if(d.tnc.value==""){ alert("Please click on checkbox");d.tnc.focus(); return false;}-->
	if(d.rnd1.value=="Result?"){alert("Please enter the Result");d.rnd1.focus();return false;}
	if(d.rnd1.value != d.cap_sum.value){ alert("Please enter Correct Result"); d.rnd1.focus(); return false; }
}
function captcha()
{
	var a=Math.floor(Math.random()*10);
	var b=Math.floor(Math.random()*10);
	c=a+b;
	document.getElementById("cap_sum").value=c;
	document.getElementById("rndnumber").innerHTML=a+'+'+b+'=';
}
window.onload=captcha;
</script>