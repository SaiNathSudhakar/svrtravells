<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])){	?>
	<script language="javascript">self.close();</script>
<? }if(!is_numeric($_GET['genq_id'])){header("location:../index.php");}
$qur=query("select * from `svr_gen_enquiries` where genq_id='".$_GET['genq_id']."'");
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
<table width="98%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td><strong>General Enquiry Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Name</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=$row['genq_name'];?></td>
      </tr>  
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Phone</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['genq_phone'])?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Email</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['genq_email']);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Area of Interest</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['genq_area_interest']);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Enquiry</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['genq_enquiry']);?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>