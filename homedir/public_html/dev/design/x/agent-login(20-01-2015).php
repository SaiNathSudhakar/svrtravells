<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- Banner Start-->
<div class="banner_inner">
	<img src="images/customer-login-banner.jpg" alt="Customer Registration" />
</div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="../index.php">Home</a><span class="divied"></span><span class="pagename">Agent Login</span></div>
</div>

<div class="inner_content">                  
<div class="enquiry" align="left">              	
<h2>Agent Login Form</h2>

<form name="agent_login_form" id="agent_login_form" method="post">
	<div class="form_styles form_wrapper">
	<h4><?=$msg?></h4>
	<input name="email" type="text" id="email" maxlength="75" placeholder="E-Mail">
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="password" type="password" id="password" maxlength="12" placeholder="Password">
   	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="ag_login" type="hidden" value="agent_login">
	<input name="Submit32" type="submit" class="sbmt_btn2" value="SUBMIT" onClick="return validation()" />
	
	<!--<div class="clear" style="line-height:5px;">&nbsp;</div>
	<p style="float:right">New Member <a href="customer-registration.php">Register Here</a></p>
	<!--<div class="clear" style="line-height:3px;">&nbsp;</div>-->
	
	<!--<div class="clear" style="line-height:5px;">&nbsp;</div>-->
	<!--<p style="float:left"><a href="customer-forgot-password.php">Forgot Password?</a></p>
	<div class="clear" style="line-height:3px;">&nbsp;</div>-->
	</div>
</form>
</div><br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>
<script>
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
function validation(){
//alert('kkkk');
	var d=document.agent_login_form;
	if(!chk_email.test(d.email.value)){alert("Please Enter Valid Email Address");d.email.focus();return false;}
	if(d.password.value==""){ alert("Please Enter Password");d.password.focus(); return false;}
	}
</script>	