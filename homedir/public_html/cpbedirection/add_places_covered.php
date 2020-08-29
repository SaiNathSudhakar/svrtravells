<?
ob_start();
//session_start();
//include_once("login_chk.php");
include_once("../includes/functions.php");

//if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['places_covered_add']) && $_SESSION['places_covered_add']=='yes' ) ) ){}else{header("location:welcome.php");}

$img_err_msg1='';
$img_err_msg='';

if($_SERVER['REQUEST_METHOD']=="POST"){

$place_name = str_replace("'","&#39;",$_POST['txt_cov_places']);
$small_desc = str_replace("'","&#39;",$_POST['text_small_desc']);
$large_desc = str_replace("'","&#39;",$_POST['text_large_desc']);

if(!empty($_FILES['image1']["size"])){  
$imgExtension1 = array('jpg','jpe','jpeg','gif');
$image_name1 = pathinfo($_FILES['image1']['name']);
$extension1 = strtolower($image_name1['extension']);

$ref_no = (empty($_GET['p_id'])) ? rand(100000, 999999) : getdata("svr_places_covered",'place_ref_no', "place_id=".$_GET['p_id']);	
$path = "../uploads/places_covered/".$ref_no."/";
if(!file_exists($path))	@mkdir($path, 0777, true);
//print_r($_FILES);
	if(in_array($extension1,$imgExtension1)){
		if($_FILES['image1']["size"] >1){
		$img1=getimagesize($_FILES['image1']['tmp_name']);
		 $width1 = $img1[0];
		 $height1= $img1[1];

		if($width1>=100 && $height1>=99){
		$b_image1=substr($_FILES['image1']['name'],0,strpos($_FILES['image1']['name'],'.'));
		$b_image1.=time();
		$b_image1.=strstr($_FILES['image1']['name'],'.'); 	//$b_image.=$_FILES['upload_ban']['name'];	
		//$b_image1="../uploads/place_cover_images_thumb/".$b_image1;
		
		if(!empty($_GET['p_id']))
	     {
     	 $array1 = query("select place_thumb from svr_places_covered where place_id='".$_GET['p_id']."'");
		 $fetch1=fetch_array($array1);
		 $update1 = $path.$fetch1['place_thumb'];
		 @unlink($update1);
		 }
		//unlink();	

		if(!move_uploaded_file($_FILES['image1']['tmp_name'],$path.$b_image1)) { $b_image1=""; }
		chmod($b_image1,0777);
		$image_thumb=$b_image1;
		}else{
		$size_err_msg1 = "your upload image is greaterthan 100 * 100";
		}
		//echo "Take the image";
		}
		//exit;
	}else{
		$img_err_msg1 = "you have upload 'jpg , jpe , jpeg , gif' images only";
	}
}elseif(!empty($_POST['old_img1'])){
		$image_thumb=$_POST['old_img1'];
		}
		
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
		//$b_image="../uploads/place_cover_images/".$b_image;
		
		if(!empty($_GET['p_id'])) {
     	 $array = query("select place_bigimage from svr_places_covered where place_id='".$_GET['p_id']."'");
		 $fetch=fetch_array($array);
		 $update = $path.$fetch['place_bigimage'];
		 @unlink($update);
		 }
		//unlink();	
		
		if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { $b_image=""; }
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

if(empty($img_err_msg) && empty($size_err_msg) && empty($img_err_msg1) && empty($size_err_msg1))
{
	if(!empty($_GET['p_id']))
	{
	$up=query("update svr_places_covered set tloc_id_fk='".$_POST['dest_name']."',place_name='".$place_name."',place_thumb='".$image_thumb."',place_small_desc='".$small_desc."',place_bigimage='".$imagepath."',place_large_desc='".$large_desc."' where place_id='".$_GET['p_id']."'");
	header("location:manage_places_covered.php");
	}else{
	//echo "insert into svr_places_covered(tloc_id_fk,place_name,place_thumb,place_small_desc,place_bigimage,place_large_desc,place_status,place_dateadded) values('".$_POST['dest_name']."','".$place_name."','".$image_thumb."','".$small_desc."','".$imagepath."','".$large_desc."',1,'".$now_time."')";exit;
	query("insert into svr_places_covered(tloc_id_fk,place_name,place_thumb,place_small_desc,place_bigimage,place_large_desc,place_status,place_dateadded) values('".$_POST['dest_name']."','".$place_name."','".$image_thumb."','".$small_desc."','".$imagepath."','".$large_desc."',1,'".$now_time."')");
	 header("location:manage_places_covered.php");
	}
}
}

