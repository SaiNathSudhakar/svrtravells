<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type']))
{
	?>
	<script language="javascript">
	self.close();
	</script>
	<?
}

if(!is_numeric($_GET['img_id'])){header("location:../index.php");}
$qur=query("select * from `svr_gallery` where gal_id='".$_GET['img_id']."'");
$row=fetch_array($qur);
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.curve-border { border: 1px solid #666; background: #ffffff ; color:#222222; -moz-border-radius: 3px; -webkit-border-radius: 3px;}

.blue_read:link{color:#333; font-weight:bold; text-decoration:none; margin-right:14px;font-size:12px;}
.blue_read:visited{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:hover{color:#FB8800; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:active{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
-->
</style>
<table width="90%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td><strong>Gallery Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Tittle</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['gal_title'];?></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>URL</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['gal_url'];?></td>
      </tr>

      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Image</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><a href="<?="uploads/gallery/".$row['gal_upload'];?>" target="_blank"><img src="<?="uploads/gallery/".$row['gal_upload'];?>" width="100" height="100"/></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>