<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../includes/script_valid.js"></script>
</head>
<body>
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>
  </tr>
<?
//Online Enquiries
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_op_accounts']) && $_SESSION['user_op_accounts']=='yes' ) ) ){$enquiries_link="manage_forms_data.php";}else{$enquiries_link="javascript:;";}
//Reviews
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_cms_reviews']) && $_SESSION['user_cms_reviews']=='yes' ) ) ){$reviews_link="review_manage.php";}else{$reviews_link="javascript:;";}
//News
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_cms_immig_news']) && $_SESSION['user_cms_immig_news']=='yes' ) ) ){$news_link="news_manage.php";}else{$news_link="javascript:;";}
//Countries
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_cms_country']) && $_SESSION['user_cms_country']=='yes' ) ) ){$country_link="countries.php";}else{$country_link="javascript:;";}
//Categories
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_cms_art_cat']) && $_SESSION['user_cms_art_cat']=='yes' ) ) ){$category_link="country_immigrations.php";}else{$category_link="javascript:;";}
//Posts
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['user_cms_art_post']) && $_SESSION['user_cms_art_post']=='yes' ) ) ){$post_link="country_immigration_content_manage.php";}else{$post_link="javascript:;";}
?>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="96%" border="0" cellpadding="0" cellspacing="0" class="mt10 mb10">
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="100" align="center" valign="bottom">Welcome to SVR Travels India (P) Ltd., Master Admin Control Panel</td>
          </tr>
          <tr>
            <td height="200" align="center" valign="bottom">&nbsp;</td>
          </tr>
        </table></td>
        <td width="0%" align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</body>
</html>