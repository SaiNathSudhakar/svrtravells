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
	<div class="fl"><h1>My Profile</h1></div>
	<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svra.'ag_fname'];?></span></h2></div>
	<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.' <br />'.$pwd.'</h3>'; }?>
<form name="profile" id="profile" method="post" enctype="multipart/form-data">
<div class="col-5 fl">
<div class="form_styles form_wrapper">
<select name="title" id="title">
<? foreach($titles as $key => $title){
	$selected_title = ($fetch_sam['ag_title'] == $key) ? 'selected' : ''; ?>
	<option value="<?=$key?>" <?=$selected_title?>><?=$title?></option>
<? }?>
</select>
<input name="fname" type="text" id="fname" maxlength="75" placeholder="First Name*" value="<?=$fetch_sam['ag_fname'];?>">
<input name="lname" type="text" id="lname" maxlength="75" placeholder="Last Name*" value="<?=$fetch_sam['ag_lname'];?>">
<input name="mobile" type="text" id="mobile" maxlength="75" placeholder="Mobile No*" value="<?=$fetch_sam['ag_mobile'];?>">
<input name="landline" type="text" id="landline" maxlength="75" placeholder="Landline No*" value="<?=$fetch_sam['ag_landline'];?>">
<input name="email" type="text" id="email" maxlength="75" placeholder="E-Mail ID*" value="<?=$fetch_sam['ag_email'];?>">
<!--<input type="Submit" value="SEND">-->
</div>
</div>
<div class="col-6 fl">
<div class="form_styles form_wrapper">
<input name="address" type="text" id="address" maxlength="75" placeholder="Address*" value="<?=$fetch_sam['ag_address'];?>">
<input name="authority" type="text" id="authority" maxlength="75" placeholder="Authority" value="<?=$fetch_sam['ag_authority'];?>">
<input name="city" type="text" id="city" maxlength="75" placeholder="City*" value="<?=$fetch_sam['ag_city'];?>">
<select name="state" id="state">
	<? foreach($states as $key => $value){
		$selected_state=($fetch_sam['ag_state']==$key )? 'selected': '';?>
	<option value="<?=$key?>"<?=$selected_state?>><?=$value?></option><? }?>
</select> 
<input name="country" type="text" id="country" maxlength="75" placeholder="Country*" value="<?=$fetch_sam['ag_country'];?>">
<input name="pincode" type="text" id="pincode" maxlength="75" placeholder="Pin Code*" value="<?=$fetch_sam['ag_pincode'];?>">
</div>
</div>
<div class="clear"></div>
<br />
<div class="mb10"><input name="promotion" type="checkbox" value="1" <?=($fetch_sam['ag_promotion']==1) ? 'checked' : ''; ?>/>
&nbsp;&nbsp;I would like to be kept infromed of special promotions and offers by SVR Travels</div>
<div class="sq">
<p>Security Question <span class="captcha" id="rndnumber"></span></p>
<input name="rnd1" id="rnd1" type="text" placeholder="Answer" class="sqta" autocomplete="off">
<input name="cap_sum" id="cap_sum" value="9" type="hidden" />
<img src="images/refresh.gif" alt="Try Another Question" title="Try Another Question" onclick="return captcha();">
<div class="clear"></div>
</div>
<input name="submit" type="submit" class="sbmt_btn" value="Update" onClick="return validate_agent_profile()" />
</form>
</div>
<div class="clear"></div>
<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>
</div>

<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$fetch_sam['cnt_content'];?></div>	
</div>
<!--expandable meuu scripts-->
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>