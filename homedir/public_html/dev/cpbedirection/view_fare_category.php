<?
ob_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])) { ?>
	<script language="javascript">self.close();</script>
<? } if(!is_numeric($_GET['id'])) { header("location:../index.php"); }

if(!empty($_GET['id']))
{	
  	$q = query("select fc_type, fc_name, fc_multiple, fc_adult_child, fc_desc, cat_name, concat(veh.vp_name, ' ', pax.vp_title, ' PAX') as vehicle, group_concat(tloc_name order by tloc_orderby separator ', ') as locations from svr_fare_category as fc
	left join svr_categories as cat on cat.cat_id = fc.fc_type
		left join svr_to_locations as tloc on FIND_IN_SET(tloc.tloc_id, fc.fc_locations)
			left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
				left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
					left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
						where fc_id='".$_GET['id']."' group by fc_id");
  	$row = fetch_array($q);
}
?>
<link href="css/view_styles.css" rel="stylesheet" type="text/css" />
<table width="90%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td><strong>Fare Category Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td valign="top" bgcolor="#F3F3F3"><strong>Category</strong></td>
		  <td width="73%" valign="top" bgcolor="#F3F3F3"><?=$row['cat_name'];?></td>
	    </tr>
		<tr>
          <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Name</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=($row['fc_type'] == 1) ? $row['fc_name'] : $row['vehicle'];?></td>
		</tr>
		<? if($row['fc_type'] == 1) { ?>
        <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Multiple of </strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['fc_multiple'];?></td>
        </tr>
        <tr>
          <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Adult or Child</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$adult_child[$row['fc_adult_child']];?></td>
        </tr>
		<? }?>
        <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Locations</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['locations'];?></td>
        </tr>      
      <? if(!empty($row['fc_desc'])) { ?>
      <tr>
		<td valign="top" bgcolor="#F3F3F3"><strong>Description</strong></td>
		<td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3"><?=$row['fc_desc'];?></td>
      </tr>
      <? }?>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
	 </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>