<? ob_start();
include_once("includes/functions.php");

$qur=mysql_query("select cnt_content from svr_content_pages where cnt_id = 2");
$row=mysql_fetch_array($qur);
	
$designFILE = "design/terms-conditions.php";
include_once("includes/svrtravels-template.php");
?> 
