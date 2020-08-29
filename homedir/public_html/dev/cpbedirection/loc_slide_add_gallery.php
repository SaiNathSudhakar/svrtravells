<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
//if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tloc',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$img_err_msg='';
$acc_type = ''; $room_type = '';
if($_SERVER['REQUEST_METHOD']=="POST")
{



	for($j=1;$j<=5;$j++) {

//print_r($_POST); exit;

		$prsimage="";
		$th_file_name="";
		if(!empty($_FILES["prsimage".$j]["tmp_name"])) {
 			//uploading big image starts here
		    $album_name='slides'; //getdata("dc_gal_cat","subname","subid='".$_POST['yp_subid']."'");
			$album=$album_name; 
			$prsimage=substr($_FILES['prsimage'.$j]['name'],0,strpos($_FILES['prsimage'.$j]['name'],'.'));
			$prsimage.=time();
			$prsimage.=strstr($_FILES['prsimage'.$j]['name'],'.'); 		
			$prsimage1="../uploads/".$album_name."/thumbs/".$prsimage;	
			$prsimage="../uploads/".$album_name."/images/".$prsimage;	
			if(!move_uploaded_file($_FILES['prsimage'.$j]['tmp_name'],$prsimage)){ 
			$prsimage="";  
				}
			chmod($prsimage,0777); 
			// uploading big image ends here
			// creation of thumbinal image starts here
				
			$image_attribs = getimagesize($prsimage);
			$im_old = imageCreateFromJpeg($prsimage);
			 $width=$image_attribs[0];
			 $height=$image_attribs[1];
			$th_max_width = 84; 
			//$th_max_height = 150; 
			$ratio = ($width > $height) ? $th_max_width/$image_attribs[0] : $th_max_width/$image_attribs[1]; 
			$th_width = $image_attribs[0] * $ratio; 
			$th_height = $image_attribs[1] * $ratio; 
			$th_width = 84; 
			$th_height = 62; 
			$im_new = imagecreatetruecolor($th_width,$th_height); 
			imageAntiAlias($im_new,true);
			$th_file_name = $prsimage1;
			imageCopyResampled($im_new,$im_old,0,0,0,0,$th_width,$th_height, $image_attribs[0], $image_attribs[1]); 
			imageJpeg($im_new,$th_file_name,100);
			
			// creation of thumbinal image ends here			
			// creation of large image starts here
				
			$image_attribs1 = getimagesize($prsimage);
			$im_old1 = imageCreateFromJpeg($prsimage);
			$width1=$image_attribs1[0];
			$height1=$image_attribs1[1];
			$th_max_width1 = 800; 
			$th_max_height1 = 600; 
			$ratio1 = ($width1 > $height1) ? $th_max_width1/$image_attribs1[0] : $th_max_width1/$image_attribs1[1];
			$th_width1 = $image_attribs1[0] * $ratio1; 
			$th_height1 = $image_attribs1[1] * $ratio1;
			//$th_width = 100; 
			//$th_height = 100; 
			$im_new1 = imagecreatetruecolor($th_width1,$th_height1); 
			imageAntiAlias($im_new1,true);
			$th_file_name1 = $prsimage;
			imageCopyResampled($im_new1,$im_old1,0,0,0,0,$th_width1,$th_height1, $image_attribs1[0], $image_attribs1[1]); 
			imageJpeg($im_new1,$th_file_name1,100);
		} 

    	if(!empty($_POST['title'.$j])){ $title=$_POST['title'.$j];}else{ $title="";}

//echo $prsimage; echo "<br>".$th_file_name;
//print_r($_FILES);

//if(!empty($th_file_name1) && !empty($th_file_name) ){
//echo "----"; exit;
			 $insert="insert into svr_upload_slide (`pkg_id`, `slide_title`,`slide_simg`,`slide_limg`,`slide_dateadded`) values 
			('".$_POST['hid_pkg_id']."', '".$title."','".$th_file_name."','".$th_file_name1."','".date('Y-m-d H:i:s')."')";
//echo $insert; exit;
			query($insert);
		//}
	}

	header("location:manage_to_location.php");

}
$edit = "Add";
if(!empty($_GET['img_id']))
{ }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script language="javascript" src="js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/redmond/jquery-ui.css" />
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ptTimeSelect.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.ptTimeSelect.js"></script>

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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Gallery</strong></td>
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			  <td valign="top" class="grn_subhead" align="right"></td>
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
			    <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
				    <td align="right"><a href="manage_to_location.php"><strong>Manage Locations</strong></a></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="7" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="24%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="74%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
