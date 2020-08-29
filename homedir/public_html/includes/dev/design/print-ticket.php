<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<!--<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">Print Ticket</span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
<div class="fl"><h1>Print Ticket</h1></div>
<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 class="msg" align="center">'.$msg.'</h3>'; } ?>

<form name="ticket" method="post">
<div class="col-5">
<div class="fl mt5"><input name="ticket" type="text" id="ticket" maxlength="35" placeholder="Enter Ticket Number"> </div>
<div class="fr mt5" id="printt"><input name="printticket" type="button" class="submit-btn" id="printticket" value="Print Ticket"></div>
<div class="clear"></div>
</div>
<!--<input name="Submit32" type="submit" class="sbmt_btn2" value="Update" onClick="return validate_agent_password()" />-->
</form>
<br><br>
<div id="ticket-details"></div>
</div>
<div class="clear"></div>
</div>
