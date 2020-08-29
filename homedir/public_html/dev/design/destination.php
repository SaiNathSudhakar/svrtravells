<!-- Banner Start-->
<? $images = $path = '';
if(!empty($_GET['sid']) && $nav['subcat_banner_image'] != '') { 
	$images = explode('|', $nav['subcat_banner_image']);
	$path = 'uploads/tour_packages/'.$nav['subcat_ref_no'].'/';
} gallery_images($images, $path); ?>
<!-- Banner End-->

<div class="navigation">
	<div class="bg">
		<a href="index.php">Home</a><span class="divied"></span>
		<a><?=$nav['cat_name'];?></a><span class="divied"></span>
        <? if(!empty($_GET['sid']) && !empty($_GET['ssid'])) {?>
        <a href="destination.php?sid=<?=$_GET['sid'];?>"><?=$nav['subcat_name']?></a><span class="divied"></span>
        <span class="pagename"><?=$nav['subsubcat_name']?></span>
		<? } else { ?>
        <span class="pagename"><?=$nav['subcat_name']?></span>
        <? }?>
	</div>
</div>

<!-- Content -->
<div class="inner_content"> 
<h1><?=(!empty($_GET['ssid'])) ? $nav['subsubcat_name'] : $nav['subcat_name'];?></h1>

<? if($_GET['sid'] == 2 || $_GET['sid'] == 4 || $_GET['sid'] == 28 || $_GET['sid'] == 3 )
{	
	include("design/enquiry-form.php");
	
} else if(($_GET['sid'] == 24 || $_GET['sid'] == 25) && empty($_GET['ssid'])) { ?>
<div>
<? $ssq = query("select subsubcat_id, cat_id_fk, subcat_id_fk, subsubcat_name, subsubcat_ref_no, subsubcat_thumb_image from svr_subsubcategories as ssc where subsubcat_status = 1 and subcat_id_fk = ".$_GET['sid']);
	$sscount = getdata("svr_to_locations", "count(distinct(subsubcat_id_fk))", "subsubcat_id_fk <> 0 and subcat_id_fk = '".$_GET['sid']."' and tloc_status = 1"); 
	if($sscount > 0){ ?>
	
	<div class="col-1">
	<?  $i = 0; while($ssrow = fetch_array($ssq)){  
		$loc_q = query("select tloc_id, tloc_name from svr_to_locations where tloc_status = 1 and cat_id_fk = '".$ssrow['cat_id_fk']."' and subcat_id_fk = '".$ssrow['subcat_id_fk']."' and subsubcat_id_fk = '".$ssrow['subsubcat_id']."' limit 0, 3");
		$loc_count = num_rows($loc_q);
		$ipath = ($ssrow['subsubcat_thumb_image'] != '') ? 'uploads/tour_packages/'.$ssrow['subsubcat_ref_no'].'/'.$ssrow['subsubcat_thumb_image'] : $default_thumb;
		//$ipath = 'uploads/tour_packages/'.$ssrow['subsubcat_ref_no'].'/'.$ssrow['subsubcat_thumb_image'];
		//$ipath = (@getimagesize($ipath)) ? $ipath : $default_thumb;
		if($loc_count > 0){ $i++; ?>
		<div class="group">
			<div class="fl"><img src="<?=$ipath?>" alt="<?=$ssrow['subsubcat_name']?>" class="slimg" width="100" height="100" /></div>
			<div class="fl text">
				<h2><?=$ssrow['subsubcat_name']?></h2>
				<ul>
					<? $j = 0; while($row_loc = fetch_array($loc_q )) { $j++;?>
					<li>
						<a href="destination-details.php?lid=<?=$row_loc['tloc_id']?>">
							<? $loc = ucwords(strtolower($row_loc['tloc_name'])); 
							echo (strlen($loc) > 25) ? substr($loc, 0, 25).'...' : $loc; ?>
						</a>
					</li>
					<? }?>
				</ul>
				<? if($loc_count >= 3){?><a href="destination.php?sid=<?=$_GET['sid'];?>&ssid=<?=$ssrow['subsubcat_id']?>">more...</a><? }?>
			</div>
			<div class="clear"></div>
		</div>
		<? } ?>
		<? if(ceil($sscount/2) <= $i){?></div><div class="col-2"><? }?>
	<? } ?> 
	</div>
	
	<? } else {?> No Records Found	<? }?>
	<div class="clear"></div>
	</div>
<? } else { ?>
	<? 
	$cond = (!empty($_GET['ssid'])) ? ' and subsubcat_id_fk = '.$_GET['ssid'] : '';
	$qur = query("select tloc_id, tloc_ref_no, tloc_image, tloc_name, tloc_code, tloc_type, tloc_places_covered, tloc_banner_image from svr_to_locations where tloc_status = 1 and subcat_id_fk = ".$_GET['sid']." $cond");			
	$count = num_rows($qur);?>
	<? if($count > 0){?>
	<div class="col-1"><div class="tour_links">
		<ul>
		<? $i = 0; while($row=fetch_array($qur)){ $i++;
		$path = ($row['tloc_image'] != '') ? 'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$row['tloc_image'] : $default_thumb;
		//$path = 'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$row['tloc_image'];
		//$path = (@getimagesize($path)) ? $path : $default_thumb;?>
		<li>
		  <a href="destination-details.php?lid=<?=$row['tloc_id'];?>">
			  <img src="<?=$path?>" alt="<?=$row['tloc_name'];?>" width="60" height="50" class="slimg" align="absmiddle" />
			  <div class="desc"><h3><?=$row['tloc_name'];?></h3>
			  <h4><? if(strlen($row['tloc_places_covered'])>=15){ echo substr(strip_tags($row['tloc_places_covered']),0,50)."...";}
					else{ echo strip_tags($row['tloc_places_covered']);} ?></h4>
			  <p>more details...</p>
			  </div>
		  </a>
		</li>
		<? if(ceil($count/2)==$i){?></ul></div></div><div class="col-2"><div class="tour_links"><ul><? }?>
		<? }?>
		</ul>
	</div></div>
	<div class="clear"></div>
	<? } else {?>
	<center>No Records Found</center>
	<? }?>

<? } ?>

<div class="clear" style="line-height:20px">&nbsp;</div>
</div>