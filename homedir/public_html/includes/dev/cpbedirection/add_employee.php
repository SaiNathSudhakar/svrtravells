<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('emp',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$max='svr-'.getdata("tm_emp","max(emp_id)+1","1");
if($_SERVER['REQUEST_METHOD']=="POST"){
$first_name =str_replace("'","&#39;",$_POST['txt_fname']);
$last_name =str_replace("'","&#39;",$_POST['txt_lname']);
$display_name =str_replace("'","&#39;",$_POST['txt_displayname']);
$user_name =str_replace("'","&#39;",$_POST['txt_username']);
$password =str_replace("'","&#39;",$_POST['txt_password']);
	if(!empty($_GET['e_id'])){
		mysql_query("update tm_emp set emp_name='".$first_name."',emp_lastname='".$last_name."',emp_gender='".$_POST['rad_gender']."',emp_contactno='".$_POST['txt_connumber']."',emp_dispname='".$display_name."',emp_uname='".$user_name."' where emp_id='".$_GET['e_id']."'");
		header("location:manage_employee.php");
	}else{
		$qry = mysql_query("select emp_uname from tm_emp where emp_uname='".$user_name."'");
		$user_cnt=mysql_num_rows($qry);		
		if($user_cnt==0)
		{
			mysql_query("insert into tm_emp(emp_regid,emp_name,emp_lastname,emp_gender, emp_contactno, emp_dispname, emp_uname, emp_pswd, emp_status, emp_permtype, emp_dateadded) values('".$max."','".$first_name."','".$last_name."','".$_POST['rad_gender']."','".$_POST['txt_connumber']."','".$display_name."','".$user_name."','".md5($password)."',1,'UNLIMITED','".$now."')");
			header("location:manage_employee.php");
		}
		else
		{
		$err_msg='<font color=red>User Name Already Exists, Please try with new one.</font>';
			//header("location:add_employee.php?msg=exists&txt_fname=".$_POST['txt_fname']);
		}
	}
}
$edit = "Add";
if(!empty($_GET['e_id'])){
	$result = mysql_query("select * from tm_emp where emp_id='".$_GET['e_id']."'");
	$fetch = mysql_fetch_array($result);
$edit = "Update";	
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
<style type="text/css">
.style1 {font-weight: bold}
</style>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?>  Employee</strong></td>
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
                  <tr>
				    <td align="right"><a href="manage_employee.php"><strong>Manage Employee</strong></a></td>
				  </tr>
				  <tr>
				    <td>
					<? if(!empty($err_msg)) {
					echo $err_msg;
					}
					?>
					&nbsp;</td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="10" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> First Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_fname" type="text" id="txt_fname" value="<? if(!empty($_POST['txt_fname'])){ echo $_POST['txt_fname'];}  if(!empty($_GET['e_id'])){ echo $fetch['emp_name'];}?>" /></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Last Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_lname" type="text" id="txt_lname" value="<? if(!empty($_POST['txt_lname'])){ echo $_POST['txt_lname'];} if(!empty($_GET['e_id'])){ echo $fetch['emp_lastname'];}?>"/></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Gender <span class="red">*</span></strong></td>
                              <td align="left"><input name="rad_gender" type="radio" id="rad_gender" value="Male"
							  <? 
							  if(!empty($_POST['rad_gender']) && $_POST['rad_gender']=='Male'){ echo "checked";}
							  if(!empty($_GET['e_id'])){ if($fetch['emp_gender']=='Male'){ echo "checked";}}?>/>Male
                              <input name="rad_gender" type="radio" id="rad_gender" value="Female"
							  <? 
							  if(!empty($_POST['rad_gender']) && $_POST['rad_gender']=='Female'){ echo "checked";}
							  if(!empty($_GET['e_id'])){ if($fetch['emp_gender']=='Female'){ echo "checked";}}?> />Female</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Contact Number <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_connumber" type="text" id="txt_connumber" onKeyPress="return NumbersOnly(this, event)" value="<? if(!empty($_POST['txt_connumber'])){ echo $_POST['txt_connumber'];} if(!empty($_GET['e_id'])){ echo $fetch['emp_contactno'];}?>" maxlength="15" /></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Display Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_displayname" type="text" id="txt_displayname" value="<? if(!empty($_POST['txt_displayname'])){ echo $_POST['txt_displayname'];} if(!empty($_GET['e_id'])){ echo $fetch['emp_dispname'];}?>"/></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>User Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_username" type="text" id="txt_username" value="<? if(!empty($_POST['txt_username'])){ echo $_POST['txt_username'];} if(!empty($_GET['e_id'])){ echo $fetch['emp_uname'];}?>"/></td>
                            </tr>
							<? if(empty($fetch['emp_pswd'])){?>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Password <span class="red">*</span></strong></td>
                              <td align="left">
							  <input name="txt_password" type="password" id="txt_password" value="" /></td>
                            </tr>
                            <? }?>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value="<?=$edit;?>" class="btn_input" onclick="return validate();" /></td>
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
	if(d.txt_fname.value==""){ alert("Please Enter your Firstname"); d.txt_fname.focus(); return false; }
	if(d.txt_lname.value==""){ alert("Please Enter your Lastname"); d.txt_lname.focus(); return false;} 	
	if(d.rad_gender[0].checked==false && d.rad_gender[1].checked==false){alert('please select your gender'); d.rad_gender[0].focus(); return false; }
	if(d.txt_connumber.value==""){ alert("Please Enter your Phone Number"); d.txt_connumber.focus(); return false; }
	if(d.txt_connumber.value.length<10){ alert("Please enter correct phone number."); d.txt_connumber.focus(); return false;}
	if(d.txt_displayname.value==""){ alert("Please Enter Display Name"); d.txt_displayname.focus(); return false; }
	if(d.txt_username.value==""){ alert("Please Enter your Username"); d.txt_username.focus(); return false;} 	
	if(d.txt_password.value==""){ alert("Please Enter your Password"); d.txt_password.focus(); return false; }
}
function NumbersOnly(MyField, e, dec)
{
var key;
var keychar;
if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
if ((key==null) || (key==0) || (key==8) ||
    (key==9) || (key==13) || (key==27) )
   return true;
else if ((("0123456789()+-").indexOf(keychar) > -1))
   return true;
else if (dec && (keychar == "."))
   {
   MyField.form.elements[dec].focus();
   return false;
   }
else
   return false;
}
</script>