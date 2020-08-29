<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('packm',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if(!empty($_GET['p_status'])){
	if($_GET['p_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_packages set pkg_status=".$status." where pkg_id='".$_GET['sch_id']."'");
	header("location:manage_packages.php");
}
$page_query = mysql_query("select pkg_id from svr_packages");
$total=mysql_num_rows($page_query);
$len=30; $start=0;
$link="manage_packages.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

$result = mysql_query("select pkg_id, pkg_status, pkg_date, pkg_seats_available, tloc_name, floc_name, tloc_code, cat_name from svr_packages as pkg
left join svr_categories as cat on cat.cat_id = 1
	left join svr_to_locations as tloc on tloc.tloc_id = pkg.pkg_to_id
		left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id
			order by pkg_id desc limit $start, $len");
$sch_count = mysql_num_rows($result);
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
			  <td valign="middle" width="50%">
			  	<img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Packages</strong>
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
				<td align="right"><a href="add_packages.php"><strong>Add Package</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="15%" class="tablehead">Type</td>
			<td width="" class="tablehead">From Location </td>
			<td class="tablehead">Destination Location </td>
			<td width="10%" class="tablehead"><strong>Package Date </strong></td>
			<td width="10%" class="tablehead">Seats Available</td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
		   $sno = $start; if($sch_count>0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['pkg_status']==1){
				$sch_status ='<a href="manage_packages.php?sch_id='.$fetch["pkg_id"].'&p_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
			}else if($fetch['pkg_status']==0){
				$sch_status='<a href="manage_packages.php?sch_id='.$fetch["pkg_id"].'&p_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
			} 
			$class = ($sno % 2 == 0) ? 'tablerow2' : 'tablerow1';
			$class = (dateDiff(date('Y-m-d'), $fetch['pkg_date']) < 0) ? "tablerowerr" : $class;
			$title = (dateDiff(date('Y-m-d'), $fetch['pkg_date']) < 0) ? "Package Expired" : ''; ?>
		  <tr class="<?=$class;?>" title="<?=$title;?>">
			<td height="25" align="left"><?=$sno;?></td>
			<td align="left"><?=$fetch['cat_name'];?></td>
			<td align="left"><?=$fetch['floc_name']; ?></td>
			<td align="left"><?=$fetch['tloc_name'].' ('.$fetch['tloc_code'].')'; ?></td>
			<td align="left"><?=date('d-m-Y', strtotime($fetch['pkg_date'])); ?></td>
			<td align="left"><?=array_sum(explode('|', $fetch['pkg_seats_available']));?></td>
			<td align="center"><a href="add_packages.php?p_id=<?=$fetch['pkg_id'];?>">
			<img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td align="center"><? echo $sch_status; ?></td>
		  </tr>
		  <? }} else if($sch_count==0){ ?>
		  <tr><td colspan="14" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
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