<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('farcat',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$locs = implode(',', $_POST['sel_destination']);
	$error = $cond = '';
	if(!empty($_GET['f_id'])){ $cond = "and fc_id != ".$_GET['f_id']; }
	$q = query("select fc_id from svr_fare_category where 1 ".$cond." and fc_name = '".$_POST['name']."' and fc_type = '".$_POST['ftype']."'");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Category aleady exists'; }
	if($count == 0)
	{
	  if(!empty($_GET['f_id']))
	  {		
		  query("update svr_fare_category set fc_type = '".$_POST['ftype']."', fc_name='".$_POST['name']."', fc_multiple = '".$_POST['multiple']."', fc_adult_child = '".$_POST['adultchild']."', fc_locations = '".$locs."', fc_desc='".$_POST['desc']."' where fc_id='".$_GET['f_id']."'");
	  }
	  else
	  {		
		  $orderby = getdata('svr_fare_category', 'max(fc_orderby)', '1');
		  query("insert into svr_fare_category(fc_type, fc_name, fc_multiple, fc_adult_child, fc_locations, fc_desc, fc_status, fc_orderby, fc_dateadded) values('".$_POST['ftype']."', '".$_POST['name']."', '".$_POST['multiple']."', '".$_POST['adultchild']."', '".$locs."', '".$_POST['desc']."', 1, '".($orderby+1)."', '".$now_time."')");
	  }
	  header("location:manage_fare_category.php");
	}
}
$edit ="Add";
if(!empty($_GET['f_id']))
{	
  	$row = query("select * from svr_fare_category where fc_id='".$_GET['f_id']."'");
  	$fares = fetch_array($row);
  	$locations = explode(',', $fares['fc_locations']);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" width="11" height="13" /><strong style="font-size:12px"><a href="welcome.php">Home</a> &raquo; <?=$edit;?> Fare Category </strong></td>
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
				    <td align="right"><a href="manage_fare_category.php"><strong>Manage Fare Category </strong></a></td>
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
							  <? $ftype = (!empty($_GET['f_id'])) ? $fares['fc_type'] : ((isset($_POST['ftype'])) ? $_POST['ftype'] : ''); ?>
                              <td id="fare_type_dropdown">
							  <select name="ftype" id="ftype_dp" style="width:150px">
							  <option value="">Select Type</option>
							  <? 
							  	$q = query("select cat_id, cat_name from svr_categories where cat_id = 1 or cat_id = 2");
								while($row = fetch_array($q)) $faretypes[$row['cat_id']] = $row['cat_name'];
							  	$faretype = array(); foreach($faretypes as $key => $fare_type){ $faretype[$key]='';
								  if((!empty($_GET['f_id']) && $fares['fc_type']==$key) || (isset($_POST['ftype']) && $_POST['ftype'] == $key)){ $faretype[$key]="selected";}?>
									<option value="<?=$key?>" <?=$faretype[$key]?>><?=$fare_type;?></option>
							  <? }?></select>
							  </td>
                            </tr>
							<?  $fcat_disp = (!empty($_GET['f_id']) || isset($_POST['name']))?'':'none'; ?>
                            <tr id="fare_cat_row" style="display:<?=$fcat_disp?>">
                              <td width="20%"><strong>Name <span class="red">*</span></strong></td>
                              <td id="fare_cat">
							  <? $name = ''; if(!empty($_GET['f_id'])) $name = $fares['fc_name']; if(!empty($_POST['name'])) $name = $_POST['name'];?>
							  <? if($ftype == 1){?>
                              		<input name="name" type="text" class="input" id="name" size="35" value="<?=$name;?>" />
							  <? } else if($ftype == 2){?>
								  <select name="name" id="name" style="width:150px">
									<option value="">Select Vehicle</option>
									<? $q = query('select v.v_id, concat(veh.vp_name, " ", pax.vp_name, " PAX") as vehicle from svr_vehicles_with_pax as v
										left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
											left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id ');
									while($row = fetch_array($q)){?>
									<? if(!empty($_POST['name']) && $_POST['name'] == $row['v_id']) $selected = "selected"; else 
									if(!empty($_GET['f_id']) && $row['v_id'] == $name) $selected = "selected"; else $selected = '';?>
										<option value="<?=$row['v_id']?>" <?=$selected;?>><?=$row['vehicle']?></option>
									<? }?>
								  </select>
							  <? }?>
							  </td>
                            </tr>
							<?  $fcatmul_disp = ((!empty($_GET['f_id']) && $fares['fc_type'] == 1) || (isset($_POST['ftype']) && $_POST['ftype'] == 1))?'':'none'; ?>
                            <tr id="multiples_row" style="display:<?=$fcatmul_disp?>">
                              <td width="20%"><strong>Multiple of <span class="red">*</span></strong></td>
                              <td>
							    <? $multiple = ''; if(!empty($_GET['f_id'])) $multiple = $fares['fc_multiple']; if(!empty($_POST['multiple'])) $multiple = $_POST['multiple'];?>
                              	<input name="multiple" type="text" class="input" id="multiple" onkeypress="return chkNumeric(event);" size="35" value="<?=$multiple;?>" /> 1, 2 or 3
							  </td>
                            </tr>
							
							<?  $adultchild_disp = ((!empty($_GET['f_id']) && $fares['fc_type'] == 1) || (isset($_POST['ftype']) && $_POST['ftype'] == 1))?'':'none'; ?>
                            <tr id="adultchild_row" style="display:<?=$adultchild_disp?>">
                              <td width="20%"><strong>Adult or Child <span class="red">*</span></strong></td>
                              <td>
							    <? $adultchild = ''; if(!empty($_GET['f_id'])) $adultchild = $fares['fc_adult_child']; 
								if(!empty($_POST['adultchild'])) $adultchild = $_POST['adultchild'];?>
                              	<input type="radio" name="adultchild" id="adultchild1" value="1" <? if($adultchild == 1){?>checked<? }?> />Adult
								<input type="radio" name="adultchild" id="adultchild2" value="2" <? if($adultchild == 2){?>checked<? }?> />Child
							  </td>
                            </tr>
								
							<?  $loc_disp = ((!empty($_GET['f_id'])) || (isset($_POST['ftype']) && $_POST['ftype'] == 1))? '' : 'none'; 
								$loc_selected = ''; if(!empty($_GET['f_id'])) $loc_selected = $locations; 
								if(isset($_POST['sel_destination'])) $loc_selected = $_POST['sel_destination'];?>
                            <tr id="loc_row" style="display:<?=$loc_disp?>">
                              <td id="loc_label"><strong>Locations <span class="red">*</span></strong></td>
                              <td id="loc_dp">
								<?php if((!empty($_GET['f_id']) && $fares['fc_type'] == 1) || (isset($_POST['ftype']) && $_POST['ftype'] == 1)){ ?>
								<select name="sel_destination[]" class="sel_destination" multiple style="width:300px;">
								<?php $svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 1 and tloc_status=1 order by tloc_orderby");
									while($loc=fetch_array($svr_query)){ 
									$loc_selected = (in_array($loc['tloc_id'], $locations)) ? "selected" : "";?>
								   <option value="<?=$loc['tloc_id'];?>" <?=$loc_selected;?>><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
								   <? }?> 
								</select>
								<? }?>
								<?php if((!empty($_GET['f_id']) && $fares['fc_type'] == 2) || (isset($_POST['sel_destination']) && $_POST['ftype'] == 2)){ ?>
								<select name="sel_destination[]" class="sel_destination" multiple style="width:600px; height:180px">
								<?php $svr_subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1 order by subcat_orderby"); ?>
								<?php while($sloc=fetch_array($svr_subq)){ 
									$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 2 and subcat_id_fk = '".$sloc['subcat_id']."' and tloc_status=1 order by tloc_name"); 
									if(num_rows($svr_query) > 0){?>
									<optgroup label="<?=$sloc['subcat_name']?>">
									<? while($loc = fetch_array($svr_query)){
										$loc_selected = (in_array($loc['tloc_id'], $locations)) ? "selected" : "";?>
										<option value="<?=$loc['tloc_id'];?>" <?=$loc_selected;?>>&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
								<? }}?></optgroup> <? }?> 
								</select>
								<? }?>
							  </td>
                            </tr>
                            <tr>
                              <td valign="top"><strong>Description </strong></td>
                              <td><? $desc = (!empty($_GET['f_id'])) ? $fares['fc_desc'] : ((isset($_POST['desc'])) ? $_POST['desc'] : ''); ?>
                              <textarea name="desc" cols="70" rows="4" id="desc"><?=$desc;?></textarea></td>
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