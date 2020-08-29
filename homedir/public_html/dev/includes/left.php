<? 
$current_url = basename($_SERVER['PHP_SELF']);
list($page, $args) = explode('?', $current_url);

if(!empty($_SESSION[$svra.'ag_id'])){ ?>

<div class="glossymenu fl">
  <a class="menuitem1" href="agent-account.php">My Profile</a>
  <a class="menuitem submenuheader" href="#x">Booked Tickets</a>
  <div class="submenu">
	<ul>
		<li><a href="fixed-departure-tickets.php">Fixed Depatures Tickets</a></li>
		<li><a href="tour-package-tickets.php">Tour Package Tickets</a></li>
	</ul>
  </div>
  <a class="menuitem" href="cancelled-tickets.php">Cancelled Tickets</a>
  <a class="menuitem" href="agent-deposits-history.php">Deposit History</a>
  <a class="menuitem" href="agent-instant-recharge.php">Instant Recharge</a>
  <a class="menuitem" href="agent-report.php">Report</a>
  <a class="menuitem" href="agent-password.php">Change Password</a>
  <a class="menuitem" href="agent-logout.php">Logout</a>
</div>

<? } else if(!empty($_SESSION[$svr.'cust_id'])){ ?>

<div class="glossymenu fl"> 
  <a class="menuitem1" href="customer-account.php">My Profile</a> 
  <a class="menuitem submenuheader" href="#x">Booked Tickets</a>
	<div class="submenu">
	  <ul>
		<li><a href="fixed-departure-tickets.php">Fixed Depatures Tickets</a></li>
		<li><a href="tour-package-tickets.php">Tour Package Tickets</a></li>
	  </ul>
	</div>
  <a class="menuitem" href="cancelled-tickets.php">Cancelled Tickets</a>
  <a class="menuitem" href="customer-password.php">Change Password</a>
  <a class="menuitem" href="customer-logout.php">Logout</a>
</div>

<? }?>