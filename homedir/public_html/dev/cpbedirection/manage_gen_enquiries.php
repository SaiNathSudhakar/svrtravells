<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('enq',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

$page_query = query("select genq_id from svr_gen_enquiries");
$total=num_rows($page_query);
$len=10; $start=0;
$link="manage_gen_enquiries.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
			
$result = query("select * from svr_gen_enquiries where 1 order by genq_id desc limit $start,$len");
$count_order=num_rows($result);

if(!empty($_GET['del'])){
	query("delete from svr_gen_enquiries where genq_id='".$_GET['del']."'");
	header("location:manage_gen_enquiries.php?msg=del");
}
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	query("update svr_gen_enquiries set enq_status=".$status." where genq_id='".$_GET['sid']."'");
	header("location:manage_gen_enquiries.php");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage General Enquiries</strong></td>
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
              <td align="right"><!--<a href="add_cms.php"><strong>Add CMS</strong></a>--></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="4%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td width="18%" class="tablehead"><strong>Name</strong></td>
					<td width="12%"class="tablehead"><strong>Phone</strong></td>
					<td width="12%"class="tablehead"><strong>E-Mail</strong></td>
					<td width="11%"class="tablehead"><strong>Area of Interest</strong></td>
					<td width="15%"class="tablehead"><strong>Enquiry</strong></td>
                    <td width="7%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
<!--<td width="7%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
-->                  </tr>
                </thead>
                <?php
		if($count_order>0)
		{
		$sno=$start;
		while($fetch=fetch_array($result))
			{ $sno++;
			
			if($fetch['enq_status']==1){
				$f_status ='<a href="manage_gen_enquiries.php?sid='.$fetch["genq_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['enq_status']==0){
				$f_status='<a href="manage_gen_enquiries.php?sid='.$fetch["genq_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}		
			?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><?=to_title_case($fetch['genq_name']);?></td>
				  <td align="left"><?=$fetch['genq_phone']?></td>
				  <td align="left"><?=$fetch['genq_email']?></td>
				  <td align="left"><?=$fetch['genq_area_interest']?></td>
				  <td align="left"><?=$fetch['genq_enquiry']?></td>
                  <td width="7%" align="center"><a href="javascript:;" onclick="popupwindow('view_gen_enquiry.php?genq_id=<?=$fetch['genq_id']?>', 'Title', '750', '550');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
<!--<td width="7%" align="center"><? echo $f_status; ?></td>
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