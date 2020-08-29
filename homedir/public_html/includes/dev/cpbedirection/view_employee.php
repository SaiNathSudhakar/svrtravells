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
if(!is_numeric($_GET['e_id'])){header("location:../index.php");}
$qur=mysql_query("select * from `tm_emp` where emp_id='".$_GET['e_id']."'");
$row=mysql_fetch_array($qur);
?>

<style type="text/css">
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
</style>

<table width="75%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td><strong>Employee Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>First Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_name'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Last Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_lastname'];?></td>
      </tr>
		<tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Gender</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_gender'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Contact Number</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_contactno'];?></td>
      </tr>
		<tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Display Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_dispname'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>User Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_uname'];?></td>
      </tr>
 <?php /*?>     <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Password</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['emp_pswd'];?></td>
      </tr><?php */?>
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>