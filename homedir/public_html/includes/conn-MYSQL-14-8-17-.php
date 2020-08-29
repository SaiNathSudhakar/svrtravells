<?
@session_start();
global $link_conn, $site_url, $admin_url, $svr, $frommail, $mastermail, $logalert_mail, $now, $now_time, $now_onlytime, $dmy, $ymd;
$timezone = "Asia/Kolkata";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
error_reporting(0);
//error_reporting(E_ERROR | E_PARSE);

//Live	
$link_conn = mysql_connect('localhost', 'svrtrave_user', 'r]To,JD4_Q1I');  
mysql_select_db('svrtrave_maindb');
$site_url="http://www.svrtravelsindia.com/";

//Dev
//$link_conn = mysql_connect('localhost', 'svrtrave_user', 'r]To,JD4_Q1I');  
//mysql_select_db('svrtrave_devdb');
//$site_url="http://www.svrtravelsindia.com/dev/";

// Local
//$link_conn = mysql_connect('localhost', 'root', '');
//mysql_select_db('svrtrave_devdb_new');
//$site_url = "http://localhost/sameera/SVR_new/";
//$admin_url = $site_url."cpbedirection/";

$svr = 'svr';
$frommail = "info@svrtravelsindia.com";
$mastermail = "prasadm@bitragroup.com";
$logalert_mail = "info@svrtravelsindia.com";

$now = date("Y-m-d");
$now_time = date("Y-m-d H:i:s");
$now_onlytime = date("H:i");
$ymd = date("Ymd"); 
$dmy = date("d-m-Y");
?>