$edit = "Add";
if(!empty($_GET['p_id'])){
	$row = query("select * from svr_places_covered where place_id='".$_GET['p_id']."'");
	$result = fetch_array($row);
	$path = "../uploads/places_covered/".$result['place_ref_no']."/";
$edit = "Edit";
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo;
                  <?=$edit;?>
                  Places Covered </strong></td>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
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
                  <td align="right"><a href="manage_places_covered.php"><strong>Manage Places Covered</strong></a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
                        <td width="2%" rowspan="12" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                      </tr>
                      <? if(!empty($size_err_msg1)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$size_err_msg1;?></strong></td>
                      </tr>
                      <? }if(!empty($img_err_msg1)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$img_err_msg1;?></strong></td>
                      </tr>
                      <? }if(!empty($size_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$size_err_msg;?></strong></td>
                      </tr>
                      <? }if(!empty($img_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$img_err_msg;?></strong></td>
                      </tr>
                      <? }?>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                        <td align="left"><select name="dest_name" id="dest_name">
                            <option value="">--- Select ---</option>
                            <?
							  $dest_name = query("select * from svr_to_locations where tloc_status=1 order by tloc_id desc");
							  while($dest_fetch = fetch_array($dest_name)){	
							?>
                            <option value="<?=$dest_fetch['tloc_id'];?>"
							<? if(!empty($_POST['dest_name']) && $_POST['dest_name']==$dest_fetch['tloc_id']){ echo "selected";} 
							   else if(!empty($_GET['p_id'])){ if($dest_fetch['tloc_id']==$result['tloc_id_fk']){ echo "selected";} }?>>
                            <?=$dest_fetch['tloc_name']; ?> <?=$dest_fetch['tloc_code']; ?>
                            </option>
                            <? }?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Place Name <span class="red">*</span></strong></td>
                        <td align="left"><input name="txt_cov_places" type="text" class="input" id="txt_cov_places" size="30"  value="<? if(!empty($_POST['txt_cov_places'])){ echo $_POST['txt_cov_places'];} else if(!empty($_GET['p_id'])) echo $result['place_name'];?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Thumb Image <span class="red">*</span></strong></td>
                        <td align="left"><input type="file" name="image1" id="image1" multiple="multiple" />
                          <? if(!empty($_GET['p_id'])){ ?>
                          <input type="hidden" name="old_img1" id="old_img1" value="<?=$result['place_thumb'];?>" />
						  <a href="#" onclick="window.open('<?=$path.$result['place_thumb'];?>','no','scrollbars=yes,width=250,height=250')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
                          <? }?>
						  </td>
                      </tr>
                      <tr>
                        <td width="25%" valign="top" class="sub_heading_black"><strong>Small Description <span class="red">*</span></strong></td>
                        <td align="left"><textarea name="text_small_desc" cols="50" rows="5" id="text_small_desc"><? if(!empty($_POST['text_small_desc'])){ echo $_POST['text_small_desc'];} 
						  else if(!empty($_GET['p_id'])) echo $result['place_small_desc']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Big Image</strong></td>
                        <td align="left"><input type="file" name="image" id="image" multiple="multiple" />
                          <? if(!empty($_GET['p_id'])){ ?>
                          <input type="hidden" name="old_img" id="old_img" value="<?=$result['place_bigimage'];?>" />
						  <a href="#" onclick="window.open('<?=$path.$result['place_bigimage'];?>','no','scrollbars=yes,width=650,height=250')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
                          <? }?></td>
                      </tr>
                      <tr>
                        <td width="25%" valign="top" class="sub_heading_black"><strong>Large Description</strong></td>
                        <td align="left"><textarea name="text_large_desc" cols="50" rows="5" id="text_large_desc"><? if(!empty($_POST['text_large_desc'])){ echo $_POST['text_large_desc'];} else if(!empty($_GET['p_id'])) echo $result['place_large_desc'];?></textarea></td>
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
  if(document.getElementById('dest_name').value==''){ alert("Please select your location"); document.getElementById('dest_name').focus(); return false;}
  if(document.getElementById('txt_cov_places').value==''){ alert("Please enter your covered place"); document.getElementById('txt_cov_places').focus(); return false;}
  <? if(empty($_GET['p_id'])){ ?>
  if(document.getElementById('image1').value==''){ alert("Please upload thumb image"); document.getElementById('image1').focus(); return false;}
  <? }?>
  if(document.getElementById('text_small_desc').value==''){ alert("Please enter small description"); document.getElementById('text_small_desc').focus(); return false;}
  <? //if(empty($_GET['p_id'])){ ?>
  //if(document.getElementById('image').value==''){ alert("Please upload big image"); document.getElementById('image').focus(); return false;}
  <? //}?>
  //if(document.getElementById('text_large_desc').value==''){ alert("Please enter large description"); document.getElementById('text_large_desc').focus(); return false;}
}
</script>