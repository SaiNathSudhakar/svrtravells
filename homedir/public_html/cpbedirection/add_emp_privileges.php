<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['employee_add']) && $_SESSION['employee_add']=='yes' && isset($_SESSION['employee_manage']) && $_SESSION['employee_manage']=='yes' ) ) ){}else{header("location:welcome.php");}
if($_SERVER['REQUEST_METHOD']=='POST')
{
	//PRIVILEGES
	$privileges = implode(',',$_POST['priv']);
	
	if(!empty($_GET['id']))
	{
		$user_up="UPDATE `tm_emp` SET  emp_privileges='".$privileges."' WHERE `emp_id`=".$_GET['id'];
		query($user_up);
		header("location:manage_employee.php?st=1&msg=up");
	}
}
if(!empty($_GET['id']))
{
	$user_sel="select emp_privileges from `tm_emp` where emp_id=".$_GET['id'];
	$user_res=query($user_sel);
	$user_cnt=num_rows($user_res);
	$user_row=fetch_array($user_res);
	$privileges = explode(',',$user_row['emp_privileges']);
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
<script language="javascript" src="../includes/script_valid.js"></script></head>
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
	  <input type="hidden" name="user_cnt" value="<?=$user_cnt;?>" /></span>Manage Privileges</strong></a></td>
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
					<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="cat" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('cat',$privileges) ) echo 'checked';?> />Categories</td>
						
				  </tr>
				  <tr>
					<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="subcat" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('subcat',$privileges) ) echo 'checked';?> />Sub Categories</td>
						
				  </tr>
				  <tr>
					<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="subsubcat" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('subsubcat',$privileges) ) echo 'checked';?> />Sub SubCategories</td>
					 
				  </tr>
				  <tr>
				    <td align="left">&nbsp;</td>
				    </tr>
				</table></td>
				<td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
				  <tr>
					<td align="left"><strong>Tour</strong></td>
				  </tr>
				  <tr>
					<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="floc" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('floc',$privileges) ) echo 'checked';?> />From Location </td>
					  
				  </tr>
				  <tr>
				    <td align="left"><strong>Destination Locations</strong></td>
				    </tr>
				  <tr>
				    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="tloc" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('tloc',$privileges) ) echo 'checked';?> />Add</td>
                      
				    </tr>
				  <tr>
				    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="tlocm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('tlocm',$privileges) ) echo 'checked';?> />Manage</td>
                      
				    </tr>
				</table></td>
				<td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Places Covered</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="placov" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('placov',$privileges) ) echo 'checked';?> />Add</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="placovm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('placovm',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><strong>Pickup Points </strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="pick" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('pick',$privileges) ) echo 'checked';?> />Add</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="pickm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('pickm',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                </table></td>
				<td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>CMS</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="cms" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('cms',$privileges) ) echo 'checked';?> />Add</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="cmsm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('cmsm',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><strong>Gallery</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="gallery" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('gallery',$privileges) ) echo 'checked';?> />Add</td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="gallerym" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('gallerym',$privileges) ) echo 'checked';?>  />Mannage</td>
                  </tr>
                </table></td>
				<td width="25%" align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left" nowrap="nowrap"><strong>Latest Updates </strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="updates" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('updates',$privileges) ) echo 'checked';?> />Add</td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="updatesm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('updatesm',$privileges) ) echo 'checked';?>  />Mannage</td>
                  </tr>
                  <tr>
                    <td align="left"><strong>Testimonials</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="test" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('test',$privileges) ) echo 'checked';?> />Add</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="testm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('testm',$privileges) ) echo 'checked';?> />Manage</td>
                      
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
</table>-->
				  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                    <tr>
                      <td align="left"><strong>Newsletter</strong></td>
                    </tr>
                    <tr>
                      <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="news" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('news',$privileges) ) echo 'checked';?> />Manage</td>
                        
                    </tr>
                    <tr>
                      <td align="left">&nbsp;</td>
                    </tr>
                  </table></td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Settings</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="sett" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('sett',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                </table>
				  <!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
<tr>
<td align="left"><strong>Meals</strong></td>
</tr>
<tr>
<td align="left"><input name="meals_manage" type="checkbox" id="meals_manage" value="meals_manage"  <? if((isset($_POST) && $_POST['meals_manage']=='meals_manage') || (!empty($_GET['id']) && $user_row['meals_manage']=='1') ) echo 'checked';?> /> Manage</td>
</tr>
</table>-->				</td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Employee</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="emp" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('emp',$privileges) ) echo 'checked';?> />Add</td>
                      
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="empm" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('empm',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                </table></td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Log Details</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="log" <? if((isset($_POST)|| !empty($_GET['id'])) && in_array('log',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                </table></td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Footer</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="footer" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('footer',$privileges) ) echo 'checked';?> />Manage</td>
                      
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                </table></td>
				</tr>
			  <tr>
				<td colspan="5" align="center" valign="top" bgcolor="#F6F6F6">&nbsp;</td>
				</tr>
			  <tr>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Settings</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="vehicle" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('vehicle',$privileges) ) echo 'checked';?> /> Vehicles</td>
                  </tr>
				  
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="pax" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('pax',$privileges) ) echo 'checked';?> />Pax</td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="vehpax" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('vehpax',$privileges) ) echo 'checked';?> />Vehicles Pax</td>
                  </tr>
				   <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="travel" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('travel',$privileges) ) echo 'checked';?> />Travel Charges</td>
                  </tr>
				   <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="room" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('room',$privileges) ) echo 'checked';?> />Room Charges</td>
                  </tr>
				  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                </table></td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                 
                  <tr>
                    <td align="left"><strong>Fare Category </strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="farcat" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('farcat',$privileges) ) echo 'checked';?> />Add</td>
                  </tr>
				  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="farcatm" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('farcatm',$privileges) ) echo 'checked';?> />Manage</td>
                  </tr>
				   <tr>
                    <td align="left"><strong>Fares</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="fares" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('fares',$privileges) ) echo 'checked';?> />Add</td>
                  </tr>
				  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="faresm" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('faresm',$privileges) ) echo 'checked';?> />Manage</td>
                  </tr>
				   <tr>
                    <td align="left"><strong>Packages</strong></td>
                  </tr>
				  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="pack" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('pack',$privileges) ) echo 'checked';?> />Add</td>
                  </tr>
				  
				   <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="packm" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('packm',$privileges) ) echo 'checked';?> />Manage</td>
                  </tr>
				    
                </table></td>
				<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
                  <tr>
                    <td align="left"><strong>Customers</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="customers" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('customers',$privileges) ) echo 'checked';?> />Customers</td>
                  </tr>
                  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="custbook" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('custbook',$privileges) ) echo 'checked';?> />Bookings</td>
                  </tr>
				  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="custcancle" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('custcancle',$privileges) ) echo 'checked';?> />Canclellation</td>
                  </tr>
				  <tr>
                    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="enq" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('enq',$privileges) ) echo 'checked';?> />Enquiries</td>
                  </tr>
				     <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
				  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                </table></td>
