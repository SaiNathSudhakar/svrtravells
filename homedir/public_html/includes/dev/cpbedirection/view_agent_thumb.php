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
if(!is_numeric($_GET['vid'])){header("location:../index.php");}
$qur=mysql_query("select ag_unique_id, ag_logo from `svr_agents` where ag_id='".$_GET['vid']."'");

$row=mysql_fetch_array($qur);
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
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">
	Close Window</a></td>
  </tr>
  <tr>
    <td align="center"><table border="0" cellpadding="5" cellspacing="1" bgcolor="#ECE9D8">
      <tr>
        <td bgcolor="#FFFFFF"><img src="<?=$site_url.'uploads/agents/'.$row['ag_unique_id'].'/'.$row['ag_logo'];?>" /></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
