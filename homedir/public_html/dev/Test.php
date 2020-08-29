<? ob_start();
include "includes/api-header.php";
include_once "includes/api-functions.php";
?>
<title>Bus Booking</title>
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<div class="navigation">
	<div class="bg">
	<a href="index.php">Home</a><span class="divied"></span>
	<span class="pagename">Bus Booking</span></div>
</div>

<? 
ob_start();
$mailit = '1'; $ticket = 'CUJJVN';
include('print_ticket.php');
$content = ob_get_contents();
ob_end_clean();
//echo $content;

$mailto = "sarah@bitragroup.com";
$mailheader  = "MIME-Version: 1.0" . "\r\n";
$mailheader .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$mailheader .= "From: SVR Travels India <info@svrtravelsindia.com> \r\n";
//$mailheader .= "Bcc: sarah@bitragroup.com"."\r\n";
$message = "SVR Bus Ticket: ".$ticket;
@mail($mailto, $message, $content, $mailheader);

include('includes/api-footer.php');
?>