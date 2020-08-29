<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<!--<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">My Account</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
<div class="fl"><h1>Change Password</h1></div>
<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<div class="enquiry" align="center">
<? if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>
<div class="form_styles form_wrapper">
<form name="editpassword" method="post">
<!--<div class="form_styles form_wrapper">-->
<div class="col ">
<div id="chngpswd" class="mt10">
<input name="oldpass" type="password" id="oldpass" maxlength="25" placeholder="Enter Old Password" class="mb5" >
<input name="newpass" type="password" id="newpass" maxlength="25" placeholder="New Password" class="mb5" >
<input name="conpass" type="password" id="conpass" maxlength="25" placeholder="Re-Enter Password" class="mb5">
</div>
</div>
<div class="col-6 fl"></div>
<div class="clear"></div>
<input name="Submit32" type="submit" class="sbmt_btn2" value="Update" onClick="return validate_customer_password()" />
<!--</div>-->
</form></div>
</div></div>

<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
<div class="clear"></div>

<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>
</div>

<!--</div>-->
<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$terms_content;?></div>	
</div>
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>
