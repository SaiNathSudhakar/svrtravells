<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('subsubcat',$_SESSION['tm_priv'])) )){}else{header("location:welcome.php");}
$cond = "1";
$cat_fltr = $cat_fltr_sucbat = "";
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_subsubcategories set subsubcat_status=".$status." where subsubcat_id='".$_GET['sid']."'");
	header("location:manage_subsubcategories.php");
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

$page_query = query("select subsubcat_id from svr_subsubcategories where $cond");
$total=num_rows($page_query);


$len=20; $start=0;
$link="manage_subsubcategories.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

$cond .= ($cat_fltr_sucbat != '') ? " order by cat_id_fk asc, subsubcat_orderby asc" : " order by subsubcat_id desc";

$result = query("select * from svr_subsubcategories where $cond limit $start,$len");

$count_order = num_rows($result);

if($_SERVER['REQUEST_METHOD']=="POST")
{
	//$replace = str_replace("'","&#39;",$_POST['txtlocation']);
	if(empty($_GET['id']) || (!empty($_GET['id']) && $_POST['hid_subcat'] != $_POST['cmb_subcat'])) {
		$subsubcat_orderby = getdata('svr_subsubcategories', 'max(subsubcat_orderby)+1', 'subcat_id_fk = '.$_POST['cmb_subcat']);
		$subsubcat_orderby = ($subsubcat_orderby != '') ? $subsubcat_orderby : 1;
	}
	$ref_no = (empty($_GET['id'])) ? rand(100000, 999999) : getdata("svr_subsubcategories",'subsubcat_ref_no', "subsubcat_id=".$_GET['id']);	
	$path = "../uploads/tour_packages/".$ref_no."/";
	
	// Thumb image
	
	if(!empty($_FILES['image']["size"]))
	{
		  $imgExtension = array('jpg','jpe','jpeg','gif');
		  $image_name = pathinfo($_FILES['image']['name']);
		  $extension = strtolower($image_name['extension']);
		  
		  //print_r($_FILES);
		  if(in_array($extension,$imgExtension))
		  {
			  if($_FILES['image']["size"] >1)
			  {
				  $b_image=substr($_FILES['image']['name'],0,strpos($_FILES['image']['name'],'.'));
				  $b_image.=time();
				  $b_image.=strstr($_FILES['image']['name'],'.');
		  		  if(!file_exists($path.$b_image))	@mkdir($path, 0777, true);
				  
				  if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { $b_image=""; } else { 
				  	  resize_image($path.$b_image, 148); //width: 148; height: 159
				  	  if(!empty($_POST['old_img'])) @unlink($path.$_POST['old_img']);
				  }
				  $imagepath=$b_image;
			  }
		  }
		  else
		  {		
			  $img_err_msg = "you have upload 'jpg , jpe , jpeg , gif' images only";
		  }
	  
	}
	elseif(!empty($_POST['old_img']))
	{
	  $b_image=$_POST['old_img'];
	}
	
	if(!empty($_GET['id'])){
		if($_POST['hid_subcat'] != $_POST['cmb_subcat']) { $order_cond = ', subsubcat_orderby = '.$subsubcat_orderby; }
		$update = query("update svr_subsubcategories set cat_id_fk = '".$_POST['cmb_cat']."',subcat_id_fk='".$_POST['cmb_subcat']."', subsubcat_name='".$_POST['txtlocation']."',subsubcat_thumb_image='".$b_image."' $order_cond where subsubcat_id='".$_GET['id']."'");
		header("location:manage_subsubcategories.php");
	}else{
		query("insert into svr_subsubcategories(cat_id_fk,subcat_id_fk, subsubcat_name,subsubcat_thumb_image, subsubcat_ref_no, subsubcat_status, subsubcat_dateadded, subsubcat_orderby) 
		values('".$_POST['cmb_cat']."','".$_POST['cmb_subcat']."' ,'".$_POST['txtlocation']."','".$b_image."','".$ref_no."', 1, '".$now_time."', '".$subsubcat_orderby."')");
		header("location:manage_subsubcategories.php");
	}
}
if(!empty($_GET['id']))
{	
	$row = query("select * from svr_subsubcategories where subsubcat_id = '".$_GET['id']."'");
	$row_result = fetch_array($row);
		
}

//ORDER BY
if(!empty($_GET['id']) && !empty($_GET['stat']) && !empty($_GET['poss']) && !empty($_GET['cat_id']))
{	
	$poss1=$_GET['poss']; $catid = $_GET['cat_id'];
	if($_GET['stat']=='up'){ $poss2=$poss1-1; }else if($_GET['stat']=='down'){ $poss2=$poss1+1; }
	$pos1id=getdata("svr_subcategories","subsubcat_id","subsubcat_orderby='".$poss1."' and cat_id_fk = '".$catid."'");
	$pos2id=getdata("svr_subsubcategories","subsubcat_id","subsubcat_orderby='".$poss2."' and cat_id_fk = '".$catid."'"); 
	query("update svr_subsubcategories set subsubcat_orderby='".$poss2."' where subsubcat_id='".$pos1id."' and cat_id_fk = '".$catid."'");
	query("update svr_subsubcategories set subsubcat_orderby='".$poss1."' where subsubcat_id='".$pos2id."' and cat_id_fk = '".$catid."'");
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
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>

<script language="javascript" src="js/ajax.js"></script>
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
			    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="6" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px;color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Category <span class="red">*</span></strong></td>
                              <td align="left" id="cat_dropdown">
							  <input name="hid_subcat" type="hidden" value="<? if(!empty($_GET['id'])) echo $row_result['subcat_id_fk'];?>">
							  <select name="cmb_cat" id="cmb_cat" onchange="show_type(this.value)">
							  <option value="">--Select Category--</option>
                                <?php
								  	$svr_query = query("select cat_id, cat_name from svr_categories where cat_status=1 and cat_id!=1");
									while($loc=fetch_array($svr_query)){
									$cat_selected =  ((!empty($_GET['id']) && $loc['cat_id'] == $row_result['cat_id_fk']) || isset($_POST['cmb_cat']) && $_POST['cmb_cat'] == $loc['cat_id']) ? "selected" : '';?>
									<option value="<?=$loc['cat_id'];?>" <? //if($loc['cat_id']==$result['cat_id_fk']){echo "selected='selected'";}?>
									<?=$cat_selected;?> >
									  <?=$loc['cat_name'];?>
									</option>
									<? }?>
                              </select></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black" nowrap="nowrap"><strong>Sub Category<span class="red">*</span></strong></td>
                              <td align="left" id="subcat_dropdown">
							  <select name="cmb_subcat" id="cmb_subcat" >
								  <option value="">Select Subcategory</option>
									<?php 
									if(!empty($_GET['id']) || isset($_POST['cmb_cat'])){
									$cat = (!empty($_GET['id'])) ? $row_result['cat_id_fk'] : $_POST['cmb_cat'];
									$svr_query = query("select subcat_id, subcat_name from svr_subcategories where subcat_status=1 and cat_id_fk = '".$cat."' order by subcat_orderby");
									while($loc=fetch_array($svr_query)){?>
									<option value="<?=$loc['subcat_id'];?>" <? if(!empty($_GET['id']) && $loc['subcat_id']==$row_result['subcat_id_fk'])echo "selected";?>>
									  <?=$loc['subcat_name'];?></option><? }}?>
								</select></td>
                            </tr>
							
							<tr>
                              <td class="sub_heading_black"><strong>Upload Image (Thumb nail) <span class="red">*</span></strong></td>
                              <td align="left"><input type="file" name="image" id="image" multiple="multiple">
                                  <? if(!empty($_GET['id'])){ ?>
                                  <input type="hidden" name="old_img" id="old_img" value="<?=$row_result['subsubcat_thumb_image'];?>" />
                                  <a href="javascript:;" onclick="window.open('view_subsubcat_thumb.php?vid=<?=$row_result['subsubcat_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=400')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
                                  
                                  <? }?></td>
                            </tr>
							
                            <tr>
                            <td align="left" class="sub_heading_black" nowrap="nowrap"><strong>Sub SubCategory <span class="red">*</span></strong></td>
                              <td align="left"><input name="txtlocation" type="text" class="input" id="txtlocation" title=""  value="<? if(!empty($_GET['id'])) echo $row_result['subsubcat_name'];?>" size="30" maxlength="99" /></td>
                            </tr>
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
		<?php /*?><tr>
		  <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
				<tr>
				  <td width="5%" align="left" valign="middle" nowrap="nowrap">
				  <select name="cat_inact" id="cat_inact" class="textbox" onchange="window.location='manage_subcategories.php?cat_fltr='+this.value">
					<option value="">Select Category</option>
					<? $q = query("select cat_id, cat_name from svr_categories where cat_status = 1");
					while($row = fetch_array($q)){?>
					<option value="<?=$row['cat_id']?>" <? if($cat_fltr_sucbat == $row['cat_id']){?>selected<? }?>><?=$row['cat_name'];?></option>
					<? }?>
				  </select>
				  <? if(!empty($cat_fltr_sucbat)){ ?>
                      <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_subcategories.php?src=reset'" title="Reset"/>
                      <? } ?>
				  </td>
				</tr>
			</table></td>
	    </tr><?php */?>
		<tr>
		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="20%" class="tablehead">Category</td>
			<td class="tablehead">Sub Category</td>
			<td class="tablehead">Sub SubCategory</td>
			<?php /*?><? if(isset($_SESSION['cat_fltr_sucbat'])){ ?><td width="10%" align="center" class="tablehead">Order By</td><? }?><?php */?>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
-->			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
			<? }?>
		  </tr>
		  </thead>
		  <?php
			
			$sno = $start; if($count_order>0){
			if(isset($_GET['start'])) {	if(!empty($_GET['start']) && $_GET['start']==0) { $sno=0; } else { $sno=$_GET['start']; } }
			if(empty($_GET['start'])) { $sno=0; }
			while($fetch=fetch_array($result)){
			$sno++;
			if($fetch['subsubcat_status']==1){
				$f_status ='<a href="manage_subsubcategories.php?sid='.$fetch["subsubcat_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['subsubcat_status']==0){
				$f_status='<a href="manage_subsubcategories.php?sid='.$fetch["subsubcat_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=getdata('svr_categories','cat_name','cat_id='.$fetch['cat_id_fk']);?></td>
			<td align="left"><?=getdata('svr_subcategories','subcat_name','subcat_id='.$fetch['subcat_id_fk']);?></td>
			<td align="left"><?=$fetch['subsubcat_name'];?></td>
			<?php /*?><? if(isset($_SESSION['cat_fltr_sucbat'])){ ?>
			<td align="left">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <? if($sno != 1){ ?>
				  <td align="left" valign="middle">
				  <a href="manage_subsubcategories.php?stat=up&id=<?=$fetch['subsubcat_id']?>&poss=<?=$fetch['subsubcat_orderby']?>&cat_id=<?=$fetch['cat_id_fk']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/uparrow.png" alt="move down" width="16" height="16" border="0" title="Click to move Up"></a></td>
				  <? } else { echo "<td align='right' valign='bottom' width='16'>&nbsp;</td>"; } 
				  if($sno != $total){ ?>
				  <td align="right" valign="middle">
				  <a href="manage_subsubcategories.php?stat=down&id=<?=$fetch['subsubcat_id']?>&poss=<?=$fetch['subsubcat_orderby']?>&cat_id=<?=$fetch['cat_id_fk']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/downarrow.png" alt="move up" width="16" height="16" border="0"title="Click to move Down"></a></td>
				  <? } else { echo "<td align='left' valign='bottom' width='16'>&nbsp;</td>"; } ?>
				  <td align="right" valign="middle"><strong><?=$fetch['subsubcat_orderby']?></strong></td>
				</tr>
			</table>
			</td><? }?><?php */?>
			<td width="5%" align="center"><a href="manage_subsubcategories.php?id=<?=$fetch['subsubcat_id'];?>&catg_id=<?=$fetch['cat_id_fk'];?>">
			<img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
<!--<td width="5%" align="center"><? echo $f_status; ?></td>
-->		  </tr>
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
		if(document.getElementById('cmb_cat').value==''){ alert("Please select Category"); document.getElementById('cmb_cat').focus(); return false;}
		if(document.getElementById('cmb_subcat').value==''){ alert("Please select SubCategory"); document.getElementById('cmb_subcat').focus(); return false;}
  		if(document.getElementById('txtlocation').value==''){ alert("Please enter Sub SubCategory"); document.getElementById('txtlocation').focus(); return false;}
	}
</script>