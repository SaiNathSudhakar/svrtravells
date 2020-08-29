<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['employee_add']) && $_SESSION['employee_add']=='yes' && isset($_SESSION['employee_manage']) && $_SESSION['employee_manage']=='yes' ) ) ){}else{header("location:welcome.php");}
if($_SERVER['REQUEST_METHOD']=='POST')
{
	//PRIVILEGES
	if(isset($_POST['from_location_manage'])){$from_location_manage='1';} else {$from_location_manage='0';}
	
	if(isset($_POST['to_location_add'])){$to_location_add='1';} else {$to_location_add='0';}
	if(isset($_POST['to_location_manage'])){$to_location_manage='1';} else {$to_location_manage='0';}
	
	if(isset($_POST['places_covered_add'])){$places_covered_add='1';} else {$places_covered_add='0';}
	if(isset($_POST['places_covered_manage'])){$places_covered_manage='1';} else {$places_covered_manage='0';}
	
	if(isset($_POST['seasons_manage'])){$seasons_manage='1';} else {$seasons_manage='0';}
	
	if(isset($_POST['schedule_add'])){$schedule_add='1';} else {$schedule_add='0';}
	if(isset($_POST['schedule_manage'])){$schedule_manage='1';} else {$schedule_manage='0';}
	
	if(isset($_POST['meals_manage'])){$meals_manage='1';} else {$meals_manage='0';}
	
	if(isset($_POST['packages_add'])){$packages_add='1';} else {$packages_add='0';}
	if(isset($_POST['packages_manage'])){$packages_manage='1';} else {$packages_manage='0';}
	
	if(isset($_POST['price_list_add'])){$price_list_add='1';} else {$price_list_add='0';}
	if(isset($_POST['price_list_manage'])){$price_list_manage='1';} else {$price_list_manage='0';}
	
	if(isset($_POST['cms_add'])){$cms_add='1';} else {$cms_add='0';}
	if(isset($_POST['cms_manage'])){$cms_manage='1';} else {$cms_manage='0';}
	
	if(isset($_POST['employee_add'])){$employee_add='1';} else {$employee_add='0';}
	if(isset($_POST['employee_manage'])){$employee_manage='1';} else {$employee_manage='0';}
	
	if(isset($_POST['logdetails_manage'])){$logdetails_manage='1';} else {$logdetails_manage='0';}
	
	
	if(isset($_POST['catg_manage'])){$catg_manage='1';} else {$catg_manage='0';}
	if(isset($_POST['subcatg_manage'])){$subcatg_manage='1';} else {$subcatg_manage='0';}
	if(isset($_POST['nl_manage'])){$nl_manage='1';} else {$nl_manage='0';}
	if(isset($_POST['testimonials_add'])){$testimonials_add='1';} else {$testimonials_add='0';}
	if(isset($_POST['testimonials_manage'])){$testimonials_manage='1';} else {$testimonials_manage='0';}
	if(isset($_POST['footer_manage'])){$footer_manage='1';} else {$footer_manage='0';}
	if(isset($_POST['new_orders_manage'])){$new_orders_manage='1';} else {$new_orders_manage='0';}
	if(isset($_POST['confirm_orders_manage'])){$confirm_orders_manage='1';} else {$confirm_orders_manage='0';}
	if(isset($_POST['cancel_orders_manage'])){$cancel_orders_manage='1';} else {$cancel_orders_manage='0';}
	
if($_POST['user_cnt']==0)
{
	$user_ins="INSERT INTO `tm_users`
	(`user_id`,
`emp_id_fk`, 
`from_location_manage`, 
`to_location_add`, 
`to_location_manage`, 
`places_covered_add`, 
`places_covered_manage`, 
`seasons_manage`, 
`schedule_add`, 
`schedule_manage`, 
`meals_manage`, 
`packages_add`, 
`packages_manage`, 
`price_list_add`, 
`price_list_manage`, 
`cms_add`, 
`cms_manage`, 
`employee_add`, 
`employee_manage`, 
`logdetails_manage`, 
`user_admin_type`, 
`user_status`, 
`user_dateadded`,
`catg_manage`, 
`subcatg_manage`, 
`nl_manage`, 
`testimonials_add`, 
`testimonials_manage`, 
`footer_manage`, 
`new_orders_manage`, 
`confirm_orders_manage`, 
`cancel_orders_manage` 
)
VALUES ('', 
'".$_POST['employee']."',
'$from_location_manage', 
'$to_location_add', 
'$to_location_manage', 
'$places_covered_add', 
'$places_covered_manage', 
'$seasons_manage', 
'$schedule_add', 
'$schedule_manage', 
'$meals_manage', 
'$packages_add', 
'$packages_manage', 
'$price_list_add', 
'$price_list_manage', 
'$cms_add',
'$cms_manage', 
'$employee_add', 
'$employee_manage', 
'$logdetails_manage', 
'subadmin', 
'1', 
'".$now."',
'$catg_manage', 
'$subcatg_manage', 
'$nl_manage', 
'$testimonials_add', 
'$testimonials_manage', 
'$footer_manage', 
'$new_orders_manage', 
'$confirm_orders_manage', 
'$cancel_orders_manage' 
)";
	mysql_query($user_ins);
	header("location:manage_employee.php?st=1&msg=ad");
}
else
{
	$user_up="UPDATE `tm_users` SET 
`from_location_manage`='$from_location_manage', 
`to_location_add`='$to_location_add', 
`to_location_manage`='$to_location_manage', 
`places_covered_add`='$places_covered_add', 
`places_covered_manage`='$places_covered_manage', 
`seasons_manage`='$seasons_manage', 
`schedule_add`='$schedule_add', 
`schedule_manage`='$schedule_manage', 
`meals_manage`='$meals_manage', 
`packages_add`='$packages_add', 
`packages_manage`='$packages_manage', 
`price_list_add`='$price_list_add', 
`price_list_manage`='$price_list_manage', 
`cms_add`='$cms_add',
`cms_manage`='$cms_manage', 
`employee_add`='$employee_add', 
`employee_manage`='$employee_manage', 
`logdetails_manage`='$logdetails_manage',
`catg_manage`='$catg_manage', 
`subcatg_manage`='$subcatg_manage', 
`nl_manage`='$nl_manage', 
`testimonials_add`='$testimonials_add', 
`testimonials_manage`='$testimonials_manage', 
`footer_manage`='$footer_manage', 
`new_orders_manage`='$new_orders_manage', 
`confirm_orders_manage`='$confirm_orders_manage', 
`cancel_orders_manage`='$cancel_orders_manage' WHERE `emp_id_fk` =".$_GET['id'];
	mysql_query($user_up);
	header("location:manage_employee.php?st=1&msg=up");
}
}
if(!empty($_GET['id']))
{
	$user_sel="select * from `tm_users` where emp_id_fk=".$_GET['id'];
	$user_res=mysql_query($user_sel);
	$user_cnt=mysql_num_rows($user_res);
	$user_row=mysql_fetch_array($user_res);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=getdata("tm_emp","emp_name","emp_id='".$_GET['id']."'")." ".getdata("tm_emp","emp_lastname","emp_id='".$_GET['id']."'");?> Privileges </strong></td>
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
<form name="user_form" id="user_form" method="post" action="" onSubmit="return task_valid()">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
					    <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="75%" align="right" class="sub_heading_red"><? if(isset($errmsg)) echo $errmsg;?></td>
                    <td align="right"><a href="manage_employee.php?st=1"><strong><span class="main_heading_black">
                      <input type="hidden" name="employee" value="<?=$_GET['id'];?>" />
                      <input type="hidden" name="user_cnt" value="<?=$user_cnt;?>" /></span>Manage CMS</strong></a></td>
                    </tr>
              </table></td>
			    </tr>
					  <tr>
						<td align="center" valign="top"><table width="60%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><fieldset><legend class="main_heading">PRIVILEGES</legend><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="datatable">
						  <tr>
						    <td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                              <tr>
                                <td align="left"><strong> Categories</strong></td>
                              </tr>
                              <tr>
                                <td align="left"><input name="catg_manage" type="checkbox" id="catg_manage" value="catg_manage" <? if((isset($_POST['catg_manage']) && $_POST['catg_manage']=='catg_manage') || (!empty($_GET['id']) && $user_row['catg_manage']=='1') ) echo 'checked';?> />
                                  	Categories							  </td>
                              </tr>
                              <tr>
                                <td align="left"><input name="subcatg_manage" type="checkbox" id="subcatg_manage" value="subcatg_manage" <? if((isset($_POST['subcatg_manage']) && $_POST['subcatg_manage']=='subcatg_manage') || (!empty($_GET['id']) && $user_row['catg_manage']=='1') ) echo 'checked';?> />
                                  	Sub Categories</td>
                              </tr>
                              <tr>
                                <td align="left"><input name="subsubcatg_manage" type="checkbox" id="subsubcatg_manage" value="subsubcatg_manage" <? if((isset($_POST['subsubcatg_manage']) && $_POST['subsubcatg_manage']=='subsubcatg_manage') || (!empty($_GET['id']) && $user_row['subsubcatg_manage']=='1') ) echo 'checked';?> />
                                  Sub SubCategories</td>
                              </tr>
                            </table></td>
						    <td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                              <tr>
                                <td align="left"><strong>From Locations</strong></td>
                              </tr>
                              <tr>
                                <td align="left"><input name="from_location_manage" type="checkbox" id="from_location_manage" value="from_location_manage"  <? if((isset($_POST['from_location_manage']) && $_POST['from_location_manage']=='from_location_manage') || (!empty($_GET['id']) && $user_row['from_location_manage']=='1') ) echo 'checked';?> />
                                  Manage</td>
                              </tr>
                            </table></td>
						    <td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                              <tr>
                                <td align="left"><strong>Destination Locations</strong></td>
                              </tr>
                              <tr>
                                <td align="left"><input name="to_location_add" type="checkbox" id="to_location_add" value="to_location_add"  <? if((isset($_POST['to_location_add']) && $_POST['to_location_add']=='to_location_add') || (!empty($_GET['id']) && $user_row['to_location_add']=='1') ) echo 'checked';?> />
                                  Add</td>
                              </tr>
                              <tr>
                                <td align="left"><input name="to_location_manage" type="checkbox" id="to_location_manage" value="to_location_manage"  <? if((isset($_POST['to_location_manage']) && $_POST['to_location_manage']=='to_location_manage') || (!empty($_GET['id']) && $user_row['to_location_manage']=='1') ) echo 'checked';?> />
                                  Manage</td>
                              </tr>
                            </table></td>
						    <td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                              <tr>
                                <td align="left"><strong>Places Covered</strong></td>
                              </tr>
                              <tr>
                                <td align="left"><input name="places_covered_add" type="checkbox" id="places_covered_add" value="places_covered_add"  <? if((isset($_POST['places_covered_add']) && $_POST['places_covered_add']=='places_covered_add') || (!empty($_GET['id']) && $user_row['places_covered_add']=='1') ) echo 'checked';?> />
                                  Add</td>
                              </tr>
                              <tr>
                                <td align="left"><input name="places_covered_manage" type="checkbox" id="places_covered_manage" value="places_covered_manage"  <? if((isset($_POST['places_covered_manage']) && $_POST['places_covered_manage']=='places_covered_manage') || (!empty($_GET['id']) && $user_row['places_covered_manage']=='1') ) echo 'checked';?> />
                                  Manage</td>
                              </tr>
                            </table></td>
							<td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                              <tr>
                                <td align="left"><strong>Packages</strong></td>
                              </tr>
                              <tr>
                                <td align="left"><input name="packages_add" type="checkbox" id="packages_add" value="packages_add"  <? if((isset($_POST['packages_add']) && $_POST['packages_add']=='packages_add') || (!empty($_GET['id']) && $user_row['packages_add']=='1') ) echo 'checked';?> />
                                  Add</td>
                              </tr>
                              <tr>
                                <td height="58" align="left"><input name="packages_manage" type="checkbox" id="packages_manage" value="packages_manage"  <? if((isset($_POST['packages_manage']) && $_POST['packages_manage']=='packages_manage') || (!empty($_GET['id']) && $user_row['packages_manage']=='1') ) echo 'checked';?> />
                                  Manage</td>
                              </tr>
                            </table>
							  <!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Seasons</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="seasons_manage" type="checkbox" id="seasons_manage" value="seasons_manage"  <? if((isset($_POST['seasons_manage']) && $_POST['seasons_manage']=='seasons_manage') || (!empty($_GET['id']) && $user_row['seasons_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>--></td>
							</tr>
						  <tr>
						    <td colspan="5" align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    </tr>
						  <tr>
						    <td align="center" valign="top" bgcolor="#F6F6F6"><!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Schedule</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="schedule_add" type="checkbox" id="schedule_add" value="schedule_add"  <? if((isset($_POST['schedule_add']) && $_POST['schedule_add']=='schedule_add') || (!empty($_GET['id']) && $user_row['schedule_add']=='1') ) echo 'checked';?> /> Add</td>
  </tr>
  <tr>
	<td align="left"><input name="schedule_manage" type="checkbox" id="schedule_manage" value="schedule_manage"  <? if((isset($_POST['schedule_manage']) && $_POST['schedule_manage']=='schedule_manage') || (!empty($_GET['id']) && $user_row['schedule_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>--></td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong> Sub Categories</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="subcatg_manage" type="checkbox" id="subcatg_manage" value="subcatg_manage" <? if((isset($_POST['subcatg_manage']) && $_POST['subcatg_manage']=='subcatg_manage') || (!empty($_GET['id']) && $user_row['subcatg_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
<!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Meals</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="meals_manage" type="checkbox" id="meals_manage" value="meals_manage"  <? if((isset($_POST['meals_manage']) && $_POST['meals_manage']=='meals_manage') || (!empty($_GET['id']) && $user_row['meals_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>-->
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong> Sub SubCategories</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="subcatg_manage" type="checkbox" id="subcatg_manage" value="subcatg_manage" <? if((isset($_POST['subcatg_manage']) && $_POST['subcatg_manage']=='subcatg_manage') || (!empty($_GET['id']) && $user_row['subcatg_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>

							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>News Letter</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="nl_manage" type="checkbox" id="nl_manage" value="nl_manage" <? if((isset($_POST['nl_manage']) && $_POST['nl_manage']=='nl_manage') || (!empty($_GET['id']) && $user_row['nl_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Testimonials</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="testimonials_add" type="checkbox" id="testimonials_add" value="testimonials_add"  <? if((isset($_POST['testimonials_add']) && $_POST['testimonials_add']=='testimonials_add') || (!empty($_GET['id']) && $user_row['testimonials_add']=='1') ) echo 'checked';?> /> Add</td>
  </tr>
  <tr>
	<td align="left"><input name="testimonials_manage" type="checkbox" id="testimonials_manage" value="testimonials_manage"  <? if((isset($_POST['testimonials_manage']) && $_POST['testimonials_manage']=='testimonials_manage') || (!empty($_GET['id']) && $user_row['testimonials_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    </tr>
						  <tr>
						    <td colspan="5" align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    </tr>
						  <tr>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Employee</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="employee_add" type="checkbox" id="employee_add" value="employee_add"  <? if((isset($_POST['employee_add']) && $_POST['employee_add']=='employee_add') || (!empty($_GET['id']) && $user_row['employee_add']=='1') ) echo 'checked';?> /> Add</td>
  </tr>
  <tr>
	<td align="left"><input name="employee_manage" type="checkbox" id="employee_manage" value="employee_manage"  <? if((isset($_POST['employee_manage']) && $_POST['employee_manage']=='employee_manage') || (!empty($_GET['id']) && $user_row['employee_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Log Details</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="logdetails_manage" type="checkbox" id="logdetails_manage" value="logdetails_manage"  <? if((isset($_POST['logdetails_manage']) && $_POST['logdetails_manage']=='logdetails_manage') || (!empty($_GET['id']) && $user_row['logdetails_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Footer</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="footer_manage" type="checkbox" id="footer_manage" value="footer_manage"  <? if((isset($_POST['footer_manage']) && $_POST['footer_manage']=='footer_manage') || (!empty($_GET['id']) && $user_row['footer_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>Orders</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="new_orders_manage" type="checkbox" id="new_orders_manage" value="new_orders_manage"  <? if((isset($_POST['new_orders_manage']) && $_POST['new_orders_manage']=='new_orders_manage') || (!empty($_GET['id']) && $user_row['new_orders_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
  <tr>
    <td align="left"><input name="confirm_orders_manage" type="checkbox" id="confirm_orders_manage" value="confirm_orders_manage"  <? if((isset($_POST['confirm_orders_manage']) && $_POST['confirm_orders_manage']=='confirm_orders_manage') || (!empty($_GET['id']) && $user_row['confirm_orders_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
  <tr>
    <td align="left"><input name="cancel_orders_manage" type="checkbox" id="cancel_orders_manage" value="cancel_orders_manage"  <? if((isset($_POST['cancel_orders_manage']) && $_POST['cancel_orders_manage']=='cancel_orders_manage') || (!empty($_GET['id']) && $user_row['cancel_orders_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table>
							</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
	<td align="left"><strong>CMS</strong></td>
  </tr>
  <tr>
	<td align="left"><input name="cms_add" type="checkbox" id="cms_add" value="cms_add"  <? if((isset($_POST['cms_add']) && $_POST['cms_add']=='cms_add') || (!empty($_GET['id']) && $user_row['cms_add']=='1') ) echo 'checked';?> /> Add</td>
  </tr>
  <tr>
	<td align="left"><input name="cms_manage" type="checkbox" id="cms_manage" value="cms_manage"  <? if((isset($_POST['cms_manage']) && $_POST['cms_manage']=='cms_manage') || (!empty($_GET['id']) && $user_row['cms_manage']=='1') ) echo 'checked';?> /> Manage</td>
  </tr>
</table></td>
						    </tr>
						  <tr>
						    <td colspan="5" align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    </tr>
						  <tr>
						    <td align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    <td colspan="2" align="center" valign="top" bgcolor="#F6F6F6"><input name="Submit" type="submit" class="OrangeButton" id="button" value="Save" /></td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    <td align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
						    </tr>
						</table>
                            </fieldset></td>
                          </tr>
                        </table></td>
					  </tr>
					  <tr>
					    <td align="center">&nbsp;</td>
			    </tr>
				</table>
</form>
		  </td>
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