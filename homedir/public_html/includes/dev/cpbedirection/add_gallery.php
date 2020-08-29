<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('gallery',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}
$img_err_msg='';
if($_SERVER['REQUEST_METHOD']=="POST"){
$name_replace = str_replace("'","&#39;",$_POST['title']);
$place_replace = str_replace("'","&#39;",$_POST['url']);
$regards_replace = str_replace("'","&#39;",$_POST['txtregards']);
$testimonials_replace = str_replace("'","&#39;",$_POST['text_testimonials']);

if($_FILES['upload']['size']>=1 || !empty($_POST['upload'])){ 

	if(($_FILES['upload']['type'] == "image/gif" 
	|| $_FILES['upload']['type'] == "image/png" 
	|| $_FILES['upload']['type'] == "image/jpg"
	|| $_FILES['upload']['type'] == "image/jpeg")){
				
		$file_upload1="../uploads/gallery/".make_filename($_FILES["upload"]["name"]);
		move_uploaded_file($_FILES['upload']['tmp_name'],$file_upload1);
		$file_upload=basename($file_upload1);
			
	}else{
		$img_err_msg = "you have upload 'jpg , jpe , jpeg , gif' images only";
	}}

if($_FILES['upload']['size']==0){ $file_upload=$_POST['hiddenimage'];}

	else if($_FILES['upload']['size']>1){ if(basename($_FILES['upload']['name'])<>$_POST['hiddenimage']){@unlink('../uploads/gallery/'.$_POST['hiddenimage']);}}

if(empty($img_err_msg)&& !empty($_POST['title'])){
	if(!empty($_GET['img_id']))
	{
		$up=mysql_query("update svr_gallery set gal_title='".$name_replace."',gal_url='".$place_replace."',gal_upload='".$file_upload."' where gal_id='".$_GET['img_id']."'");
		header("location:manage_gallery.php");
	}else{
		mysql_query("insert into svr_gallery(
		`gal_title`,`gal_url`,`gal_upload`,`gal_status`,`gal_added_date`) values('".$name_replace."','".$place_replace."','".$file_upload."',1,'".$now_time."')");
		header("location:manage_gallery.php");
	}
}
}

$edit = "Add";
if(!empty($_GET['img_id'])){
	$row = mysql_query("select * from svr_gallery where gal_id='".$_GET['img_id']."'");
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong> <a href="welcome.php">Home</a> &raquo;<?=$edit;?>Gallery</strong></td>
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
                  <td align="right"><a href="manage_gallery.php"><strong>Manage Gallery</strong></a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
                        <td width="2%" rowspan="12" align="left" class="sub_heading_black">&nbsp;</td>
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
                        <td width="24%" class="sub_heading_black"><strong>Tittle <span class="red">*</span></strong></td>
                        <td align="left"><input name="title" type="text" class="input" id="title" size="30"  value="<? if(!empty($_POST['title'])){ echo $_POST['title'];} else if(!empty($_GET['img_id'])){ echo $result['gal_title']; } ?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>URL <span class="red">*</span></strong></td>
                        <td align="left"><input name="url" type="text" class="input" id="url" size="30"  value="<? if(!empty($_POST['url'])){ echo $_POST['url'];} else if(!empty($_GET['img_id'])){ echo $result['gal_url']; } ?>" title="" /></td>
                      </tr>

                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>Image</strong></td>
                        <td align="left"><input type="file" name="upload" id="upload"  >
                          <? if(!empty($_GET['img_id'])){ ?>
                          <input type="hidden" name="hiddenimage" id="hiddenimage" value="<?=$result['gal_upload'];?>" />
                          <a href="javascript:;" onClick="window.open('gallery_image.php?img_id=<?=$result['gal_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=450')"></a>
                          <? }?><br /><span style="font-size:10px;color:#666">Upload width="520" height="283" Only.</span></td>
                      </tr>
                      <tr align="center">
                        <td align="center">&nbsp;</td>
                        <td align="left"><input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" onclick="return check_valid();" /></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form><br /><br /></td>
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
  if(document.getElementById('title').value==''){ alert("Please Enter Tittle"); document.getElementById('tittle').focus(); return false;}
  if(document.getElementById('url').value==''){ alert("Please Enter URL"); document.getElementById('url').focus(); return false;}
  <? if(empty($_GET['img_id'])){ ?>
  if(document.getElementById('upload').value==''){ alert("Please Upload Image"); document.getElementById('upload').focus(); return false;}
<? } ?>
  <? //if(empty($_GET['img_id'])){ ?>
  //if(document.getElementById('image').value==''){ alert("Please upload image"); document.getElementById('image').focus(); return false;}
  <? //} ?>
}
</script>
