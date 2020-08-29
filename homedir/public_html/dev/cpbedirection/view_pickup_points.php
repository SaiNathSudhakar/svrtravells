<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])){	?> <script language="javascript">self.close();</script>
<? } 
if(!is_numeric($_GET['p_id'])){header("location:../index.php");}
$qur=query("select tloc_name,pick_name, pick_time, pick_note from `svr_pickup_points` left join svr_to_locations as tloc on tloc.tloc_id = svr_pickup_points.tloc_id_fk where pick_id='".$_GET['p_id']."'");
$row=fetch_array($qur);

?>
<style type="text/css">
	<!--
	body,td,th { font-family: Arial, Helvetica, sans-serif;	font-size: 12px; color: #000000; }
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
    <td><strong>Covered Places Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Destination Location </strong></td>
		  <td valign="top" bgcolor="#F3F3F3">
		  <?=$row['tloc_name'];?> </td>
	    </tr>
		<tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Place Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['pick_name'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Pickup Time</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['pick_time'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Note </strong></td>
		<td valign="top" bgcolor="#F3F3F3"><?=$row['pick_note'];?></td>
      </tr>

    </table></td>
  </tr>
  
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
