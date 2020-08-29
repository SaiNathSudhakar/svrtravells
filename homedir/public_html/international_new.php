<?php
ob_start();
include_once("includes/functions.php");
$error = '';
$nqur = getBanners();
$nav_count = num_rows($nqur);
$nav = fetch_array($nqur);
$international = getInternationalInfo();
$designFILE = "design/destination_international.php";
include_once("includes/svrtravels-template-new.php");
?>
