<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['price_list_add']) && $_SESSION['price_list_add']=='yes' ) ) ){}else{header("location:welcome.php");}
if($_SERVER['REQUEST_METHOD']=="POST")
{
$price_cate =str_replace("'","&#39;",$_POST['txt_price_category']);
	if(!empty($_GET['pl_id']))
	{
		query("update svr_pricelist set tloc_id_fk='".$_POST['sel_destination']."',price_category='".$price_cate."',price_season_one='".$_POST['txt_price_sea_one']."',price_season_two='".$_POST['txt_price_sea_two']."',price_servicetax_season_one='".$_POST['txt_price_service_sea_one']."',price_servicetax_season_two='".$_POST['txt_price_service_sea_two']."',price_convenience_charges__season_one='".$_POST['txt_price_conve_sea_one']."',price_convenience_charges__season_two='".$_POST['txt_price_conve_sea_two']."' where price_id='".$_GET['pl_id']."'");
		header("location:manage_pricelist.php");
	}
	else
	{	
		query("insert into svr_pricelist(tloc_id_fk,price_category,price_season_one,price_season_two,price_servicetax_season_one,price_servicetax_season_two,price_convenience_charges__season_one,price_convenience_charges__season_two,price_status,price_dateadded) values('".$_POST['sel_destination']."','".$price_cate."','".$_POST['txt_price_sea_one']."','".$_POST['txt_price_sea_two']."','".$_POST['txt_price_service_sea_one']."','".$_POST['txt_price_service_sea_two']."','".$_POST['txt_price_conve_sea_one']."','".$_POST['txt_price_conve_sea_two']."',1,'".$now_time."')");
		header("location:manage_pricelist.php");
	}
}
$edit ="Add";
if(!empty($_GET['pl_id']))
{
  $row = query("select * from svr_pricelist where price_id='".$_GET['pl_id']."'");
  $schedule = fetch_array($row);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Price List </strong></td>
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
			<form action="" method="post" name="form1" id="form1" onsubmit="return validate()" enctype="multipart/form-data">
			    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				    <td align="right"><a href="manage_pricelist.php"><strong>Manage Pricelist </strong></a></td>
				  </tr> 
				  <tr>
					<td>&nbsp;</td>
				  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="11" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td width="35%" align="left" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                              <td align="left"><select name="sel_destination" id="sel_destination">
                                <option value="">--Select Location--</option>
								<?php
								  	$svr_query = query("select tloc_id, tloc_name, tloc_type from svr_to_locations where tloc_status=1 order by tloc_orderby");
									while($loc=fetch_array($svr_query)){
									list($nights, $days) = explode('|', $loc['tloc_type']);
									$type = ((!empty($nights)) ? $nights.' Nights' : '').((!empty($nights)) ? ' / '.$nights.' Days' : '');
								  ?>
								   <option value="<?=$loc['tloc_id'];?>" <? if(!empty($_GET['pl_id'])){ if($loc['tloc_id']==$schedule['tloc_id_fk']){ echo "selected";} }?> ><?=$loc['tloc_name'];?> - (<?=$type;?>)</option>
								   <? }?>
                                </select></td>
                            </tr>
                            <tr >
                              <td width="35%"><strong>Price Category <span class="red">*</span></strong></td>
                              <td ><input name="txt_price_category" type="text" class="input" id="txt_price_category" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_category']; } ?>" /></td>
                            </tr>
                            <tr >
                              <td width="35%"><strong> Price  <span class="red">*</span></strong></td>
                              <td ><input name="txt_price_sea_one" type="text"  class="input" id="txt_price_sea_one" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_season_one']; } ?>"/></td>
                            </tr>
                            <tr >
                              <td><strong>Price Service Tax  <span class="red">*</span></strong></td>
                              <td ><input name="txt_price_service_sea_one" type="text" class="input" id="txt_price_service_sea_one" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_servicetax_season_one']; } ?>" /></td>
                            </tr>
                            <tr >
                              <td><strong>Price Convenience charges</strong></td>
                              <td ><input name="txt_price_conve_sea_one" type="text" class="input" id="txt_price_conve_sea_one" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_convenience_charges__season_one']; } ?>" /></td>
                            </tr>
                            <tr >
                              <td>&nbsp;</td>
                              <td >&nbsp;</td>
                            </tr>
<!--<tr >
<td width="35%"><strong>Price Season Two </strong></td>
<td ><input name="txt_price_sea_two" type="text" class="input" id="txt_price_sea_two" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_season_two']; } ?>" /></td>
</tr>
<tr >
<td width="35%"><strong>Price Service Tax Season Two </strong></td>
<td ><input name="txt_price_service_sea_two" type="text"  class="input" id="txt_price_service_sea_two" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_servicetax_season_two']; } ?>"/></td>
</tr>
<tr >
<td width="35%"><strong>Price Convenience charges Season Two </strong></td>
<td ><input name="txt_price_conve_sea_two" type="text"  class="input" id="txt_price_conve_sea_two" size="30" value="<? if(!empty($_GET['pl_id'])){ echo $schedule['price_convenience_charges__season_two']; } ?>"/></td>
</tr>
-->                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" /></td>
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
		if(d.sel_destination.value==""){ alert("Please Select Your Location"); d.sel_destination.focus(); return false; }
		if(d.txt_price_category.value==""){ alert("Please Enter Your Category"); d.txt_price_category.focus(); return false;} 	
		if(d.txt_price_sea_one.value==""){ alert("Please Enter Price Season One"); d.txt_price_sea_one.focus(); return false; }
		if(d.txt_price_service_sea_one.value==""){ alert("Please Enter Price Service Tax Season One"); d.txt_price_service_sea_one.focus(); return false; }
	}
</script>