<? require_once("conn.php");
function getdata($tble,$field,$whr,$xtra='')
{	
	$res=mysql_query("SELECT $field FROM $tble where $whr ");
	$row=mysql_fetch_array($res, MYSQL_BOTH);
	//return $row[0];
	if($xtra=='') return $row[0]; else return $row;
	mysql_close($link_conn);
}
function getcount($tble,$whr)
{	
	$res=mysql_query("SELECT * FROM $tble where $whr ");
	$count=mysql_num_rows($res);
	return $count;
	mysql_close($link_conn);
}
//Top Logos
function get_logos()
{	
	$qur_logo=mysql_query("select * from `svr_logos` where logo_status=1");
	while($row_logo=mysql_fetch_array($qur_logo))
	{
		$logos[$row_logo['logo_title']]=array('path'=>$row_logo['logo_path'],'alt'=>$row_logo['logo_alt'],'url'=>$row_logo['logo_url']);
	}
	return $logos; 
}
function alerts_msg($dismsg)
{	
	switch($dismsg)
	{	
		case 'ad': return '<font color=green>Record Added Successfully.</font>';break;
		case 'up': return '<font color=green>Record Updated Successfully.</font>';break;
		case 'del': return '<font color=red>Record Deleted Successfully.</font>';break;
		case 'sts': return '<font color=green>Record Status Changed Successfully.</font>'; break;
		case 'pw_ss': return '<font color=green>Password Changed Successfully.</font>'; break;
		case 'pw_er': return '<font color=red>InValid-Password ,Try Again.</font>'; break;
		case 'succ': return '<font color=green>Mail sent Successfully.</font>'; break;
		case 'exists': return '<font color=red>User Name Already Exists, Please try with new one.</font>'; break;
	}
}
function page_Navigation($start,$total,$link)
{	
	global $len; $en=$start+$len;
	if($start==0){if($total>0){$start2=1;}else {$start2=0;}}else{$start2=$start+1;}
	if($en>$total)$en = $total;
	if($total!=0) $pagecount=($total % $len)?(intval($total / $len)):($total / $len)-1; else{$pagecount=0;return;}
	print "<table  cellpading=0 cellspacing=0  width=100% align=center><tr>";
	print "<td width=40% class='' valign=middle height=25  align='left'><strong style='color:#888'>Showing $start2 - $en of $total</strong></td>";
	print "<td width=60% align='right' valign=middle><span id='pagination-digg'>";
	$numstr="";
	$curpage=intval(($start+1)/$len)+1;
	if($pagecount > 7){$istart=(intval($curpage/7) * 7)+1;
	if($istart + 7 > $pagecount) $istart=$pagecount - 6;$pagecount=7;} else $istart=1;
	for($i=$pagecount+$istart;$i>=$istart;$i--){$ed=($i-1)*$len;
	if($start!=$ed){$numstr.= " <li><a href='$link&start=$ed' class='previous-off'> $i </a></li>";}else {$numstr.= "<li class='active'> $i </li>";}} $next="";
	if($en>$len){$en1=$start-$len; $previous="<li class=''><a href='$link&start=$en1'>Previous</a></li>" ; } else { $previous="<li class='previous-off'>Previous</li>"; } 
	if($en<$total){$en2=$start+$len;$next="<li class=''><a href='$link&start=$en2'>Next</a></li>" ;}else $next="<li class='previous-off'>Next</li>";
	print $next.$numstr.$previous; 
	print "</span></td></tr></table>";
}
function page_Navigation_front($start,$total,$link)
{
	global $len; $en = $start +$len;
	
	if($start==0){
		if($total>0){$start2=1;}else {$start2=0;}
	}else{$start2=$start+1;}
		if($en>$total)$en = $total;
	if($total!=0) $pagecount=($total % $len)?(intval($total / $len)):($total / $len)-1; else{$pagecount=0;return;}
	
	print "<table cellpading=0 cellspacing=0 width=99% align=center ><tr>";
	print "<td width=40% class='' valign=middle height=25 align='left'><strong style='color:#888'>Showing $start2 - $en of $total</strong></td>";
	print "<td width=60% align='right' valign=middle>
	
	<div class='paginatio'>
	
	<ul style='float:right'>";
	
	$numstr=""; $curpage=intval(($start+1)/$len)+1;
	
	if($pagecount > 7){$istart=(intval($curpage/7) * 7)+1;
	
	if($istart + 7 > $pagecount) $istart=$pagecount - 6; $pagecount=7;} else $istart=1;
	
	for($i=$pagecount+$istart;$i>=$istart;$i--){
		$ed=($i-1)*$len;
		if($start!=$ed){$numstr.= " <li style='float:right'><a href='$link&start=$ed' class='prevnext disablelink'> $i </a></li>";}
		else {$numstr.= "<li class='currentpage' style='float:right'> $i </li>";}
	} $next="";
	
	if($en>$len){$en1=$start-$len; $previous="<li class='prevnext' style='float:right'><a href='$link&start=$en1'> Previous</a></li>" ; } 
	else { $previous=" "; } 
	
	if($en<$total){$en2=$start+$len;$next="<li class='' style='float:right'><a href='$link&start=$en2'> Next</a></li>" ;}
	else $next=" ";
	
	print $next.$numstr.$previous; 
	print "</ul></div></td></tr></table>";
}
function page_Navigation_second($start,$total,$link)
{
	global $len; $en = $start +$len;
	
	if($start==0){
		if($total>0){$start2=1;}else {$start2=0;}
	}else{$start2=$start+1;}
	if($en>$total)$en = $total;
	if($total!=0) $pagecount=($total % $len)?(intval($total / $len)):($total / $len)-1; else{$pagecount=0;return;}
	
	print "<table  cellpading=0 cellspacing=0  width=99% align=center ><tr>";
	print "<td width=40% class='' valign=middle height=25  align='left'><strong style='color:#888'>Showing $start2 - $en of $total</strong></td>";
	print "<td width=60% align='right' valign=middle>
	
	<div class='pagination'>
	
	<ul style='float:right'>";
	
	$numstr="";$curpage=intval(($start+1)/$len)+1;
	
	if($pagecount > 7){$istart=(intval($curpage/7) * 7)+1;
	
	if($istart + 7 > $pagecount) $istart=$pagecount - 6;$pagecount=7;} else $istart=1;
	
	for($i=$pagecount+$istart;$i>=$istart;$i--){
		$ed=($i-1)*$len;
		if($start!=$ed){$numstr.= " <li style='float:right'><a href='$link&start=$ed' class='prevnext disablelink'> $i </a></li>";}
		else {$numstr.= "<li class='currentpage' style='float:right'> $i </li>";}
	} $next="";
	
	if($en>$len){$en1=$start-$len; $previous="<li class='prevnext' style='float:right'><a href='$link&start=$en1'> Previous</a></li>" ; } 
	else { $previous=" "; } 
	
	if($en<$total){$en2=$start+$len;$next="<li class='next' style='float:right'><a href='$link&start=$en2'> Next</a></li>" ;}
	else $next=" ";
	
	print $next.$numstr.$previous; 
	print "</ul></div></td></tr></table>";
}
function no_to_words ($no)
{
    $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
    if($no == 0)
    return ' ';
    else {
		$novalue='';
		$highno=$no;
		$remainno=0;
		$value=100;
		$value1=1000;
		while($no>=100) {
			if(($value <= $no) &&($no < $value1)) {
				$novalue=$words["$value"];
				$highno = (int)($no/$value);
				$remainno = $no % $value;
				break;
			}
			$value= $value1;
			$value1 = $value * 100;
		}
		if(array_key_exists("$highno",$words))
		return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
		else {
			$unit=$highno%10;
			$ten =(int)($highno/10)*10;
			return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
		}
    }
}
//EMPLOYEE WITH STATUS-OFFICE-EMP :
function get_st_office_emp($emp)
{
	$qur1=mysql_query("select e.emp_id,e.emp_name,e.emp_lastname from `tm_emp` as e where e.emp_status=1");
	$j=0; while($row1=mysql_fetch_array($qur1)){ $j++;
		if($emp==$row1['emp_id']) 
			echo '<option value='.$row1['emp_id'].' selected> &nbsp;&nbsp; &raquo; '.$j.". ".$row1['emp_name']." ".$row1['emp_lastname'].'</option>';
		else 
			echo '<option value='.$row1['emp_id'].'> &nbsp;&nbsp; &raquo; '.$j.". ".$row1['emp_name']." ".$row1['emp_lastname'].'</option>';
	}
}
//////////////////// July 2014 ////////////////////
$accomodation_type = array('' => 'Select Accomodation Type', '1' => 'AC', '2' => 'Non-AC');
$room_type = array('' => 'Select Room Type', '1' => 'Standard', '2' => 'Deluxe', '3' => 'Luxury');
$vehicles_pax = array('' => 'Select Type', '1' => 'Vehicle', '2' => 'PAX' );
$titles = array('' => 'Title', '1' => 'Mr.', '2' => 'Mrs.', '3' => 'Miss', '4' => 'Dr.', '5' => 'Prof.');
$adult_child = array('1' => 'Adults', '2' => 'Children');
$pickup_drop = array('1' => 'Flight', '2' => 'Train', '3' => 'Address/Location');
$gender = array('1' => 'Male', '2' => 'Female');
$states = array('' => 'Select State *', '1' => 'Andaman &amp; Nicobar', '2' => 'Andhra Pradesh', '3' => 'Arunachal Pradesh', '4'=>'Assam', '5' => 'Bihar', '6' => 'Chandigarh', '7' =>'Chhattisgarh', '8' => 'Dadar &amp; Nagar Haveli', '9' => 'Daman and Diu', '10' => 'Delhi', '11' => 'Goa', '12' => 'Gujrat', '13' => 'Haryana', '14' => 'Himachal Pradesh', '15' => 'Jammu &amp; Kashmir', '16' => 'Jharkhand', '17' => 'Karnataka', '18' => 'Kerala', '19' => 'Lakshadweep', '20' => 'Madhya Pradesh', '21' => 'Maharashtra', '22' => 'Manipur', '23' => 'Meghalaya', '24' => 'Mizoram', '25' => 'Nagaland', '26' => 'Orissa', '27' => 'Pondicherry', '28' => 'Punjab', '29' => 'Rajasthan', '30' => 'Sikkim', '31' => 'Tamil Nadu', '32' => 'Telangana' , '33' => 'Tripura', '34' => 'Uttar Pradesh' , '35' => 'Uttaranchal', '36' => 'West Bengal');
$seat_numbers = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45');
$enquiry_forms = array('2' => 'LTC/LFC', '4' => 'Corporate Tours', '28' => 'Group Tours');
$enquiry_interest = array('1' => 'Air / Rail Ticketing', '2' => 'Tour of India', '3' => 'Hotel Reservation', '4' => 'Car / Coach Rental');
$api_order_status = array('0' => 'Pending', '1' => 'Refund', '2' => 'Booked', '3' => 'Failure', '4' => 'Cancelled', '5' => 'Partially Cancelled');
$bank = array('' => '----', '1' => 'ICICI', '2' => 'SBI'); 
//Deposit Request
$ag_dep_req_status = array('0' => 'Pending', '1' => 'Accepted', '2' =>'Rejected'); //, '4' => 'Recharge'
$deposit_type = array('0' => '', '1' => 'Cash', '2' =>'Cheque', '3' => 'Bank Transfer', '4' => 'Online');
$default_path = $site_url.'uploads/default/';
$default_gallery_images = array('delhi_banner.jpg', 'bellary3.jpg');
$default_thumb = $default_path.'default_thumb.png';
$null = 'Not Provided';
$margin = 2500; //rupees
$service_tax = 3.09; //percentage
$ftime_span = '1:0:0'; //hours
$cancel_before = '15'; //days
$agent_commission = 0.05;
// Get Filename with timestamp
function make_filename($file)
{	
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$replace  = array(" ", ".", "'", $ext); $replaceWith = array('-', '', '', '');
	$filename = str_replace($replace, $replaceWith, $file).'-'.time();
	return $filename.'.'.$ext;
}
// Get Month Year
function get_month_year($date)
{	
	return ($date != '0000-00-00' && $date != '1970-01-01') ? date('M Y', strtotime($date)) : '';
}
// Get Month Year Range
function get_month_year_range($from_date, $to_date)
{	
	$from_date = ($from_date != '0000-00-00' && $from_date != '1970-01-01') ? date('M Y', strtotime($from_date)) : '';
	$to_date = ($to_date != '0000-00-00' && $to_date != '1970-01-01') ? date('M Y', strtotime($to_date)) : '';
	
	return (date("m-Y", strtotime($from_date)) == date("m-Y", strtotime($to_date))) ? $from_date : $from_date.' To '.$to_date;
}
// Date Difference 
function dateDiff($start, $end) 
{	
	$start = strtotime($start);
	$end = strtotime($end);
	$diff = $end - $start;
	return round($diff / 86400);
}
// DB Date and Time
function db_date_time($date = '')
{	
	return date('Y-m-d H:s:i', strtotime($date));
}
// Site Date and Time
function site_date_time($date = '')
{	
	global $null;
	return ($date != '' && $date != '1970-01-01 00:00:00' && $date != '0000-00-00 00:00:00') ? date('d-m-Y h:s A', strtotime($date)) : $null;
}
// DB Date
function db_date($date = '')
{
	return date('Y-m-d', strtotime($date));
}
// Site Date 
function site_date($data = '')
{	
	global $null;
	return ($date != '' && $date != '1970-01-01' && $date != '0000-00-00') ? date('d-m-Y', strtotime($date)) : $null;
}
//Title Case
function to_title_case($string = '')
{
	return ucwords(strtolower($string));
}
function cust_login_check()
{
	global $svr;
	if(empty($_SESSION[$svr.'cust_id'])){
		header("location:index.php");
	} 
}
function agent_login_check()
{
	global $svra;
	if(empty($_SESSION[$svra.'ag_id'])){
		header("location:index.php");
	}
}
function php_self()
{
	global $svr;
	if(!$_SESSION[$svr.'cust_id']){
		$_SESSION['redir_after_auth'] = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
		if($_GET){
			$_SESSION['redir_args'] = $_GET;
		}
	}
}
//Data Exists
function exists($data = '', $text = '', $title_case = '')
{	
	global $null;
	$text = (isset($text)) ? $text : $null;
	return ($data != '') ? (($title_case != '') ? to_title_case($data) : $data) : $text;
}
// Search Tracker
//function search_tracker($cat = '', $from = '', $to = '', $avail_dates = '')
//{	
//	include("search_tracker.php");
//}
// Extract Numbers from a String
function extract_numbers($string)
{
	preg_match_all('/([\d]+)/', $string, $match);
	return $match[0];
}
/* Example: 
$string = 'Lorem ipsum dolor sit 45 40 amet, consectetuer adipiscing elit. 35 65675 Suspendisse sed nibh non diam consectetuer pharetra. Morbi ultricies 235 536pede et pede. 9432 3536 Nunc eu risus eget quam lacinia feugiat. In sapien sem, fringilla quis, 34 24 8762condimentum id, bibendum ut, nibh. Quisque 2367 784 elementum massa 350 235 vel nulla.';
$numbers_array = extract_numbers($string);
echo '<pre>'; print_r($numbers_array); echo "</pre>";*/
function genRandomString() {
	$length = 10;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$string3 = '';    
	for ($p = 0; $p < $length; $p++) {
	$string3 .= $characters[mt_rand(0, strlen($characters))];
}
return $string3;
}
function gallery_images($images = '', $path = '')
{	
	global $default_gallery_images;
	global $default_path;
	
	$images = ($images != '') ? $images : $default_gallery_images;
	$path = ($path != '') ? $path : $default_path;
	
?>
<div class="banner_inner">
	<div class="slider-frame">
		<div class="sliderImages">
			<ul>
			<? foreach($images as $image){?>						
				<li><a href="#nogo" class="mySliderImages"><img src="<?=$path.$image?>" width="800" class="slimg" height="225" style="display:none" /></a></li>
			<? }?>
			</ul>		
		</div>
	</div>
	<div class="arrow-but">
		<a href="#" class="prev"><img src="images/l_arrow.png" alt="Previous" width="33" height="33" border="0" /></a>					
		<a href="#" class="next"><img src="images/r_arrow.png" alt="Next" width="33" height="33" border="0"/></a>
	</div>
</div>
<? }
//Fare Month Array
function get_fare_months($loc = '')
{
	$fq = mysql_query("select fr_id, fr_from_date, fr_to_date, fr_group_id from svr_fares where fr_status = 1 and fr_loc_id = '".$loc."' and fr_to_date > CURDATE() group by fr_group_id order by fr_from_date");
	while($row = mysql_fetch_array($fq)) $fare_mon[] = $row;
	return $fare_mon;
}
function get_fare_cats($loc = '')
{	
	$fcq = mysql_query("select concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle from svr_fares as fr
	left join svr_fare_category as fc on fr.fr_fc_id = fc.fc_id
		left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
			left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
				left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
					where fc_status = 1 and fr_loc_id = '".$loc."' and FIND_IN_SET('".$loc."', fc_locations) group by fc_id order by fr_id");
	$fare_cats = array(); $fcq_count = mysql_num_rows($fcq);
	//if($fcq_count > 0) { while($row = mysql_fetch_array($fcq)) $fare_cats[] = $row; }
	
	return $fare_cats;
}
function fares_table($cat = '')
{	
	//Fare Prices Array
	if($cat == 1)
	{	
		$prq = mysql_query("select fr_id, fr_type, fr_fc_id, fc_orderby, fr_acc_type, fr_room_type, fr_data, fr_group_id, fc_name from svr_fares as fr
			left join svr_fare_category as fc on fr.fr_fc_id = fc.fc_id
				where fr_status = 1 and fr_loc_id = '".$_GET['lid']."' order by fr_id");
	
	} else {
		
		$prq = mysql_query("select fr_id, fr_type, fr_fc_id, fc_orderby, fr_acc_type, fr_room_type, fr_data, fr_group_id, concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle from svr_fares as fr
		left join svr_fare_category as fc on fr.fr_fc_id = fc.fc_id
			left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
				left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
					left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
						where fr_status = 1 and fr_loc_id = '".$_GET['lid']."' order by fr_id");
	}
	$pcount = mysql_num_rows($prq);
	
	while($fare = mysql_fetch_array($prq)) 
	{	
		if($fare['fr_type'] == 1) 
		{	
			$acc[] = $fare['fr_acc_type']; 
			$fares[$fare['fr_fc_id']][$fare['fr_acc_type']][$fare['fr_group_id']] = $fare['fr_data']; 
			$farecatnames[$fare['fr_fc_id']] = $fare['fc_name'];
		}
		if($fare['fr_type'] == 2) 
		{	
			$acc[] = $fare['fr_room_type']; 
			$fares[$fare['fr_fc_id']][$fare['fr_room_type']] = $fare['fr_data']; 
			$farecatnames[$fare['fr_fc_id']] = $fare['vehicle'];
		}
		$fare_cat_orderby[] = $fare['fc_orderby'];
		$fare_cat[] = $fare['fr_fc_id'];
	}
	
	$fare_cat = array_combine($fare_cat_orderby, $fare_cat);
	ksort($fare_cat);
	
	//Populate Accomodation / Room Types
	$acc = ($pcount != 0) ? array_unique($acc) : '';
	
	//Fare Month Array
	if($cat == 1)	$fare_mon = get_fare_months($_GET['lid']);
	//Fare Cat Array
	$fare_cats = ($pcount != 0) ? array_unique($fare_cat) : '';	
	
	return array($fare_cats, $farecatnames, $acc, $fares, $fare_mon);
}
function fixed_fares_table($fare_cats, $farecatnames, $acc, $fixed_fares, $fare_mon)
{ 	
	global $accomodation_type;
	//if($fare_cats == '' || $farecatnames == '' || $acc == '' || $fixed_fares == '' || $fare_mon == '')
		//list($fare_cats, $farecatnames, $acc, $fixed_fares, $fare_mon) = fares_table(1);
	if(!empty($fixed_fares) && !empty($fare_cats)){
	?>
	<table style="border:1px solid #eaeaea;" cellpadding="10" cellspacing="1">
	<tbody>
	  <tr>
		<td rowspan="2" align="center" bgcolor="#F4F4F4" valign="middle"><span class="red_heading">Category</span></td>
		<? foreach($fare_mon as $fm) { ?>
			<td colspan="<?=sizeof($acc);?>" align="center" bgcolor="#F4F4F4" valign="middle">
			<span class="red_heading"><?=get_month_year_range($fm['fr_from_date'], $fm['fr_to_date']);?></span></td>
		<? }?>
	  </tr>
	  <tr>
	  <? foreach($fare_mon as $fm) { 
		 	foreach($acc as $ac) { ?>
				<td rowspan="" colspan="" align="center" bgcolor="#F4F4F4" valign="middle">
					<span class="red_heading"><?=$accomodation_type[$ac];?></span>
				</td>
	  <? }}?>
	  </tr>	
	  <? $i = 0; foreach($fare_cats as $fare_cat) { ?>
	  <tr bgcolor="<?=($i%2==0) ? '#FFFFFF' : '#F4F4F4';?>">
		<td align="left" valign="middle"><?=$farecatnames[$fare_cat];?></td>
		<? foreach($fare_mon as $fm) {
		foreach($acc as $key => $ac) {?>
		<td align="center" valign="middle"><span class="rupee">&#x20B9;</span> <?=$fixed_fares[$fare_cat][$ac][$fm['fr_group_id']].'/-';?></td>
		<? }}?>
	  </tr>
	  <? $i++; }?>
	</tbody>
  </table>
<? }}
function tour_fares_table($fare_cats, $farecatnames, $acc, $tour_fares)
{
	global $room_type; 
	//if($fare_cats == '' || $farecatnames == '' || $acc == '' || $tour_fares == '')
		//list($fare_cats, $farecatnames, $acc, $tour_fares) = fares_table(2);
	//header("content-type:text/html");	
	sort($fare_cats);
	if(!empty($tour_fares) && !empty($fare_cats)){
	?>
	<div class="mining_tbl">
		<ul>
			<li class="title">CATEGORY</li>
			<? foreach($acc as $ac){ ?><li><?=$room_type[$ac];?></li><? }?>
		</ul>
		<? $j = 0; foreach($fare_cats as $fare_cat) { $j++; ?>
		<ul style="width:auto; <?=($j == sizeof($fare_cats)) ? 'border:1px dotted #C9C9C9;' : ''?>">
			<li class="title"><?=$farecatnames[$fare_cat];?></li>
			<? foreach($acc as $ac) { ?>
			<li><span class="rupee">&#x20B9;</span> <?=((!empty($tour_fares[$fare_cat][$ac])) ? $tour_fares[$fare_cat][$ac] : 0).'/-';?></li>
			<? }?>
		</ul>
		<? }?>
	</div>
<? }}
function get_min_max_pax($loc, $room_type, $vehicle)
{	
	$q = mysql_query("select max(pax.vp_min) as vp_min, max(pax.vp_max) as vp_max from svr_fares as fr 
	left join svr_fare_category as fc on fc.fc_id = fr.fr_fc_id
		left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name
			left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id
				left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
					where fr_loc_id = ".$loc." and fr_room_type = ".$room_type." 
						and fr_status = 1 and veh.vp_id = ".$vehicle." ");
	$fetch = mysql_fetch_array($q);
	return $fetch['vp_min']."#".$fetch['vp_max'];					
}
function get_hotel_charges($loc, $room_type)
{	
	$q= mysql_query("select ch_charges from svr_charges where ch_type = 2 and ch_room_type = ".$room_type." and FIND_IN_SET('".$loc."', ch_locations)");
	$fetch = mysql_fetch_array($q);
	return $fetch['ch_charges'];
}
function get_travel_charges($loc, $vehicle)
{	
	$q = mysql_query("select ch_charges, ch_km from svr_charges where ch_type = 1 and ch_vehicle_id = '".$vehicle."' and FIND_IN_SET('".$loc."', ch_locations)");
	$fetch = mysql_fetch_array($q);
	return $fetch['ch_charges'].'#'.$fetch['ch_km'];
}
function get_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights = '', $days = '')
{	
	global $margin, $service_tax;
	
	if($pax != "" && $pax <= $min_pax)
	{	
	  	$q = mysql_query("select fr_data from svr_fares as fr 
	  	left join svr_fare_category as fc on fc.fc_id = fr.fr_fc_id
			left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name
				left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id
					left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
						where fr_loc_id = ".$loc." and fr_room_type = ".$room_type." and fr_status = 1
							and veh.vp_id = ".$vehicle." and (".$pax." between 1 and pax.vp_min)");
	  	$fetch = mysql_fetch_array($q);
	  	$fare = $fetch['fr_data'] * $min_pax;
	  	
	} else {
		
		$room_charges = get_hotel_charges($loc, $room_type);
		$travel_charges = get_travel_charges($loc, $vehicle);
		
		$room_charges = ($travel_charges != '#' && $room_charges != '') ? $room_charges : 0;
		$hotel_pp = ($room_charges * $nights)/2;
		$travel_charges = ($travel_charges != '#' && $room_charges != '') ? $travel_charges : 0;
		list($rate, $pkm) = (!empty($travel_charges)) ? explode('#', $travel_charges) : array_fill(0, 2, 0);
		$vehicle_pp = ($pax != '') ? ($rate * $pkm * $days)/$pax : 0;
		
		$fare = ($vehicle_pp != '') ? ($hotel_pp + $vehicle_pp + $margin) * $pax : 0;
	}
	$tax = ($service_tax/100) * $fare;
	$fare = $tax + $fare;
	
	return $tax.'#'.$fare;
}
function get_additional_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax)
{	
	global $service_tax;
	list($old_tax, $old_fare) = explode('#', get_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days));
	$hotel_charges = (get_hotel_charges($loc, $room_type) * $nights)/2;
	$additional_fare = $hotel_charges * $new_pax;
	$new_tax = ($service_tax/100) * $additional_fare;
	$new_fare = $additional_fare + $new_tax;
	
	$total_fare = $old_fare + $new_fare;
	$total_tax = $old_tax + $new_tax;
	
	$pax_left = $pax - $new_pax;
	
	return $total_tax."#".$total_fare."#".$hotel_charges."#".$additional_fare."#".$pax_left;
}
function get_fares_childbed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax)
{	
	global $service_tax;
	//echo $childbed_pax.'#'.$childnobed_pax; exit;
	//if($childnobed_pax != '')
	//{	
		//$get_fare = get_fares_childnobed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax);
		
	//} else {
		
		if($new_pax != '') 
			$getfare = get_additional_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax);
		else 
			$getfare = get_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days);
	//}
	list($old_tax, $old_fare) = explode('#', $getfare);
	
	$hotel_charges = ((get_hotel_charges($loc, $room_type) * $nights)/2) * 0.3;
	$additional_fare = $hotel_charges * $childbed_pax;
	//$new_tax = ($service_tax/100) * $additional_fare;
	$new_tax = 0;
	$new_fare = $additional_fare + $new_tax;
	
	$total_fare = $old_fare - ($new_fare);
	//$total_tax = $old_tax - $new_tax;
	$total_tax = $old_tax;
	
	//$pax_left = $pax - $new_pax - $childbed_pax - $childnobed_pax;
	//if($childbed_pax == 0) $hotel_charges = $additional_fare = 0;
	
	return $total_tax."#".$total_fare."#".$hotel_charges."#".$additional_fare;
}
function get_fares_childnobed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax)
{	
	global $service_tax;
	if($childbed_pax != '')
	{	
		$getfare = get_fares_childbed($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax, $childbed_pax, $childnobed_pax);
		
	} else {
		
		if($new_pax != '') 
			$getfare = get_additional_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days, $new_pax);
		else 
			$getfare = get_fares($loc, $room_type, $vehicle, $pax, $min_pax, $nights, $days);
	}
	list($old_tax, $old_fare) = explode('#', $getfare);
	
	$hotel_charges = ((get_hotel_charges($loc, $room_type) * $nights)/2) * 0.6;
	$additional_fare = $hotel_charges * $childnobed_pax;
	//$new_tax = ($service_tax/100) * $additional_fare;
	$new_tax = 0;
	$new_fare = $additional_fare + $new_tax;
	
	$total_fare = $old_fare - ($new_fare);
	//$total_tax = $old_tax - $new_tax;
	$total_tax = $old_tax;
	
	//$pax_left = $pax - $new_pax - $childbed_pax - $childnobed_pax;
	//if($childbed_pax == 0) $hotel_charges = $additional_fare = 0;
	
	return $total_tax."#".$total_fare."#".$hotel_charges."#".$additional_fare;
}
//function bus_layout($booked_seats = '')
//{
//	include('bus_layout.php');
//}
function resize_image($image, $wd, $ht = '')
{	
	// creation of thumbnail image starts here
	$image_attribs = getimagesize($image);
	$im_old = imageCreateFromJpeg($image);
	$width=$image_attribs[0];
	$height=$image_attribs[1];
	
	$th_max_width = $wd;
	//if($ht != '') $th_max_height = $ht; 
	$ratio = ($width > $height) ? $th_max_width/$image_attribs[0] : $th_max_width/$image_attribs[1];
	$th_width = $image_attribs[0] * $ratio;
	$th_height = $image_attribs[1] * $ratio;
	$im_new = imagecreatetruecolor($th_width,$th_height);
	imageAntiAlias($im_new,true);
	$th_file_name = $image;
	imageCopyResampled($im_new,$im_old,0,0,0,0,$th_width,$th_height, $image_attribs[0], $image_attribs[1]);
	imageJpeg($im_new,$th_file_name,100);
	// creation of thumbnail image ends here
}
function get_available_dates($loc)
{	
	global $ftime_span;
	$qur_pkg = mysql_query("select pkg_id, pkg_date, ((pkg_ac_seats + pkg_nac_seats)-COALESCE(sum(bot_no_of_persons), 0)) as avail_seats from svr_packages as pkg 
		left join svr_book_order_temp as bot on bot.bot_pkg_id = pkg.pkg_id AND 
			(bot_request_status = 1 or bot_added_date > subtime('".$now_time."', '".$ftime_span."') and bot_request_status = 0)
				where pkg_date > CURDATE() and pkg_to_id = ".$loc." group by pkg_id having avail_seats > 0");
	
	while($row_pkg = mysql_fetch_array($qur_pkg)) { 
		$avail_dates[] = date('d-m-Y', strtotime($row_pkg['pkg_date']));
		$avail_seats[$row_pkg['pkg_date']] = $row_pkg['avail_seats'];
		//$lid = array($loc);
	}
	//print_r($avail_dates); exit;
	//return implode(",", $avail_dates).'#'.implode(",", $avail_seats);
	return array($avail_dates, $avail_seats, $loc);
}
function array_combine_array(array $keys)
{
	$arrays = func_get_args();
	$keys = array_shift($arrays);
	
	/* Checking if arrays are on the same model (array('INDEX'=> array()) or array()) */
	$check = count(array_unique(array_map('is_array',array_map('current',$arrays)))) === 1;
	if (!$check) { trigger_error('Function array_combine_array() expects all parameters to be same type array or array of array',E_USER_NOTICE); return array(); }
	
	/* Checking the model of arrays, array('INDEX' => array()) or Array() */
	$assocArray = is_array(array_shift(array_map('current',$arrays)));
	
	/* If empty $Keys is given, we fill an empty array */
	if (empty($keys)) $keys = array_keys(array_fill(0,max(($assocArray) ? array_map('count',array_map('current',$arrays)) : array_map('count',$arrays)),'foo'));
	/* Init */
	$ret=array();$i=0;
	/* Cycling on each keys values, making an offset for each */
	foreach($keys as $v)
	{
		/* Cycling on arrays */
		foreach ($arrays as $k)
		{
			if ($assocArray)
			{
				/* Getting the index of the element */
				$key = key($k);
				/* If the offset exists, we place it */
				$ret[$v][$key] = isset($k[$key][$i]) ? $k[$key][$i]:false;
			}
			/* Making the array with auto-made index */
			else
				$ret[$v][] = isset($k[$i]) ? $k[$i]: false;
		}
		/* Getting the next offset */
		$i++;
	}
	return $ret;
}
function isJson($string) {
 	json_decode($string);
 	return (json_last_error() == JSON_ERROR_NONE);
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}
function send_email($data)
{	
	$mailbody = "<style type='text/css'>
	table, td, th { font-family: Verdana; font-size:12px; }
	.clr { color: #FFFFFF; font-weight: bold; }</style>
	<table width='500' border='0' align='center' cellpadding='5' cellspacing='0' style='border-bottom:2px solid #aaa'>	
	  <tr>
		<td height='30' align='center' valign='middle' bgcolor='#F2F2F2'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td align='center' valign='top'><a href='http://www.svrtravelsindia.com/' target='_blank'>
				<img src='http://www.svrtravelsindia.com/images/svr-travels.jpg' alt='svrtravelsindia' border='0' /></a></td>
			  </tr>
			  <tr>
				<td align='center' valign='middle' bgcolor='#D50000'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td height='40' align='center' valign='middle'>
						<span class='clr' style='color: #FFFFFF; font-weight: bold;'>".$data['subject']."</span>
					</td>
				  </tr>
				</table>			  
				</td>
			  </tr>
			</table>			
		</td>
	  </tr>
	  <tr>
		<td align='center' valign='top' bgcolor='#F2F2F2'>".$data['content']."</td>
	  </tr>
	</table>";
	
	/*$mailto = "ewrite2me@gmail.com";
	$mailheader  = "MIME-Version: 1.0" . "\r\n";
	$mailheader .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$mailheader .= "From: SVR Travels India <nizamians@gmail.com> \r\n";
	$message = $data['subject'];
	@mail($mailto, $message, $mailbody, $mailheader);*/
	
	/*echo $data['to_email'].'<br>';
	echo $data['subject'].'<br>';*/
	//echo $mailbody; exit;
	
	//$mailto = $data['to_email'];
	$mailto = "info@svrtravelsindia.com";
	$mailheader  = "MIME-Version: 1.0" . "\r\n";
	$mailheader .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	//$mailheader .= "From: info@svrtravelsindia.com \r\n";
	$mailheader .= "From: SVR Travels India <dsnr@svrtravelsindia.com> \r\n";
	$mailheader .= "Bcc: shireesh@svrtravelsindia.com"."\r\n";
	$mailheader .= "Bcc: ".$data['to_email']."\r\n";
	if($data['to_email'] != 'janardhan@svrtravelsindia.com')
		$mailheader .= "Bcc: janardhan@svrtravelsindia.com"."\r\n";
	$mailheader .= "Bcc: sameera@bitragroup.com"."\r\n";
	$mailheader .= "Bcc: sarah@bitragroup.com"."\r\n";
	$mailheader .= "Bcc: ewrite2me@gmail.com"."\r\n";
	$message = $data['subject'];
	@mail($mailto, $message, $mailbody, $mailheader);
}

function refund_amount($jdate, $cdate, $fare)
{ 
	$diff = dateDiff($cdate, $jdate); $amt = $fare; $percent = '100%';
	
	if($diff >= 30){
	
		$amt = ($fare*20)/100;
		$percent = '80%';
		
	} else if( $diff >= 15){ 
	
		$amt = ($fare*50)/100;
		$percent = '50%';
		
	}
	return $fare-$amt;
}

function cancel_amount($jdate, $cdate, $fare)
{ 
	$diff = dateDiff($cdate, $jdate); $amt = $fare; $percent = '100%';
	
	if($diff >= 30){
	
		$amt = ($fare*20)/100;
		$percent = '80%';
		
	} else if( $diff >= 15){ 
	
		$amt = ($fare*50)/100;
		$percent = '50%';
		
	}
	return $amt;
}

function canCharges($v1, $doj, $doc)
{	
	$charges = $date = $date1 = $date2 = '';
	$cancellationcharges = explode(';', $v1);
	$limit = count($cancellationcharges);
	for ($i=0; $i < $limit; $i++) { 
		if(!empty($cancellationcharges[$i])) 
		{	
			$ccount = strlen($cancellationcharges[$i]);
			$substr = str_split($cancellationcharges[$i]);
			$colon_count = 0;
			$p1='';	$p2='';
			for ($j=0; $j<$ccount; $j++) { 
				if($substr[$j]==':'){
					$colon_count++;
				}
				if($colon_count<=1){
					$p1.=$substr[$j];
				}
				else{
					$p2.=$substr[$j];
				}
			}
			$p2=ltrim($p2,':');
			$p1=explode(':', $p1);
			$p2=explode(':', $p2);
			
			if($p1[0]==0) {
				$date = date('Y-m-d H:i:s', strtotime('-'.$p1[1].' hours', strtotime($doj)));
				if(($doc > $date) && ($doc < $doj)) {
					$charges = $p2[0]; 
					break;
				}
			}
			elseif ($p1[1]==-1) {
				$date = date('Y-m-d H:i:s', strtotime('-'.$p1[0].' hours', strtotime($doj))); 
				if(($doc < $date)) { 
					$charges = $p2[0];
					break;
				}
			}
			else {
				$date1 = date('Y-m-d H:i:s', strtotime('-'.$p1[1].' hours', strtotime($doj)));
				$date2 = date('Y-m-d H:i:s', strtotime('-'.$p1[0].' hours', strtotime($doj)));
				if(($doc > $date1) && ($doc < $date2)) { 
					$charges = $p2[0];
					break;
				}
			}
		}
	}
	return $charges;
}


function cancelPolicy($v1, $doj, $pc = '', $plain = '')
{	
	$STORE = '';
	$class = (empty($plain)) ? 'myTable' : '';
	$cell = (empty($plain)) ? '3' : '';
	$ht = (empty($plain)) ? 0 : 25;
	$STORE.='<table width="100%" cellpadding='.$cell.' cellspacing='.$cell.' class='.$class.'>';
	if(empty($plain)) $STORE.='<tr><th colspan=2><h2>Cancellation Policy</h2></th></tr>';
	$STORE.='<tr height='.$ht.'><th align="left">Cancellation Time</th><th align="left">Charges</th></tr>';
	$cancellationcharges = explode(';', $v1);
	$limit = count($cancellationcharges); //2
	for ($i=0; $i < $limit ; $i++) { 
		if(!empty($cancellationcharges[$i])) 
		{	
			$ccount = strlen($cancellationcharges[$i]); //10
			$substr = str_split($cancellationcharges[$i]); //Array ( [0] => 0 [1] => : [2] => 4 [3] => 9 [4] => : [5] => 1 [6] => 0 [7] => 0 [8] => : [9] => 0 )
			$colon_count = 0;
			$p1='';
			$p2='';
			for ($j=0; $j<$ccount; $j++) { 
				if($substr[$j]==':'){
					$colon_count++;
				}
				if($colon_count<=1){
					$p1.=$substr[$j];
				}
				else{
					$p2.=$substr[$j];
				}
			}$STORE.='<tr height='.$ht.'>'; //p1 = 0:49 //p2 = :100:0
			$p2=ltrim($p2,':'); //100:0
			$p1=explode(':', $p1); //Array ( [0] => 0 [1] => 49 )
			$p2=explode(':', $p2); //Array ( [0] => 100 [1] => 0 )
			
			$departure = date('d/m/y g:i A', strtotime($doj));
			
			if($p1[0]==0) {
				$date = date('d/m/y g:i A', strtotime('-'.$p1[1].' hours', strtotime($doj)));
				$STORE.= "<td>Between ".$date." and ".$departure."</td>";
			}
			elseif ($p1[1]==-1) {
				$date = date('d/m/y g:i A', strtotime('-'.$p1[0].' hours', strtotime($doj)));
				$STORE.= "<td>Before ".$date."</td>";
			}
			else {
				$date1 = date('d/m/y g:i A', strtotime('-'.$p1[1].' hours', strtotime($doj)));
				$date2 = date('d/m/y g:i A', strtotime('-'.$p1[0].' hours', strtotime($doj)));
				$STORE.= "<td> Between ".$date1." and ".$date2."</td>";
			}
		 $STORE.= "<td>".$p2[0]."%</td></tr>";
		}
	}
	if($pc != '') {
		$allow = ($pc == true) ? '' : 'NOT';
		$STORE.='<tr><td colspan=2><b><strong>* Partial cancellation is '.$allow.' allowed for this ticket.</strong></b></td></tr>';
	}
	$STORE.="</table>";
	return $STORE;
}

function getSourceName($source_id)
{
	global $src;
	$src = getAllSources();
	$source = json_decode($src);
	$source_cities = $source->cities;
	foreach($source_cities as $scities){
		if($scities->id == $source_id)
			$source_name = $scities->name;
	}
	return $source_name;
}

function getDestinationName($source_id, $destination_id)
{
	global $dest;
	$dest = getAllDestinations($source_id);
	$source = json_decode($dest);
	$destination_cities = $source->cities;
	foreach($destination_cities as $dcities){
		if($dcities->id == $destination_id)
			$destination_name = $dcities->name;
	}
	return $destination_name;
}

function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}

function encrypt_decrypt($action, $string)
{
	$key = "KEYVALUE";
	
	if( $action == 'encrypt' ) {
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
		$output = $encrypted;
	}
	else if( $action == 'decrypt' ) {
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		$output = $decrypted;
	}
	return $output;
}

function titlecase($title) 
{
	$donotcap = array('a','an','and','at','but','by','else','for','from','if','in','into','nor','of','on','or','the','to','with'); 
	// Split the string into separate words 
	$words = explode(' ', $title); 
	foreach ($words as $key => $word) { 
		// Capitalize all but the $donotcap words and the first word in the title
		if ($key == 0 || !in_array($word, $donotcap)) $words[$key] = ucwords($word); 
		if (preg_match("/^&#8220;/", $word))
			$words[$key] = '&#8220;' . ucwords(substr($word, 7));
		elseif (preg_match("/^&#8216;/", $word))
			$words[$key] = '&#8216;' . ucwords(substr($word, 7));
	} 
	// Join the words back into a string 
	$newtitle = implode(' ', $words);
	return $newtitle;
}
?>