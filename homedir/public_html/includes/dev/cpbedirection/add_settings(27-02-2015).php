<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['to_location_add']) && $_SESSION['to_location_add']=='yes' ) ) ){}else{header("location:welcome.php");}

$img_err_msg='';
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$title_replace = str_replace("'","&#39;",$_POST['title']);
	$description_replace = str_replace("'","&#39;",$_POST['description']);
	
	if(empty($img_err_msg)&& empty($size_err_msg))
	{
		if(!empty($_GET['img_id']))
		{
			$up=mysql_query("update svr_settings set sett_title='".$title_replace."',sett_description='".$description_replace."' where sett_id='".$_GET['img_id']."'");
			header("location:manage_settings.php");
		}else{
			mysql_query("insert into svr_settings(`sett_title`,`sett_description`,`sett_status`,`sett_added_date`) values('".$title_replace."','".$description_replace."','".$imagepath."',1,'".$now_time."')");
			header("location:manage_settings.php");
		}
	}
}
$edit = "Add";
if(!empty($_GET['img_id'])){
	$row = mysql_query("select * from svr_settings where sett_id='".$_GET['img_id']."'");
	$result = mysql_fetch_array($row);
$edit = "Update";
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong> <a href="welcome.php">Home</a> &raquo;
                  <?=$edit;?> Settings</strong></td>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td valign="top" class="grn_subhead" align="right"></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
              <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="right"><a href="manage_settings.php"><strong>Manage Settings</strong></a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
                        <td width="2%" rowspan="9" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="24%" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="74%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                      </tr>
                      <? if(!empty($size_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong>
                          <?=$size_err_msg;?>
                          </strong></td>
                      </tr>
                      <? }if(!empty($img_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong>
                          <?=$img_err_msg;?>
                          </strong></td>
                      </tr>
                      <? }?>
                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>Title <span class="red">*</span></strong></td>
                        <? //if(isset($_POST['txtcountry'])) echo $_POST['txtcountry']; else?>
                        <td align="left"><input name="title" type="text" class="input" id="title" size="30"  value="<? if(!empty($_POST['title'])){ echo $_POST['title'];} else if(!empty($_GET['img_id'])){ echo $result['sett_title']; } ?>" title="" /></td>
                      </tr>
                      
                      <tr>
                        <td width="24%" valign="top" class="sub_heading_black"><strong>Description<span class="red">*</span></strong></td>
                        <td align="left"><textarea name="description" cols="50" rows="5" id="description"><? if(!empty($_POST['description'])){ echo $_POST['description'];} else if(!empty($_GET['img_id'])){ echo $result['sett_description'];} ?>
</textarea></td>
                      </tr>
                      
                      <tr align="center">
                        <td align="center">&nbsp;</td>
                        <td align="left"><input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" onclick="return check_valid();" /></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
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
  if(document.getElementById('title').value==''){ alert("Please Enter Title"); document.getElementById('title').focus(); return false;}
  if(document.getElementById('description').value==''){ alert("Please Enter Description"); document.getElementById('description').focus(); return false;}
  <? //if(empty($_GET['img_id'])){ ?>
  //if(document.getElementById('image').value==''){ alert("Please upload image"); document.getElementById('image').focus(); return false;}
  <? //} ?>
}
</script>
