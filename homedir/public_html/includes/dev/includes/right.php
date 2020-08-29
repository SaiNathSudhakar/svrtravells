<?  
$url = basename($_SERVER['REQUEST_URI']);
$u = explode("?", $url);
?>
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
	$qur = mysql_query("select tloc_id, tloc_ref_no, tloc_image, tloc_name, tloc_code, tloc_type, tloc_costpp from svr_to_locations where ".$cond." and tloc_status = 1 and tloc_featured = 1 order by rand() limit 0, 5");			
	$count = mysql_num_rows($qur);
	$i = 1;
if($count > 0)
{
while($row = mysql_fetch_array($qur)){
	if($i%5 == 0) $i = 1; 
	switch($i)
	{	
		case '1': $color = 'yellow'; break;
		case '2': $color = 'green'; break;
		case '3': $color = 'red'; break;
		case '4': $color = 'blue'; break;
		//default: $color = 'yellow'; break;
	}
?>
<div class="right_<?=$color;?>" style="position:relative;">
   <a href="destination-details.php?lid=<?=$row['tloc_id']?>" title="<?=$row['tloc_name'];?>">
      <? if($row['tloc_costpp'] != '' ) {?><div class="right_<?=$color;?>_price"><?=$row['tloc_costpp']?>/- only*</div><? }?>
	  <? 
	  $ipath = ($row['tloc_image'] != '') ? $site_url.'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$row['tloc_image'] : $default_thumb;
	  //$ipath = $site_url.'uploads/destination_locations/'.$row['tloc_ref_no'].'/'.$row['tloc_image'];
	  //$ipath = (@getimagesize($ipath)) ? $ipath : $default_thumb;?>
      <img src="<?=$ipath?>" alt="<?=$row['tloc_name'];?>" width="148" height="159" class="slimg" />
      <div class="right_<?=$color;?>_text">
        <h1><?=$row['tloc_name'];//substr(, 0, 15);?></h1>
        <h2><? list($nights, $days) = explode('|', $row['tloc_type']); 
		echo (!empty($nights) ? $nights.' Nights' : '').' / '.(!empty($days) ? $days.' Days' : ''); ?></h2>
      </div>
   </a>      
  <div class="right_yellow_text_book-btn">
    <a href="destination-details.php?lid=<?=$row['tloc_id']?>"><input name="book" type="button" class="book-btn" value="Book Now" /></a>
  </div>
</div>
<? $i++; }
}
?>
</div>