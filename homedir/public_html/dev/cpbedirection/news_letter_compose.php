<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['hid_field']) && $_POST['hid_field']=='ok'){

	$content="<table width='90%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
	  <tr><td colspan='3' align='justify'>".$_POST['content']."</td></tr></table>";
	
	$emlids = explode(",", $_POST['toemail']);
	$mails = implode(",", $emlids);
	
	$data['subject'] = 'Newsletter From SVR Travels India';
	$data['content'] = $content;
	$data['to_email'] = $mails;
	send_email($data);
	
	/*for ($i=0; $i<=count($emlids)-2; $i++)
	{	
		//echo $mail_body;
		//$mailto = "sales@svrholidays.com";
	
		//$mailto = "prasadm@bitragroup.com";
		$mailto = $emlids[$i];
		$mailheader  = 'MIME-Version: 1.0' . "\r\n";
		$mailheader.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$mailheader.="From: SVR Travels India (P) LTD <sales@svrholidays.com>\r\n";
		$mailheader.="Bcc: prasadm@bitragroup.com"."\r\n";
		$message="News Letter From svrtravelsindia.com";
		@mail($mailto,$message,$mail_body,$mailheader);
	}*/
	
	header("location:news_letter.php");
}

$mail_id='';
	if(!empty($_POST['cl_mailid'])){
	$mailid=$_POST['cl_mailid'];
	for($i=0;$i<count($_POST['cl_mailid']);$i++){
		$mail_id.=$mailid[$i].", ";
	}
	//$mail_id=substr($mail_id,0,-2);
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
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; News Letter</strong></td>

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
			    <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="5" align="left" class="sub_heading_black">&nbsp;</td>
                              <td colspan="2" align="right" class="sub_heading_black"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td width="25%" class="sub_heading_black">E-Mail ID(s)  <span class="red">*</span></td>
                              <td><textarea name="toemail" style="width:475px; height:75px; resize:none;" class="box" id="toemail"><? if(!empty($mail_id)){echo $mail_id;} ?></textarea></td>
                            </tr>
                            <tr>
                              <td width="25%">Mail Body </td>
                			  <td align="left">&nbsp;</td>
                            </tr>
                            <tr align="">
						    <td colspan="2" align="left"><textarea name="content" id="content" class="ckeditor"><? //if(!empty($_GET['id'])){ echo $row_de['cnt_content'];}?></textarea></td>                            </tr>
                            <tr align="center">
                              <td>&nbsp;</td>
                              <td align="left"><input type="submit" name="Submit" id="Submit" value=" Send" class="btn_input" />
							  <input type="hidden" name="hid_field" value="ok" /></td>
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
config.toolbar = 'Full';
/*
	var config = {
		toolbar:[
		['Image','Preview','Bold','Italic','Underline','Strike','Subscript','Superscript','TextColor','Link','Styles'],'/',['Format','Font','FontSize', 'Source','JustifyLeft','JustifyCenter','JustifyRight', 'JustifyBlock','Button']
		]
	};
	*/
	config.height = 200;
	config.width = 800;
	CKEDITOR.replace('content', config);
</script>