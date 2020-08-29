<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('travel',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_charges set ch_status=".$status." where ch_id='".$_GET['sid']."'");
	header("location:manage_travel_charges.php");
}
$page_query = query("select ch_id from svr_charges");
$total=num_rows($page_query);
$len=30; $start=0;
$link="manage_travel_charges.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
			
$result = query("select ch.*, veh.vp_name as vehicle, group_concat(tloc_name order by tloc_orderby desc) as locations from svr_charges as ch
	left join svr_vehicles_pax as veh on veh.vp_id = ch.ch_vehicle_id
		left join svr_to_locations as tloc on CONCAT(',', ch.ch_locations, ',') LIKE CONCAT('%,', tloc.tloc_id, ',%')
			where ch_type = 1 group by ch_id order by ch_id desc limit $start, $len");	
			
$count_order = num_rows($result);

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$locs = implode(',', $_POST['sel_destination']);
	$cond = (!empty($_GET['id'])) ? "and ch_id != ".$_GET['id'] : '';
	
	$loccond = ''; 
	$destinations = $_POST['sel_destination'];
	if(!empty($destinations)){
		$loccond = ' and (';
		foreach($destinations as $dest)	$loccond .= " FIND_IN_SET('".$dest."', ch_locations) OR";
		$loccond = substr($loccond, 0, -3).')';
	}
	
	$q = query("select ch_id from svr_charges where 1 ".$cond." and ch_vehicle_id = '".$_POST['vehicle']."' $loccond");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Travel charges aleady exists'; }
	
	if($count == 0)
	{	
		if(!empty($_GET['id'])){ 
			$update = query("update svr_charges set ch_vehicle_id = '".$_POST['vehicle']."', ch_charges = '".$_POST['charges']."', ch_km = '".$_POST['km']."', ch_locations = '".$locs."' where ch_id = '".$_GET['id']."'");
			header("location:manage_travel_charges.php");
		} else {
			query("insert into svr_charges(ch_vehicle_id, ch_type, ch_charges, ch_km, ch_locations, ch_status, ch_dateadded) values ('".$_POST['vehicle']."', '1', '".$_POST['charges']."', '".$_POST['km']."', '".$locs."', 1, '".$now_time."')");
			header("location:manage_travel_charges.php");
		}
	}
}
if(!empty($_GET['id'])){
	$row = query("select * from svr_charges where ch_id='".$_GET['id']."'");
	$fetch = fetch_array($row); $locations = explode(',', $fetch['ch_locations']);
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
<link href="css/multiple-select.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery.multiple.select.js"></script>
<script>
$(function() { 
	$(".sel_destination").multipleSelect({
		placeholder: 'Select Locations',
		multiple: true,
		filter: true
	});
});
</script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Travel Charges </strong></td>
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
					<? if(!empty($error)){?>
						<tr><td class="error" align="center"><?=$error;?></td></tr>
						<tr><td>&nbsp;</td></tr>
					<? }?>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="8" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Vehicle <span class="red">*</span></strong></td>
                              <td align="left">
							  <select name="vehicle" id="vehicle" style="width:120px">
							    <option value="">Select Vehicle</option>
								<? $q = query('select vp_id, vp_name from svr_vehicles_pax where vp_type = 1 and vp_status = 1');
								while($row = fetch_array($q)){?>
								<? if(!empty($_POST['vehicle']) && $_POST['vehicle'] == $row['vp_id']) $selected = "selected"; else 
								if(!empty($_GET['id']) && $row['vp_id'] == $fetch['ch_vehicle_id']) $selected = "selected"; else $selected = '';?>
									<option value="<?=$row['vp_id']?>" <?=$selected;?>><?=$row['vp_name']?></option>
								<? }?>
							  </select>							  
                              </td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Charges per Day <span class="red">*</span></strong></td>
                              <td align="left"><input type="text" name="charges" id="charges" value="<? if(isset($_POST['charges'])) echo $_POST['charges']; else if(!empty($_GET['id']))echo $fetch['ch_charges'];?>"></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Per <span class="red">*</span></strong></td>
                              <td align="left"><input type="text" name="km" id="km" value="<? if(isset($_POST['km'])) echo $_POST['km']; else if(!empty($_GET['id']))echo $fetch['ch_km'];?>"><span>KM</span></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Locations <span class="red">*</span></strong></td>
                              <td align="left">
								<select name="sel_destination[]" class="sel_destination" multiple style="width:300px;">
								<?php $svr_subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1"); ?>
								<?php while($sloc=fetch_array($svr_subq)){ 
									$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 2 and subcat_id_fk = '".$sloc['subcat_id']."' and tloc_status=1 order by tloc_orderby desc"); 
									if(num_rows($svr_query) > 0){?>
									<optgroup label="<?=$sloc['subcat_name']?>">
									<? while($loc = fetch_array($svr_query)){
										if(!empty($_GET['id']) && in_array($loc['tloc_id'], $locations)) $loc_selected = "selected";
										else if(!empty($_POST['sel_destination']) && in_array($loc['tloc_id'], $_POST['sel_destination']))$loc_selected = "selected";
										else $loc_selected = '';
										?>
										<option value="<?=$loc['tloc_id'];?>" <?=$loc_selected;?>>&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')'.' ('.$loc['tloc_code'].')';?></option>
								<? }}?></optgroup> <? }?> 
								</select>                              
                              </td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">	<input type="submit" name="Submit" id="Submit" value="<? if(!empty($_GET['id'])){ echo "Update";} else{ echo "Add";} ?>" class="btn_input" onclick="return check_valid();" /><input type="button" onclick="javascript:window.location='manage_travel_charges.php'" value="Cancel"></td>
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
		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="10%" class="tablehead">Vehicle</td>
			<td width="10%" class="tablehead">Charges</td>
			<td width="10%" class="tablehead">Per</td>
			<td class="tablehead"><strong>Locations</strong></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
-->			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?><? }?>
		  </tr>
		  </thead>
		  <?php
			$sno = $start; if($count_order>0){
			while($fetch=fetch_array($result)){
			$sno++;
			  
			if($fetch['ch_status']==1){
				$f_status ='<a href="manage_travel_charges.php?sid='.$fetch["ch_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['ch_status']==0){
				$f_status='<a href="manage_travel_charges.php?sid='.$fetch["ch_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=$fetch['vehicle'];?></td>
			<td align="left"><?=($fetch['ch_charges'] != '') ? 'Rs. '.$fetch['ch_charges'].'/-' : '';?></td>
			<td align="left"><?=($fetch['ch_km'] != '') ? $fetch['ch_km'].' KM' : '';?></td>
			<td align="left" title="<?=$fetch['locations']?>"><? $locat = (strlen($fetch['locations']) > 70) ? substr($fetch['locations'], 0, 100).'...' : $fetch['locations']; echo ucwords(strtolower($locat)); ?></td>
			<td width="5%" align="center"><a href="manage_travel_charges.php?id=<?=$fetch['ch_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
<!--<td width="5%" align="center"><? echo $f_status; ?></td>
-->		  </tr>
		  <? }} else if($count_order==0){?>
		  <tr><td height="50" colspan="13" align="center" bgcolor="#CCC" class="red">No Records Found</td></tr>
		  <? } ?>
		  </table></td>
		</tr>
		<? if($total>$len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
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
	if(document.getElementById('vehicle').value==''){ alert("Please select Vehicle"); document.getElementById('vehicle').focus(); return false; }
	if(document.getElementById('charges').value==''){ alert("Please enter charges"); document.getElementById('charges').focus(); return false; }
	if(document.getElementById('km').value==''){ alert("Please enter per how many KMs"); document.getElementById('km').focus(); return false; }
	if(document.getElementById('sel_destination').value==''){ alert("Please select Locations"); document.getElementById('sel_destination').focus(); return false; }
}
</script>