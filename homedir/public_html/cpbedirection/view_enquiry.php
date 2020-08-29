<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])){	?>
	<script language="javascript">self.close();</script>
<? }if(!is_numeric($_GET['enq_id'])){header("location:../index.php");}
$qur=query("select * from `svr_enquiries` where enq_id='".$_GET['enq_id']."'");
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
    <td><strong>Enquiry Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Name</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=$row['enq_name'];?></td>
      </tr>  
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Email</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_email']);?></td>
      </tr>
	   <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Mobile</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_mobile'])?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Arrival Date</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=date('F d, Y',strtotime($row['enq_arrival_date']));?></td>
      </tr>
	   <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Departure Date</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=date('F d, Y',strtotime($row['enq_departure_date']));?></td>
      </tr>
	  
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Interest</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['enq_interests'];?></td>
      </tr>
	    <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Adults</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=$row['enq_adults']?></td>
      </tr>
	    <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Children</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=$row['enq_children']?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Description</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_description'])?></td>
      </tr>
      <tr>
		  <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Enquiry Type</strong></td>
		  <td width="75%" valign="top" bgcolor="#F3F3F3"><?=exists($enquiry_forms[$row['enq_type']])?></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Address</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_address'], $null, 1);?></td>
      </tr>
      <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>City</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_city'], $null, 1);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>State</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($states[$row['enq_state']], $null, 1);?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Country</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=exists($row['enq_country'], $null, 1);?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>