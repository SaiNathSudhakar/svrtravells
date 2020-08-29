<!-- Banner Start-->
<? $images = $path = '';
if(!empty($_GET['lid']) && $row_loc['tloc_banner_image'] != '') { 
	$images = explode('|', $row_loc['tloc_banner_image']);
	$path = 'uploads/destination_locations/'.$row_loc['tloc_ref_no'].'/';
} gallery_images($images, $path); ?>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
  <div class="bg">
    <a href="index.php">Home</a>
    <span class="divied"></span>
    <a><?=($row_loc['tloc_international'] == 0) ? $row_loc['cat_name'] : 'International';?></a>
    <? if($row_loc['cat_id_fk'] == 2){?>
     <span class="divied"></span>
     <span class="pagename"><a href="destination.php?sid=<?=$row_loc['subcat_id_fk'];?>"><?=$row_loc['subcat_name']?></a></span>
     <? if(!empty($row_loc['subsubcat_name'])){?>
     <span class="divied"></span>
     <span class="pagename"><a href="destination.php?sid=<?=$row_loc['subcat_id_fk']?>&ssid=<?=$row_loc['subsubcat_id_fk'];?>"><?=$row_loc['subsubcat_name']?></a></span>
     <? }?>
    <? }?>
    <span class="divied"></span>
    <span class="pagename"><?=$row_loc['tloc_name'];?></span>
  </div>
</div>
<!-- Navigation end-->

<!-- Mid Content Start-->
<div class="inner_content">
<h1><?=$row_loc['tloc_code'].": ".$row_loc['tloc_name'];?>
<span style="font-size:16px">
    <? if(!empty($row_loc['tloc_transport'])) {
        echo "( ".$row_loc['tloc_transport']." ) ".(($row_loc['tloc_pickup_point'] != '') ? "Ex: ".$row_loc['tloc_pickup_point'] : '');
    }?>
</span></h1>
<h2><?=$night;?> Nights / <?=$day;?> Days</h2>

<div>

<div><!-- class="col-1"--><h2>Places Covered: <span><?=$row_loc['tloc_places_covered'];?></span></h2>
	<? if($deptime != '' && $rettime != '') { ?>
	<h5>Departure : <span><?=$deptime;?></span> Return : <span><?=$rettime;?></span></h5>
	<? } ?> 
</div> 

