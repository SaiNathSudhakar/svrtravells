<div>
<div id="headerwrap">
<ul class="menu">
  <li class="top" style="display:"><a href="#x" class="top_link"><span class="down">FLIGHTS</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
        <li><a href="#x">Flights Booking</a></li>
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <li class="top"><a href="#x" class="top_link"><span class="down">Bus</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
        <li><a href="BusBooking.php">Bus Booking</a></li>
        <li><a href="CancelBooking.php">Cancel Booking</a></li>
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  
	<? $qur_fixd = mysql_query("select tloc_id, tloc_name, tloc_international from svr_to_locations where cat_id_fk=1 and tloc_status=1 order by tloc_orderby");
	//$fixed_menu = $internl_menu = array();
	while($rows = mysql_fetch_assoc($qur_fixd)){ $row_fixed[] = $rows; } 
	foreach($row_fixed as $row_fixd){
		if($row_fixd['tloc_international'] == 0) {
			$fixed_menu[] = $row_fixd['tloc_id'].'|'.$row_fixd['tloc_name'];
		} else {
			$internl_menu[] = $row_fixd['tloc_id'].'|'.$row_fixd['tloc_name'];
		} 
	}
	 ?>
  <li class="top"><a href="#x" class="top_link"><span class="down">FIXED Departure</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
   <ul class="sub">
    <? foreach($fixed_menu as $val){ list($key, $value) = explode('|', $val);?>
    <li><a href="<?=$site_url;?>destination-details/lid/<?=$key;?>/<?=ucwords(str_replace(" ","-",$value));?>"><?=ucwords(strtolower($value));?></a>
	<!--<a href="destination-details.php?lid=<?=$key;?>"><?=ucwords(strtolower($value));?></a>--></li>
    <? }?>
  </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <li class="top"> <a href="#x" class="top_link"><span class="down">TOUR PACKAGES</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
  		<? $qur_pack = mysql_query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status=1 order by subcat_orderby");
    	while($row_pack = mysql_fetch_array($qur_pack)){?>
        <li><a href="<?=$site_url;?>destination/sid/<?=$row_pack['subcat_id'];?>/<?=ucwords(str_replace(" ","-",$row_pack['subcat_name']));?>"><?=ucwords($row_pack['subcat_name']);?></a>
		
		<!--<a href="destination.php?sid=<?=$row_pack['subcat_id'];?>"><?=ucwords($row_pack['subcat_name']);?></a>--></li>
  		<? }?> 
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <? if(sizeof($internl_menu) > 0){?>
  <li class="top"> <a href="#x" class="top_link"><span class="down">INTERNATIONAL</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
  		<? foreach($internl_menu as $val){ list($key, $value) = explode('|', $val); ?>
		<li><a href="destination-details.php?lid=<?=$key;?>"><?=ucwords(strtolower($value));?></a></li>
		<? }?> 
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <? }?>
  <li class="top"> <a href="#x" class="top_link"><span class="down">Hotels</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
        <li><a href="#x">Hotel Kalinga</a></li>
        <li><a href="#x">Booking</a></li>
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <li class="top" style="display:none"> <a href="#x" class="top_link"><span class="down">CAR/COACH RENTALS</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
      <ul class="sub">
        <li><a href="#x">Car, Coach Veh Images</a></li>
        <li><a href="#x">Enquiry Form</a></li>
      </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>
  <li class="top"><a href="#x" class="top_link"><span class="down">VISAS</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
  </li>
  <li class="top"><a href="enquiry.php" class="top_link" style="border-right:none"><span class="down">ENQUIRY</span>
        <!--[if gte IE 7]><!-->
    </a>
      <!--<![endif]-->
  </li>
</ul>
<div class="clear"></div></div>
<div class="clear"></div>
</div>