<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['to_location_add']) && $_SESSION['to_location_add']=='yes' ) ) ){}else{header("location:welcome.php");}
$img_err_msg='';
if($_SERVER['REQUEST_METHOD']=="POST"){
$name_replace = str_replace("'","&#39;",$_POST['txtname']);
$place_replace = str_replace("'","&#39;",$_POST['txtplace']);
$regards_replace = str_replace("'","&#39;",$_POST['txtregards']);
$testimonials_replace = str_replace("'","&#39;",$_POST['text_testimonials']);

if(!empty($_FILES['image']["size"])){
$imgExtension = array('jpg','jpe','jpeg','gif');
$image_name = pathinfo($_FILES['image']['name']);
$extension = strtolower($image_name['extension']);

//print_r($_FILES);
	if(in_array($extension,$imgExtension)){
		if($_FILES['image']["size"] >1){
		$img=getimagesize($_FILES['image']['tmp_name']);
		$width = $img[0];
		$height= $img[1];

		if($width>=200 && $height>=150){
		$b_image=substr($_FILES['image']['name'],0,strpos($_FILES['image']['name'],'.'));
		$b_image.=time();
		$b_image.=strstr($_FILES['image']['name'],'.'); 	//$b_image.=$_FILES['upload_ban']['name'];	
		$b_image="../uploads/testimonials_images/".$b_image;

		//unlink();	
		if(!empty($_GET['img_id']))
	    {
			$array = query("select test_image from svr_testimonials where test_id='".$_GET['img_id']."'");
			$fetch=fetch_array($array);
			$update = $fetch['test_image'];
			@unlink($update);
		}

		if(!move_uploaded_file($_FILES['image']['tmp_name'],$b_image)) { $b_image=""; }
			chmod($b_image,0777);
			$imagepath=$b_image;
		}else{
			$size_err_msg = "your upload image is greaterthan 200 * 150";
		}
		//echo "Take the image";
		}
		//exit;
	}else{
		$img_err_msg = "you have upload 'jpg , jpe , jpeg , gif' images only";
	}
}elseif(!empty($_POST['old_img'])){
		$imagepath=$_POST['old_img'];
}
if(empty($img_err_msg)&& empty($size_err_msg)){
	if(!empty($_GET['img_id']))
	{
		$up=query("update svr_testimonials set test_name='".$name_replace."',test_place='".$place_replace."',test_regards='".$regards_replace."',test_testimonial='".$testimonials_replace."',test_image='".$imagepath."' where test_id='".$_GET['img_id']."'");
		header("location:manage_testimonials.php");
	}else{
		query("insert into svr_testimonials(
		`test_name`,`test_place`,`test_regards`,`test_testimonial`,`test_image`,`test_status`,`test_added_date`) values('".$name_replace."','".$place_replace."','".$regards_replace."','".$testimonials_replace."','".$imagepath."',1,'".$now_time."')");
		header("location:manage_testimonials.php");
	}
}
}

$edit = "Add";
if(!empty($_GET['img_id'])){
	$row = query("select * from svr_testimonials where test_id='".$_GET['img_id']."'");
	$result = fetch_array($row);
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
                  <?=$edit;?>
                  Testimonials</strong></td>
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
                  <td align="right"><a href="manage_testimonials.php"><strong>Manage Testimonials</strong></a></td>
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
                        <td width="24%" class="sub_heading_black"><strong>Name <span class="red">*</span></strong></td>
                        <? //if(isset($_POST['txtcountry'])) echo $_POST['txtcountry']; else?>
                        <td align="left"><input name="txtname" type="text" class="input" id="txtname" size="30"  value="<? if(!empty($_POST['txtname'])){ echo $_POST['txtname'];} else if(!empty($_GET['img_id'])){ echo $result['test_name']; } ?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>Place <span class="red">*</span></strong></td>
                        <td align="left"><input name="txtplace" type="text" class="input" id="txtplace" size="30"  value="<? if(!empty($_POST['txtplace'])){ echo $_POST['txtplace'];} else if(!empty($_GET['img_id'])){ echo $result['test_place']; } ?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>Regards <span class="red">*</span></strong></td>
                        <td align="left"><input name="txtregards" type="text" class="input" id="txtregards" size="30"  value="<? if(!empty($_POST['txtregards'])){ echo $_POST['txtregards'];} else if(!empty($_GET['img_id'])){ echo $result['test_regards']; } ?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="24%" valign="top" class="sub_heading_black"><strong>Testimonial <span class="red">*</span></strong></td>
                        <td align="left"><textarea name="text_testimonials" cols="50" rows="5" id="text_testimonials"><? if(!empty($_POST['text_testimonials'])){ echo $_POST['text_testimonials'];} else if(!empty($_GET['img_id'])){ echo $result['test_testimonial'];} ?>
</textarea></td>
                      </tr>
                      <tr>
                        <td width="24%" class="sub_heading_black"><strong>Image</strong></td>
                        <td align="left"><input type="file" name="image" id="image" multiple="multiple" >
                          <? if(!empty($_GET['img_id'])){ ?>
                          <input type="hidden" name="old_img" id="old_img" value="<?=$result['test_image'];?>" />
                          <a href="javascript:;" onClick="window.open('testimonial_image.php?img_id=<?=$result['test_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=450')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
                          <? }?></td>
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
  if(document.getElementById('txtname').value==''){ alert("Please Enter Your Name"); document.getElementById('txtname').focus(); return false;}
  if(document.getElementById('txtplace').value==''){ alert("Please Enter Your Place"); document.getElementById('txtplace').focus(); return false;}
  if(document.getElementById('txtregards').value==''){ alert("Please Enter Regards Name"); document.getElementById('txtregards').focus(); return false;}
  if(document.getElementById('text_testimonials').value==''){ alert("Please Enter Your Testimonial"); document.getElementById('text_testimonials').focus(); return false;}
  <? //if(empty($_GET['img_id'])){ ?>
  //if(document.getElementById('image').value==''){ alert("Please upload image"); document.getElementById('image').focus(); return false;}
  <? //} ?>
}
</script>
