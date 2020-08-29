<style>

/* Style tab links */
.tablink {
  background-color: #4d4f88;
  color: #fff;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 7px 8px;
  font-size: 17px;
  width: 20%;
}

.tablink:hover {
  background-color: #8e90ce;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: #65656;
  display: none;
  padding: 10px 10px;
  height: 100%;
}

#PlacesCovered {background-color: white;}
#CostIncludes {background-color: white;}
#CostExcludes {background-color: white;}
#About {background-color: white;}

.button-active {
	color: #4d4f88!important;
	background-color: transparent!important;
	border: 1px solid black!important;
	border-bottom: solid 1px #fff!important;
}

</style>

<div style="width:100%">
  <!-- Banner Start-->
  <? $images = $path = '';
  if(!empty($_GET['sid']) && $nav['subcat_banner_image'] != '') {
    $images = explode('|', $nav['subcat_banner_image']);
    $path = 'uploads/tour_packages/'.$nav['subcat_ref_no'].'/';
  } galleryImagesHome($images, $path); ?>
  <!-- Banner End-->
  <div class="row">
    <!-- Lastest News Scrolling Start-->
    <div class="lastesnewsscroll">
      <div class="bg" align="center">
        LATEST NEWS SCROLLING
      </div>
    </div>
    <!-- Lastest News Scrolling End-->
  </div>
  <div class="row">
      <div align="left" style="padding: 14px 16px;">
        <h4><span style="color:#e40011;"><?=$row_loc['tloc_code'].": ".$row_loc['tloc_name'];?></span>
          <span style="font-size:16px">
              <? if(!empty($row_loc['tloc_transport'])) {
                  echo "( ".$row_loc['tloc_transport']." ) ".(($row_loc['tloc_pickup_point'] != '') ? "Ex: ".$row_loc['tloc_pickup_point'] : '');
              }?>
          </span></h4>
          <h4><span style="color:#e40011;"><?=$night;?> Nights / <?=$day;?> Days</span></h4>
      </div>
	</div>
  <div class="row">
    <!-- Tabs Start-->
    <button class="tablink" onclick="openPage('placesCovered', this, 'white')" id="defaultOpen">Places Covered</button>
    <button class="tablink" onclick="openPage('tourGallery', this, 'white')" >Tour Gallery</button>
    <button class="tablink" onclick="openPage('costIncludes', this, 'white')" >Cost Includes</button>
    <button class="tablink" onclick="openPage('costExcludes', this, 'white')">Cost Excludes</button>
    <button class="tablink" onclick="openPage('termsConditions', this, 'white')">Terms & Conditions</button>
    <!-- Tabs  End-->
  </div>
  <div class="row">
    <div id="placesCovered" class="tabcontent">
      <div>
      <div><h4><span style="color:#e40011;">Places Covered:</span> <span><?=$row_loc['tloc_places_covered'];?></span></h4>
      	<? if($deptime != '' && $rettime != '') { ?>
      	<h4> <span style="color:#e40011;">Departure :</span> <span><?=$deptime;?></span> Return : <span><?=$rettime;?></span></h4>
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
      	include("design/search-tracker_fixed_departure.php"); //search_tracker($cat, $from, $to, $avail_dates); ?>
      </div>
      </div>
    <div id="tourGallery" class="tabcontent">
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
        	<div class="image_new">
        		<?
        		if(!empty($place_thumbs[$key])) {
        		$thumb = "uploads/places_covered/".$place_ref_no[$key]."/".$place_thumbs[$key];
        		} else {
        		$thumb = "images/no-image.png";
        		}
        		//$place_thumb = (@getimagesize($thumb)) ? $thumb : $default_thumb; ?>
        		<img src="<?=$thumb;?>" title="<?=$place_name;?>" alt="<?=$place_name;?>" class="slimg" width="120" height="auto" align="absmiddle" />
        	</div>
        	<div class="txt_new">
        		<h1><?=$place_name;?></h1>
        		<p align="justify"><?=$place_small_desc[$key];?></p>
        	</div>
        	<div class="clear"></div>
        </div>
      <? } }?>
    </div>

    <div id="costIncludes" class="tabcontent">
      <?php
				$cst_inc = explode("|", $row_loc['tloc_cost_includes']);
				if(sizeof($cst_inc) > 1) {
			?>
			<div class="cost_links">
			<!-- <div class="title">Cost Includes</div> -->
				<ul>
					<? foreach($cst_inc as $cinc){?><li><?=$cinc;?></li><? } ?>
				</ul>
			</div>
		  </div>

		<?php } ?>
    </div>

    <div id="costExcludes" class="tabcontent">
      <?php
				$cst_exc = explode("|", $row_loc['tloc_cost_excludes']);

				if(sizeof($cst_exc) > 1) {
			?>
			<div class="cost_links">
				<!-- <div class="title">Cost Excludes</div> -->
				<ul>
					<? foreach($cst_exc as $cexc){?><li><?=$cexc;?></li><? } ?>
				</ul>
			</div>
		  </div>

		<?php } ?>
    </div>

    <div id="termsConditions" class="tabcontent">
      	<div class="facebox">
      		<?=$row_loc['cnt_content'];?>
      	</div>
    </div>
  </div>
</div>
  <script>
  function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
      tablinks[i].className = tablinks[i].className.replace(" button-active", "");
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
    console.log(elmnt.className);
    elmnt.className += " button-active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
  </script>
