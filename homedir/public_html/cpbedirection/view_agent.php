<?
ob_start(); //session_start();
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
$qur=query("select * from `svr_agents` where ag_id='".$_GET['e_id']."'");
$row=fetch_array($qur);
?>

<style type="text/css">
body,td,th{font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000; }
.curve-border{border: 1px solid #666; background: #ffffff; color:#222222; -moz-border-radius: 3px; -webkit-border-radius: 3px;}
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
    <td><strong>Agent Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
	<? if(!empty($row['ag_logo'])){?>
	<tr>
        <td bgcolor="#F3F3F3" colspan="2" align="center"><img src="<?='uploads/agents/'.$row['ag_unique_id'].'/'.$row['ag_logo'];?>" /></td>
      </tr>
	  <? }?>
	  <tr>
	    <td valign="top" bgcolor="#F3F3F3"><strong>Title</strong></td>
	    <td valign="top" bgcolor="#F3F3F3"><?=$titles[$row['ag_title']];?></td>
	  </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>First Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_fname'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Last Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_lname'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Gender</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$gender[$row['ag_gender']];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>User Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_uname'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Email</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_email'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Mobile Number</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_mobile'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Landline Number</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_landline'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Pan Card</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_pancard'];?></td>
      </tr>
	  <tr>
	    <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Deposit</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_deposit'];?></td>
	    </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Authority Level</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_authority'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Address</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_address'];?></td>
      </tr>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>City</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_city'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>State</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$states[$row['ag_state']];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Country</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_country'];?></td>
      </tr>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Pincode</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_pincode'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>