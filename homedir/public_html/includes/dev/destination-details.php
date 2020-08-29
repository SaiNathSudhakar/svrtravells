<?
ob_start();
include_once("includes/functions.php");
if(!isset($_GET['lid'])) header("location:index.php");
$query = mysql_query('SET group_concat_max_len=15000');

//Query to get location details
$qur_loc = mysql_query("select loc.cat_id_fk, tloc_type, tloc_international, tloc_id, tloc_code, tloc_floc_id, tloc_transport, tloc_pickup_point, cat_name, tloc_status, tloc_time, tloc_ref_no, tloc_banner_image, loc.subcat_id_fk, subcat_name, loc.subsubcat_id_fk, subsubcat_name, tloc_id, tloc_name, tloc_places_covered, tloc_notes, tloc_cost_includes, tloc_cost_excludes, tloc_acc_type, cnt_content, GROUP_CONCAT(pc.place_name SEPARATOR '|') AS place_name, GROUP_CONCAT(pc.place_thumb) AS place_thumb, GROUP_CONCAT(pc.place_ref_no) AS place_ref_no, GROUP_CONCAT(pc.place_small_desc SEPARATOR '|') AS place_small_desc from svr_to_locations as loc
left join svr_categories as cat on loc.cat_id_fk = cat.cat_id left join svr_content_pages on cnt_id = 2
	left join svr_subcategories as subcat on loc.subcat_id_fk = subcat.subcat_id 
		left join svr_subsubcategories as subsubcat on loc.subsubcat_id_fk = subsubcat.subsubcat_id 
			left outer join svr_places_covered as pc on pc.tloc_id_fk = loc.tloc_id and pc.place_status = 1
				where tloc_id=".$_GET['lid']." group by pc.tloc_id_fk");
$row_loc = mysql_fetch_array($qur_loc);

list($deptime, $rettime) = (!empty($row_loc['tloc_time'])) ? explode('|', $row_loc['tloc_time']) : array_fill(0, 2, '');
list($night, $day) = (!empty($row_loc['tloc_type'])) ? explode('|', $row_loc['tloc_type']) : array_fill(0, 2, '');

if($row_loc['cat_id_fk'] == 1)
	list($fare_cats, $farecatnames, $acc, $fixed_fares, $fare_mon) = fares_table($row_loc['cat_id_fk']);
if($row_loc['cat_id_fk'] == 2)
	list($fare_cats, $farecatnames, $acc, $tour_fares) = fares_table($row_loc['cat_id_fk']);

$designFILE = "design/destination-details.php";
include_once("includes/svrtravels-template.php");
?>