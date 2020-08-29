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
<!-- Tour Packages  Start-->
<div class="fixed_depature">
	 	 <div class="row">
       <div class="tour_p_header">
       	<div class="bg" align="center">
       		TOUR PACKAGES
       	</div>
       </div>
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
			 <?php for ($row = 0; $row < count($tourPackages); $row++) {
				 $imgPath = getImagePath($tourPackages, $row, "tourpack");
				?>
		   <tr>
		     <td class="col-lg-1 col-md-1 col-sm-4 ">
           <div class="member-thumb">
           <img src="<?=$imgPath?>" alt="<?=getImageName($tourPackages,$row) ?>" title="<?=strtoupper(getImageName($tourPackages,$row));?>" class="img-responsive-tour" width="100%" height="100%" /></div></td>
				 <td><a href="destination_new.php?sid=<?=$tourPackages[$row]['id'];?>"><?=getImageName($tourPackages,$row) ?></a>
         </td>
				 <td><?=$tourPackages[$row]['days'];?></td>
		     <td><?=$tourPackages[$row]['price'];?></td>
		 		<td><?=$tourPackages[$row]['reqMore'];?></td>
		   </tr>
			 <?php } ?>
		 </table>
	 </div>
</div>
<!-- Tour Packages  End-->
