<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pack',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$date = explode('/', $_POST['date']); $acc_type = $room_type = $seats = $seats_data = '';
	$date_picker = ($date) ? $date[0].'-'.$date[1].'-'.$date[2] : '0000-00-00';
	
	$cond = (!empty($_GET['p_id']))? "and pkg_id != ".$_GET['p_id'] : '';
	$q = query("select pkg_id from svr_packages where 1 ".$cond." and pkg_to_id = '".$_POST['sel_to_loc']."' and pkg_date = '".$date_picker."'");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Package aleady exists'; }
	
	if(isset($_POST['sel_to_loc']) || !empty($_GET['p_id']))
	{	
		if(empty($_GET['p_id'])){
			$ac_query = query('select tloc_acc_type, cat_id_fk, tloc_room_type from svr_to_locations where tloc_id = '.$_POST['sel_to_loc']);
			$ac = fetch_array($ac_query);
			$acc = $ac['tloc_acc_type'];
		} else {
			$ac_query = query("select pkg_acc_type from svr_packages where pkg_id = '".$_GET['p_id']."' order by pkg_id");
			$ac = fetch_array($ac_query);
			$acc = $ac['pkg_acc_type'];
		}
		$actypes = explode('|', $acc);
		$ac_types = array_filter($actypes); //print_r($ac_types); exit;
	} 
	$valid_error = false;
	foreach($ac_types as $i => $ac_type){
		if($_POST['seats'][$i] == '' || !is_numeric($_POST['seats'][$i])){
			$valid_error = true;
		}
	}
	
	$seats = $_POST['seats'];
		
	for($i = 0; $i < 2; $i++){
		$acc_type .= ((!empty($actypes[$i])) ? $actypes[$i] : 0).'|';
		$seats_data .= ((!empty($seats[$i])) ? $seats[$i] : 0).'|';
	}
	$acc_type = substr($acc_type, 0, -1);
	$seats_data = substr($seats_data, 0, -1);
	
	//if($ac['cat_id_fk'] == 2) { $room_type = $acc_type; $acc_type = ''; }
	list($ac, $nac) = explode('|', $seats_data);
	
	if($count == 0 && $valid_error == false)
	{	
		if(!empty($_GET['p_id']))
		{	
			query("update svr_packages set pkg_to_id='".$_POST['sel_to_loc']."', pkg_date='".$date_picker."', pkg_seats_available = '".$seats_data."', pkg_ac_seats = '".$ac."',	pkg_nac_seats = '".$nac."', pkg_acc_type = '".$acc_type."' where pkg_id='".$_GET['p_id']."'");
			header("location:manage_packages.php");
		}
		else
		{	
			query("insert into svr_packages(pkg_to_id, pkg_date, pkg_acc_type, pkg_seats_available, pkg_ac_seats, pkg_nac_seats, pkg_status, pkg_dateadded) values('".$_POST['sel_to_loc']."', '".$date_picker."', '".$acc_type."', '".$seats_data."', '".$ac."', '".$nac."', 1, '".$now_time."')");
			header("location:manage_packages.php");
		}
	}
}
$edit = "Add";
if(!empty($_GET['p_id']))
{	
    $row = query("select * from svr_packages where pkg_id='".$_GET['p_id']."'");
	$package = fetch_array($row);
	$edit = "Update";
	
	$acc = $package['pkg_acc_type'];
		
	$actypes = explode('|', $acc);
	$ac_types = array_filter($actypes);
	
	//Populate Fares
	$fares_tmp = explode('|', $package['pkg_seats_available']);
	$i = 0; $my_seats = array();
	foreach($ac_types as $key => $val){ 
		$my_seats[$key] = $fares_tmp[$key];
		$i++;
	}
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
<!--Date Picker Styles-->
<link rel="stylesheet" href="css/jdpicker.css" type="text/css" />
<!--Date Picker Styles-->
<!--<script language="javascript" src="../includes/script_valid.js"></script>-->
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Package </strong></td>
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
			<form action="" method="post" name="form1" id="form1" onSubmit="return validate()" enctype="multipart/form-data">
			    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				    <td align="right"><a href="manage_packages.php"><strong>Manage Packages</strong></a></td>
				  </tr> 
				  <tr>
					<td>&nbsp;</td>
				  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="8" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
							<? if(!empty($error)){?>
                            	<tr><td>&nbsp;</td><td class="error"><?=$error;?></td></tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
							<? }?>
                            <tr id="to_loc_row">
                              <td width="25%" align="left" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                              <td align="left" id="to_loc_dp">
								<select name="sel_to_loc" id="sel_to_loc">
									<option value="">--- Select To Location ---</option>
									<?  $cond = ''; if(!empty($_GET['p_id']) || isset($_POST['sel_from_loc'])){	$cond = ''; } 
										$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where 1 ".$cond." and cat_id_fk = 1 and tloc_status = 1 order by tloc_orderby");
										while($row = fetch_array($svr_query)){
											if((!empty($_GET['p_id']) && $row['tloc_id'] == $package['pkg_to_id'])|| (isset($_POST['sel_to_loc']) && $row['tloc_id'] == $_POST['sel_to_loc'])) { $sel = "selected"; } else { $sel = ''; }?>
											<option value="<?=$row['tloc_id'];?>" <?=$sel?>><?=ucwords(strtolower($row['tloc_name'])).' ('.$row['tloc_code'].')';?></option>
									<? }?>
								</select></td>
                            </tr>
                            <tr>
                              <td width="25%"><strong>Departure Date <span class="red">*</span></strong></td>
                              <td><input name="date" id="date" type="text" placeholder="Select Calendar" class="jdpicker" value="<? if(!empty($_GET['p_id'])) echo date('Y/m/d',strtotime($package['pkg_date'])); else if(isset($_POST['date'])) echo $_POST['date']; ?>"/></td>
                            </tr>
                            <tr class="seats_row" style="display:<?=(isset($_POST['sel_to_loc']) || !empty($_GET['p_id'])) ? 'compact' : 'none';?>">
							<td colspan="2" id="seats_details">
							<? $class = (!empty($valid_error) && $valid_error == true) ? 'class="error"' : '';
							if(isset($_POST['sel_to_loc']) || !empty($_GET['p_id'])){?>
							<table width="100%" align="left">
							  <? if($class != '') {?>
							  <tr>
								<td>&nbsp;</td>
								<td class="error">Select Seats Available</td>
							  </tr>
							  <? }?>
							  <tr>
							    <td width="25%">&nbsp;</td>
							    <? foreach($ac_types as $ac_type){?>
								  <td align="left"><strong><?=$accomodation_type[$ac_type]?></strong></td>
							    <? } ?>
							  </tr>
							  <tr>
							    <td><strong>Seats Available</strong> <span class="red">*</span></td>
							    <? foreach($ac_types as $key => $ac_type){ ?>
								  <td><!--<input type="text" name="seats[<?=$key?>]" value="<?=(!empty($_GET['p_id'])) ? $my_seats[$key] : '';?>">-->
                                  	<select name="seats[<?=$key?>]" id="seats[<?=$key?>]" required>
                                    	<option value="">Select Seats Available</option>
                                        <option value="12" <?php if((!empty($_GET['p_id'])) &&($my_seats[$key]==12)) { echo 'selected = "selected"';}?>>12</option>
                                        <option value="25" <?php if((!empty($_GET['p_id'])) &&($my_seats[$key]==25)) { echo 'selected = "selected"';}?>>25</option>
                                        <option value="27" <?php if((!empty($_GET['p_id'])) &&($my_seats[$key]==27)) { echo 'selected = "selected"';}?>>27</option>
                                        <option value="40" <?php if((!empty($_GET['p_id'])) &&($my_seats[$key]==40)) { echo 'selected = "selected"';}?>>40</option>
                                        <option value="45" <?php if((!empty($_GET['p_id'])) &&($my_seats[$key]==45)) { echo 'selected = "selected"';}?>>45</option>
            						</select>
                                  </td>
							    <? }?>
							  </tr>
						    </table><? }?></td></tr>
                           <tr align="center" class="seats_row" style="display:<?=(isset($_POST['sel_to_loc']) || !empty($_GET['p_id'])) ? 'compact' : 'none';?>">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" /></td>
                            </tr>
                           <tr>
                             <td align="center">&nbsp;</td>
                             <td align="left">&nbsp;</td>
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
	if(d.sel_to_loc.value==""){ alert("Please Select Destination Location"); d.cmbtoloc.focus(); return false; }
	if(d.date.value==""){ alert("Please Select your Deapture Date"); d.date.focus(); return false;}
	//if(d.txt_ava_seats.value==""){ alert("Please Enter Available Seats"); d.txt_ava_seats.focus(); return false; }
}
</script>
<script type ="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type ="text/javascript" src="../js/jdpicker.js"></script>