<div><!-- class="col-2"-->
<? if(($row_loc['cat_id_fk'] == 1 && is_array($fare_mon)) || $row_loc['cat_id_fk'] == 2) { ?>
<h3>Package Cost Per Person in INR (<span class="rupee bold red">&#x20B9;</span>)</h3>
<? } else if(!empty($tour_fares) && !empty($fare_cats) && $row_loc['cat_id_fk'] == 2 ){?>
<h3>Package Cost Per Person in INR (<span class="rupee bold red">&#x20B9;</span>)</h3>
<? tour_fares_table($fare_cats, $farecatnames, $acc, $tour_fares); }?>

<? if($row_loc['cat_id_fk'] == 1 && is_array($fare_mon)) { //print_r($fare_mon);
	fixed_fares_table($fare_cats, $farecatnames, $acc, $fixed_fares, $fare_mon);
   } if($row_loc['cat_id_fk'] == 2) {
	tour_fares_table($fare_cats, $farecatnames, $acc, $tour_fares); 
	if($hloc_ids!='') {?>
	<p>&nbsp;</p><h3>Hotel Details</h3>
	<? hotel_fares_table($hloc_ids, $hloc_names, $hacc, $hotel_names, $hotel_ids);
   } } ?>
</div>

</div>
<div class="clear"></div>
<? 
////////////////// FARE NOTES - BEGIN //////////////////
$notes = explode("|", $row_loc['tloc_notes']);
if(($row_loc['cat_id_fk'] == 1 && is_array($fare_mon)) || $row_loc['cat_id_fk'] == 2) { 
//if((!empty($fixed_fares) || !empty($tour_fares)) && !empty($fare_cats)) { ?>	 
	<div style="width:690px; margin-top:10px;">
       	<div class="mr40"><input name="book" type="button" class="submit-btn" value="Book Now" onclick="validate('<?=$row_loc['cat_id_fk']?>');"/>
        <? if(!empty($row_loc['tloc_pdf'])){?>
        <a style="float:right; color:#FFFFFF" name="pdf" type="button" class="submit-btn"
        href='uploads/destination_locations/<?=$row_loc['tloc_ref_no'].'/'.$row_loc['tloc_pdf']?>' download>Download PDF</a><? }?></div>
		<div class="clear"></div><br /><? if(!empty($notes[0])) {?><h5 class="fl">Note <span>: <?=$notes[0]?></span></h5><? }?>
	</div>
	<div class="clear"></div>
<? } if(!empty($notes[1])) {?><h5>Note <span>: <?=$notes[1];?></span></h5><? }
////////////////// FARE NOTES - END //////////////////
?>

<div>
<? 	$cat = $row_loc['cat_id_fk']; $from = $row_loc['tloc_floc_id']; $to = $row_loc['tloc_id'];
	include("design/search-tracker.php"); //search_tracker($cat, $from, $to, $avail_dates); ?>
</div>
<div class="clear mt30">&nbsp;</div><br />
<? //echo $row_loc['place_small_desc']; exit;
$place_names = ($row_loc['place_name'] != '' ) ? explode('|', $row_loc['place_name']) : '';
$place_thumbs = explode(',', $row_loc['place_thumb']);
$place_ref_no = explode(',', $row_loc['place_ref_no']);
$place_small_desc = explode('|', $row_loc['place_small_desc']);

//while($row_plcs=fetch_array($qur_plcs)){
if($place_names != ''){
foreach($place_names as $key => $place_name){
?>
<div class="box_boder">
	<div class="image">
		<? 
		if(!empty($place_thumbs[$key])) { 
		$thumb = "uploads/places_covered/".$place_ref_no[$key]."/".$place_thumbs[$key];
		} else {
		$thumb = "images/no-image.png";	
		}
		//$place_thumb = (@getimagesize($thumb)) ? $thumb : $default_thumb; ?>
		<img src="<?=$thumb;?>" title="<?=$place_name;?>" alt="<?=$place_name;?>" class="slimg" width="120" height="auto" align="absmiddle" />
	</div>
	<div class="txt">
		<h1><?=$place_name;?></h1>
		<p align="justify"><?=$place_small_desc[$key];?></p>
	</div>
	<div class="clear"></div>
</div>
<? } }
$cst_inc = explode("|", $row_loc['tloc_cost_includes']);
$cst_exc = explode("|", $row_loc['tloc_cost_excludes']);
if(sizeof($cst_inc) > 1 && sizeof($cst_exc) > 1){ ?>
<div style="background:#f9f9f9; padding:10px">
  <? if(sizeof($cst_inc) > 1){?>
  <div class="col-1">
	<div class="cost_links">
	<div class="title">Cost Includes</div>
		<ul>
			<? foreach($cst_inc as $cinc){?><li><?=$cinc;?></li><? } ?>
		</ul>
	</div>
  </div>
  <? } if(sizeof($cst_exc) > 1) { ?>
  <div class="col-2">
	<div class="cost_links">
		<div class="title">Cost Excludes</div>
		<ul>
			<? foreach($cst_exc as $cexc){?><li><?=$cexc;?></li><? } ?>
		</ul>
	</div>
  </div>
  <? }?>
  <div class="clear"></div>
</div>
<? } if($row_loc['cnt_content'] != '') { ?>
<br />
<h3>*<a href="#dealit" rel="facebox"> Terms & Conditions</a></h3>
<div class="clear mt20">&nbsp;</div>
<? } ?>
</div>
<!-- Mid Content End-->

<div id="dealit">
	<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
	<div style="padding:20px;" class="facebox">
		<?=$row_loc['cnt_content'];?>
	</div>
</div>