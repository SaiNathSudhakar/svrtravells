<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('vehpax',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_vehicles_with_pax set v_status=".$status." where v_id='".$_GET['sid']."'");
	header("location:manage_vehicles_with_pax.php");
}
$page_query = query("select v_id from svr_vehicles_with_pax");
$total=num_rows($page_query);
$len=30; $start=0;
$link="manage_vehicles_with_pax.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

$result = query("select v.*, veh.vp_name as vehicle, pax.vp_name as paxx from svr_vehicles_with_pax as v
		left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
			left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id 
				order by v_id desc limit $start, $len");
$count_order = num_rows($result);
  
if($_SERVER['REQUEST_METHOD']=="POST"){
	$cond = (!empty($_GET['id']))? "and v_id != ".$_GET['id'] : '';
	$q = query("select v_id from svr_vehicles_with_pax where 1 ".$cond." and v_vehicle_id = '".$_POST['vehicle']."' and v_pax_id = '".$_POST['pax']."'");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Combination aleady exists'; }
	
	if($count == 0)
	{	
		if(!empty($_GET['id'])){
			$update = query("update svr_vehicles_with_pax set v_vehicle_id='".$_POST['vehicle']."', v_pax_id = '".$_POST['pax']."' where v_id='".$_GET['id']."'");
			header("location:manage_vehicles_with_pax.php");
		} else {
			query("insert into svr_vehicles_with_pax(v_vehicle_id, v_pax_id, v_status, v_dateadded) values('".$_POST['vehicle']."', '".$_POST['pax']."', 1, '".$now_time."')");
			header("location:manage_vehicles_with_pax.php");
		}
	}
}
if(!empty($_GET['id'])){
	$row = query("select * from svr_vehicles_with_pax where v_id='".$_GET['id']."'");
	$fetch = fetch_array($row);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Vehicles with PAX </strong></td>
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
                              <td width="2%" rowspan="4" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
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
								if(!empty($_GET['id']) && $row['vp_id'] == $fetch['v_vehicle_id']) $selected = "selected"; else $selected = '';?>
									<option value="<?=$row['vp_id']?>" <?=$selected;?>><?=$row['vp_name']?></option>
								<? }?>
							  </select>							  
							  </td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> PAX <span class="red">*</span></strong></td>
                              <td align="left">
							  <select name="pax" id="pax" style="width:120px">
							    <option value="">Select PAX</option>
								<? $q = query('select vp_id, vp_name from svr_vehicles_pax where vp_type = 2 and vp_status = 1');
								while($row = fetch_array($q)){?>
								<? if(!empty($_POST['pax']) && $_POST['pax'] == $row['vp_id']) $selected = "selected"; else 
								if(!empty($_GET['id']) && $row['vp_id'] == $fetch['v_pax_id']) $selected = "selected"; else $selected = '';?>
									<option value="<?=$row['vp_id']?>" <?=$selected;?>><?=$row['vp_name']?></option>
								<? }?>
							  </select>							  
							  </td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
							  <td align="center">&nbsp;</td>
                              <td align="left">	<input type="submit" name="Submit" id="Submit" value="<? if(!empty($_GET['id'])){ echo "Update";} else{ echo "Add";} ?>" class="btn_input" onclick="return check_valid();" /><input type="button" onclick="javascript:window.location='manage_vehicles_with_pax.php'" value="Cancel"></td>
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
			<td class="tablehead"><strong>PAX</strong></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
-->			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
			<? }?>
		  </tr>
		  </thead>
		  <?php
			
			  $sno = $start; if($count_order>0){
			  while($fetch=fetch_array($result)){
			  $sno++;
			  
			  
			if($fetch['v_status']==1){
				$f_status ='<a href="manage_vehicles_with_pax.php?sid='.$fetch["v_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['v_status']==0){
				$f_status='<a href="manage_vehicles_with_pax.php?sid='.$fetch["v_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=$fetch['vehicle'];?></td>
			<td align="left"><?=$fetch['paxx'].' PAX';?></td>
			<td width="5%" align="center"><a href="manage_vehicles_with_pax.php?id=<?=$fetch['v_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
<!--<td width="5%" align="center"><? echo $f_status; ?></td>
-->		  </tr>
		  <? 
		  }}
		  else if($count_order==0){?>
		  <tr><td height="50" colspan="11" align="center" bgcolor="#CCC" class="red">No Records Found</td>
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
  if(document.getElementById('vehicle').value==''){ alert("Please select Vehicle"); document.getElementById('vehicle').focus(); return false;}
  if(document.getElementById('pax').value==''){ alert("Please select PAX"); document.getElementById('pax').focus(); return false;}
}
</script>