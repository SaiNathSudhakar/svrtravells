<?php
ob_start();
include_once("includes/functions.php");
$error = '';

$query = "select cat_name, subcat_name, subcat_meta_title, subcat_meta_keywords, subcat_meta_description, subsubcat_name, subcat_ref_no, subcat_banner_image from svr_categories as cat
		left join svr_subcategories as subcat on subcat.cat_id_fk = cat.cat_id
			left join svr_subsubcategories as subsubcat on subsubcat.subcat_id_fk = subcat.subcat_id";

//Navigational
$nqur = query($query);
$nav_count = num_rows($nqur);

$nav = fetch_array($nqur);

//Fixed Depature
$fixedDepature = array (
	array("locName"=>"Char Dham Yatra","tourPlace"=>"member1.jpg","id"=>3),
	array("locName"=>"Holy Amarnath Yatra","tourPlace"=>"member2.jpg","id"=>1),
	array("locName"=>"Do Dham Yatra","tourPlace"=>"member3.jpg","id"=>4),
	array("locName"=>"Best of North India","tourPlace"=>"member4.jpg","id"=>5),
	array("locName"=>"Holy Muktinath Yatra ","tourPlace"=>"day11409636656.jpg","id"=>8),
	array("locName"=>"DESTINANTION ANDAMAN ","tourPlace"=>"day11409636656.jpg","id"=>128)
);

//International
$international = array (
  array("locName"=>"Best Of Srilanka","tourPlace"=>"day11409636656.jpg","id"=>9),
	array("locName"=>"Singapore and Malaysia","tourPlace"=>"day11409636656.jpg","id"=>114),
	array("locName"=>"Dubai & Abu Dhabi","tourPlace"=>"day11409636656.jpg","id"=>120),
	array("locName"=>"Thailand","tourPlace"=>"day11409636656.jpg","id"=>133),
	array("locName"=>"Grand Tour Of Ramayana ","tourPlace"=>"day11409636656.jpg","id"=>132)
);

//Tour Packages
$tourPackages = array (
  array("locName"=>"India Tour Packages","tourPlace"=>"day11409636656.jpg","id"=>24),
	array("locName"=>"Srilanka, Nepal and Bhutan","tourPlace"=>"day11409636656.jpg","id"=>22),
	array("locName"=>"LTC / LFC","tourPlace"=>"day11409636656.jpg","id"=>2),
	array("locName"=>"Corporate Tours","tourPlace"=>"day11409636656.jpg","id"=>4),
	array("locName"=>"Corporate Tours","tourPlace"=>"day11409636656.jpg","id"=>28),
	array("locName"=>"Adventurs Trips","tourPlace"=>"day11409636656.jpg","id"=>29),
	array("locName"=>"Student EducationTours ","tourPlace"=>"day11409636656.jpg","id"=>3),
	array("locName"=>"Tours From Hyderabad","tourPlace"=>"day11409636656.jpg","id"=>20),
	array("locName"=>"Tours from Delhi","tourPlace"=>"day11409636656.jpg","id"=>21)
);

$designFILE = "design/destination_home.php";
include_once("includes/svrtravels-template_home.php");
?>
