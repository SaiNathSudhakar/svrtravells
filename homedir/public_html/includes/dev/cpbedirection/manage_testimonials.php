<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['to_location_manage']) && $_SESSION['to_location_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

if(!empty($_GET['t_status'])){
	if($_GET['t_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_testimonials set test_status=".$status." where test_id='".$_GET['sid']."'");
	header("location:manage_testimonials.php");
}

$page_query = mysql_query("select test_id from svr_testimonials");
$total=mysql_num_rows($page_query);

$len=10; $start=0;
$link="manage_testimonials.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$page_query = mysql_query("select test_id from svr_testimonials");
$total=mysql_num_rows($page_query);

$result = mysql_query("select * from svr_testimonials order by test_id desc limit $start,$len");
$count_order = mysql_num_rows($result);

if(!empty($_GET['del'])){
	$array = mysql_query("select test_image from svr_testimonials where test_id='".$_GET['del']."'");
	$fetch = mysql_fetch_array($array);
	$del = $fetch['test_image'];
	@unlink($del);
	
	mysql_query("delete from svr_testimonials where test_id='".$_GET['del']."'");
	header("location:manage_testimonials.php");
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
    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td><img src="images/spacer.gif" border="0" height="5" /></td>
		</tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr>
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage   Testimonials  </strong></td>
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
				<td align="right"><a href="add_testimonials.php"><strong>Add Testimonials</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td class="tablehead">Name</td>
			<td class="tablehead"><strong>Place</strong></td>
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
			if($fetch['test_status']==1){
				$t_status ='<a href="manage_testimonials.php?sid='.$fetch["test_id"].'&t_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="Click to In-Active" alt="Click to In-Active" /></a>';
			}else if($fetch['test_status']==0){
				$t_status='<a href="manage_testimonials.php?sid='.$fetch["test_id"].'&t_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="Click to Active" alt="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=$fetch['test_name'];?></td>
			<td align="left"><?=$fetch['test_place'];?></td>
			<td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_testimonials.php?img_id=<?=$fetch['test_id'];?>','no','scrollbars=yes,menubar=no,width=650,height=450')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<td width="5%" align="center"><a href="add_testimonials.php?img_id=<?=$fetch['test_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td width="5%" align="center"><? echo $t_status; ?></td>
			<td width="5%" align="center" onclick="return confirm('Do You Want To Delete This Record?');"><a href="manage_testimonials.php?del=<?=$fetch['test_id'];?>"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></a></td>
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