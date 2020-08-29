<?
ob_start();
//session_start();
include_once("login_chk.php");
include_once("../includes/functions.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('footer',$_SESSION['tm_priv']) ) ) ){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST"){
	if(!empty($_GET['id'])){
		query("update `svr_footer` set f_desc='".$_POST['desc']."' where f_id='".$_GET['id']."'");
		header("location:footer_manage.php?msg=up");
	} else {
		query("insert into `svr_footer`(`f_id`,`f_desc`,`f_status`,`f_dateadded`)
		values('','".$_POST['desc']."','','".$now."')");
		header("location:footer_manage.php?msg=ad");
	}
}
//Suspend Record :
if(!empty($_GET['cn'])){
	if($_GET['cn']==1) {$con=1; } else { $con=0; } 
	query("update `svr_footer` set f_status='".$con."' where f_id='".$_GET['cid']."' ");
	header("location:footer_manage.php?msg=sts");
}
	
if(!empty($_GET['id'])){
	$qur_edit=query("select * from `svr_footer` where f_id='".$_GET['id']."'");
	$row_edit=fetch_array($qur_edit);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Footer Management </strong></td>
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
			<form action="" method="post" name="footer_mgnt" id="footer_mgnt">
			    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="4" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Footer Text<span class="red"> *</span></strong></td>
                              <td align="left"><textarea name="desc" cols="60" rows="5" class="box" id="desc"><? if(isset($_POST['desc'])){ echo $_POST['desc']; }else if(!empty($_GET['id'])){ echo $row_edit['f_desc'];}?></textarea></td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  
							  <input type="submit" name="Submit" id="Submit" value=" <? if(!empty($_GET['id'])){ echo "Edit";} else{ echo "Add";} ?> " class="btn_input" onclick="return check_valid();" /></td>
                            </tr>
                    </table>
					</td>
                  </tr>
              </table></form>
		  </td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>

		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td class="tablehead"><span class="sub_heading_black">Footer Text</span></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
			<? }?>
		  </tr>
		  </thead>
		  <?php
			if(!empty($_GET['f_status'])){
				if($_GET['f_status']=="active")
				{
					$status=1;
				}else{
					$status=0;
				}
			query("update svr_footer set f_status=".$status." where f_id='".$_GET['sid']."'");
			header("location:footer_manage.php");
			}

			  $qur=query("select * from `svr_footer`");
			  $cnt=num_rows($qur);
			  $i = 0; if($cnt>0){
			  while($row=fetch_array($qur)){
			  $i++;
			  
			if($row['f_status']==1){
				$f_status ='<a href="footer_manage.php?sid='.$row["f_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($row['f_status']==0){
				$f_status='<a href="footer_manage.php?sid='.$row["f_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($i%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$i;?>.</td>
			<td align="left"><?=$row['f_desc'];?></td>
			<td width="5%" align="center"><a href="footer_manage.php?id=<?=$row['f_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
			<td width="5%" align="center"><? echo $f_status; ?></td>
		  </tr>
		  <? 
		  }}
		  else if($cnt==0){?>
		  <tr><td height="50" colspan="10" align="center" bgcolor="#CCC" class="red">No Records Found</td>
		  </tr>
		  <? } ?>
		  </table></td>
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
<script type="text/javascript">
function check_valid()
{
  if(document.getElementById('desc').value==''){ alert("Please Enter Footer Description"); document.getElementById('desc').focus(); return false;}
}
</script>