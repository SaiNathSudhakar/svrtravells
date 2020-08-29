<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pax',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$cond = "1"; $type_fltr = $type_fltr_vpax = "";

if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_vehicles_pax set vp_status=".$status." where vp_id='".$_GET['sid']."'");
	header("location:manage_vehicles_pax.php");
}
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset"){
	unset($_SESSION["type_fltr_vpax"]);
	header("location:manage_vehicles_pax.php");
}

//category filter
if(!empty($_GET['type_fltr']) || isset($type_fltr_vpax)){
	if(!empty($_GET['type_fltr'])) { $_SESSION['type_fltr_vpax'] = $_GET['type_fltr']; }
	$type_fltr_vpax = (isset($_SESSION['type_fltr_vpax'])) ? $_SESSION['type_fltr_vpax'] : '';
	
	if($type_fltr_vpax != ''){	$type_fltr = " and vp_type = ".$type_fltr_vpax; }
}
$cond .= $type_fltr;

$page_query = query("select vp_id from svr_vehicles_pax where $cond");
$total=num_rows($page_query);

$len=30; $start=0;
$link="manage_vehicles_pax.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

//$cond .= ($type_fltr_vpax != '') ? " order by vp_type asc, subcat_orderby asc" : " order by subcat_id desc";

$result = query("select * from svr_vehicles_pax where $cond order by vp_id desc limit $start, $len");
$count_order = num_rows($result);

if($_SERVER['REQUEST_METHOD']=="POST"){
	$replace = str_replace("'","&#39;",$_POST['txtvalue']); $min = $max = '';
	$cond = (!empty($_GET['id']))? "and vp_id != ".$_GET['id'] : '';
	$q = query("select vp_id from svr_vehicles_pax where 1 ".$cond." and vp_type = '".$_POST['type']."' and vp_name = '".$replace."'");
	$count = num_rows($q); if( $count > 0 ) { $error = 'Name aleady exists'; }
	
	if($count == 0)
	{	
		if($_POST['type'] == 2) $replace = str_replace(' ', '', $replace);
		list($min, $max) = explode('-', $replace); if($max == '') $max = $min;
		if(!empty($_GET['id'])){
			$update = query("update svr_vehicles_pax set vp_name='".$replace."', vp_min = '".$min."', vp_max = '".$max."', vp_type = '".$_POST['type']."' where vp_id='".$_GET['id']."'");
			header("location:manage_vehicles_pax.php");
		} else {
			query("insert into svr_vehicles_pax(vp_type, vp_name, vp_min, vp_max, vp_status, vp_dateadded) values('".$_POST['type']."', '".$replace."', '".$min."', '".$max."', 1,'".$now_time."')");
			header("location:manage_vehicles_pax.php");
		}
	}
}
if(!empty($_GET['id'])){
	$row = query("select * from svr_vehicles_pax where vp_id='".$_GET['id']."'");
	$row_result = fetch_array($row);
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
<script language="javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/jquery-ui.min.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Vehicles and PAX </strong></td>
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
			<form method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
			    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
					<? if(!empty($error)){?>
						<tr><td class="error" align="center"><?=$error;?></td></tr>
						<tr><td>&nbsp;</td></tr>
					<? }?>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="5" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Type  <span class="red">*</span></strong></td>
                              <td align="left" id="type_dp">
							  <select name="type" id="type" style="width:120px">
								<? foreach($vehicles_pax as $key => $value){?>
								<? if(!empty($_POST['type']) && $_POST['type'] == $key) $selected = "selected"; else 
								if(!empty($_GET['id']) && $row_result['vp_type'] == $key) $selected = "selected"; else $selected = '';?>
									<option value="<?=$key?>" <?=$selected;?>><?=$value?></option>
								<? }?>
							  </select>
							  </td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Name <span class="red">*</span></strong></td>
                              <td align="left">
							  <? $name = ''; if(!empty($_POST['txtvalue'])) $name = $_POST['txtvalue']; else if(!empty($_GET['id'])) $name = $row_result['vp_name'];?>
							  <input name="txtvalue" type="text" class="input" id="txtvalue" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value=" <? if(!empty($_GET['id'])){ echo "Update";} else{ echo "Add";} ?> " class="btn_input" onclick="return check_valid();" /><input type="reset" value="Cancel"></td>
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
		  <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
			<tr>
			  <td width="5%" align="left" valign="middle" nowrap="nowrap">
			  <select name="type_filter" id="type_filter" class="textbox" onchange="window.location='manage_vehicles_pax.php?type_fltr='+this.value">
				<? foreach($vehicles_pax as $key => $value){?>
					<option value="<?=$key?>" <? if($type_fltr_vpax == $key){?>selected<? }?>><?=$value?></option>
				<? }?>
			  </select>
			  <? if(!empty($type_fltr_vpax)){ ?>
				  <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_vehicles_pax.php?src=reset'" title="Reset"/>
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
			<td width="10%" class="tablehead">Type</td>
			<td class="tablehead"><strong>Name</strong></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" /></td>
			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
			<? }?>
		  </tr>
		  </thead>
		  <?php
			
			  $sno = $start; if($count_order>0){
			  while($fetch=fetch_array($result)){
			  $sno++;
			  
			  
			if($fetch['vp_status']==1){
				$f_status ='<a href="manage_vehicles_pax.php?sid='.$fetch["vp_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['vp_status']==0){
				$f_status='<a href="manage_vehicles_pax.php?sid='.$fetch["vp_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left"><?=$vehicles_pax[$fetch['vp_type']];?></td>
			<td align="left"><?=$fetch['vp_name'];?></td>
			<td width="5%" align="center"><a href="manage_vehicles_pax.php?id=<?=$fetch['vp_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
			<td width="5%" align="center"><? echo $f_status; ?></td>
		  </tr>
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
  if(document.getElementById('type').value==''){ alert("Please select Type"); document.getElementById('type').focus(); return false;}
  if(document.getElementById('txtvalue').value==''){ alert("Please enter Name"); document.getElementById('txtvalue').focus(); return false;}
  if(document.getElementById('type').value == 2){
  	var reg = /^\d+(-\d+)?$/;
 	if (!reg.test(document.getElementById('txtvalue').value)){ alert("Please enter valid PAX"); document.getElementById('txtvalue').focus(); return false; }
  }
}
</script>