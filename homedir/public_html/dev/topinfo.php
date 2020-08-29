<? ob_start();
include_once("includes/functions.php");?>
<? if(!empty($_SESSION[$svra.'ag_id'])){?>
<div class="top_header">
  <div id="topinfo" class="fr toplinks">
    <a href="index.php">Home</a><span>|</span>
    <a href="cms-page.php?cmsid=1">About Us</a><span>|</span>
	<a href="print-ticket.php">Print Ticket</a><span>|</span>
	<? if(empty($_SESSION[$svr.'cust_id'])){?>
    	<!--<a href="customer-login.php">Customer Login</a><span>|</span>-->
	<? }elseif(!empty($_SESSION[$svr.'cust_id'])){?>
    	<a href="customer-account.php">Customer Account</a><span>|</span>
		<a href="customer-logout.php">Customer Logout</a><span>|</span>
    <? }?>
    <a href="agent-account.php">Agent Account (Bal: Rs. <?=number_format($_SESSION[$svra.'ag_deposit'], 2);?>)</a><span>|</span>
	<a href="agent-logout.php">Agent Logout</a><span>|</span>    
    <a href="#x">Online Brochure</a>
  </div>
</div>
<? }else if(!empty($_SESSION[$svr.'cust_id'])){?>
<div class="top_header">
  <div id="topinfo" class="fr toplinks">
    <a href="index.php">Home</a><span>|</span>
    <a href="cms-page.php?cmsid=1">About Us</a><span>|</span>
	<a href="print-ticket.php">Print Ticket</a><span>|</span>
    <a href="customer-account.php">My Account</a><span>|</span>
	<a href="customer-logout.php">Logout</a><span>|</span>
    <a href="#x">Online Brochure</a>
  </div>
</div>
<? }?>
