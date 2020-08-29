<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('updates',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}
if($_SERVER['REQUEST_METHOD']=="POST")
{
$page_replace =str_replace("'","&#39;",$_POST['txtpage']);
//$max=getdata("svr_latest_news","max(news_id)+1","1");
	if(!empty($_GET['id']))
	{
		query("update `svr_latest_updates` set `up_title`='".$_POST['title']."',`up_desc`='".addslashes($_POST['desc'])."' where up_id='".$_GET['id']."'");
		header("location:manage_updates.php?msg=up");
	}
	else
	{
		query("insert into svr_latest_updates (up_title, up_desc, up_status,  up_dateadded) values ('".$_POST['title']."','".addslashes($_POST['desc'])."', 1,'".$now."')");
		header("location:manage_updates.php?msg=up");
	}
}
if(!empty($_GET['id']))
{
	$qur_de="select * from `svr_latest_updates` where up_id=".$_GET['id']." limit 1";
	$res_de=query($qur_de);
	$row_de=fetch_array($res_de);
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Add  Latest Updates</strong></td>
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
                    <td align="right" valign="top"><a href="manage_updates.php"><strong>Manage Latest Updates</strong></a></td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="bor_task datatable">
              <tr class="form_table_row1">
                <td width="4%" align="left">&nbsp;</td>
                <td width="16%" align="left">Title</td>
                <td width="80%" align="left"><input name="title" type="text" id="title" value="<? if(!empty($_GET['id'])){ echo $row_de['up_title']; }?>" size="70"  /></td>
              </tr>
              <tr class="form_table_row1">
                <td align="left">&nbsp;</td>
                <td align="left">Description</td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr class="form_table_row1">
                <td colspan="3" align="left"><textarea name="desc" id="desc" class="ckeditor"><? if(!empty($_GET['id'])){ echo $row_de['up_desc'];}?></textarea></td>
                </tr>
				  
			  
              <tr class="form_table_row">
                <td colspan="3" align="center"><input type="submit" name="Submit" id="Submit" value="Submit" class="btn_input"/></td>
                </tr>
            </table>					</td>
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
<script language="javascript">
function chk_valid()
{
	d=document.form1;
	if(d.title.value==""){alert("Please enter Title"); d.title.focus(); return false;}
	//if(d.content.value==""){alert("Please enter Content"); d.content.focus(); return false;}
}
</script>
<script type="text/javascript">
config.toolbar = 'Full';

	var config = {
		toolbar:[
		['Image','Preview','Bold','Italic','Underline','Strike','Subscript','Superscript','TextColor','Link','Styles'],'/',['Format','Font','FontSize', 'Source','JustifyLeft','JustifyCenter','JustifyRight', 'JustifyBlock','Button']
		]
	};
	
	config.height = 200;
	config.width = 800;
	CKEDITOR.replace('desc', config);
</script>