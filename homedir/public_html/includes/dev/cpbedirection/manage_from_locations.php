<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('floc',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST"){
$replace = str_replace("'","&#39;",$_POST['txtlocation']);
	if(!empty($_GET['id'])){
		$update = mysql_query("update svr_from_locations set floc_name='".$replace."',floc_code='".$_POST['txtcode']."' where floc_id='".$_GET['id']."'");
		header("location:manage_from_locations.php");
	}else{
		mysql_query("insert into svr_from_locations(floc_name,floc_code,floc_status,floc_dateadded) values('".$replace."','".$_POST['txtcode']."',1,'".$now_time."')");
		header("location:manage_from_locations.php");
	}
}
if(!empty($_GET['id'])){
	$row = mysql_query("select * from svr_from_locations where floc_id='".$_GET['id']."'");
	$row_result = mysql_fetch_array($row);
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage From Locations</strong></td>

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
<form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
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
                              <td align="left" class="sub_heading_black"><strong>From Location <span class="red">*</span></strong></td>
                              <td align="left"><input name="txtlocation" type="text" class="input" id="txtlocation" title=""  value="<? if(!empty($_GET['id'])) echo $row_result['floc_name'];?>" size="30" maxlength="99" /></td>
                            </tr>
                            
                            <!--<tr align="center">
                              <td align="left" class="sub_heading_black"><strong>Location Code <span class="red">*</span></strong></td>
                              <td align="left"><input name="txtcode" type="text" class="input" id="txtcode" size="30"  value="<? //if(!empty($_GET['id'])) echo $row_result['floc_code'];?>" title="" /></td>
                            </tr>-->
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  
							  <input type="submit" name="Submit" id="Submit" value=" <? if(!empty($_GET['id'])){ echo "Update";} else{ echo "Add";} ?> " class="btn_input" onclick="return check_valid();" /></td>
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
			<td class="tablehead"><strong>From Location</strong></td>
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
			mysql_query("update svr_from_locations set floc_status=".$status." where floc_id='".$_GET['sid']."'");
			header("location:manage_from_locations.php");
			}

			  $result = mysql_query("select * from svr_from_locations");
			  $count_order = mysql_num_rows($result);
			  $sno = 0; if($count_order>0){
			  while($fetch=mysql_fetch_array($result)){
			  $sno++;
			  
			  
			if($fetch['floc_status']==1){
				$f_status ='<a href="manage_from_locations.php?sid='.$fetch["floc_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['floc_status']==0){
				$f_status='<a href="manage_from_locations.php?sid='.$fetch["floc_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}

		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?></td>
			<td align="left"><?=$fetch['floc_name'];?></td>
			<td width="5%" align="center"><a href="manage_from_locations.php?id=<?=$fetch['floc_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
			<td width="5%" align="center"><? echo $f_status; ?></td>
		  </tr>
		  <? 
		  }}
		  else if($count_order==0){?>
		  <tr><td colspan="10" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
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
  if(document.getElementById('txtlocation').value==''){ alert("Please enter your location"); document.getElementById('txtlocation').focus(); return false;}
  /*if(document.getElementById('txtcode').value==''){ alert("Please enter location code"); document.getElementById('txtcode').focus(); return false;}*/
}
</script>