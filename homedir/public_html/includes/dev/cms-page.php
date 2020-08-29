<?php ob_start();
include_once("includes/functions.php");
$pageTitle="";
if($_GET['cmsid']){
	$qur=mysql_query("select * from svr_content_pages where cnt_status=1 and cnt_id=".$_GET['cmsid']);
	$row=mysql_fetch_array($qur);
}
$designFILE = "design/cms-page.php";
include_once("includes/svrtravels-template.php");
?> 
