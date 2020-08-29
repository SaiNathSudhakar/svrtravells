<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('gallerym',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

if(!empty($_GET['t_status'])){
	if($_GET['t_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_gallery set gal_status=".$status." where gal_id='".$_GET['sid']."'");
	header("location:manage_gallery.php");
}

$page_query = mysql_query("select gal_id from svr_testimonials");
$total=mysql_num_rows($page_query);

$len=10; $start=0;
$link="manage_gallery.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$page_query = mysql_query("select gal_id from svr_gallery");
$total=mysql_num_rows($page_query);

$result = mysql_query("select * from svr_gallery order by gal_id desc limit $start,$len");
$count_order = mysql_num_rows($result);

if(!empty($_GET['del'])){
	$del = "../uploads/gallery/".$_GET['img'];
	@unlink($del);
	
	mysql_query("delete from svr_gallery where gal_id='".$_GET['del']."'");
	header("location:manage_gallery.php");
}
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
    <td valign="top" bgcolor="#FFFFFF">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><img src="images/spacer.gif" border="0" height="5" /></td>
		</tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Gallery  </strong></td>
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
				<td align="right"><a href="add_gallery.php"><strong>Add Gallery</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="5%" class="tablehead">&nbsp;</td>
			<td class="tablehead">Tittle</td>
			<td class="tablehead"><strong>URL</strong></td>
			<td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
			
		   $sno = $start; if($count_order>0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['gal_status']==1){
				$t_status ='<a href="manage_gallery.php?sid='.$fetch["gal_id"].'&t_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="Click to In-Active" alt="Click to In-Active" /></a>';
			}else if($fetch['gal_status']==0){
				$t_status='<a href="manage_gallery.php?sid='.$fetch["gal_id"].'&t_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="Click to Active" alt="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td width="5%" align="left">
			<? $path = $site_url."uploads/gallery/"; ?>
			<? $image = ($fetch['gal_upload'] != '') ? $path.$fetch['gal_upload'] : $default_thumb;?>
			<a href="<?=$image;?>"><img src="<?=$image;?>" height="50" width="50" border="0" /></a>
			</td>
			<td align="left"><?=$fetch['gal_title'];?></td>
			<td align="left"><?=$fetch['gal_url'];?></td>
			<td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_gallery.php?img_id=<?=$fetch['gal_id'];?>','no','scrollbars=yes,menubar=no,width=650,height=450')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<td width="5%" align="center"><a href="add_gallery.php?img_id=<?=$fetch['gal_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td width="5%" align="center"><? echo $t_status; ?></td>
			<td width="5%" align="center" onclick="return confirm('Do You Want To Delete This Record?');"><a href="manage_gallery.php?del=<?=$fetch['gal_id'];?>&img=<?=$fetch['gal_upload'];?>"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></a></td>
		  </tr>
		  <? 
		  }} else if($count_order==0){ ?>
		  <tr><td colspan="13" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
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