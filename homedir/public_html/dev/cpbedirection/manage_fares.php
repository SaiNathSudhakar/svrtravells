<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('faresm',$_SESSION['tm_priv']) ) ) ){}else{header("location:welcome.php");}
$cond = '1';

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset"){
	unset($_SESSION["cat_fltr_fr"]);
	header("location:manage_fares.php");
}

//category filter
if(!empty($_GET['cat_fltr']) || isset($cat_fltr_fr)){
	if(!empty($_GET['cat_fltr'])) { $_SESSION['cat_fltr_fr'] = $_GET['cat_fltr']; }
	$cat_fltr_fr = (isset($_SESSION['cat_fltr_fr'])) ? $_SESSION['cat_fltr_fr'] : '';
	
	if($cat_fltr_fr != ''){	
		$cat_fltr = " and fr_loc_id = ".$cat_fltr_fr; 
		//$cond_cat .= " and tloc_id_fk = ".$cat_fltr_fr;
	}
}
$cond .= $cat_fltr;

if(!empty($_GET['del_id'])){ 
	query("delete from svr_fares where fr_group_id='".$_GET['del_id']."'");
	header("location:manage_fares.php");
}

if(!empty($_GET['f_status'])){ 
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_fares set fr_status=".$status." where fr_group_id='".$_GET['frs_id']."'");
	header("location:manage_fares.php");
}
$page_query = query("select fr_id from svr_fares where $cond group by fr_group_id");
$total=num_rows($page_query);
$len=30; $start=0;
$link="manage_fares.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$result = query("select cat_id, cat_name, subcat_name, fr_id, fr_from_date, fr_to_date, fr_data, fc_name, tloc_name, tloc_acc_type, fr_group_id, fr_status from svr_fares as fr 
left join svr_fare_category as fc on fc.fc_id = fr.fr_fc_id 
	left join svr_to_locations as loc on loc.tloc_id = fr.fr_loc_id
		left join svr_subcategories as subcat on subcat.subcat_id = fr.fr_subcat_id
			left join svr_categories cat on cat.cat_id = fr.fr_type
				where $cond group by fr_group_id order by fr_id desc limit $start,$len");

$sch_count = num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/multiple-select.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery.multiple.select.js"></script>
<script language="javascript" src="../js/script.js"></script>
<script>
$(function() { 
	$("#dest_name").multipleSelect({
		placeholder: 'Select Locations',
		multiple: false,
		single: true,
		filter: true
	});
});
</script>
</head>
<body>
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><img src="images/spacer.gif" border="0" height="5" /></td>
		</tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
			  <td valign="middle" width="50%">
			  	<img src="images/home-icon.gif" alt="" width="11" height="13" />
				<strong style="font-size:12px"><a href="welcome.php">Home</a> &raquo; Manage Fares</strong>
			  </td>
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			  		<td valign="top" class="grn_subhead" align="right">&nbsp;</td>
				</tr></table></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>
			<table width="95%" align="center" border="0" cellspacing="0" cellpadding="6">
			  <tr>
				<td>
				  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td align="left" valign="middle">
					  	<select name="dest_name" id="dest_name" onchange="window.location='manage_fares.php?cat_fltr='+this.value">
							<option value="">Please Select Location</option>
							<? 
							  $dest_q = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where tloc_status=1 order by tloc_name");
							  while($dest_fetch = fetch_array($dest_q)){	
							?>
							<option value="<?=$dest_fetch['tloc_id'];?>"
							<? if($cat_fltr_fr == $dest_fetch['tloc_id']){?>selected<? }?>>
							<?=$dest_fetch['tloc_name']; ?> <?=' ('.$dest_fetch['tloc_code'].')'; ?>
							</option>
							<? }?>
					  	</select>
					    <? if(!empty($cat_fltr_fr)){ ?>
				        <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_fares.php?src=reset'" title="Reset"/>
			            <? } ?>
					  </td>
                      <td align="right" valign="middle" nowrap="nowrap"><input type="button" name="add" onclick="javascript:window.location='add_fares.php'" value="Add New" class="button" title="Add New"/></td>
                    </tr>
                  </table>
				</td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="1%" height="20" align="center" class="tablehead"><strong>S.No</strong></td>
			<td width="25%" class="tablehead">Type</td>
			<td class="tablehead">Location </td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/del.png" alt="Edit" title="Edit" width="16" height="16" /></td>
-->		  </tr>
		  </thead>
		  <?php
		   $sno = $start; if($sch_count>0){
		   while($fetch=fetch_array($result)){
		    $sno++;
			if($fetch['fr_status']==1){
				$sch_status ='<a href="manage_fares.php?frs_id='.$fetch["fr_group_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
			}else if($fetch['fr_status']==0){
				$sch_status='<a href="manage_fares.php?frs_id='.$fetch["fr_group_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1"; } ?>">
			<td align="center"><?=$sno;?>.</td>
			<td width="15%" align="left"><?=$fetch['cat_name'].(($fetch['subcat_name'] != '') ? '&ensp; &raquo; &ensp;'.$fetch['subcat_name'] : ''); ?></td>
			<td align="left">
				<? $duration = get_month_year_range($fetch['fr_from_date'], $fetch['fr_to_date']);?>
				<?=$fetch['tloc_name'].($fetch['cat_id'] == 1 && ($duration != '') ? " &ensp; &raquo; &ensp; ( ".$duration." )" : "" ); ?></td>
			<td align="center"><a href="add_fares.php?frs_id=<?=$fetch['fr_group_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
<td align="center"><? echo $sch_status; ?></td>
<!--<td width="5%" align="center" class="tablehead"><a href="manage_fares.php?del_id=<?=$fetch['fr_group_id'];?>">
<img src="images/del.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
-->		  </tr>
		  <? }} else if($sch_count==0) { ?>
		  <tr><td colspan="15" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
		  <? } ?>
		  </table>
		  </td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? if($total>$len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? }?>
		<tr>
		  <td align="center">&nbsp;</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</body>
</html> 