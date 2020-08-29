<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- Banner Start-->
<div class="banner_inner">
	<img src="images/customer-login-banner.jpg" alt="Customer Registration" />
</div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="../index.php">Home</a><span class="divied"></span><span class="pagename">Reset Password</span></div>
</div>

<div class="inner_content">                  
<div class="enquiry" align="left">              	
<h2>Reset Password Form</h2>

<form name="reset_password_form" id="reset_password_form" method="post">
	<div class="form_styles form_wrapper">
	
	<h4><? if(!empty($invmsg)){ echo $invmsg;}
	 if(!empty($_GET['msg']) && $_GET['msg']=="inv_rid"){ echo "Invalid link please submit your E-Mail ID .";}
	 if(!empty($_GET['rmsg']) && $_GET['rmsg']=="reset_pwd_login"){ echo "You have Successfully Changed your Password";}
	?></h4>
	<input name="new_pwd" type="password" id="new_pwd" maxlength="75" placeholder="New Password">
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input name="confirm_pwd" type="password" id="confirm_pwd" maxlength="75" placeholder="Confirm Password">
	<div class="clear" style="line-height:5px">&nbsp;</div>
	<input type="hidden" name="pwd_reset" id="pwd_reset" value="<?=$_GET['rid']?>"/>
	<input name="reset_password" type="submit" class="sbmt_btn2" value="SUBMIT" onClick="return validation()" />
	</div>
</form>
</div><br />
<div><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
 </div>
<script>

function validation(){
//alert('kkkk');
	var d=document.reset_password_form;
	if(d.new_pwd.value==""){ alert("Please Enter New Password");d.new_pwd.focus(); return false;}
	if(d.confirm_pwd.value != d.new_pwd.value){alert("Confirm Password Deosn't Match With New Password Field");d.confirm_pwd.focus();return false;}
	}
</script>	
