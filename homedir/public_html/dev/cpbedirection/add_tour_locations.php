<?php
ob_start();
@session_start();
include_once("login_chk.php");
include_once("../includes/functions.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['fare_cat_add']) && $_SESSION['fare_cat_add']=='yes' ) ) ){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$locs = implode(',', $_POST['sel_destination']);
	$error = $cond = '';
	if(!empty($_GET['id'])){ $cond = "and trl_id != ".$_GET['id']; }
	$q = query("select trl_id from svr_tour_locations where 1 ".$cond." and trl_floc_id = '".$_POST['from_loc']."' and trl_type = '".$_POST['type']."'");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Tour aleady exists'; }
	if($count == 0)
	{
		if(!empty($_GET['id']))
		{	
			query("update svr_tour_locations set trl_type='".$_POST['type']."', trl_floc_id = '".$_POST['from_loc']."', trl_tloc_id = '".$locs."', trl_desc='".$_POST['desc']."' where trl_id='".$_GET['id']."'");
			header("location:manage_tour_locations.php");
		}
		else
		{	
			query("insert into svr_tour_locations(trl_type, trl_floc_id, trl_tloc_id, trl_desc, trl_status, trl_dateadded) values('".$_POST['type']."', '".$_POST['from_loc']."', '".$locs."', '".$_POST['desc']."', 1, '".$now_time."')");
			header("location:manage_tour_locations.php");
		}
	}	
}
$edit ="Add";
if(!empty($_GET['id']))
{	
	$row = query("select * from svr_tour_locations where trl_id='".$_GET['id']."'");
	$tour_loc = fetch_array($row);
	$locations = explode(',', $tour_loc['trl_tloc_id']);
	$edit ="Update";  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<link href="css/site.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
<link href="css/multiple-select.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/jquery-1.9.1.min.js"></script>
<script language="javascript" src="js/jquery.multiple.select.js"></script>
<script>
$(function() { 
	$(".fixed").multipleSelect({
		placeholder: 'Select Locations',
		multiple: true,
		filter: true
	}); 
	$(".package").multipleSelect({
		placeholder: 'Select Locations',
		minumimCountSelected: 1,
		multiple: true,
		filter: true
	});
});
</script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Tour Locations </strong></td>
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
				<td align="right"><a href="manage_tour_locations.php"><strong>Manage Tour Locations</strong></a></td>
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
						<tr>
						  <td><strong>Type <span class="red">*</span></strong></td>
						  <td id="tour_loc_dropdown"><select name="type" id="type_dp">
						  <option value="">Select Type</option>
						  <? 
						  $q = query("select cat_id, cat_name from svr_categories where cat_id = 1 or cat_id = 2");
							while($row = fetch_array($q)) $types[$row['cat_id']] = $row['cat_name'];
						  $type = array(); foreach($types as $key => $type){ $typea[$key] = '';
							  if((!empty($_GET['id']) && $tour_loc['trl_type'] == $key) || (isset($_POST['type']) && $_POST['type'] == $key)){$typea[$key]="selected";}?>
								<option value="<?=$key?>" <?=$typea[$key]?>><?=$type;?></option>
						  <? }?></select>
						  </td>
						</tr>
						<tr>
						  <td width="20%"><strong>From Location <span class="red">*</span></strong></td>
						  <td>
							<select name="from_loc" id="from_loc">
							  <option value="">Select From Location</option>
							  <? $q = query("select floc_id, floc_name from svr_from_locations where floc_status = 1");
							  while($row = fetch_array($q)){
								  if((!empty($_GET['id']) && $row['floc_id'] == $tour_loc['trl_floc_id']) || isset($_POST['from_loc']) && $_POST['from_loc'] == $row['floc_id']){ $from_loc_sel = "selected"; } else { $from_loc_sel = ""; }
								  ?><option value="<?=$row['floc_id']?>" <?=$from_loc_sel?>><?=$row['floc_name'];?></option><? }?>
							</select>
						  </td>
						</tr>
						<? $loc_disp = (!empty($_GET['id']) || isset($_POST['sel_destination'])) ? '' : 'none'; 
						$locations = (!empty($_GET['id'])) ? $locations : ((isset($_POST['sel_destination'])) ? $_POST['sel_destination'] : '');?>
						<tr id="loc_row" style="display:<?=$loc_disp?>">
						  <td id="loc_label"><strong>To Locations <span class="red">*</span></strong></td>
						  <td id="loc_dp">
							<?php if((!empty($_GET['id']) && $tour_loc['trl_type'] == 1) || (isset($_POST['sel_destination']) && $_POST['type'] == 1)){ ?>
						  	<select name="sel_destination[]" id="sel_destination" multiple style="width:300px;" class="fixed">
							<?php $svr_query = query("select tloc_id, tloc_name from svr_to_locations where cat_id_fk = 1 and tloc_status=1 order by tloc_orderby desc");
								while($loc=fetch_array($svr_query)){ 
								$loc_selected = (in_array($loc['tloc_id'], $locations)) ? "selected" : "";?>
							   <option value="<?=$loc['tloc_id'];?>" <?=$loc_selected;?>><?=$loc['tloc_name'];?></option>
							   <? }?> 
							</select>
							<? }?>
							<?php if((!empty($_GET['id']) && $tour_loc['trl_type'] == 2) || (isset($_POST['sel_destination']) && $_POST['type'] == 2)){ ?>
							<select name="sel_destination[]" id="sel_destination" multiple style="width:300px;" class="package">
							<?php $svr_subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1"); ?>
							<?php while($sloc=fetch_array($svr_subq)){ 
								$svr_query = query("select tloc_id, tloc_name from svr_to_locations where cat_id_fk = 2 and subcat_id_fk = '".$sloc['subcat_id']."' and tloc_status=1 order by tloc_orderby desc"); 
								if(num_rows($svr_query) > 0){?>
								<optgroup label="<?=$sloc['subcat_name']?>">
								<? while($loc = fetch_array($svr_query)){
									$loc_selected = (in_array($loc['tloc_id'], $locations)) ? "selected" : "";?>
									<option value="<?=$loc['tloc_id'];?>" <?=$loc_selected;?>>&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['tloc_name']));?></option>
							<? }}?></optgroup> <? }?> 
							</select>
							<? }?>
						  </td>
						</tr>
						<tr>
						  <td valign="top"><strong>Description </strong></td>
						  <? if(!empty($_POST['desc'])) $desc = $_POST['desc']; else if(!empty($_GET['id'])) $desc = $tour_loc['trl_desc']; else $desc = '';?>
						  <td><textarea name="desc" cols="50" rows="5" id="desc"><?=$desc;?></textarea></td>
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
		  </table></form>
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
	if(d.type.value == ""){ alert("Please Select Type"); d.type.focus(); return false; }
	if(d.from_loc.value == ""){ alert("Please Select From Location"); d.from_loc.focus(); return false; }
	if(d.sel_destination.value == ""){ alert("Please Select To Location"); d.sel_destination.focus(); return false; }
	//if(d.desc.value == ""){ alert("Please Enter Description"); d.desc.focus(); return false; } 	
}
</script>