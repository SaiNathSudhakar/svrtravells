<?
ob_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])) { ?>
	<script language="javascript">self.close();</script>
<? } if(!is_numeric($_GET['id'])) { header("location:../index.php"); }

if(!empty($_GET['id']))
{	
  	$q = query("select hc_id,hc_subcat_id,hc_room_type, ht_loc_name,hc_location,hc_ht_ids,subcat_name,hc_desc,tloc_name,hc_status,hc_orderby,group_concat(h.ht_name separator ', ') as hot from svr_hotel_category as hc
	left join svr_to_locations as loc on loc.tloc_id = hc.hc_location 
		left join svr_hotel_location as hloc on hloc.ht_loc_id = hc.hc_ht_loc_id
		 left join svr_subcategories as subcat on subcat.subcat_id = hc.hc_subcat_id 
			left join svr_hotels as h on FIND_IN_SET(h.ht_id, hc.hc_ht_ids)
						where hc_id='".$_GET['id']."' group by hc.hc_ht_ids");
			
  	$row = fetch_array($q);
}
?>
<link href="css/view_styles.css" rel="stylesheet" type="text/css" />
<table width="90%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td><strong>Hotel Category Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td valign="top" bgcolor="#F3F3F3"><strong>Tour Package</strong></td>
		  <td width="73%" valign="top" bgcolor="#F3F3F3"><?=$row['subcat_name'];?></td>
	    </tr>
		<tr>
          <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Location</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_name'];?></td>
		</tr>
        <tr>
          <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Hotel Location</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['ht_loc_name'];?></td>
		</tr>
        <tr>
          <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Category</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><? if($row['hc_room_type']==1) echo "Standard"; else if($row['hc_room_type']==2) echo "Deluxe"; else echo "Luxury";?></td>
		</tr>
        <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Hotels</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['hot'];?></td>
        </tr>
      <tr>
		<td valign="top" bgcolor="#F3F3F3"><strong>Description</strong></td>
		<td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3"><?=$row['hc_desc'];?></td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
	 </table></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>