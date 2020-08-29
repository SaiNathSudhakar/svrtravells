<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.,"CONTENT="http://www.bitranet.com">
<title>SVR Travels India (P) Ltd.</title>

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="favicon" href="images/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/css.css" type="text/css">
<link rel="stylesheet" href="css/calendar.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/scrolltopcontrol.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/md5.js"></script>
<!--<script type="text/javascript" src="js/ticker.js"></script>
<script type="text/javascript" src="js/preloader.js"></script>-->
<script type="text/javascript" src="js/loopedslider.js"></script>
<? 	$url = basename($_SERVER['REQUEST_URI']); $page = explode("?", $url); 
	if($page[0] == 'destination.php' || $page[0] == 'destination-details.php' || $page[0] == 'fixed-departure-booking.php' || 'tour-package-booking.php') { ?>
		<link rel="stylesheet" href="css/facebox.css" type="text/css" />
		<script type='text/javascript' src="js/facebox.js"></script>
		<script type='text/javascript' src="js/loopedslider.js"></script>
		<script type="text/javascript" src="js/jcarousellite.js"></script>
		<script type="text/javascript" src="js/jquery.easing-1.3.min.js"></script>
<? }?>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/load.js"></script>
<script type="text/javascript"> var siteurl = '<?=$site_url;?>'; </script>
<script type="text/javascript" src="js/ajax.js"></script>

<!--<link href="css/facebox.css" rel="stylesheet" type="text/css" />
<script src="js/facebox.js" type='text/javascript'></script>-->

<? if($page[0] == 'orders.php' || $page[0] == 'cancellations.php' || $page[0] == 'agent-deposits-history.php' 
|| $page[0] == 'BusBookingOrders.php' || $page[0] == 'BusCancellations.php') { ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.fancybox.js" type="text/javascript"></script>
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".various").fancybox({
		/*maxWidth	: 800,
		maxHeight	: 600,*/
		fitToView	: true,
		width		: '600px',
		/*width		: '70%',
		height		: '70%',*/
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		
	});/*$('fancybox').fancybox();*/
});
</script>
<? }?>

