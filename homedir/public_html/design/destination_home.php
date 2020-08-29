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
<div class="fixed_p_header">
	<div class="bg" align="center">
		FIXED DEPATURE
	</div>
</div>
<div class="templatemo-team" id="templatemo-about">
            <div class="container">
                    <ul class="row row_team">
											<?php

										   for ($row = 0; $row < count($fixedDepature); $row++) {
										      $imgPath = getImagePath($fixedDepature, $row, "depature");
										 	?>
                        <li class="col-lg-3 col-md-3 col-sm-6 ">
                            <div class="text-left">
                                <div class="member-thumb">
																		<img src="<?=$imgPath?>" alt="<?=getImageName($fixedDepature,$row) ?>" title="<?=strtoupper(getImageName($fixedDepature,$row));?>" class="img-responsive" />
                                </div>
                                <div class="imageName">
                                    <p><?=strtoupper(getImageName($fixedDepature,$row));?></p>
                                </div>
                            </div>
                        </li>
											<?php }

											?>
                    </ul>
            </div>
        </div><!-- /.templatemo-team -->

<!-- Fixed Depature  End-->
<!-- International  Start-->
<div class="international_p_header">
	<div class="bg" align="center">
		INTERNATIONAL
	</div>
</div>
<div class="templatemo-team" id="templatemo-about">
            <div class="container">
                    <ul class="row row_team">
											<?php

										   for ($row = 0; $row < count($international); $row++) {
										     $imgPath = getImagePath($international, $row, "International");
										 	?>
                        <li class="col-lg-3 col-md-3 col-sm-6 ">
                            <div class="text-left">
                                <div class="member-thumb">
																		<img src="<?=$imgPath?>" alt="<?=getImageName($international,$row) ?>" title="<?=strtoupper(getImageName($international,$row));?>" class="img-responsive" />
                                </div>
                                <div class="imageName">
                                    <p><?=strtoupper(getImageName($international,$row));?></p>
                                </div>
                            </div>
                        </li>
											<?php }

											?>
                    </ul>
            </div>
        </div><!-- /.templatemo-team -->

<!-- International  End-->
<!-- Tour Packages   Start-->
<div class="tour_p_header">
	<div class="bg" align="center">
		TOUR PACKAGES
	</div>
</div>
<div class="templatemo-team" id="templatemo-about">
            <div class="container">
                    <ul class="row row_team">
											<?php

										   for ($row = 0; $row < count($tourPackages); $row++) {
										      $imgPath = getImagePath($tourPackages, $row, "tourpack");
										 	?>
                        <li class="col-lg-3 col-md-3 col-sm-6 ">
                            <div class="text-left">
                                <div class="member-thumb">
																		<img src="<?=$imgPath?>" alt="<?=getImageName($tourPackages,$row) ?>" title="<?=strtoupper(getImageName($tourPackages,$row));?>" class="img-responsive" />
                                </div>
                                <div class="imageName">
                                    <p><?=strtoupper(getImageName($tourPackages,$row));?></p>
                                </div>
                            </div>
                        </li>
											<?php }

											?>
                    </ul>
            </div>
        </div><!-- /.templatemo-team -->

<!-- Tour Packages End-->
