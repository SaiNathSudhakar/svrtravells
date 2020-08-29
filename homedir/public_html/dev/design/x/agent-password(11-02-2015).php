<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Account</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
<div class="fl"><h1>Change Password</h1></div>
<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svra.'ag_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>
<form name="editpassword" method="post">
<div class="col-5 fl">
<div id="chngpswd" class="mt10">
<input name="oldpass" type="password" id="oldpass" maxlength="25" placeholder="Enter Old Password" class="mb5">
<input name="newpass" type="password" id="newpass" maxlength="25" placeholder="New Password" class="mb5">
<input name="conpass" type="password" id="conpass" maxlength="25" placeholder="Re-Enter Password" class="mb5">
</div>
</div>
<div class="col-6 fl"></div><div class="clear"></div><br />
<input name="Submit32" type="submit" class="sbmt_btn2" value="Update" onClick="return validate_agent_password()" />
</form>
</div>
<div class="clear"></div>
</div>