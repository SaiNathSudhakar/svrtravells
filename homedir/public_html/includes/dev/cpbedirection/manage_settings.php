<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('settm',$_SESSION['tm_priv']) ) ) ){}else{header("location:welcome.php");}
if(!empty($_GET['del'])){
	mysql_query("delete from svr_settings where sett_id='".$_GET['del']."'");
	header("location:manage_settings.php");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Settings  </strong></td>
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
				<td align="right"><a href="add_settings.php"><strong>Add Settings</strong></a></td>
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td class="tablehead">Title</td>
			<td class="tablehead"><strong>Description</strong></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
			if(!empty($_GET['t_status'])){
			if($_GET['t_status']=="active")
			{
				$status=1;
			}else{
				$status=0;
			}
			mysql_query("update svr_settings set sett_status=".$status." where sett_id='".$_GET['sid']."'");
			header("location:manage_settings.php");
			}
			
		   $result = mysql_query("select * from svr_settings order by sett_id desc");
		   $count_order = mysql_num_rows($result);
		   $sno = 0; if($count_order>0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['sett_status']==1){
				$t_status ='<a href="manage_settings.php?sid='.$fetch["sett_id"].'&t_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="Click to In-Active" alt="Click to In-Active" /></a>';
			}else if($fetch['sett_status']==0){
				$t_status='<a href="manage_settings.php?sid='.$fetch["sett_id"].'&t_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="Click to Active" alt="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=$fetch['sett_title'];?></td>
			<td align="left"><?=$fetch['sett_description'];?></td>
			<td width="5%" align="center"><a href="add_settings.php?img_id=<?=$fetch['sett_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<td width="5%" align="center"><? echo $t_status; ?></td>
			<td width="5%" align="center" onclick="return confirm('Do You Want To Delete This Record?');"><a href="manage_settings.php?del=<?=$fetch['sett_id'];?>"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></a></td>
		  </tr>
		  <? 
		  }} else if($count_order==0){ ?>
		  <tr><td colspan="12" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
		  <? } ?>
		  </table>
		  </td>
			  </tr>
			</table>
		  </td>
		</tr>
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