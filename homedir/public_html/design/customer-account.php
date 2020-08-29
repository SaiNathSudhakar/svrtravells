<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<? $my = (!empty($_SESSION[$svra.'ag_id'])) ? 'Customer' : 'My';?>
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$my?> Account</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
	<div class="fl"><h1><?=$my?> Profile</h1></div>
    <? if(empty($_SESSION[$svra.'ag_id'])){ ?>
	<div class="fr"><h2>Welcome: <span><?=$fetch_sam['cust_fname']?></span></h2></div>
    <? }?>
	<div class="clear"></div>
</div>
<? if(!empty($_SESSION["ATime"]) && !empty($_SESSION["CustomerAccount"])){
	$OldTime=$_SESSION["ATime"]; $NewTime=time(); 
	if(($NewTime-$OldTime)>2){ unset($_SESSION["CustomerAccount"]); }
} $msg = (!empty($_SESSION['CustomerAccount']))? $_SESSION['CustomerAccount'] : '';
if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.' <br />'.$pwd.'</h3>'; }?>
<form name="profile" id="profile" method="post" enctype="multipart/form-data">
<div class="col-5 fl">
<div class="form_styles form_wrapper">
<select name="title" id="title">
<? foreach($titles as $key => $title){
	$selected_title=($fetch_sam['cust_title']==$key )? 'selected': ''; ?>
	<option value="<?=$key?>"<?=$selected_title?>><?=$title?></option>
<? }?>
</select>
<input name="fname" type="text" id="fname" maxlength="75" placeholder="First Name*" value="<?=$fetch_sam['cust_fname'];?>">
<input name="lname" type="text" id="lname" maxlength="75" placeholder="Last Name*" value="<?=$fetch_sam['cust_lname'];?>">
<input name="mobile" type="text" id="mobile" maxlength="75" placeholder="Mobile No*" value="<?=$fetch_sam['cust_mobile'];?>">
<input name="landline" type="text" id="landline" maxlength="75" placeholder="Landline No" value="<?=$fetch_sam['cust_landline'];?>">
<input name="email" type="text" id="email" maxlength="75" placeholder="E-Mail ID*" value="<?=$fetch_sam['cust_email'];?>">

<!--<input type="Submit" value="SEND">-->
</div>
</div>
<div class="col-6 fl">
<div class="form_styles form_wrapper">
<input name="address1" type="text" id="address1" maxlength="75" placeholder="Address1*" value="<?=$fetch_sam['cust_address_1'];?>">
<input name="address2" type="text" id="address2" maxlength="75" placeholder="Address2" value="<?=$fetch_sam['cust_address_2'];?>">
<input name="city" type="text" id="city" maxlength="75" placeholder="City*" value="<?=$fetch_sam['cust_city'];?>">
<select name="state" id="state">
	<? foreach($states as $key => $value){
		$selected_state=($fetch_sam['cust_state']==$key )? 'selected': '';?>
	<option value="<?=$key?>"<?=$selected_state?>><?=$value?></option><? }?>
</select> 
<input name="country" type="text" id="country" maxlength="75" placeholder="Country*" value="<?=$fetch_sam['cust_country'];?>">
<input name="pincode" type="text" id="pincode" maxlength="75" placeholder="Pin Code*" value="<?=$fetch_sam['cust_pincode'];?>">
</div>
</div>
<div class="clear"></div>
<br />
<div class="mb10"><input name="promotion" type="checkbox" value="1" <?=($fetch_sam['cust_promotion']==1) ? 'checked' : ''; ?>/>
&nbsp;&nbsp;I would like to be kept infromed of special promotions and offers by SVR Travels</div>
<div class="sq">
<p>Security Question <span class="captcha" id="rndnumber"></span></p>
<input name="rnd1" id="rnd1" type="text" placeholder="Answer" class="sqta" autocomplete="off">
<input name="cap_sum" id="cap_sum" value="9" type="hidden" />
<img src="images/refresh.gif" alt="Try Another Question" title="Try Another Question" onclick="return captcha();">
<div class="clear"></div>
</div>
<input name="submit" type="submit" class="sbmt_btn" value="Update" onClick="return validate_customer_profile()" />
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