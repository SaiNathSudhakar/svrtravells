<?
ob_start();
include_once("includes/functions.php");
$qur=query("select cnt_content from svr_content_pages where cnt_id = 7");
$row=fetch_array($qur);	
$designFILE = "design/contact.php";
include_once("includes/svrtravels-template.php");
?> 
