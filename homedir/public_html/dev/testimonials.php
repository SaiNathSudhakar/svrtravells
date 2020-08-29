<?
ob_start();
include_once("includes/functions.php");

$qur=query("select test_name, test_place, test_testimonial, test_image from svr_testimonials where test_status=1");

$designFILE = "design/testimonials.php";
include_once("includes/svrtravels-template.php");
?> 
