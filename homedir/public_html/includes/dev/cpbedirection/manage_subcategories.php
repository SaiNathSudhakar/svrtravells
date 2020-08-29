<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('subcat',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$cond = "1";
$cat_fltr = $cat_fltr_sucbat = "";
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_subcategories set subcat_status=".$status." where subcat_id='".$_GET['sid']."'");
	header("location:manage_subcategories.php");
}

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset"){
	unset($_SESSION["cat_fltr_sucbat"]);
	header("location:manage_subcategories.php");
}

//category filter
if(!empty($_GET['cat_fltr']) || isset($cat_fltr_sucbat)){
	if(!empty($_GET['cat_fltr'])) { $_SESSION['cat_fltr_sucbat'] = $_GET['cat_fltr']; }
	$cat_fltr_sucbat = (isset($_SESSION['cat_fltr_sucbat'])) ? $_SESSION['cat_fltr_sucbat'] : '';
	
	//$link = "manage_subcategories.php?cat_fltr=".$_GET['cat_fltr'];
	if($cat_fltr_sucbat != ''){	$cat_fltr = " and cat_id_fk = ".$cat_fltr_sucbat; }
}
$cond.=$cat_fltr;

$page_query = mysql_query("select subcat_id from svr_subcategories where $cond");
$total=mysql_num_rows($page_query);

$len=20; $start=0;
$link="manage_subcategories.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

$cond .= ($cat_fltr_sucbat != '') ? " order by cat_id_fk asc, subcat_orderby asc" : " order by subcat_id desc";

$result = mysql_query("select * from svr_subcategories where $cond limit $start,$len");
$count_order = mysql_num_rows($result);


