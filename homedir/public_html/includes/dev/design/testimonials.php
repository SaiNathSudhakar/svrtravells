<!-- Banner Start-->
<div class="banner_inner">
<img src="images/testimonial-banner.jpg" alt="Testimonials" /></div>
<!-- Banner End-->

<!-- Navigation Start-->
<div class="navigation">
	<div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename">Testimonials</span></div>
</div>
<!-- Navigation End-->

<!-- Mid Content Start-->
<div class="inner_content">

<h1>Customer Testimonials</h1>
<? while($row=mysql_fetch_array($qur)){ ?>
	<div class="testimonial">
		<? if(!empty($row['test_image'])){ ?>
			<div class="imgage">
				<img src="<?=substr($row['test_image'], 3);?>"width="100" height="80" border="0" />
			</div>
		<? }?>
		<div class="text">
			<p><?=$row['test_testimonial'];?></p>
			<h1><?=$row['test_name'];?>,<br /><span><?=$row['test_place'];?></span></h1>
		</div>
		<div class="clear"></div>
	</div>
<? }?>             
</div>
<!-- Mid Content End-->