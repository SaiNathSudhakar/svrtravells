<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])){	?>
	<script language="javascript">self.close();</script>
<? }if(!is_numeric($_GET['custom_id'])){header("location:../index.php");}
$qur=query("select * from `svr_customers` where cust_id='".$_GET['custom_id']."'");
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
    <td><strong>Customer Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Name</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=$titles[$row['cust_title']]?> <?=$row['cust_fname']." ".$row['cust_lname'];?></td>
      </tr>  
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Email</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_email']);?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>DOB</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=site_date_time($row['cust_dob']);?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Mobile</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_mobile'])?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Land Line</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_landline'])?></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Address</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_address_1'], $null, 1);?></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>City</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_city'], $null, 1);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>State</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($states[$row['cust_state']], $null, 1);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Country</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_country'], $null, 1);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Pincode</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['cust_pincode'], $null);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>