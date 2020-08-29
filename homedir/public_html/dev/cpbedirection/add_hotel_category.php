<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
//print_r($_POST);exit;
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcat',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$hotels = implode(',', $_POST['sel_hotels']);
	$error = $cond = '';
	if(!empty($_GET['f_id'])){ $cond = "and hc_id != ".$_GET['f_id']; }
	$q = query("select hc_location from svr_hotel_category where 1 ".$cond." and hc_location = '".$_POST['sel_destination']."' and hc_ht_loc_id = '".$_POST['hot_loc']."' and hc_room_type = '".$_POST['cat']."'");
	 $count = num_rows($q); if( $count > 0 ) { $error = 'Category aleady exists'; }
	if($count == 0)
	{
	  if(!empty($_GET['f_id']))
	  {	
		  query("update svr_hotel_category set hc_subcat_id = '".$_POST['sel_subcategory']."', hc_location='".$_POST['sel_destination']."',
		  hc_ht_loc_id='".$_POST['hot_loc']."', hc_ht_ids = '".$hotels."',hc_room_type = '".$_POST['cat']."', hc_desc = '".$_POST['desc']."' where hc_id='".$_GET['f_id']."'");
	  }
	  else
	  {		
		  $orderby = getdata('svr_hotel_category', 'max(hc_orderby)', '1');
		  query("insert into svr_hotel_category(hc_subcat_id, hc_location, hc_ht_loc_id, hc_ht_ids, hc_room_type, hc_desc, hc_orderby, hc_dateadded) values('".$_POST['sel_subcategory']."', '".$_POST['sel_destination']."', '".$_POST['hot_loc']."', '".$hotels."', '".$_POST['cat']."', '".$_POST['desc']."', '".($orderby+1)."', '".$now_time."')");
	
	  }
	  header("location:manage_hotel_category.php");
	}
}
$edit ="Add";
if(!empty($_GET['f_id']))
{	
  	$row = query("select * from svr_hotel_category where hc_id='".$_GET['f_id']."'");
						
  	$fares = fetch_array($row);
  	$hotl = explode(',', $fares['hc_ht_ids']);
	$edit ="Update";
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/multiple-select.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery.multiple.select.js"></script>
<script src="../js/script.js"></script>
<script>
$(function() { 
	$(".sel_destination").multipleSelect({
		placeholder: 'Select Locations',
		multiple: true,
		filter: true
	});
});
</script>
<script language="javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/jquery-ui.min.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<script language="javascript" src="js/script.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" width="11" height="13" /><strong style="font-size:12px"><a href="welcome.php">Home</a> &raquo; <?=$edit;?> Hotel Category </strong></td>
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
			  <form method="post" name="form1" id="form1" onsubmit="return validate()" enctype="multipart/form-data">
			    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				    <td align="right"><a href="manage_hotel_category.php"><strong>Manage Hotel Category </strong></a></td>
				  </tr> 
				  <tr>
					<td>&nbsp;</td>
				  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="12" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="20%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <? if(!empty($error)){?>
                            	<tr><td>&nbsp;</td><td class="error"><?=$error;?></td></tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
							<? }?>
                            
							<tr id="sub_row1">
                            <td id="sub_label1"><strong>Tour Package</strong></td>
                            <td id="sub_dp2">
                            <select name="sel_subcategory" id="sel_subcategory" style="width:300px;" required>
                              <option value="">Select Tour Package</option>
                              <?php 
                                  $subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk=2 and subcat_status=1 order by subcat_orderby");
                                  while($sub=fetch_array($subq)){ 
								  if(!empty($_GET['f_id']) ){$selected = "selected"; }else $selected = '';?>
           						  		<option value="<?=$sub['subcat_id'];?>"<? if(!empty($_GET['f_id']) && $sub['subcat_id']==$fares['hc_subcat_id']) {echo $selected;}?>><?=$sub['subcat_name']?></option>                      
                                 <? }?>
                              </select>
                            </td>
                          </tr>
                         
                          <tr id="loc_row2" >
                            <td id="loc_label"><strong>Location<span class="red">*</span></strong></td>
                            <td id="loc_dp2">
                              <select name="sel_destination" id="sel_destination" style="width:300px;" required>
							  	<option value="">--Select Location--</option>
                              <?php if(!empty($_GET['f_id']) || isset($_POST['sel_subcategory'])){
                                  $svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where 1 ".$cond." and tloc_status=1 order by tloc_orderby");
                                  while($loc=fetch_array($svr_query)){
								  if(!empty($_GET['f_id']) ){$selected = "selected"; }else $selected = '';?>
                                 		<option value="<?=$loc['tloc_id'];?>"<? if(!empty($_GET['f_id']) && $loc['tloc_id']==$fares['hc_location']) {echo $selected;}?>><?=$loc['tloc_name']?></option>
                                 <? }}?>
                              </select>							  
                            </td>
                          </tr>
                          
                          <tr id="hloc_row2" >
                            <td id="loc_label"><strong>Hotel Location<span class="red">*</span></strong></td>
                            <td id="hloc_dp2">
                              <select name="hot_loc" id="hot_loc" style="width:300px;" required>
							  	<option value="">Select Hotel Location</option>
                              <?php if(!empty($_GET['f_id'])){
                                  $svr_query = query("select ht_loc_id, ht_loc_name from svr_hotel_location where ht_loc_status=1 order by ht_loc_name");
								  
                                  while($loc=fetch_array($svr_query)){
								 	 if(!empty($_GET['f_id']) ){ $selected = "selected"; }else $selected = '';?>
                                     
                                 		<option value="<?=$loc['ht_loc_id'];?>"<? if(!empty($_GET['f_id']) && $loc['ht_loc_id']==$fares['hc_ht_loc_id']) {echo $selected;}?>>
                                        <?=$loc['ht_loc_name']?></option>
                                 <? } }?>
                              </select>							  
                            </td>
                          </tr>
                          
                          <tr id="loc_row2" >
                            <td id="loc_label"><strong>Category<span class="red">*</span></strong></td>
                            <td id="loc_dp2">
                              <select name="cat" id="cat" style="width:300px;" required>
							  	<option value="">Select Category</option>
                              	<option value="1" <?php if(!empty($_GET['f_id']) && ($fares['hc_room_type'] == 1)){ echo 'selected = "selected"';}?>>Standard</option>
                                <option value="2" <?php if(!empty($_GET['f_id']) && ($fares['hc_room_type'] == 2)){ echo 'selected = "selected"';}?>>Deluxe</option>
                                <option value="3" <?php if(!empty($_GET['f_id']) && ($fares['hc_room_type'] == 3)){ echo 'selected = "selected"';}?>>Luxury</option>
                              </select>							  
                            </td>
                          </tr>
                          
                          <tr id="loc_row">
                              <td id="loc_label"><strong>Hotels <span class="red">*</span></strong></td>
                              <td id="loc_dp">
                                
                                <select name="sel_hotels[]" class="sel_hotels" multiple style="width:300px;">
                         
                                    <? $svr_query = query("select * from svr_hotels where ht_status = 1 order by ht_name"); 
                                    if(num_rows($svr_query) > 0){?>
                                    
                                    <? while($loc = fetch_array($svr_query)){
                                        $loc_selected = (in_array($loc['ht_id'], $hotl)) ? "selected" : "";?>
                                        <option value="<?=$loc['ht_id'];?>" <?=$loc_selected;?>>&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['ht_name']));?></option>
                                <? }}?>
                                </select>
                              </td>
                          </tr>
                          
                          <tr>
                              <td valign="top"><strong>Description </strong></td>
                              <td><? $desc = (!empty($_GET['f_id'])) ? $fares['fc_desc'] : ((isset($_POST['desc'])) ? $_POST['desc'] : ''); ?>
                              <textarea name="desc" cols="50" rows="5" id="desc"><?=$desc;?></textarea></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                          </tr>
                          <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left"><input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" /></td>
                          </tr>
                    </table>
					</td>
                  </tr>
              </table>
			  </form>
		  </td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
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
function validate()
{	
	var d = document.form1;
	if(d.ftype.value == ""){ alert("Please Select Type"); d.ftype.focus(); return false; }
	if(d.name.value == ""){ alert("Please Enter Name"); d.name.focus(); return false; }
	if(d.sel_destination.value == ""){ alert("Please Select Destinations"); d.sel_destination.focus(); return false; }	
}
</script>