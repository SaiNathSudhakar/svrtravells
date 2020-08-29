<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('cmsm',$_SESSION['tm_priv']) ) ) ){}else{header("location:welcome.php");}

$page_query = query("select subcat_id from svr_subcategories");
$total=num_rows($page_query);
$len=10; $start=0;
$link="manage_subcat_keywords.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
			//echo "select tloc_name, tloc_meta_title, tloc_meta_description,tloc_meta_keywords from svr_to_locations where 1 order by tloc_id desc limit $start,$len";exit;
$result = query("select subcat_id, subcat_name, subcat_meta_title  from svr_subcategories where 1 order by subcat_id desc limit $start,$len");
$count_order=num_rows($result);



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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Subcategories Keywords</strong></td>
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
              <td align="left"><h1>Subcategories Keywords</h1></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td class="tablehead"><strong>Location</strong></td>
					<td class="tablehead"><strong>Meta Title</strong></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
                  </tr>
                </thead>
                <?php
		if($count_order>0)
		{
		$sno=$start;
		while($fetch=fetch_array($result))
			{ $sno++;
		
			?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><a href="../destination.php?sid=<?=$fetch['subcat_id'];?>" target="_blank"><?=$fetch['subcat_name'];?></a></td>
				  <td align="left"><?=$fetch['subcat_meta_title'];?></td>
                  <td width="5%" align="center"><a href="javascript:;" onclick="popupwindow('view_subcat_keywords.php?key_id=<?=$fetch['subcat_id'];?>','','650','450')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                  <td width="5%" align="center"><a href="add_subcat_keywords.php?meta_id=<?=$fetch['subcat_id'];?><? if(!empty($_GET['start'])){echo "&start=".$_GET['start'];}?>">
				  <img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
                </tr>
                <?
			}
		}
		  else if($count_order==0)
		  {
		  ?>
                <tr>
                  <td colspan="6" height="150" align="center" bgcolor="#CCC">No Records Found</td>
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