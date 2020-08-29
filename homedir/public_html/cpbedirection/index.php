<?
ob_start();
//@session_start();
include_once("../includes/functions.php");
$logos=get_logos();
$bcc_mail='';
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$errmsg="";
	//SESSIONS
	
	$qur_user=query("select * from `tm_emp` as e,`tm_users` as u where e.emp_id=u.emp_id_fk and e.emp_status=1 and u.user_status=1 and e.emp_uname='".$_POST['log_id']."' and e.emp_pswd='".md5($_POST['log_pswd'])."'");
	$cnt_user=num_rows($qur_user);
	$row_user=fetch_array($qur_user);
	if($row_user['emp_permtype']=='UNLIMITED'){$cnt_perm='1';} else { if($row_user['emp_permto']>=$now){ $cnt_perm='1'; } else { $cnt_perm='0'; } } 
	if($cnt_user>0 && $cnt_perm>0)
	{
		
		//LOG-IN SUCCESS
		//CREATE USER SESSIONS
		
		$_SESSION['tm_id']=$row_user['emp_id'];
		$_SESSION['tm_regid']=$row_user['emp_regid'];
		$_SESSION['tm_dispname']=$row_user['emp_dispname'];
		$_SESSION['tm_type']=$row_user['user_admin_type'];

		if($row_user['user_admin_type']<>'admin')
		{
			//SUB-ADMIN PRIVILEGES
			$_SESSION['tm_priv'] = explode(',',$row_user['emp_privileges']);
		}
		//INSERT LOGIN DETAILS
		$ipAry = explode('.', $_SERVER['REMOTE_ADDR']);
		$ipStr = str_pad(dechex($ipAry[0]), 2, "0", STR_PAD_LEFT) . str_pad(dechex($ipAry[1]), 2, "0", STR_PAD_LEFT) . str_pad(dechex($ipAry[2]), 2, "0", STR_PAD_LEFT) . str_pad(dechex($ipAry[3]), 2, "0", STR_PAD_LEFT);
		$ipInt = hexdec($ipStr);
		query("insert into `tm_logindetails` (`login_regid`,`in_time`,`logintime`,`ipaddress`,`login_user`,`login_dateadded`) values('".$_SESSION['tm_id']."','".$now_onlytime."','".$now_time."','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['tm_type']."','".$now."')");

//$log_insertid=insert_id();
$log_insertid = mysqli_insert_id($conn);

		
		$_SESSION['logd_id']=$log_insertid;
		//LAST LOGIN DATE - TIME
		$last_log=explode(" ",getdata("tm_logindetails","logintime","login_regid='".$_SESSION['tm_id']."' and login_id!='".$_SESSION['logd_id']."' order by login_id desc limit 0,1"));
		$_SESSION['tm_lastlogindate']=date("jS-M' Y",strtotime($last_log[0]));	// Last LOGIN-DATE
		$_SESSION['tm_lastlogintime']=$last_log[1];								// Last LOGIN-TIME
		$_SESSION['ses_serdate']=date('d-m-Y');
		//LOGIN-SUCCESS MAIL
		$log_date=explode(" ",$now_time);
		$log_date1=explode("-",$log_date[0]);
		$ldate=$log_date1[2]."-".$log_date1[1]."-".$log_date1[0];
		$mail_body="<style type=text/css>
		<!--
		td { font-family: Tahoma;font-size: 12px;}
		.Headings{font-family: Tahoma;font-size:12px; font-weight: bold; color:#228A07;}
		.Headings1{font-family: Tahoma; font-size:12px; font-weight: bold; color:#FB8A36; text-decoration:none}
		.name{clear:#0B55C4; font-size:11px; font-weight:bold; padding-left:3px;}
		.price_green{font-family:Tahoma;font-size:12px;font-weight:bold; color: #09B642; text-decoration:none; }
		.blue_bold{font-family:Tahoma;font-size:12px;font-weight:bold; color: #4040FF; text-decoration:none; }
		.blue_lighter{font-family:Tahoma;font-size:12px;font-weight:lighter; color: #4040FF; text-decoration:none; }
		.sub_heading_black{	height:20px;color:#000000;font-size:11px;padding-left:3px;}
		.main_heading_green {height:20px;color:#09B642;font-size:11px; font-weight:bold;padding-left:3px;}
		-->
		</style>
		<table width='70%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#9DACBF'>
		<tr><td bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<tr><td align='left' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<td rowspan='9'>&nbsp;</td>
		<tr><td>&nbsp;</td></tr>
		<tr><td><strong> Dear Sir, </strong></td></tr>
		<tr><td>Details for <strong class='price_green'>INTRANET APPLICATION Admin - Login Success</strong><br><br>Log-In Attempt Details:</td></tr>
		<tr><td>Date / Time : ".$ldate." / ".$log_date[1]."</td></tr>
		<tr><td>Username : ".$_POST['log_id']."</td></tr>
		<tr><td>Password : ******</td></tr>
		<tr><td>IP Address : ".$_SERVER['REMOTE_ADDR']."</td></tr>
		<tr><td>URL : "."</td></tr>
		<tr><td>&nbsp;</td></tr>
		</table></td>
		</tr>
		</table></td>
		</tr>
		</table>";
		//echo $mail_body; exit;
		$mailto = $mastermail;
		$mailheader = 'MIME-Version: 1.0' . "\r\n";
		$mailheader.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$mailheader.= 'From: '.$_SESSION['tm_dispname']."-".$_SESSION['tm_desig']."<".$_SESSION['tm_email'].">". "\r\n";
		$mailheader.='Bcc: '.$bcc_mail. "\r\n";
		$mess='INTRANET APPLICATION Admin-Success Log-In Attempt ';
		//@mail($mailto,$mess,$mail_body,$mailheader);
		//@session_unregister("bitra_site"); @session_register("bitra_site"); $_SESSION['bitra_site']='Task';
		header("location:welcome.php");
	
	}
	else if($cnt_user>0 && $cnt_perm==0)
	{
	//ACCESS DENIED
		$log_date=explode(" ",$now_time);
		$log_date1=explode("-",$log_date[0]);
		$ldate=$log_date1[2]."-".$log_date1[1]."-".$log_date1[0];
		//$emp_id_fk=getdata("tm_users","emp_id_fk","emp_uname='".$_POST['log_id']."'");
		$emp_name=getdata("tm_emp","emp_dispname","emp_uname='".$_POST['log_id']."'");
		
		$mail_body="<style type=text/css>
		<!--
		td { font-family: Tahoma;font-size: 12px;}
		.Headings {font-family: Tahoma;font-size: 12px; font-weight: bold; color:#228A07;}
		.Headings1 {font-family: Tahoma; font-size: 12px; font-weight: bold; color:#FB8A36; text-decoration:none}
		.name{ clear:#0B55C4; font-size:11px; font-weight:bold; padding-left:3px;}
		.price_yellow{font-family:Tahoma;font-size:12px;font-weight:bold; color: #FF9900; text-decoration:none; }
		.blue_bold{font-family:Tahoma;font-size:12px;font-weight:bold; color: #4040FF; text-decoration:none; }
		.blue_lighter{font-family:Tahoma;font-size:12px;font-weight:lighter; color: #4040FF; text-decoration:none; }
		.sub_heading_black{	height:20px;color:#000000;font-size:11px;padding-left:3px;}
		.sub_heading_yellow{height:20px;color:#FF9900;font-size:11px;padding-left:3px;}
		-->
		</style>
		<table width='70%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#9DACBF'>
		<tr><td bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<tr><td align='left' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<td rowspan='10'>&nbsp;</td>
		<tr><td>&nbsp;</td></tr>
		<tr><td><strong> Dear Sir, </strong></td></tr>
		<tr><td>Here is the details for <strong class='price_yellow'>INTRANET APPLICATION Admin - Access Denied</strong><br><br>Log-In Attempt Details:</td></tr>
		<tr><td>Employee Name : <strong>".$emp_name."</strong></td></tr>
		<tr><td>Date / Time : ".$ldate." / ".$log_date[1]."</td></tr>
		<tr><td>Username : ".$_POST['log_id']."</td></tr>
		<tr><td>Password : ".$_POST['log_pswd']."</td></tr>
		<tr><td>IP Address : ".$_SERVER['REMOTE_ADDR']."</td></tr>
		<tr><td>URL : "."</td></tr>
		<tr><td>&nbsp;</td></tr>
		</table></td>
		</tr>
		</table></td>
		</tr>
		</table>";
		//echo $mail_body; exit;
		$mailto = $mastermail;
		$mailheader = 'MIME-Version: 1.0' . "\r\n";
		$mailheader.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$mailheader.= 'From: '.$emp_name." - ".$_POST['log_id']."<".$frommail.">". "\r\n";
		$mailheader.= 'Reply-To: sales@svrtravelsindia.com'."\r\n";
		$mailheader.= 'Bcc: '.$bcc_mail. "\r\n";
		$mess='INTRANET APPLICATION Admin Access Denied';
		//@mail($mailto,$mess,$mail_body,$mailheader);
		$err_denied="Application Log-In Time Period is over, Please Contacnt Administrator";
	}
	else
	{
		//LOGIN-FAILURE :
		$log_date=explode(" ",$now_time);
		$log_date1=explode("-",$log_date[0]);
		$ldate=$log_date1[2]."-".$log_date1[1]."-".$log_date1[0];
		//$emp_id_fk=getdata("tm_users","emp_id_fk","user_login='".$_POST['log_id']."'");
		$emp_name=getdata("tm_emp","emp_dispname","emp_uname='".$_POST['log_id']."'");
		
		$mail_body="<style type=text/css>
		<!--
		td{font-family: Tahoma;font-size: 12px;}
		.Headings{font-family: Tahoma;font-size: 12px; font-weight: bold; color:#228A07;}
		.Headings1{font-family: Tahoma; font-size: 12px; font-weight: bold; color:#FB8A36; text-decoration:none}
		.name{clear:#0B55C4; font-size:11px; font-weight:bold; padding-left:3px;}
		.price_red{font-family:Tahoma;font-size:12px;font-weight:bold; color: #F9554F; text-decoration:none; }
		.blue_bold{font-family:Tahoma;font-size:12px;font-weight:bold; color: #4040FF; text-decoration:none; }
		.blue_lighter{font-family:Tahoma;font-size:12px;font-weight:lighter; color: #4040FF; text-decoration:none; }
		.sub_heading_black{	height:20px;color:#000000;font-size:11px;padding-left:3px;}
		-->
		</style>
		<table width='70%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#9DACBF'>
		<tr><td bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<tr><td align='left' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='0'>
		<td rowspan='9'>&nbsp;</td>
		<tr><td>&nbsp;</td></tr>
		<tr><td><strong> Dear Sir, </strong></td></tr>
		<tr><td>Here is the details for <strong class='price_red'>INTRANET APPLICATION Login Failed</strong> <br><br>Log-In Attempt Details:</td></tr>
		<tr><td>Date / Time : ".$ldate." / ".$log_date[1]."</td></tr>
		<tr><td>Username :  ".$_POST['log_id']."</td></tr>
		<tr><td>Password : ".$_POST['log_pswd']."</td></tr>
		<tr><td>IP Address : ".$_SERVER['REMOTE_ADDR']."</td></tr>
		<tr><td>URL : "."</td></tr>
		<tr><td>&nbsp;</td></tr>
		</table></td>
		</tr>
		</table></td>
		</tr>
		</table>";
		//echo $mail_body; exit;
		$mailto = $mastermail;
		$mailheader  = 'MIME-Version: 1.0' . "\r\n";
		$mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$mailheader.='From: '.$emp_name." - ".$_POST['log_id']."<".$frommail.">". "\r\n";
		$mailheader.='Reply-To: sales@svrtravelsindia.com'."\r\n" ;
		$mailheader.='Bcc: '.$bcc_mail. "\r\n";
		$mess='INTRANET APPLICATION Admin-Failed Log-In Attempt ';
		//@mail($mailto,$mess,$mail_body,$mailheader);
		$errmsg1="Invalid UserName / Password";
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
</head>
<body onLoad="javascript:document.form_index.log_id.focus();">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb">
		<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
		    <td colspan="3" valign="middle"><img src="images/spacer.gif" border="0" /></td>
	      </tr>
		  <tr>
			<td width="300" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
<!--<td><img src="<?=$logos['LEFT']['path']?>" alt="<?=$logos['LEFT']['alt']?>" title="<?=$logos['LEFT']['alt']?>" border="0" /></td>
-->                <td><img src="images/bitranet/logo_side.gif" width="405" height="75" border="0" /></td>
              </tr>
            </table>
		    </td>
			<td align="center">&nbsp;</td>
			<td width="300" align="right"><a href="<?=$logos['RIGHT']['url']?>" target="_blank"><img src="<?=$logos['RIGHT']['path']?>" alt="<?=$logos['RIGHT']['alt']?>" title="<?=$logos['RIGHT']['alt']?>" border="0" /></a></td>
		  </tr>
	  </table>
    </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="350" valign="top"><table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <? if(isset($err_denied)){?>
			<tr>
              <td align="center" class="bold-red"><?=$err_denied;?></td>
            </tr>
			<? } else {?>
            <tr>
              <td align="center" valign="top">
			  <form name="form_index" id="form_index" action="" method="post" onSubmit="return valid()">
			    <table border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="30" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" class="sub_heading_blue">Use valid username and password to access </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="390" align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="5">
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right">Username</td>
                        <td width="10" align="center"><strong>:</strong></td>
                        <td align="left"><input name="log_id" type="text" class="input" id="log_id" size="20" /></td>
                      </tr>
                      <tr>
                        <td align="right">Password</td>
                        <td align="center"><strong>:</strong></td>
                        <td align="left"><input name="log_pswd" type="password" class="input" id="log_pswd" size="20" /></td>
                      </tr>
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                      </tr>
                      <? if(isset($errmsg)){?>
		  <tr>
			<td colspan="3" align="right"><table width="60%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td><div class="red" id="err">In-Valid <br /> Username and Password... <br /> (you provided <? echo $_POST['log_id'];?>)</div></td>
				</tr>
			</table></td>
		  </tr>
                      <? }?>
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle">
						<!--
						<input type="submit" name="Submit" id="Submit" value="Submit" class="btn_input" />
						-->
						<input type="submit" name="button" id="button" value="Login" class="inputbutton"/></td>
                      </tr>
                      <!--
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><a href="includes/forgot_password.php" class="f11"><strong>Forgot Password ?</strong></a> </td>
                      </tr>
                      -->
                    </table></td>
                  </tr>
              </table>
              </form></td>
            </tr>
            <? }?>
      </table></td>
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
<script language="javascript">
function valid(){
 var d=document.form_index;
 if(d.log_id.value==""){alert("Please enter Username");d.log_id.focus();return false;}
 if(d.log_pswd.value==""){alert("Please enter Password");d.log_pswd.focus();return false;}
}
</script>