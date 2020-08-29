<?php ob_start();
include_once("includes/functions.php");
$pageTitle="";
if($_GET['cmsid']){
	$qur=query("select * from svr_content_pages where cnt_status=1 and cnt_id=".$_GET['cmsid']);
	$row=fetch_array($qur);
}

$meta_title =$row['cnt_meta_title'];
$meta_keywords =$row['cnt_meta_keywords'];
$meta_description =$row['cnt_meta_description'];

$designFILE = "design/cms-page.php";
include_once("includes/svrtravels-template.php");
?> 
