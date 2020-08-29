<?php
ob_start();
include_once("includes/functions.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$error = '';
$nqur = getBanners();
//Navigational
$nav_count = num_rows($nqur);
$nav = fetch_array($nqur);
//Tour Packages
$tourPackages = getTourPackagesInfo();
$designFILE = "design/destination_tour_package.php";
include_once("includes/svrtravels-template-new.php");
?>
