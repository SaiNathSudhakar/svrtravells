<? ob_start();
include_once("includes/functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<title>SVR - Tours and Travel | Holiday Packages | Online Bus Booking Hyderabad</title>
<meta name="description" content="We are one stop solutions for all travel needs starting from Tour Planning, Ticket Booking, accommodation and Transportation" />
<meta name="keywords" content="travel agency in india, holiday packages in india, domestic holiday packages, international tour packages, car rental services in Hyderabad" />
<!--<meta name="Website Design, Development, Maintenance and Powered by BitraNet Pvt. Ltd.," content="http://www.bitranet.com" />-->
<head>

<? include('includes/header.php');?>
<? include("includes/menu.php");?>
<?  $result=mysql_query("select up_title from svr_latest_updates where up_status=1"); 
	$count = mysql_num_rows($result); 
if($count > 0){?>
<div class="news_box">
	<h1>Latest Updates :</h1>
	<div class="news_scroll">
	<ul id="fade" style="list-style:none; font-size:15px; color:#4d4f88; line-height:30px">
	<? while($update=mysql_fetch_array($result)){?>
	<li><?=$update['up_title'];?></li>
	<? }?>
	</ul>
	</div>
</div>
<? }?>
<div class="clear"></div>
<div class="mid_section">
	<div class="fl panel_left">
		<? include("design/search-tracker.php"); ?>
	</div>
	<div class="fl panel_middle">	
	<? $slqry=mysql_query("select gal_title, gal_url,gal_upload from svr_gallery where gal_status=1 order by gal_id desc ");		
	$gcount=mysql_num_rows($slqry);?>	
	<div id="loopedSlider">
		<ul class="pagination">
		<? for($i=1;$i<=$gcount;$i++){?>
		<li  class="<?=($i==1)?'active':'';?>"><a rel="<?=$i?>" href="#"></a></li>
		<? }?>
		</ul>
		<div class="container">
			<div class="slides">
			<?  
			while($fetch_slides=mysql_fetch_array($slqry)){?>
				<div style="display:block;">
				<a href="<?=$fetch_slides['gal_url'];?>"><img src="<?=$site_url."uploads/gallery/".$fetch_slides['gal_upload']?>" alt="SCCL" width="520" height="283" /></a></div><? }?>
			</div>
		</div> 
		<div class="clear"></div>
	</div>
	<div class="box_mid">
		<div class="tour_packages">
			<h1>Tour Packages</h1>
			<h2>Explore City based vacation packages</h2>
            
			<? $location = array();
			$loc1 = mysql_query("select subcat_id, tloc_id, tloc_name from svr_subcategories as subcat
				left join svr_categories as cat on cat.cat_id = subcat.cat_id_fk
					left join svr_to_locations as tloc on subcat.subcat_id = tloc.subcat_id_fk
						where tloc_status = 1 and (subcat_id = 20 or subcat_id = 21)"); $i = 0;
			while($row1 = mysql_fetch_array($loc1)){
				$location[$row1['subcat_id']][$i] = $row1['tloc_id'].'|'.$row1['tloc_name']; $i++;
			} ?>
            
			<? $tour_q = mysql_query("select subcat_id, cat_id_fk, subcat_name from svr_subcategories where subcat_id = 20 or subcat_id = 21"); $j = 0;
			while($row_tour = mysql_fetch_array($tour_q)){
				$locatio = array_slice($location[$row_tour['subcat_id']], 0, 4);
				$loc_count = count($locatio);?>
			<div class="<?=($row_tour['subcat_id'] == 20) ? 'fl' : 'fr';?>">
			<h3><?=$row_tour['subcat_name']?> <span>(By Volvo)</span></h3>
			<div class="tour_packages_245 fl"><div class="tour_packages_img">
			<? $place = ($row_tour['subcat_id'] == 20) ? 'hyderabad' : 'delhi';?>
			<img src="images/tours-from-<?=$place;?>.jpg" alt="<?=$row_tour['subcat_name'];?>" width="70" height="63" /></div>
				<div class="fl">
					<ul>
						<? foreach($locatio as $key => $val){ list($tloc_id, $tloc_name) = explode('|', $val); ?>
						<li>
							<a href="destination-details.php?lid=<?=$tloc_id?>">
								<? $loc = ucwords(strtolower($tloc_name)); 
								echo (strlen($loc) > 25) ? substr($loc, 0, 25).'...' : $loc; ?>
							</a>
						</li>
						<? }?>
					</ul>
					<a href="destination.php?sid=<?=$row_tour['subcat_id'];?>"><? if($loc_count > 0) { ?>more...<? }?></a></div>
				</div>
			</div>
			<? }?>            
			<div class="clear"></div>
		</div>
		<div class="clear" style="line-height:5px;">&nbsp;</div>
	</div>
	<div class="box_mid">
		<div class="tour_packages">
			<h1><span>Fixed Departures</span></h1>
			<div style="line-height:8px">&nbsp;</div>
			<div class="fl">
			<div class="tour_packages_img_big"><img src="images/fixed-departures.jpg" alt="Fixed Departures" width="129" height="80" /></div>
			<div class="fl mr30">
			<?  arsort($row_fixed); $row_fixed = array_slice($row_fixed, 0, 8);
				$m=1; foreach($row_fixed as $row_fixd){//while($row_fixd = mysql_fetch_array($qur_fixd)){
				if($m % 5 == 0) { echo "</ul></div><div class='fr'><ul>";}?>
				<ul>
					<li><a href="destination-details.php?lid=<?=$row_fixd['tloc_id'];?>"><?=ucwords(strtolower($row_fixd['tloc_name']));?></a></li>
				</ul><? $m++; } ?>
			  </div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear" style="line-height:5px;">&nbsp;</div>
	</div>
    
    <? $location = array();
	$loc1 = mysql_query("select cat_id, subcat_id, tloc_id, tloc_name, tloc_code from svr_subcategories as subcat
		left join svr_categories as cat on cat.cat_id = subcat.cat_id_fk
			left join svr_to_locations as tloc on subcat.subcat_id = tloc.subcat_id_fk
				where tloc_status = 1 and cat_id = 2 and subcat_status = 1 and subcat_id in (1, 2, 3, 4)"); $i = 0;
	while($row1 = mysql_fetch_array($loc1)){
		$location[$row1['subcat_id']][$i] = $row1['tloc_id'].'|'.$row1['tloc_name'].'|'.$row1['tloc_code']; $i++;
	} ?>
            
    <? $pak_q = mysql_query("select subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1 and subcat_id in (1, 2, 3, 4) order by subcat_id");
	 $i=1; while($row_pak = mysql_fetch_array($pak_q)){
	 $locatio = array_slice($location[$row_pak['subcat_id']], 0, 3);
	 $total = count($locatio);
	 if($total >0 ){
	?>
	<div class="family_tour <?=($i%2==0) ? 'fr' : 'fl';?>">
	<h1><?=$row_pak['subcat_name'];?></h1>
	<? 	switch($row_pak['subcat_id'])
		{	
			case 1: $img = 'family-tours.jpg'; $alt = 'Family Tours'; break;
			case 2: $img = 'ltc-lfc.jpg'; $alt = 'LTC LFC'; break;
			case 3: $img = 'student-tours.jpg'; $alt = 'Student Tours'; break;
			case 4: $img = 'corporate-tours.jpg'; $alt = 'Corporate Tours'; break;
			default: $img = 'family-tours.jpg'; $alt = 'Family Tours';
		} 
	?>
	<div><img src="images/<?=$img;?>" alt="Family Tours" width="217" height="75" />
	<div class="clear"></div></div>
	<? foreach($locatio as $key => $val){ list($tloc_id, $tloc_name, $tloc_code) = explode('|', $val);?>
	<ul>
		<li>
			<a href="destination-details.php?lid=<?=$tloc_id?>">
				<?=$tloc_name.(($tloc_code != '') ? ' ('.$tloc_code.')' : '');?>
			</a>
		</li>
	</ul>
	<? } ?>
	<a href="destination.php?sid=<?=$row_pak['subcat_id'];?>" class="fr">more...</a>
	</div>
	<? $i++;}}?>   
			</div>
	  <div class="fl panel_right">
			<? include('includes/right.php'); ?>
	  </div>
	</div>

<? include('includes/footer.php'); ?>
</body>
</html>