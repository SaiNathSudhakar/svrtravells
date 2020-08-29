<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcatm',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

if(!empty($_GET['f_status'])){
if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
mysql_query("update svr_fare_category set fc_status=".$status." where fc_id='".$_GET['f_id']."'");
header("location:manage_fare_category.php");
}
$page_query = mysql_query("select fc_id from svr_fare_category");
$total=mysql_num_rows($page_query);

$len=30; $start=0;
$link="manage_fare_category.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$result = mysql_query("select fc_id, fc_type, fc_locations, fc_name, fc_orderby, fc_status, fc_dateadded, cat_id, cat_name, group_concat(tloc_name order by tloc_orderby) as to_locations, concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle from svr_fare_category as fc 
left join svr_categories cat on cat.cat_id = fc.fc_type
	left join svr_to_locations as tloc on CONCAT(',', fc.fc_locations, ',') LIKE CONCAT('%,', tloc.tloc_id, ',%')
		 left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
			left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
				left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
					group by fc.fc_id order by fc_orderby desc limit $start, $len");
$sch_count = mysql_num_rows($result); 

//ORDER BY
if(!empty($_GET['id']) && !empty($_GET['stat']) && !empty($_GET['poss']))
{	
	$poss1 = $_GET['poss'];
	if($_GET['stat']=='up'){ $poss2=$poss1+1; }else if($_GET['stat']=='down'){ $poss2=$poss1-1; }
	$pos1id=getdata("svr_fare_category","fc_id","fc_orderby='".$poss1."'");
	$pos2id=getdata("svr_fare_category","fc_id","fc_orderby='".$poss2."'"); 
	mysql_query("update svr_fare_category set fc_orderby='".$poss2."' where fc_id='".$pos1id."'");
	mysql_query("update svr_fare_category set fc_orderby='".$poss1."' where fc_id='".$pos2id."'");
	header("location:manage_fare_category.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/script.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"><a href="welcome.php">Home</a> &raquo; Manage Fare Category</strong></td>
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
				<td align="right"><a href="add_fare_category.php"><strong>Add Fare Category</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="12%" class="tablehead">Type</td>
			<td width="20%" class="tablehead">Category </td>
			<td class="tablehead">Locations  </td>
			<td class="tablehead">Orderby</td>
			<td width="10%" align="center" class="tablehead">Date Added</td>
			<td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
		   $sno = $start; if($sch_count>0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['fc_status']==1){
				$sch_status ='<a href="manage_fare_category.php?f_id='.$fetch["fc_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
			}else if($fetch['fc_status']==0){
				$sch_status='<a href="manage_fare_category.php?f_id='.$fetch["fc_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
			<td width="5%" height="25" align="left"><?=$sno;?></td>
			<td width="12%" align="left"><?=$fetch['cat_name'];?></td>
			<td width="20%" align="left"><?=($fetch['cat_id'] == 1) ? $fetch['fc_name'] : $fetch['vehicle'];?></td>
			<td align="left" title="<?=$fetch['to_locations']?>"><? $locat = (strlen($fetch['to_locations']) > 70) ? substr($fetch['to_locations'], 0, 70).'...' : $fetch['to_locations']; echo ucwords(strtolower($locat)); ?></td>
			<td align="left">
			  <table border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <? if($sno != 1){ ?>
				  <td align="left" valign="middle">
				  <a href="manage_fare_category.php?stat=up&id=<?=$fetch['fc_id']?>&poss=<?=$fetch['fc_orderby']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/uparrow.png" alt="move down" width="16" height="16" border="0" title="Click to move Up"></a></td>
				  <? } else { echo "<td align='right' valign='bottom' width='16'>&nbsp;</td>"; } 
				  if($sno != $total){ ?>
				  <td align="right" valign="middle">
				  <a href="manage_fare_category.php?stat=down&id=<?=$fetch['fc_id']?>&poss=<?=$fetch['fc_orderby']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/downarrow.png" alt="move up" width="16" height="16" border="0"title="Click to move Down"></a></td>
				  <? } else { echo "<td align='left' valign='bottom' width='16'>&nbsp;</td>"; } ?>
				  <td align="right" valign="middle"><strong><?=$fetch['fc_orderby']?></strong></td>
				</tr>
			  </table>			</td>
			<td width="10%" align="center"><?=date('d-m-Y', strtotime($fetch['fc_dateadded']));?></td>
			<td width="5%" align="center"><a href="javascript:;" onClick="popupwindow('view_fare_category.php?id=<?=$fetch['fc_id']?>', 'Title', '750', '500')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<td width="5%" align="center"><a href="add_fare_category.php?f_id=<?=$fetch['fc_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td width="5%" align="center"><? echo $sch_status; ?></td>
		  </tr>
		  <? 
		  }} else if($sch_count==0){ ?>
		  <tr><td colspan="17" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
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