<? $bal = getdata('svr_agent_reports', 'ar_closing_bal', "ar_ag_id = '".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
$closing_bal = (!empty($bal)) ? $bal : '0.00'; $_SESSION[$svra.'ag_deposit'] = $closing_bal; ?>
<? //$closing_bal = getdata('svr_agent_reports', 'ar_closing_bal', "ar_ag_id = '".$_SESSION[$svra.'ag_id']."' order by ar_id desc");?>
<? //$closing_bal = ($_SESSION[$svra.'ag_deposit']) ? number_format($_SESSION[$svra.'ag_deposit'], 2) : 0;?>
<? if(!empty($_SESSION[$svra.'ag_id'])){?>
<div class="top_header">
  <div id="topinfo" class="fr toplinks">
    <a href="index.php">Home</a><span>|</span>
    <a href="cms-page.php?cmsid=1">About Us</a><span>|</span>
    <a href="agent-account.php">Agent Account (Bal: Rs. <?=(!empty($_SESSION[$svra.'ag_deposit'])) ? number_format($_SESSION[$svra.'ag_deposit'], 2) : '0'; ?>)</a><span>|</span>
	<a href="agent-logout.php">Agent Logout</a><span>|</span>
	<? if(empty($_SESSION[$svr.'cust_id'])){?>
    	<!--<a href="customer-login.php">Customer Login</a><span>|</span>-->
	<? }elseif(!empty($_SESSION[$svr.'cust_id'])){?>
    	<a href="customer-account.php">Customer Account</a><span>|</span>
		<a href="customer-logout.php">Customer Logout</a><span>|</span>
    <? }?>    
    <a href="#x">Online Brochure</a>
  </div>
</div>
<? }else if(!empty($_SESSION[$svr.'cust_id'])){?>
<div class="top_header">
  <div id="topinfo" class="fr toplinks">
    <a href="index.php">Home</a><span>|</span>
    <a href="cms-page.php?cmsid=1">About Us</a><span>|</span>
    <a href="customer-account.php">My Account</a><span>|</span>
	<a href="customer-logout.php">Logout</a><span>|</span>
    <a href="#x">Online Brochure</a>
  </div>
</div>
<? }else{ ?>
<div class="top_header">
  <div id="topinfo" class="fr toplinks">
    <a href="index.php">Home</a><span>|</span>
    <a href="cms-page.php?cmsid=1">About Us</a><span>|</span>
    <a href="print-ticket.php">Print Ticket</a><span>|</span>
   	<a href="agent-login.php">Agent Login</a><span>|</span>
   	<a href="customer-login.php">Customer Login</a><span>|</span>
    <a href="#x">Online Brochure</a>
  </div>
</div>
<? }?>
<? if(!empty($_SESSION[$svra.'ag_id']) || !empty($_SESSION[$svr.'cust_id'])){?>
<div class="agentheader">
	<div class="agentlogo"><a href="index.php"><img src="<?=(!empty($_SESSION[$svra.'ag_image']) && getimagesize($_SESSION[$svra.'ag_image'])>0) ? $_SESSION[$svra.'ag_image'] :'images/svr-travels.jpg';?>" alt="SVR TRAVELS INDIA (P) LTD." /></a></div>
  <div class="agentdetails"> 
  <div class="smllinks"><a href="print-ticket.php">Print Ticket</a><span>|</span><a href="<?=(!empty($_SESSION[$svra.'ag_id'])) ? 'agent-account.php' : 'customer-account.php';?>">My Profile</a><span>|</span><a href="<?=(!empty($_SESSION[$svra.'ag_id'])) ? 'agent-password.php' : 'customer-password.php';?>">Change Password</a><!--<span>|</span><a href="#nogo">Control Panel</a>--></div><div class="clear"></div>
  	
	<? if(!empty($_SESSION[$svra.'ag_id'])){?>
	<div class="atitle">Welcome <?=$_SESSION[$svra.'ag_fname'];?> <?=$_SESSION[$svra.'ag_unique_id'];?>
	<p><? if(!empty($_SESSION[$svra.'ag_mobile'])){?>Mobile: <?=$_SESSION[$svra.'ag_mobile']?>&nbsp;<? }?> 
	<? if(!empty($_SESSION[$svra.'ag_landline'])){?>Land Line: <?=$_SESSION[$svra.'ag_landline'];?><? }?></p>
	</div><? } else if(!empty($_SESSION[$svr.'cust_id'])){?>
	<div class="atitle">Welcome <?=$_SESSION[$svr.'cust_fname'];?>
	<p><? if(!empty($_SESSION[$svr.'cust_mobile'])){?>Mobile: <?=$_SESSION[$svr.'cust_mobile']?>&nbsp;<? }?> 
	<? if(!empty($_SESSION[$svr.'cust_landline'])){?>Land Line: <?=$_SESSION[$svr.'cust_landline'];?><? }?></p>
	</div>
	<? }?>
	
	<? if(!empty($_SESSION[$svra.'ag_id'])){ ?>
	<div class="balancetable">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="right">Balance</td>
			<td align="center" width="10">:</td>
			<td align="center" width="20">&nbsp;</td>
			<td align="right"><?='Rs. '.((!empty($_SESSION[$svra.'ag_deposit'])) ? number_format($_SESSION[$svra.'ag_deposit'], 2) : '0.00');?></td>
		  </tr>
		  <tr>
			<td align="right"><?=(!empty($_SESSION[$svra.'ag_pan'])) ? 'Pan Card' : '';?></td>
			<td align="center">:</td>
			<td align="center" width="20"></td>
			<td align="right"><?=$_SESSION[$svra.'ag_pan']?></td>
		  </tr>
		</table>
	</div>
	
	<div class="accbtn">
		<ul class="accmenu">
			<li class="top"><a href="#x" class="top_link"><span class="down">Accounts</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
			  <!--[if lte IE 6]><table><tr><td><![endif]-->
				<ul class="sub">
				 
				  <li><a href="orders.php">Orders</a></li>
				  <li><a href="cancellations.php">Cancellations</a></li>
				  <li><a href="BusBookingOrders.php">Bus Booking Orders</a></li>
                  <li><a href="BusCancellations.php">Bus Cancellations</a></li>
				  <li><a href="bank-account-details.php">Bank Account Details</a></li>
				  <li><a href="agent-deposits.php">Deposit Update Request</a></li>
				  <li><a href="agent-deposits-history.php">Deposit History</a></li>
				  <li><a href="agent-instant-recharge.php">Instant Recharge</a></li>
				  <li><a href="agent-report.php">Accounting Reports</a></li>
				</ul>
			  <!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
		</ul>
	</div>
	<? }else if(!empty($_SESSION[$svr.'cust_id'])){ ?>
	<div class="accbtn">
		<ul class="accmenu">
			<li class="top"><a href="#x" class="top_link"><span class="down">Accounts</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
			  <!--[if lte IE 6]><table><tr><td><![endif]-->
				<ul class="sub">
				  <li><a href="customer-account.php">My Profile</a></li>
				  <li><a href="orders.php">Orders</a></li>
				  <li><a href="cancellations.php">Cancellations</a></li>
				  <li><a href="BusBookingOrders.php">Bus Booking Orders</a></li>
                  <li><a href="BusCancellations.php">Bus Cancellations</a></li>
				  <li><a href="customer-password.php">Change Password</a></li>
				  <li><a href="customer-logout.php">Logout</a></li>
				</ul>
			  <!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
		</ul>
	</div>
	  <? }?>
  </div>
   <div class="clear"></div>
</div>
<? }else{ ?>
<div class="header">
	<div class="logo fl"><a href="index.php"><img src="images/svr-travels.jpg" alt="SVR TRAVELS INDIA (P) LTD." /></a></div>
	<div class="fr callus mr20"><h1>040-6999 8289<br />040-6550 4140</h1></div>
	<div class="clear"></div>
</div>
<? }
if(!empty($_GET['date']))
{	
	list($date, $month, $year) = explode('-', $_GET['date']);
	if(!checkdate($month, $date, $year)) header("location:index.php");
}
?>
<script>(function($){$.fn.list_ticker=function(options){var defaults={speed:4000,effect:'slide'};var options=$.extend(defaults,options);return this.each(function(){var obj=$(this);var list=obj.children();list.not(':first').hide();setInterval(function(){list=obj.children();list.not(':first').hide();var first_li=list.eq(0)
var second_li=list.eq(1)
if(options.effect=='slide'){first_li.slideUp();second_li.slideDown(function(){first_li.remove().appendTo(obj);});}else if(options.effect=='fade'){first_li.fadeOut(function(){obj.css('height',second_li.height());second_li.fadeIn();first_li.remove().appendTo(obj);});}},options.speed)});};})(jQuery);</script>