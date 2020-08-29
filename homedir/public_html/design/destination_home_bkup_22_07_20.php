<!-- Banner Start-->
<? $images = $path = '';
if(!empty($_GET['sid']) && $nav['subcat_banner_image'] != '') {
	$images = explode('|', $nav['subcat_banner_image']);
	$path = 'uploads/tour_packages/'.$nav['subcat_ref_no'].'/';
} galleryImagesHome($images, $path); ?>
<!-- Banner End-->

<div style="width:100%">
<!-- Lastest News Scrolling Start-->
<div class="lastesnewsscroll">
	<div class="bg" align="center">
		LATEST NEWS SCROLLING
	</div>
</div>
<!-- Lastest News Scrolling End-->

<!-- Fixed Depature  Start-->
<div class="fixed_depature">
 	 <div class="row">
 		 <div class="fixed_p_header" align="center">FIXED DEPATURE</div>
 	 </div>
 	 <div class="row">
 <?php

  for ($row = 0; $row < count($fixedDepature); $row++) {
     $imgPath = getImagePath($fixedDepature, $row, "depature");
	?>
 <div class="column">
	 <div class="thumbnail">
			 <a class="image-link" href="destination-details.php?lid=<?=$fixedDepature[$row]['id'] ?>" target="_blank">
				 <img src="<?=$imgPath?>" alt="<?=getImageName($fixedDepature,$row) ?>" title="<?=strtoupper(getImageName($fixedDepature,$row));?>" class="slimg" width="100%" height="100%" />
				 <div class="imageName">
					 <p><?=strtoupper(getImageName($fixedDepature,$row));?></p>
				 </div>
			 </a>
		 </div>
 </div>
<?php }

?>
 	 </div>
</div>
<!-- Fixed Depature  End-->
<!-- International  Start-->
<div class="international">
 	 <div class="row">
 		 <div class="international_p_header" align="center">INTERNATIONAL</div>
 	 </div>
 	 <div class="row">
     <?php
      for ($row = 0; $row < count($international); $row++) {
        $imgPath = getImagePath($international, $row, "International");
    ?>
     <div class="column">
    	 <div class="thumbnail">
    			 <a class="image-link" href="destination-details.php?lid=<?=$international[$row]['id'] ?>" target="_blank">
    				 <img src="<?=$imgPath?>" alt="<?=getImageName($international,$row) ?>" title="<?=strtoupper(getImageName($international,$row));?>" class="slimg" width="100%" height="100%" />
    				 <div class="imageName">
    					 <p><?=strtoupper(getImageName($international,$row));?></p>
    				 </div>
    			 </a>
    		 </div>
     </div>
    <?php }
    ?>
 	 </div>
</div>
<!-- International  End-->

<!-- Tour Packages  Start-->
<div class="tour_packagess">
 	 <div class="row">
 		 <div class="tour_p_header" align="center">TOUR PACKAGES</div>
 	 </div>
 	 <div class="row">
     <?php
      for ($row = 0; $row < count($tourPackages); $row++) {
    	   $imgPath = getImagePath($tourPackages, $row, "tourpack");
    	?>
     <div class="column">
    	 <div class="thumbnail">
    			 <a class="image-link" href="destination-details.php?lid=<?=$tourPackages[$row]['id'] ?>" target="_blank">
    				 <img src="<?=$imgPath?>" alt="<?=getImageName($tourPackages,$row) ?>" title="<?=strtoupper(getImageName($tourPackages,$row));?>" class="slimg" width="100%" height="100%" />
    				 <div class="imageName">
    					 <p><?=strtoupper(getImageName($tourPackages,$row));?></p>
    				 </div>
    			 </a>
    		 </div>
     </div>
    <?php }

    ?>
 	 </div>
</div>
</div>
<!-- Tour Packages  End-->