if($_SERVER['REQUEST_METHOD']=="POST")
{
	$replace = str_replace("'","&#39;",$_POST['txtlocation']);
	if(empty($_GET['id']) || (!empty($_GET['id']) && $_POST['hid_cat'] != $_POST['cmb_cat'])) {
		$subcat_orderby = getdata('svr_subcategories', 'max(subcat_orderby)+1', 'cat_id_fk = '.$_POST['cmb_cat']);
		$subcat_orderby = ($subcat_orderby != '') ? $subcat_orderby : 1;
	}
	$ref_no = (empty($_GET['id'])) ? rand(100000, 999999) : getdata("svr_subcategories",'subcat_ref_no', "subcat_id=".$_GET['id']);	
	$path = "../uploads/tour_packages/".$ref_no."/";	//chmod($path, 0777);
	
	//banner
	$i = 0; $attachments = ''; 
	if($_FILES["upload"]["size"] > 0){
	  foreach($_FILES["upload"]["error"] as $key => $err) {
		  if ($err == UPLOAD_ERR_OK) {
		  	  $filename = make_filename(basename($_FILES["upload"]['name'][$key]));
		  	  //$target_path = ($_FILES["upload"]['name'][$key]) ? "../uploads/destination_locations/".$ref_no."/" : '';
		      $attachments .= $filename."|";
			  if(!file_exists($path.$filename))	@mkdir($path, 0777, true);
			 // echo $error_codes[$error];
			 move_uploaded_file( $_FILES["upload"]["tmp_name"][$key], $path.$filename ) or die("Problems with Upload");
		  }
	  }
	}
	$attachments = ($attachments != '') ? substr($attachments, 0, -1) : '';

	$order_cond='';
	if(!empty($_GET['id'])){
		$check = getdata("svr_subcategories", "subcat_banner_image", "subcat_id=".$_GET['id']);
		$field = (!empty($check)) ? (($_FILES["upload"]['name'][0] != '') ? "subcat_banner_image = CONCAT(subcat_banner_image,'|".$attachments."')" : "subcat_banner_image = subcat_banner_image") : " subcat_banner_image='".$attachments."'";
		if($_POST['hid_cat'] != $_POST['cmb_cat']) { $order_cond = ', subcat_orderby = '.$subcat_orderby; }
		$update = mysql_query("update svr_subcategories set cat_id_fk = '".$_POST['cmb_cat']."', subcat_name='".$replace."', ".$field." $order_cond where subcat_id='".$_GET['id']."'");
		header("location:manage_subcategories.php");
	}else{
		mysql_query("insert into svr_subcategories(cat_id_fk, subcat_name, subcat_banner_image, subcat_ref_no, subcat_status, subcat_dateadded, subcat_orderby) 
		values('".$_POST['cmb_cat']."', '".$replace."','".$attachments."','".$ref_no."', 1, '".$now_time."', '".$subcat_orderby."')");
		header("location:manage_subcategories.php");
	}
}
if(!empty($_GET['id']))
{	
	$row = mysql_query("select * from svr_subcategories where subcat_id = '".$_GET['id']."'");
	$row_result = mysql_fetch_array($row);
	
	$ref_no = $row_result['subcat_ref_no'];	
	$path = $site_url."uploads/tour_packages/".$ref_no."/";
	
	//delete attached files
	if(!empty($_GET['file']))
	{	
		$attachments = ''; 
		$attachment = explode('|', $row_result['subcat_banner_image']); 
		foreach($attachment as $attach){
			if($attach == $_GET['file']){ 
				$attachments .= ''; 
				$image_path = '../uploads/tour_packages/'.$row_result['subcat_ref_no'].'/'.$_GET['file'];
				if(file_exists($image_path)) @unlink($image_path);
			} else {
				$attachments .= $attach.'|';
			}
		} $attachments = substr($attachments, 0, -1);
		mysql_query("update svr_subcategories set subcat_banner_image = '".$attachments."' where subcat_id = ".$_GET['id']);
		header("location:manage_subcategories.php?id=".$_GET['id']."&catg_id=".$_GET['catg_id']);
	}
}

//ORDER BY
if(!empty($_GET['id']) && !empty($_GET['stat']) && !empty($_GET['poss']) && !empty($_GET['cat_id']))
{	
	$poss1=$_GET['poss']; $catid = $_GET['cat_id'];
	if($_GET['stat']=='up'){ $poss2=$poss1-1; }else if($_GET['stat']=='down'){ $poss2=$poss1+1; }
	$pos1id=getdata("svr_subcategories","subcat_id","subcat_orderby='".$poss1."' and cat_id_fk = '".$catid."'");
	$pos2id=getdata("svr_subcategories","subcat_id","subcat_orderby='".$poss2."' and cat_id_fk = '".$catid."'"); 
	mysql_query("update svr_subcategories set subcat_orderby='".$poss2."' where subcat_id='".$pos1id."' and cat_id_fk = '".$catid."'");
	mysql_query("update svr_subcategories set subcat_orderby='".$poss1."' where subcat_id='".$pos2id."' and cat_id_fk = '".$catid."'");
	header("location:manage_subcategories.php");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Sub Categories</strong></td>
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
			    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="4" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Category <span class="red">*</span></strong></td>
                              <td align="left">
							  <input name="hid_cat" type="hidden" value="<? if(!empty($_GET['id'])) echo $row_result['cat_id_fk'];?>">
							  <select name="cmb_cat" id="cmb_cat">
							  <option value="">--Select Category--</option>
                                <?php
								  	$svr_query = mysql_query("select cat_id, cat_name from svr_categories where cat_status=1");
									while($loc=mysql_fetch_array($svr_query)){ ?>
                                <option value="<?=$loc['cat_id'];?>" <? if(!empty($_GET['catg_id'])){ if($loc['cat_id']==$_GET['catg_id']){ echo "selected";} }?> >
                                  <?=$loc['cat_name'];?></option>
                                <? }?>
                              </select></td>
                            </tr>
							 
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Sub Category <span class="red">*</span></strong></td>
                              <td align="left"><input name="txtlocation" type="text" class="input" id="txtlocation" title="" value="<? if(!empty($_GET['id'])) echo $row_result['subcat_name'];?>" size="30" maxlength="99" /></td>
                            </tr>
							<br /><br />
                            
                            <tr>
                              <td valign="top" class="sub_heading_black" nowrap="nowrap"><b>Banner Images</b></td>
                              <td align="left"><input name="upload[]" type="file" multiple="true"/>
							  
						<? if(!empty($_GET['id']) && !empty($row_result['subcat_banner_image'])){
							$files = explode('|', $row_result['subcat_banner_image']);
							foreach($files as $key => $file)
								if($file)
									echo '<br><a href='.$path.$file.'>'.($key+1).'. '.basename($file).'</a>
									  	  <a href="manage_subcategories.php?id='.$_GET['id'].'&catg_id='.$row_result['cat_id_fk'].'&file='.$file.'"><i class="delicon"></i></a>';
						   }?><br>(Hold the <strong>CTRL key </strong>to select multiple images of 800 x 225 dimension)</td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
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
		  <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
				<tr>
				  <td width="5%" align="left" valign="middle" nowrap="nowrap">
				  <select name="cat_inact" id="cat_inact" class="textbox" onchange="window.location='manage_subcategories.php?cat_fltr='+this.value">
					<option value="">Select Category</option>
					<? $q = mysql_query("select cat_id, cat_name from svr_categories where cat_status = 1");
					while($row = mysql_fetch_array($q)){?>
					<option value="<?=$row['cat_id']?>" <? if($cat_fltr_sucbat == $row['cat_id']){?>selected<? }?>><?=$row['cat_name'];?></option>
					<? }?>
				  </select>
				  <? if(!empty($cat_fltr_sucbat)){ ?>
                      <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_subcategories.php?src=reset'" title="Reset"/>
                      <? } ?>
				  </td>
				</tr>
			</table></td>
	    </tr>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="20%" class="tablehead">Category</td>
			<td class="tablehead">Sub Category</td>
			<? if(isset($_SESSION['cat_fltr_sucbat'])){ ?><td width="10%" align="center" class="tablehead">Order By</td><? }?>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
			<? }?>
		  </tr>
		  </thead>
		  <?php
			
			$sno = $start; if($count_order>0){
			if(isset($_GET['start'])) {	if(!empty($_GET['start']) && $_GET['start']==0) { $sno=0; } else { $sno=$_GET['start']; } }
			if(empty($_GET['start'])) { $sno=0; }
			while($fetch=mysql_fetch_array($result)){
			$sno++;
			if($fetch['subcat_status']==1){
				$f_status ='<a href="manage_subcategories.php?sid='.$fetch["subcat_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['subcat_status']==0){
				$f_status='<a href="manage_subcategories.php?sid='.$fetch["subcat_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=getdata('svr_categories','cat_name','cat_id='.$fetch['cat_id_fk']);?></td>
			<td align="left"><?=$fetch['subcat_name'];?></td>
			<? if(isset($_SESSION['cat_fltr_sucbat'])){ ?>
			<td align="left">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <? if($sno != 1){ ?>
				  <td align="left" valign="middle">
				  <a href="manage_subcategories.php?stat=up&id=<?=$fetch['subcat_id']?>&poss=<?=$fetch['subcat_orderby']?>&cat_id=<?=$fetch['cat_id_fk']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/uparrow.png" alt="move down" width="16" height="16" border="0" title="Click to move Up"></a></td>
				  <? } else { echo "<td align='right' valign='bottom' width='16'>&nbsp;</td>"; } 
				  if($sno != $total){ ?>
				  <td align="right" valign="middle">
				  <a href="manage_subcategories.php?stat=down&id=<?=$fetch['subcat_id']?>&poss=<?=$fetch['subcat_orderby']?>&cat_id=<?=$fetch['cat_id_fk']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/downarrow.png" alt="move up" width="16" height="16" border="0"title="Click to move Down"></a></td>
				  <? } else { echo "<td align='left' valign='bottom' width='16'>&nbsp;</td>"; } ?>
				  <td align="right" valign="middle"><strong><?=$fetch['subcat_orderby']?></strong></td>
				</tr>
			</table>
			</td><? }?>
			<td width="5%" align="center"><a href="manage_subcategories.php?id=<?=$fetch['subcat_id'];?>&catg_id=<?=$fetch['cat_id_fk'];?>">
			<img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
			<td width="5%" align="center"><? echo $f_status; ?></td>
		  </tr>
		  <? 
		  }}
		  else if($count_order==0){?>
		  <tr><td height="50" colspan="12" align="center" bgcolor="#CCC" class="red">No Records Found</td>
		  </tr>
		  <? } ?>
		  </table></td>
		</tr>
		<? if($total>$len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>		  </td>
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
<script type="text/javascript">
function check_valid()
{
  if(document.getElementById('txtlocation').value==''){ alert("Please enter Sub Category"); document.getElementById('txtlocation').focus(); return false;}
}
</script>