<? if(!empty($size_err_msg)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$size_err_msg;?></strong></td></tr><? }?>
<? if(!empty($img_err_msg)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$img_err_msg;?></strong></td></tr><? }?>
<? if(!empty($loc_name_error)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$loc_name_error;?></strong></td></tr><? }?>
<? if(!empty($loc_code_error)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$loc_code_error;?></strong></td></tr><? }?>
                            
							<? $interl_disp = ((!empty($_GET['img_id']) && !empty($result['tloc_international'])) || !empty($_POST['international'])) ? '' : 'none'; ?>
							
                            <? $subcat_disp = ((!empty($_GET['img_id']) && !empty($result['subcat_id_fk'])) || !empty($_POST['cmb_subcat'])) ? '' : 'none'; ?>
                            
							<? $subsubcat_disp = ((!empty($_GET['img_id']) && !empty($result['subsubcat_id_fk'])) || !empty($_POST['cmb_subsubcat'])) ? '' : 'none'; ?>
                            
							 <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                    <tr>
                    <td colspan="2" valign="top" class="sub_heading_black">
					<table width="99%" border="0" align="center" cellpadding="1" cellspacing="0" class="box_gray">                      
                      <tr>
                        <td colspan="8" align="center" valign="middle" class="bot_brd_left"><span class="mandatory"> </span><span class="mandatory"><span class="bot_brd_right"></span></span></td>
                      </tr>
                      <tr>
                        <td width="0" align="center" valign="middle" nowrap class="t4">Image Title 1</td>
                        <td width="0" align="center" valign="middle" class="t4">:</td>
                        <td width="0" align="center" valign="middle"><input name="title1" type="text" class="lstbx2" id="title1" ></td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td width="0" align="right" valign="middle" nowrap class="t4">Upload Image 1</td>
                        <td width="0" align="center" valign="middle" class="t4">:</td>
                        <td width="0" align="left" valign="middle"><input name="prsimage1" type="file" class="lstbx2" id="prsimage1"></td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" nowrap class="t4">Image Title 2</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="center" valign="middle"><input name="title2" type="text" class="lstbx2" id="title2" ></td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle" nowrap class="t4">Upload Image 2</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="left" valign="middle"><input name="prsimage2" type="file" class="lstbx2" id="prsimage2"></td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" nowrap class="t4">Image Title 3</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="center" valign="middle"><input name="title3" type="text" class="lstbx2" id="title3" ></td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle" nowrap class="t4">Upload Image 3</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="left" valign="middle"><input name="prsimage3" type="file" class="lstbx2" id="prsimage3"></td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" nowrap class="t4">Image Title 4</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="center" valign="middle"><input name="title4" type="text" class="lstbx2" id="title4" ></td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle" nowrap class="t4">Upload Image 4</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="left" valign="middle"><input name="prsimage4" type="file" class="lstbx2" id="prsimage4"></td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" nowrap class="t4">Image Title 5</td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="center" valign="middle"><input name="title5" type="text" class="lstbx2" id="title5" ></td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle" nowrap class="t4">Upload Image 5 </td>
                        <td align="center" valign="middle" class="t4">:</td>
                        <td align="left" valign="middle"><input name="prsimage5" type="file" class="lstbx2" id="prsimage5"></td>
                      </tr>
                      <tr>
                        <td colspan="7"  valign="middle" align="center"><span class="mandatory">Upload jpg / png/ gif files and size 500x375 </span></td>
                      </tr>
                      <tr>
                        <td colspan="3" align="left" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle">&nbsp;</td>
                        <td colspan="3" align="right" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" align="left" valign="middle">&nbsp;</td>
                        <td width="5" align="right" valign="middle">&nbsp;</td>
                        <td colspan="3" align="right" valign="middle">
<input type="hidden" name="hid_pkg_id" value="<?=$_GET['loc_id'];?>" />
						<? if(!empty($_GET['loc_id'])){ ?>
                            <input name="up_date" type="submit" value="Upload" class="button" />
                            <? } ?>
                            <input name="cancel" type="button" class="button" id="cancel" value="Cancel" onClick="javascript:history.back();" /></td>
                      </tr>
                  </table></td>
</tr>
                            <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
							  <td align="left">&nbsp;</td>
                            </tr>
                    </table>
					</td>
                  </tr>
              </table></form>
		  </td>
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
var d=document.form1;

<?php for ($k=1;$k<=5;$k++) { ?>		
		if(d.prsimage<?php echo $k?>.value=="") {
			alert("Please Upload Image");
			d.prsimage<?php echo $k?>.focus();
			return false
	}else return true;	
<?php } ?>		
} 
</script>