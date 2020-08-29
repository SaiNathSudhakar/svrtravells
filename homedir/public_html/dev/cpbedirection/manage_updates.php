<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('updatesm',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

$page_query = query("select up_id from svr_latest_updates");
$total=num_rows($page_query);
$len=10; $start=0;
$link="manage_updates.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
			
$result = query("select * from svr_latest_updates where 1 order by up_id desc limit $start,$len");
$count_order=num_rows($result);
if(!empty($_GET['id']))
{
	query("update svr_latest_updates set up_status=".$_GET['status']." where up_id='".$_GET['id']."'");	
	header("location:manage_updates.php?msg=sts");
}
if(!empty($_GET['del'])){
query("delete from svr_latest_updates where up_id='".$_GET['del']."'");
header("location:manage_updates.php?msg=del");
}
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	query("update svr_latest_updates set up_status=".$status." where up_id='".$_GET['sid']."'");
	header("location:manage_updates.php");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage  CMS</strong></td>
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
		  <td valign="top"><table width="95%" border="0" align="center" cellpadding="6" cellspacing="0">
            <tr>
              <td align="right"><a href="add_updates.php"><strong>Add Updates</strong></a></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td class="tablehead"><strong>Title</strong></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
-->                  </tr>
                </thead>
                <?php
		if($count_order>0)
		{
		$sno=$start;
		while($fetch=fetch_array($result))
			{ $sno++;
			
			if($fetch['up_status']==1){
				$f_status ='<a href="manage_updates.php?sid='.$fetch["up_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['up_status']==0){
				$f_status='<a href="manage_updates.php?sid='.$fetch["up_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
			?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><?=$fetch['up_title'];?></td>
                  <td width="5%" align="center"><a href="javascript:;" onclick="popupwindow('view_updates.php?update_id=<?=$fetch['up_id'];?>','Title','650','550')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                  <td width="5%" align="center"><a href="add_updates.php?id=<?=$fetch['up_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
<!--<td width="5%" align="center"><? echo $f_status; ?></td>
-->                </tr>
                <?
			}
		}
		  else if($count_order==0)
		  {
		  ?>
                <tr>
                  <td colspan="11" height="150" align="center" bgcolor="#CCC">No Records Found</td>
                </tr>
                <? } ?>
              </table></td>
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