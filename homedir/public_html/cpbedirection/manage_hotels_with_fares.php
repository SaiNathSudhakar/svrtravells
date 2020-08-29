<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('vehicle',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

if(!empty($_GET['f_status'])){
	if($_GET['f_status']=="active"){$status=1;}else{$status=0;}
	query("update svr_hotel_fares set hfr_status=".$status." where hfr_id='".$_GET['sid']."'");
	header("location:manage_hotels_with_fares.php");
}

$page_query = query("select hfr_id from svr_hotel_fares where hfr_status = 1");
$total=num_rows($page_query);

$len=30; $start=0;
$link="manage_hotels_with_fares.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

//$cond .= ($type_fltr_vpax != '') ? " order by vp_type asc, subcat_orderby asc" : " order by subcat_id desc";

$result = query("select * from svr_hotel_fares where 1 order by hfr_id desc limit $start, $len");
$count_order = num_rows($result);

if($_SERVER['REQUEST_METHOD']=="POST"){ 
	$cond = (!empty($_GET['id']))? "and hfr_id != ".$_GET['id'] : '';
	$q = query("select hfr_id from svr_hotel_fares where 1 and hfr_ht_name = '".$_POST['txtvalue']."'".$cond);
	$count = num_rows($q); if( $count > 0 ) { $error = 'Name aleady exists'; }
	
	else
	{	
		if(!empty($_GET['id'])){
			$update = query("update svr_hotel_fares set hfr_ht_name='".$_POST['txtvalue']."', hfr_fare='".$_POST['fare']."', hfr_fu_fare='".$_POST['fufare']."', hfr_address='".$_POST['address']."', hfr_mobile='".$_POST['mobile']."', hfr_email='".$_POST['email']."' where hfr_id='".$_GET['id']."'");
			header("location:manage_hotels_with_fares.php");
		} else {

		query("insert into svr_hotel_fares(hfr_ht_name, hfr_fare, hfr_fu_fare, hfr_address, hfr_mobile, hfr_email, hfr_dateadded) values('".$_POST['txtvalue']."', '".$_POST['fare']."', '".$_POST['fufare']."', '".$_POST['address']."', '".$_POST['mobile']."', '".$_POST['email']."', '".$now_time."')");
			header("location:manage_hotels_with_fares.php");
		}
	}
}
if(!empty($_GET['id'])){
	$row = query("select * from svr_hotel_fares where hfr_status = 1 and hfr_id='".$_GET['id']."'");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo;  Bus Bookings  &raquo; Hotels &raquo; Manage Hotels</strong></td>
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
                              <td width="2%" rowspan="4" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Hotel Name <span class="red">*</span></strong></td>
                              <td align="left">
							  <? $name = ''; if(!empty($_POST['txtvalue'])) $name = $_POST['txtvalue']; else if(!empty($_GET['id'])) $name = $row_result['hfr_ht_name'];?>
							  <input name="txtvalue" type="text" class="input" id="txtvalue" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr>
                                <td align="left" class="sub_heading_black"><strong> Hotel Fare Per Night<span class="red">*</span></strong></td>
                                <td align="left">
                                  <? $name = ''; if(!empty($_POST['fare'])) $name = $_POST['fare']; else if(!empty($_GET['id'])) $name = $row_result['hfr_fare'];?>
                                  <input name="fare" type="text" class="input" id="fare" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="left" class="sub_heading_black"><strong> Hotel Fare FreshUp<span class="red">*</span></strong></td>
                                <td align="left">
                                  <? $name = ''; if(!empty($_POST['fufare'])) $name = $_POST['fufare']; else if(!empty($_GET['id'])) $name = $row_result['hfr_fu_fare'];?>
                                  <input name="fufare" type="text" class="input" id="fufare" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="left" class="sub_heading_black"><strong>Hotel Address<span class="red">*</span></strong></td>
                                <td align="left">
                                  <? $name = ''; if(!empty($_POST['address'])) $name = $_POST['address']; else if(!empty($_GET['id'])) $name = $row_result['hfr_address'];?>
                                  <textarea name="address" class="input" id="address" style="width:197px"><?=$name?></textarea>
                                  <span id="categ"></span></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="left" class="sub_heading_black"><strong>Contact Number <span class="red">*</span></strong></td>
                                <td align="left">
                                  <? $name = ''; if(!empty($_POST['mobile'])) $name = $_POST['mobile']; else if(!empty($_GET['id'])) $name = $row_result['hfr_mobile'];?>
                                  <input name="mobile" type="text" class="input" id="mobile" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="left" class="sub_heading_black"><strong>Email-Id<span class="red">*</span></strong></td>
                                <td align="left">
                                  <? $name = ''; if(!empty($_POST['email'])) $name = $_POST['email']; else if(!empty($_GET['id'])) $name = $row_result['hfr_email'];?>
                                  <input name="email" type="text" class="input" id="email" title="" value="<?=$name?>" size="30" maxlength="99" /><span id="categ"></span></td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value=" <? if(!empty($_GET['id'])){ echo "Update";} else{ echo "Add";} ?> " class="btn_input" onclick="return check_valid();" /><input type="button" value="Cancel" onclick="window.location='manage_hotels_with_fares.php'"></td>
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
			<td class="tablehead"><strong>Hotel Name</strong></td>
            <td class="tablehead"><strong>Price Per Night</strong></td>
            <td class="tablehead"><strong>FreshUp Price</strong></td>
            <td class="tablehead"><strong>Address</strong></td>
            <td class="tablehead"><strong>Contact No.</strong></td>
            <td class="tablehead"><strong>Email-Id</strong></td>
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
			if($fetch['hfr_status']==1){
				$f_status ='<a href="manage_hotels_with_fares.php?sid='.$fetch["hfr_id"].'&f_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
			}else if($fetch['vp_status']==0){
				$f_status='<a href="manage_hotels_with_fares.php?sid='.$fetch["hfr_id"].'&f_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="3%" height="25" align="left"><?=$sno;?>.</td>
			<td align="left" width="15%"><?=$fetch['hfr_ht_name'];?></td>
            <td align="left" width="10%">Rs. <?=$fetch['hfr_fare'];?></td>
            <td align="left" width="10%">Rs. <?=$fetch['hfr_fu_fare'];?></td>
            <td align="left" width="20%"><?=$fetch['hfr_address'];?></td>
            <td align="left" width="13%"><?=$fetch['hfr_mobile'];?></td>
            <td align="left" width="15%"><?=$fetch['hfr_email'];?></td>
			<td width="5%" align="center"><a href="manage_hotels_with_fares.php?id=<?=$fetch['hfr_id']?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a></td>
    		<td width="5%" align="center"><? echo $f_status; ?></td>
	  </tr>
		  <? 
		  }}
		  else if($count_order==0){?>
		  <tr><td height="50" colspan="10" align="center" bgcolor="#CCC" class="red">No Records Found</td>
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
  if(document.getElementById('txtvalue').value==''){ alert("Please enter Name"); document.getElementById('txtvalue').focus(); return false;}
  if(document.getElementById('fare').value==''){ alert("Please enter Fare per night"); document.getElementById('fare').focus(); return false;}
  if(document.getElementById('fufare').value==''){ alert("Please enter Freshup fare"); document.getElementById('fufare').focus(); return false;}
}
</script>