<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['manage_tour_locations']) && $_SESSION['manage_tour_locations']=='yes' ) ) ){}else{header("location:welcome.php");}

if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_tour_locations set trl_status=".$status." where trl_id='".$_GET['id']."'");
	header("location:manage_tour_locations.php");
}
$page_query = mysql_query("select trl_id from svr_tour_locations");
$total = mysql_num_rows($page_query);

$len = 10; $start = 0;
$link = "manage_tour_locations.php?a=a";
if(!empty($_GET['start'])) { $start = $_GET['start']; }

$result = mysql_query("select cat_name, trl_id, trl_type, trl_floc_id, trl_tloc_id, trl_status, trl_dateadded, floc.floc_name, group_concat(tloc_name order by tloc_orderby desc) as to_locations from svr_tour_locations as trl 
left join svr_categories cat on cat.cat_id = trl.trl_type
	left join svr_from_locations as floc on floc.floc_id = trl.trl_floc_id
		left join svr_to_locations as tloc on CONCAT(',', trl.trl_tloc_id, ',') LIKE CONCAT('%,', tloc.tloc_id, ',%')
			group by trl.trl_id order by trl_id desc limit $start, $len");

$sch_count = mysql_num_rows($result); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../includes/script_valid.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Tour Locations</strong></td>
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
				<td align="right"><a href="add_tour_locations.php"><strong>Add Tour Locations</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="15%" class="tablehead">Type</td>
			<td width="15%" class="tablehead">From Location </td>
			<td class="tablehead">To Location </td>
			<td width="10%" align="center" class="tablehead">Date Added </td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
		   $sno = $start; if($sch_count > 0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['trl_status'] == 1){
				$sch_status ='<a href="manage_tour_locations.php?id='.$fetch["trl_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
			}else if($fetch['trl_status'] == 0){
				$sch_status='<a href="manage_tour_locations.php?id='.$fetch["trl_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2"; } else { echo "tablerow1"; } ?>">
			<td width="5%" height="25" align="left"><?=$sno;?></td>
			<td width="15%" align="left"><?=$fetch['cat_name'];?></td>
			<td width="15%" align="left"><?=$fetch['floc_name'];?></td>
			<td align="left" title="<?=$fetch['to_locations']?>"><? $locat = (strlen($fetch['to_locations']) > 70) ? substr($fetch['to_locations'], 0, 70).'...' : $fetch['to_locations']; echo ucwords(strtolower($locat)); ?></td>
			<td width="10%" align="center"><?=date('d-m-Y', strtotime($fetch['trl_dateadded']));?></td>
			<td width="5%" align="center"><a href="add_tour_locations.php?id=<?=$fetch['trl_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td width="5%" align="center"><? echo $sch_status; ?></td>
		  </tr>
		  <? 
		  }} else if($sch_count==0){ ?>
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
				<td><? page_Navigation_second($start, $total, $link); ?></td>
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