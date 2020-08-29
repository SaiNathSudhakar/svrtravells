<?php
ob_start();
include_once("includes/functions.php");
$error = '';
$nqur = getBanners();
//Navigational
$nav_count = num_rows($nqur);
$nav = fetch_array($nqur);

//Fixed Depature
$fixedDepature = getFixedDepatureInfo();
$designFILE = "design/destination_fixed_departure.php";
include_once("includes/svrtravels-template-new.php");
?>
