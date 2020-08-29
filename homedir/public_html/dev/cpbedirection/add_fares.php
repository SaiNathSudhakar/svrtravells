<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('fares',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

$from = ''; $to = '';

if($_SERVER['REQUEST_METHOD']=="POST"){	 
	$from = (isset($_POST['from'])) ? $_POST['from'] : ''; 
	$to = (isset($_POST['to'])) ? $_POST['to'] : '';
	$fare_cat = $fare = $fares = $acc = $acc_type = '';
	
	$from_date = date('Y-m-01', strtotime($from)); 
	$to_date = date('Y-m-t', strtotime($to));
	
	$cond = (!empty($_GET['frs_id']))? "and fr_group_id != ".$_GET['frs_id'] : '1';
	if($_POST['ftype'] == 1){
		$cond .= " and fr_from_date = '".$from_date."' and fr_to_date = '".$to_date."'";
	}
	$qc = query("select fr_id from svr_fares where ".$cond." and fr_type = '".$_POST['ftype']."' and fr_loc_id = '".$_POST['sel_destination']."' and fr_status = 1"); 
	$count = num_rows($qc); if( $count > 0 ) { $error = 'Fares for this location and month aleady exists'; }
	
	$valid_error = false;
	if(isset($_POST['sel_destination']))
	{	
		if(empty($_GET['frs_id'])){
			$ac_query = query('select tloc_acc_type, cat_id_fk, tloc_room_type from svr_to_locations where tloc_id = '.$_POST['sel_destination']);
			$ac = fetch_array($ac_query);
			$category = $ac['cat_id_fk'];
			if( $category == 1 ) $ac_types = explode('|', $ac['tloc_acc_type']);
			if( $category == 2 ) $ac_types = explode('|', $ac['tloc_room_type']);
		} else {
			$ac_query = query("select fr_acc_type, fr_type, fr_room_type from svr_fares where fr_group_id = '".$_GET['frs_id']."' order by fr_id");
			while($ac = fetch_array($ac_query))
			{
				$category = $ac['fr_type'];
				if( $category == 1 ) $ac_types[] = $ac['fr_acc_type'];
				if( $category == 2 ) $ac_types[] = $ac['fr_room_type'];
			}
		}
		//print_r($ac_types); exit;
		$ac_types = array_unique(array_filter($ac_types)); 
	} 
	foreach($_POST['fare_cat'] as $key => $val){ 
		foreach($ac_types as $i => $ac_type){
			if($_POST['fare'][$key][$i] == '' || !is_numeric($_POST['fare'][$key][$i])){
				$valid_error = true;
			}
		}	
	}
		
	if(!empty($_GET['frs_id']))
	{	
		if($count == 0 /*&& $valid_error == false*/){
			$subcat = ($category == 2) ? $_POST['sel_subcategory'] : 0; 
			$from_date = ($category == 1) ? $from_date : '0000-00-00'; $to_date = ($category == 1) ? $to_date : '0000-00-00'; $i =1;$arr=array();
			$arr=$_POST['fare'];
			
			foreach ($arr as $k=>$subArray){
			  foreach ($subArray as $id=>$value){ $sumArray[$id]+=$value; }
			}
			if(empty($sumArray[0])){ ?>
				<script type='text/javascript'>alert('Please Add atleast one Fare'); window.location="add_fares.php?frs_id=<?=$_GET['frs_id']?>";</script>
            <? exit; }
			
			foreach($_POST['fare_cat'] as $key => $val){ 
				foreach($ac_types as $i => $ac_type){
					$acc_type = ($category == 1) ? $ac_type : ''; $room_type = ($category == 2) ? $ac_type : '';
					$cat_qur=query("select * from svr_fares where fr_group_id='".$_GET['frs_id']."' and fr_type='".$category."' and fr_fc_id='".$val."' and fr_room_type='".$room_type."'");
					$cat_qur_cnt=mysqli_num_rows($cat_qur);
					if(isset($_POST['fare_status'][$key][$i])) { $fare_status=$_POST['fare_status'][$key][$i]; } else { $fare_status=0; }
					
					if($cat_qur_cnt>=1){$str=str_replace(",","",$_POST['fare'][$key][$i]);
							query("update svr_fares set fr_loc_id = '".$_POST['sel_destination']."', fr_from_date = '".$from_date."', 
						fr_to_date = '".$to_date."', fr_type = '".$category."', fr_subcat_id = '".$subcat."', fr_fc_id = '".$val."', 
						fr_acc_type = '".$acc_type."', fr_room_type = '".$room_type."', fr_data = '".$str."' , fr_status='".$fare_status."' 
						where fr_group_id = '".$_GET['frs_id']."' and fr_fc_id = '".$val."' and fr_acc_type = '".$acc_type."' and fr_type = '".$category."' 
						and fr_room_type = '".$room_type."'");
					
					} else if(!empty($_POST['fare'][$key][$i])){$str=str_replace(",","",$_POST['fare'][$key][$i]);
						query("insert into svr_fares (fr_loc_id, fr_group_id, fr_from_date, fr_to_date, fr_type, fr_subcat_id, fr_fc_id, fr_acc_type, 
						fr_room_type, fr_data, fr_status, fr_dateadded) values('".$_POST['sel_destination']."', '".$_GET['frs_id']."', '".$from_date."', '".$to_date."', 
						'".$category."', '".$subcat."', '".$val."', '".$acc_type."', '".$room_type."', '".$str."', '".$fare_status."', '".$now_time."')");
				   }
				}
			}
			header("location:manage_fares.php");
		}
	}
	else
	{	
		$arr=array();$arr=$_POST['fare'];
		foreach ($arr as $k=>$subArray){
		foreach ($subArray as $id=>$value){ $sumArray[$id]+=$value; }
		}
		if(empty($sumArray[0])){ ?>
		<script type='text/javascript'>alert('Please Add atleast one Fare'); </script>
		<? }else{
		if($count == 0 /*&& $valid_error == true*/){
			$group_id = getdata('svr_fares','max(fr_group_id)','1')+1; $room_type = $acc_type = '';
			if($ac['cat_id_fk'] == 2) { $from_date = '0000-00-00'; $to_date = '0000-00-00'; }
			foreach($_POST['fare_cat'] as $key => $fare_cat){ 
				foreach($ac_types as $i => $ac_type){
					if($ac['cat_id_fk'] == 1) $acc_type = $ac_type; if($ac['cat_id_fk'] == 2) $room_type = $ac_type;
					if(!empty($_POST['fare'][$key][$i])){$str=str_replace(",","",$_POST['fare'][$key][$i]);
					query("insert into svr_fares (fr_loc_id, fr_group_id, fr_from_date, fr_to_date, fr_type, fr_subcat_id, fr_fc_id, fr_acc_type, 
					fr_room_type, fr_data, fr_status, fr_dateadded) values('".$_POST['sel_destination']."', '".$group_id."', '".$from_date."', '".$to_date."', 
					'".$ac['cat_id_fk']."', '".$_POST['sel_subcategory']."', '".$fare_cat."', '".$acc_type."', '".$room_type."', '".$str."', 1, '".$now_time."')");
					}
				}
			}
			header("location:manage_fares.php");
		}
		}
	}
}
$edit ="Add";
if(!empty($_GET['frs_id']))
{
  $q = query("select * from svr_fares where fr_group_id='".$_GET['frs_id']."' order by fr_id");
  while($row = fetch_array($q)) $fares[] = $row;
  $edit ="Update";  $acc = $fare_cat = $fre = $fare_data = '';
  
  foreach($fares as $key => $fare) { 
  	if($fare['fr_type'] == 1) { $ac_types[] = $fare['fr_acc_type']; $ac = $fare['fr_acc_type'];}
	if($fare['fr_type'] == 2) { $ac_types[] = $fare['fr_room_type']; $ac = $fare['fr_room_type']; }
	$fare_cat[] = $fare['fr_fc_id']; $my_fares[$fare['fr_fc_id']][$ac] = $fare['fr_data'];
	$my_fares_status[$fare['fr_fc_id']][$ac] = $fare['fr_status'];
  }
  //Populate Accomodation / Room Types
  $ac_types = array_unique($ac_types);
 
  //Populate Fare Categories
  $fare_cat = array_unique($fare_cat);
  
  //Populate 'from' and 'to' dates
  $from = ($fares[0]['fr_from_date'] != '1970-01-01' && $fares[0]['fr_from_date'] != '0000-00-00') ? date('F Y', strtotime($fares[0]['fr_from_date'])) : ''; 
  $to = ($fares[0]['fr_to_date'] != '1970-01-01' && $fares[0]['fr_to_date'] != '0000-00-00') ? date('F Y', strtotime($fares[0]['fr_to_date'])) : ''; 
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
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/jquery-ui.min.js"></script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
<style type="text/css">.ui-datepicker-calendar { display: none; }</style>

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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Fares </strong></td>
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
		  <form method="post" name="form1" id="form1" onSubmit="return validate()" enctype="multipart/form-data">
			<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="right"><a href="manage_fares.php"><strong>Manage Fares</strong></a></td>
			  </tr> 
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td valign="top">
				  <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
						<tr>
						  <td width="2%" rowspan="13" align="left" class="sub_heading_black">&nbsp;</td>
						  <td align="left" class="sub_heading_black">&nbsp;</td>
						  <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
						</tr>
						<? if(!empty($error)){?>
							<tr><td>&nbsp;</td><td class="error"><?=$error;?></td></tr>
							<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<? }?>
						<tr>
                          <td><strong>Type <span class="red">*</span></strong></td>
                          <td id="fare_type_dropdown1"><select name="ftype" id="ftype_dp"> 
						  <? if(empty($_GET['frs_id'])){?><option value="">Select Type</option><? }?>
                          <? 
						  	$q = query("select cat_id, cat_name from svr_categories where cat_id = 1 or cat_id = 2");
							while($row = fetch_array($q)) $faretypes[$row['cat_id']] = $row['cat_name'];
						  	$faretype = array(); foreach($faretypes as $key => $fare_type){ $faretype[$key]='';
                              if((isset($_POST['ftype']) && $_POST['ftype'] == $key)){ $faretype[$key]="selected";}
							  if((!empty($_GET['frs_id']) && $fares[0]['fr_type']==$key) || empty($_GET['frs_id'])){?>
                                <option value="<?=$key?>" <?=$faretype[$key]?>><?=$fare_type;?></option>
                          <? }}?></select>
                          </td>
                        </tr>
						<? $date_disp = ((!empty($_GET['frs_id']) && $fares[0]['fr_type'] == 1) || (isset($_POST['ftype']) && $_POST['ftype'] == 1))?'':'none'; ?>
						<tr id="fare_date" style="display:<?=$date_disp;?>">
						  <td width="20%"><strong>Date <span class="red">*</span></strong></td>
						  <td>
						  From <input type="text" class="from" name="from" readonly value="<?=$from;?>" /> 
						  To <input type="text" class="to" name="to" readonly value="<?=$to;?>" /></td>
						</tr>
                        <? $sub_disp = ((!empty($_GET['frs_id']) && $fares[0]['fr_type'] == 2) || (isset($_POST['sel_subcategory']) && $_POST['ftype'] == 2))?'':'none'; ?>
                          <tr id="sub_row1" style="display:<?=$sub_disp?>">
                            <td id="sub_label1"><strong>Tour Package</strong></td>
                            <td id="sub_dp1">
                            <select name="sel_subcategory" id="sel_subcategory" style="width:300px;">
                               <? if(empty($_GET['frs_id'])){?><option value="">Select Tour Package</option><? }?>
                              <?php if(!empty($_GET['frs_id']) || isset($_POST['sel_subcategory'])){
                                  $subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk=2 and subcat_status=1 order by subcat_orderby");
                                  while($sub=fetch_array($subq)){ 
                                  $sub_selected = ""; if(isset($_POST['sel_subcategory']) && $_POST['sel_subcategory'] == $sub['subcat_id']){ $sub_selected = "selected"; }
								  if((!empty($_GET['frs_id']) && $sub['subcat_id']== $fares[0]['fr_subcat_id']) || empty($_GET['frs_id'])){?>
                                 <option value="<?=$sub['subcat_id'];?>" <?=$sub_selected;?>><?=$sub['subcat_name'];?></option>
                                 <? }}}?>
                              </select>
                            </td>
                          </tr>
                          <?  $loc_disp = ((!empty($_GET['frs_id'])) || isset($_POST['sel_destination']))?'':'none';
							if(!empty($_GET['frs_id'])){
								$cond = ($fares[0]['fr_type'] == 1) ? " and cat_id_fk = 1" : " and subcat_id_fk = ".$fares[0]['fr_subcat_id'];
							} else if(isset($_POST['ftype'])){
								$cond = ($_POST['ftype'] == 1) ? " and cat_id_fk = 1" : " and subcat_id_fk = ".$_POST['sel_subcategory'];
							} else {
								$cond = '';
							}?>
                          <tr id="loc_row1" style="display:<?=$loc_disp?>">
                            <td id="loc_label"><strong>Location<span class="red">*</span></strong></td>
                            <td id="loc_dp1">
                              <select name="sel_destination" id="sel_destination" style="width:300px;">
								<? if(empty($_GET['frs_id'])){?><option value="">--Select Location--</option><? }?>
                              <?php if(!empty($_GET['frs_id']) || isset($_POST['sel_destination'])){
                                  $svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where 1 ".$cond." and tloc_status=1 order by tloc_orderby");
                                  while($loc=fetch_array($svr_query)){ $selected = ''; 
								if(!empty($_POST['sel_destination'])){ if($loc['tloc_id']==$_POST['sel_destination']){ $selected = "selected";} }
								 if((!empty($_GET['frs_id']) && $loc['tloc_id'] == $fares[0]['fr_loc_id']) || empty($_GET['frs_id'])) { ?>
                                 <option value="<?=$loc['tloc_id'];?>" <?=$selected;?>><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
                                 <? }}}?>
                              </select>							  
                            </td>
                          </tr>
						<tr>
						  <td>&nbsp;</td>
						  <td><? $class = (!empty($valid_error) && $valid_error == true) ? 'class="error"' : ''; 
						  if(!empty($_GET['frs_id'])) $type = $fares[0]['fr_type']; else if(!empty($_POST['ftype'])) $type = $_POST['ftype']; ?></td>
						</tr>
						<tr id="fares_row" style="display:<?=(isset($_POST['sel_destination']) || !empty($_GET['frs_id'])) ? 'compact' : 'none';?>">
						<td colspan="2" id="fares_details">
						<? if(isset($_POST['sel_destination']) || !empty($_GET['frs_id'])){?>
						<table width="100%" align="left">
						<?php /*?><? if($class != '') {?>
						<!--<tr>
						  <td>&nbsp;</td>
						  <td class="error">Please Fill All the Fields (Numbers Only)</td>
						</tr>-->
						<? }?><?php */?>
						<tr>
						  <td width="20%">&nbsp;</td>
						  <? foreach($ac_types as $ac_type){?>
						  <td align="left"><strong><?=($type == 1) ? $accomodation_type[$ac_type] : $room_type[$ac_type];?> Fare</strong></td>
						  <? } ?>
						</tr>
						<? if(isset($_POST['sel_destination'])) { $dest = $_POST['sel_destination'];?>
						<? $fc_query = query("select fc_id, fc_type, fc_name, concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle from svr_fare_category as fc
							left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
								left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
									left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
										where fc_status = 1 and FIND_IN_SET('".$dest."', fc_locations)"); }
						if(!empty($_GET['frs_id'])) { $dest = $fares[0]['fr_loc_id']; 
							$fc_query = query("select distinct(fc_id), fc_type, fc_name, concat(veh.vp_name, ' ', pax.vp_title, ' PAX') as vehicle from 
							svr_fare_category as fc left join svr_fares as fr on fr.fr_fc_id = fc.fc_id
								left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
									left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
										left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
											where fc_status = 1 and FIND_IN_SET('".$dest."', fc_locations) order by fc_orderby");
						
						}
						$count = num_rows($fc_query);
						if($count > 0){
						$i = 0; while($fare_cat = fetch_array($fc_query)){?>
						<tr>
							<td><strong> <?=($fare_cat['fc_type'] == 1) ? $fare_cat['fc_name'] : $fare_cat['vehicle'];?></strong>
							<input type="hidden" name="fare_cat[<?=$i?>]" value="<?=$fare_cat['fc_id'];?>"></td>
							<? foreach($ac_types as $key => $ac_type){?>
							<td>
                            <input type="text" <? //=$class?> name="fare[<?=$i?>][<?=$key?>]" value="<?=(!empty($_GET['frs_id'])) ? ((isset($my_fares[$fare_cat['fc_id']][$ac_type])) ? $my_fares[$fare_cat['fc_id']][$ac_type] : '') : '';?>">
                            <input name="fare_status[<?=$i?>][<?=$key?>]" type="checkbox" value="1" <?=((!empty($_GET['frs_id']) && $my_fares_status[$fare_cat['fc_id']][$ac_type]==1) ? "checked" : "");?>>
                            </td>
							<? }?>
						</tr>
						<? $i++; }?>
						<tr>
						  <td>&nbsp;</td>
						  <td colspan="<?=sizeof($ac_types)+1?>">&nbsp;</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td colspan="<?=sizeof($ac_types)+1?>"><input type="submit" name="Submit" id="Submit" value=" Save " class="btn_input" /></td>
						</tr>
						<? } else {?>
							<tr><td colspan="2">No Fare Categories Found</td></tr>
						<? }?>
						</table>
						<? }?></td></tr>
						<tr align="center">
						  <td align="center">&nbsp;</td>
						  <td align="left">&nbsp;</td>
						</tr>
				</table>
				</td>
			  </tr>
		  </table>
		  </form>
		  </td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">&nbsp;</td></tr>
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
	if(d.ftype.value == ""){ alert("Please Select Type"); d.ftype.focus(); return false;}
	if(d.ftype.value == 1){
		if(d.from.value == ""){ alert("Please Select From Date"); d.from.focus(); return false; }
		if(d.to.value == ""){ alert("Please Select To Date"); d.to.focus(); return false; }
	}
	if(d.sel_destination.value == ""){ alert("Please Select Destination"); d.sel_destination.focus(); return false;}
}
</script>