<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- Banner Start-->
<div class="banner_inner">
	<img src="images/customer-login-banner.jpg" alt="Customer Registration" />
</div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg">
		<a href="index.php">Home</a>
		<span class="divied"></span>
		<a href="customer-login.php">Agent Login</a>
		<span class="divied"></span>
		<span class="pagename">Forgot Password</span>
	</div>
</div>

<div class="inner_content">                  
<div class="enquiry" align="left">              	
<h2>Forgot Password Form</h2>

<form name="customer_forgot_form" id="customer_forgot_form" method="post">
	<div class="form_styles form_wrapper">
	<h4><? if(!empty($_GET['fgmsg'])){ echo "Please check your email for your login details.";}
	 if($invmsg){ echo $invmsg;}?></h4>
	 
	<input name="email" type="text" id="email" maxlength="75" placeholder="E-Mail">
	
	<div class="clear" style="line-height:5px">&nbsp;</div>
	
	<input name="forgot_password" type="hidden" value="forgot_password">
	<input name="Submit32" type="submit" class="sbmt_btn2" value="SUBMIT" onClick="return validate_customer_forgotpwd()" />
		
	</div>
</form>
</div><br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>