<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
  <tr>
    <td align="left"><strong>Agents</strong></td>
  </tr>
  <tr>
    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="agents" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('agents',$privileges) ) echo 'checked';?> />Add Agents</td>
  </tr>
  	<tr>
	<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="agentsm" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('agentsm',$privileges) ) echo 'checked';?> />Manage Agents</td>
	</tr>
   <tr>
    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="deposit" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('deposit',$privileges) ) echo 'checked';?> />Deposits</td>
  </tr>
  <tr>
    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="agentbook" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('agentbook',$privileges) ) echo 'checked';?> />Bookings</td>
  </tr>
 
  <tr>
    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="agentcancle" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('agentcancle',$privileges) ) echo 'checked';?> />Canclellation</td>
  </tr>
  <tr>
    <td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="report" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('report',$privileges) ) echo 'checked';?> />Reports</td>
  </tr>

</table>
<!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
<tr>
<td align="left"><strong>Orders</strong></td>
</tr>
<tr>
<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="orders" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('orders',$privileges) ) echo 'checked';?> /> Orders</td>
</tr>
<tr>
<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="confirm" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('confirm',$privileges) ) echo 'checked';?> /> Confirm</td>
</tr>
<tr>
<td align="left"><input name="priv[]" type="checkbox" id="priv[]" value="cancel" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('cancel',$privileges) ) echo 'checked';?> /> Cancel</td>
</tr>
</table>-->	</td>
	<td align="center" valign="top" bgcolor="#F6F6F6"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
      <tr>
        <td align="left"><strong>Bus Bookings </strong></td>
      </tr>
      <tr>
        <td align="left" nowrap="nowrap"><input name="priv[]" type="checkbox" id="priv[]" value="busbook" <? if((isset($_POST) || !empty($_GET['id'])) && in_array('busbook',$privileges) ) echo 'checked';?> />Bus Bookings</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
	  <tr>
        <td align="left">&nbsp;</td>
      </tr>
	  <tr>
        <td align="left">&nbsp;</td>
      </tr>
	  <tr>
        <td align="left">&nbsp;</td>
      </tr>
	 <tr>
       <td align="left">&nbsp;</td>
    </tr>

    </table>
	  <!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bor_task datatable">
      <tr>
        <td align="left"><strong>Packages</strong></td>
      </tr>
      <tr>
        <td align="left"><input name="priv[]4" type="checkbox" id="priv[]4" value="pack" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('pack',$privileges) ) echo 'checked';?> />
          Add</td>
      </tr>
      <tr>
        <td  align="left"><input name="priv[]4" type="checkbox" id="priv[]4" value="packm" <? if((isset($_POST['catg_manage'])|| !empty($_GET['id'])) && in_array('packm',$privileges) ) echo 'checked';?> />
          Manage</td>
      </tr>
    </table>--></td>
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