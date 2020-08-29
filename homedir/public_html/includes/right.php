<?
$url = basename($_SERVER['REQUEST_URI']);
$u = explode("?", $url);
?>
<style>
.backgroundRed{
	background: #F00;
}
#divtoBlink{
	-webkit-transition: background 1.0s ease-in-out;
	-ms-transition:     background 1.0s ease-in-out;
	transition:         background 1.0s ease-in-out;
}
/*.quadrat {*/
 /* -webkit-animation: NAME-YOUR-ANIMATION 1s infinite; Safari 4+ */
 /* -moz-animation:    NAME-YOUR-ANIMATION 1s infinite;  Fx 5+ */
 /* -o-animation:      NAME-YOUR-ANIMATION 1s infinite;  Opera 12+ */
 /* animation:         NAME-YOUR-ANIMATION 1s infinite;  IE 10+, Fx 29+ */
/*}*/

/*@-webkit-keyframes NAME-YOUR-ANIMATION {
0%, 49% {
    background-color: #ffb300;
    border: 3px solid #ff1e00;
}
50%, 100% {
    background-color: #ff1e00;
    border: 3px solid #ffb300;
}*/
.quadrat {
    background-color: #ffb300;
    border: 3px solid #ff1e00;
}
</style>

<div class="fr panel_right">
<? 	$cond = '1';
	if($u[0]=="destination.php" || $u[0]=="destination-details.php")
	{

		if(!empty($_GET['ssid'])){ $cond .= " and subsubcat_id_fk = ".$_GET['ssid']; }
		if(!empty($_GET['sid'])){ $cond .= " and subcat_id_fk = ".$_GET['sid']; }
		if(!empty($_GET['lid'])){
			$cat = getdata("svr_to_locations", "cat_id_fk, subcat_id_fk, subsubcat_id_fk", "tloc_id=".$_GET['lid'], 1);
			$cond .= " and cat_id_fk = ".$cat[0]." and subcat_id_fk = ".$cat[1]." and subsubcat_id_fk = ".$cat[2]." and tloc_id != ".$_GET['lid'];
		}
	}
	$qur = query("select tloc_id, tloc_ref_no, tloc_image, tloc_name, tloc_code, tloc_type, tloc_costpp,tloc_banner_image from svr_to_locations where ".$cond." and tloc_status = 1 and tloc_featured = 1 order by rand() limit 0, 5");			
	$count = num_rows($qur);
	$i = 1;
if($count > 0){
	while($row = fetch_array($qur)){
	if($i%5 == 0) $i = 1; 
	switch($i){	
		case '1': $color = 'yellow'; break;
		case '2': $color = 'green'; break;
		case '3': $color = 'red'; break;
		case '4': $color = 'blue'; break;
	}
?>
<!--id="divtoBlink"-->

<div class="right_<?=$color;?> quadrat" style="position:relative;"  >
   <a href="destination-details.php?lid=<?=$row['tloc_id']?>" title="<?=$row['tloc_name'];?>">
      <? if($row['tloc_costpp'] != '' ) {?><div class="right_<?=$color;?>_price" style="z-index:99;"><?=$row['tloc_costpp']?>/- only*</div><? }?>
	  <? 
	  	$images=explode("|",$row['tloc_banner_image']); 
		$ipath = 'uploads/destination_locations/'.$row['tloc_ref_no'].'/';		
	  ?>
     <ul class="bxslider">
		<? 
		if($images[0]!="") { 
		for ($x = 0; $x < count($images); $x++) {
         $ipath= $site_url.'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$images[$x];
        ?>
            <li><img src="<?=$ipath?>" alt="<?=$row['tloc_name'];?>" width="148" height="159" class="slimg" /></li>
        <? }} else { $ipath=$site_url.'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$row['tloc_image']; ?>
	        <li><img src="<?=$ipath?>" alt="<?=$row['tloc_name'];?>" width="148" height="159" class="slimg" /></li>
        <? } ?>
	 </ul>
<!--
<li><img src="<?=$ipath?>" alt="<?=$row['tloc_name'];?>" width="148" height="159" class="slimg" /></li>
<img src="<?=$ipath?>" alt="<?=$row['tloc_name'];?>" width="148" height="159" class="slimg" />
-->
      <div class="right_<?=$color;?>_text" style="display:block; margin-top:-20px; padding:5px 0px">
        <h1><?=$row['tloc_name'];//substr(, 0, 15);?></h1>
        <h2><? list($nights, $days) = explode('|', $row['tloc_type']); 
		echo (!empty($nights) ? $nights.' Nights' : '').' / '.(!empty($days) ? $days.' Days' : ''); ?></h2>
      </div>
   </a>      
  <div class="right_yellow_text_book-btn" >
    <a href="destination-details.php?lid=<?=$row['tloc_id']?>" ><input name="book" type="button" class="book-btn" value="Book Now"/></a>
  </div>
  
</div>
<? $i++; }
}
?>
</div>

<script>
var $div2blink = $("#divtoBlink"); // Save reference, only look this item up once, then save
var backgroundInterval = setInterval(function(){
    $div2blink.toggleClass("backgroundRed");
 },1500)
</script>