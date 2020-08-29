<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

$pwd="";
if($_SERVER['REQUEST_METHOD']=="POST"){

if(!empty($_SESSION['tm_id'])){
$cpwd = query("select emp_uname,emp_pswd from tm_emp where emp_pswd='".md5($_POST['txt_current_pwd'])."' and emp_id='".$_SESSION['tm_id']."'");
$row = num_rows($cpwd);

if($row==0){
	header("location:change_password.php?err=r");
}
else{
	$up = query("update tm_emp set emp_pswd='".md5($_POST['txt_new_pwd'])."' where emp_id='".$_SESSION['tm_id']."'");

session_destroy();
header("location:index.php");
}
}
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Change Password </strong></td>

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
<form action="" method="post" name="form1" id="form1" onsubmit="return validate();" enctype="multipart/form-data">
			    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="6" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
							 <? if(!empty($_GET['err'])){ ?>
                            <tr>
                              <td colspan="2" align="center" class="red"><? echo "Old password is incorrect."; ?></td>
                            </tr>
							<? }?>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Current password  <span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_current_pwd" type="password" class="input" id="txt_current_pwd" size="30" /></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>New password<span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_new_pwd" type="password" class="input" id="txt_new_pwd" size="30" /></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Confirm password<span class="red">*</span></strong></td>
                              <td align="left"><input name="txt_confirm_pwd" type="password"  class="input" id="txt_confirm_pwd" size="30" /></td>
                            </tr>
                            <tr>
                              <td align="center">&nbsp;</td>
                              <td><input type="submit" name="Submit" id="Submit" value="Submit" class="btn_input" /></td>
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
		if(d.txt_current_pwd.value==""){ alert("Please Enter Current Password"); d.txt_current_pwd.focus(); return false; }
		if(d.txt_new_pwd.value==""){ alert("Please Enter New Password"); d.txt_new_pwd.focus(); return false;} 	
		if(d.txt_confirm_pwd.value==""){ alert("Please Enter Same Password"); d.txt_confirm_pwd.focus(); return false; }
		if(d.txt_confirm_pwd.value!=d.txt_new_pwd.value){ alert("Passwords Are Not-Matched"); d.txt_confirm_pwd.focus(); return false; }
	}
</script>