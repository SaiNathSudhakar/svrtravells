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

<!-- Fixed Depature  Start-->
<div class="fixed_depature">
	 	 <div class="row">
 		 <div class="fixed_p_header" align="center">FIXED DEPATURE</div>
 	 </div>
	 <div class="row">
		 <?Php include("design/search-tracker_fixed_departure.php"); ?>
	 </div>
	 <div class="row">
		 <table id="tourplace">
		   <tr>
		     <th>TOUR PLACE</th>
		     <th>LOCATION NAME</th>
		     <th>DAYS</th>
		 		<th>PRICE</th>
		 		<th>REQUEST FOR MORE</th>
		   </tr>
			 <?php for ($row = 0; $row < count($fixedDepature); $row++) {
				 $imgPath = getImagePath($fixedDepature, $row, "depature");
				?>
		   <tr>
		     <td class="col-lg-1 col-md-1 col-sm-4 ">
           <div class="member-thumb">
           <img src="<?=$imgPath?>" alt="<?=getImageName($fixedDepature,$row) ?>" title="<?=strtoupper(getImageName($fixedDepature,$row));?>" class="img-responsive-tour" width="100%" height="100%" /></div></td>
				 <td><a href="destination-details-new.php?lid=<?=$fixedDepature[$row]['id'];?>"><?=getImageName($fixedDepature,$row) ?>
         </a></td>
				 <td><?=$fixedDepature[$row]['days'];?></td>
		     <td><?=$fixedDepature[$row]['price'];?></td>
		 		<td><?=$fixedDepature[$row]['reqMore'];?></td>
		   </tr>
			 <?php } ?>
		 </table>
	 </div>
</div>
<!-- Fixed Depature  End-->
