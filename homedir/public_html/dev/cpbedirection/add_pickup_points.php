<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pick',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$img_err_msg1=''; $img_err_msg='';

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$place_name = str_replace("'","&#39;",$_POST['place_name']);
	$small_desc = str_replace("'","&#39;",$_POST['text_small_desc']);
	$large_desc = str_replace("'","&#39;",$_POST['text_large_desc']);
	//$ref_no = $_POST['ref_no_hid'];	$path = "../uploads/places_covered/".$ref_no."/";


	if(empty($img_err_msg) && empty($size_err_msg) && empty($img_err_msg1) && empty($size_err_msg1))
	{
		if(!empty($_GET['p_id']))
		{	
			$up=query("update svr_pickup_points set tloc_id_fk = '".$_POST['dest_name']."', pick_name = '".$place_name."', pick_time = '".$_POST['time1']."', pick_note = '".$_POST['note']."' where pick_id='".$_GET['p_id']."'");
			header("location:manage_pickup_points.php");
		}else{
			query("insert into svr_pickup_points(tloc_id_fk, pick_name, pick_time,pick_note ,pick_status, pick_dateadded) values('".$_POST['dest_name']."', '".$place_name."', '".$_POST['time1']."', '".$_POST['note']."', 1, '".$now_time."')");
			header("location:manage_pickup_points.php");
		}
	}
}
$edit = "Add";
if(!empty($_GET['p_id']))
{	
	$row = query("select * from svr_pickup_points where pick_id='".$_GET['p_id']."'");
	$result = fetch_array($row);
	$edit = "Update";
	//$path = "../uploads/places_covered/".$result['place_ref_no']."/";
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
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery.ui.timepicker.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery.multiple.select.js"></script>
<script src="../js/jquery-ui.js" type="text/javascript" ></script>
<script src="../js/jquery.ui.timepicker.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function(){
	$('#time1').timepicker({
		showNowButton: true,
		showDeselectButton: true,
		showLeadingZero: false,
		showPeriod: true,
		defaultTime: '',  // removes the highlighted time for when the input is empty.
		showCloseButton: true
	});
	$("#dest_name").multipleSelect({
		placeholder: 'Select Destination',
		single: true,
		multiple: false,
		selectAll: false,
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo;
                  <?=$edit;?> Pickup Points </strong></td>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><form method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
              <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="right"><a href="manage_pickup_points.php"><strong>Manage Pickup Places </strong></a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
                        <td width="2%" rowspan="12" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                      </tr>
                      <? if(!empty($size_err_msg1)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$size_err_msg1;?></strong></td>
                      </tr>
                      <? }if(!empty($img_err_msg1)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$img_err_msg1;?></strong></td>
                      </tr>
                      <? }if(!empty($size_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$size_err_msg;?></strong></td>
                      </tr>
                      <? }if(!empty($img_err_msg)){ ?>
                      <tr>
                        <td colspan="2" class="red" align="center"><strong><?=$img_err_msg;?></strong></td>
                      </tr>
                      <? }?>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                        <td align="left">
                          <select name="dest_name" id="dest_name">
                            <? $dest_name = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where tloc_status = 1 and cat_id_fk = 1 order by tloc_orderby");
							  while($dest_fetch = fetch_array($dest_name)){ ?>
                            <option value="<?=$dest_fetch['tloc_id'];?>"
							<? if(!empty($_POST['dest_name']) && $_POST['dest_name']==$dest_fetch['tloc_id']){ echo "selected";} 
							   else if(!empty($_GET['p_id'])){ if($dest_fetch['tloc_id']==$result['tloc_id_fk']){ echo "selected";} }?>>
                            <?=$dest_fetch['tloc_name']; ?> <?=' ('.$dest_fetch['tloc_code'].')'; ?>
                            </option>
                            <? }?>
                          </select>                  
                        </td>
                      </tr>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong>Pickup Place Name <span class="red">*</span></strong></td>
                        <td align="left"><input name="place_name" type="text" class="input" id="place_name" size="50"  value="<? if(!empty($_POST['place_name'])){ echo $_POST['place_name'];} else if(!empty($_GET['p_id'])) echo $result['pick_name'];?>" title="" /></td>
                      </tr>
                      <tr>
                        <td width="25%" class="sub_heading_black"><strong><span id="time1_caption">Time </span> <span class="red">*</span></strong></td>
                        <td align="left" valign="top"><div id="sample2"><input type="text" name="time1" id="time1" placeholder="Select Time" /><!--<img src="images/Clock-icon.png" width="25" />--></div>                      </td>
                      </tr>
                      <tr>
                        <td width="25%" valign="top" class="sub_heading_black"><strong>Note <span class="red">*</span></strong></td>
                        <td align="left">
                        <input name="note" type="text" class="input" id="note" size="50"  value="<? if(!empty($_POST['note'])){ echo $_POST['note'];} else if(!empty($_GET['p_id'])) echo $result['pick_note'];?>" title="" /> </td>
                      </tr>
                      
                      
                      <tr align="center">
                        <td align="center">&nbsp;</td>
                        <td align="left"><input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" onclick="return check_valid();" /></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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
  if(document.getElementById('dest_name').value==''){ alert("Please select location"); document.getElementById('dest_name').focus(); return false;}
  if(document.getElementById('place_name').value==''){ alert("Please enter place Name"); document.getElementById('place_name').focus(); return false;}
  if(document.getElementById('time1').value==''){ alert("Please select time"); document.getElementById('time1').focus(); return false;}
  if(document.getElementById('note').value==''){ alert("Please enter note"); document.getElementById('note').focus(); return false;}
}
</script>
