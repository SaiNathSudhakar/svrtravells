<?
ob_start();
//session_start();
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type']))
{
	?>
	<script language="javascript">
	//self.close();
	</script>
	<?
}
include_once("../includes/functions.php");
if(!is_numeric($_GET['p_id'])){header("location:../index.php");}
$qur=query("select * from `svr_places_covered` where place_id='".$_GET['p_id']."'");
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
    <td><strong>Covered Places Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Destination Location </strong></td>
		  <td valign="top" bgcolor="#F3F3F3">
		  <? echo getdata('svr_to_locations','tloc_name','tloc_id='.$row['tloc_id_fk']); ?>		  </td>
	    </tr>
		<tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['place_name'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Small Description</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['place_small_desc'];?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Thumb Image </strong></td>
        <td valign="top" bgcolor="#F3F3F3"><a target="_blank" href="../uploads/places_covered/<?=$row['place_ref_no']."/".$row['place_thumb'];?>"><img src="../uploads/places_covered/<?=$row['place_ref_no']."/".$row['place_thumb'];?>" width="75" height="75" border="0" /></a></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Big Image</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><? if(!empty($row['place_bigimage'])) { ?><a target="_blank" href="<?=$row['place_bigimage'];?>"><img src="../uploads/places_covered/<?=$row['place_ref_no']."/".$row['place_bigimage'];?>" width="150" height="150" border="0" /></a><? } ?></td>
      </tr>
      <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Large Description</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['place_large_desc'];?></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
