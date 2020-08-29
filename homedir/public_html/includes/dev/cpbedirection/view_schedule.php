<?php
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
if(!is_numeric($_GET['sch_id'])){header("location:../index.php");}
$query=mysql_query("select * from svr_tour_schedule where sch_id='".$_GET['sch_id']."'");
$sch=mysql_fetch_array($query);
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
    <td><strong>Schedule Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Destination Location </strong></td>
		  <td valign="top" bgcolor="#F3F3F3">
		  <? echo getdata('svr_to_locations','tloc_name','tloc_id='.$sch['tloc_id_fk']); ?>		</td>
		</tr>
		<tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Day Number </strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$sch['sch_day_number'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top"><strong>Schedule Time</strong></td>
        <td width="73%" valign="top"><?=$sch['sch_time'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Schedule</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$sch['sch_schedule'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Night Halt</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$sch['sch_halt'];?></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
