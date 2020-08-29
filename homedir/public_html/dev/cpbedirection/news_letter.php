<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('news',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

$result = query("select * from svr_nl order by nl_id desc");
if(!empty($_GET['del'])){
	query("delete from svr_nl where nl_id='".$_GET['del']."'");
	header("location:news_letter.php");
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage </strong></td>
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
          <td><form action="" name="news_letter" id="news_letter" method="post">
              <table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td class="tablehead"><strong><span class="main_heading_white">
                      <input name="cl_mailid_checkall" type="checkbox" onclick="check_phmailid(document.news_letter.cl_mailid)" value="All" size="2" style="cursor:pointer" title="Check / Un-Check All" />
                      </span> E-Mail
                      <input type="button" name="Submit" value="Send E-Mail" onclick="goto_sms121212(document.news_letter.cl_mailid)" />
                      </strong></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></td>
                  </tr>
                </thead>
				<?php
					$count_order = num_rows($result);
					$sno = 0; if($count_order>0){
					while($fetch=fetch_array($result)){
					$sno++;
				?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td width="5%" height="25" align="left"><?=$sno;?></td>
                  <td align="left"><input name="cl_mailid[]" type="checkbox" id="cl_mailid" value="<?=$fetch['nl_email'];?>" />
                    <?=$fetch['nl_email'];?></td>
                  <td width="5%" align="center" onclick="return confirm('Do You Want To Delete This Record?');"><a href="news_letter.php?del=<?=$fetch['nl_id'];?>"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></a></td>
                  <? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>
                  <? }?>
                </tr>
				<? 
					}} else if($count_order==0){
				?>
                <tr>
                  <td colspan="9" height="150" align="center" bgcolor="#CCC">No Records Found</td>
                </tr>
                <? } ?>
              </table>
            </form></td>
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
function check_phmailid(chk){
	if(document.news_letter.cl_mailid_checkall.value=="All"){
		for (i = 0; i < chk.length; i++)
		chk[i].checked = true ;
		document.news_letter.cl_mailid_checkall.value="None";
	}else{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = false ;
		document.news_letter.cl_mailid_checkall.value="All";
	}
}

function goto_sms121212(id){
var  res=false;
var d=document.news_letter;
		for(i = 0; i < id.length; i++){
			if(id[i].checked == false){res=false;}
			if(id[i].checked==true){res=true;break;}
		}
		if(res==false){alert("Please Select Atleast One E-Mail ID !"); return false;}
			d.action='news_letter_compose.php';
			d.submit(); return true;
}
</script>