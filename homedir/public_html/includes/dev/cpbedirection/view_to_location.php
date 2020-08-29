<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])){	?>
	<script language="javascript">self.close();</script>
<? } if(!is_numeric($_GET['img_id'])){header("location:../index.php");}

$qur=mysql_query("select tloc_id, cat_name, subcat_name, subsubcat_name, tloc_name, tloc_code, tloc_costpp, tloc_transport, tloc_time, tloc_type, tloc_cost_includes, tloc_cost_excludes, tloc_code, tloc_pickup_point, tloc_places_covered, tloc_ref_no, tloc_image, tloc_notes, tloc_orderby, tloc_status from svr_to_locations as tloc
	left join svr_subcategories as subcat on subcat.subcat_id = tloc.subcat_id_fk
		left join svr_subsubcategories as subsubcat on subsubcat.subsubcat_id = tloc.subsubcat_id_fk
			left join svr_categories cat on cat.cat_id = tloc.cat_id_fk
				where tloc_id='".$_GET['img_id']."'");
$row=mysql_fetch_array($qur);
list($deptime, $rettime) = (!empty($row['tloc_time'])) ? explode('|', $row['tloc_time']) : array_fill(0, 2, '');
list($night, $day) = (!empty($row['tloc_type'])) ? explode('|', $row['tloc_type']) : array_fill(0, 2, '');

$cost_inc=explode("|", $row['tloc_cost_includes']);
$cost_exc=explode("|", $row['tloc_cost_excludes']);
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
    <td><strong>Destination Details : </strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
		<tr>
		  <td valign="top" bgcolor="#F3F3F3"><strong>Category</strong></td>
		  <td width="73%" valign="top" bgcolor="#F3F3F3"><?=$row['cat_name']; //=getdata('svr_categories','cat_name','cat_id='.$row['cat_id_fk']);?></td>
	    </tr>
		<? if(!empty($row['subcat_name'])){?>
		<tr>
		  <td valign="top" bgcolor="#F3F3F3"><strong>SubCategory</strong></td>
		  <td width="73%" valign="top" bgcolor="#F3F3F3"><?=$row['subcat_name']; //=getdata('svr_subcategories','subcat_name','subcat_id='.$row['subcat_id_fk']);?></td>
	    </tr>
		<? } if(!empty($row['subsubcat_name'])){?>
		<tr>
		  <td valign="top" bgcolor="#F3F3F3"><strong>SubSubCategory</strong></td>
		  <td width="73%" valign="top" bgcolor="#F3F3F3"><?=$row['subsubcat_name']; //=getdata('svr_subsubcategories','subsubcat_name','subsubcat_id='.$row['subsubcat_id_fk']);?></td>
	    </tr>
		<? }?>
		<tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Destination Location (Title)</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_name'];?></td>
		</tr>
		<? if(!empty($row['tloc_costpp'])) { ?>
        <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Cost PP</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=number_format($row['tloc_costpp']);?>/- </td>
        </tr>
		<? }?>
        <tr>
        <td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Location Type (No. of Days)</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$night;?> Nights/<?=$day;?> Days
		<? //=$row['tloc_type'];?></td>
      </tr>
        <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Location Code</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_code'];?></td>
        </tr>
		<? if(!empty($row['tloc_transport'])){?>
		 <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Transport</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_transport'];?></td>
        </tr>
		<? } if(!empty($row['tloc_pickup_point'])){?>
		 <tr>
          <td valign="top" bgcolor="#F3F3F3"><strong>Pickup Point</strong></td>
          <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_pickup_point'];?></td>
        </tr>
        <? }?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Places Covered</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_places_covered'];?></td>
      </tr>
      <tr style="display:none">
        <td valign="top" bgcolor="#F3F3F3"><strong>Upload PDF</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><a href="<?=$row['tloc_pdf'];?>" target="_blank" class="blue_read"><u>View PDF</u></a></td>
      </tr>
      <? if( count($cost_inc) > 1 ) {?>
      <tr>
		<td valign="top" bgcolor="#F3F3F3"><strong>Cost Includes</strong></td>
		<td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">
			<? for ($i=0; $i<=count($cost_inc)-1; $i++)	{ echo "&raquo;&nbsp;".$cost_inc[$i]."<br>"; } ?>			
        </td>
      </tr>
      <? } if( count($cost_exc) > 1 ) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Cost Excludes</strong></td>
        <td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">
			<?	for ($i=0; $i<=count($cost_exc)-1; $i++) { echo "&raquo;&nbsp;".$cost_exc[$i]."<br>"; } ?>
		</td>
      </tr>
	  <? }  ?><?php /*?>if( count($cost_exc) > 1 ) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Terms &amp; Conditions</strong></td>
        <td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">
			<?	for ($i=0; $i<=count($tnc)-1; $i++)	{ echo "&raquo;&nbsp;".$tnc[$i]."<br>";	} ?>
		</td>
      </tr>
	  <? }?><?php */?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Image (Thumb nail)</strong></td>
        <td valign="top" bgcolor="#F3F3F3">
		<? $path = $site_url."uploads/destination_locations/".$row['tloc_ref_no']."/"; ?>
		<? $image = ($row['tloc_image'] != '') ? $path.$row['tloc_image'] : $default_thumb;?>
		<a href="<?=$image;?>"><img src="<?=$image;?>" height="100" border="0" /></a></td>
      </tr>
	  <? if( count($note) > 1 ) {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Notes</strong></td>
        <td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">
		<?  $note = explode("|", $row['tloc_notes']);
			for ($i=0; $i<=count($note)-1; $i++) { echo "&raquo;&nbsp;".$note[$i]."<br>"; }?>
		</td>
      </tr>
      <? } if( count($pick) > 1 ) {?>
      <tr>
		<td valign="top" bgcolor="#F3F3F3"><strong>Pickup Places</strong></td>
		<td valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      </tr>
      <tr>
		<td colspan="2" valign="top" bgcolor="#F3F3F3">
		<?  $pick=explode("|", $row['tloc_pickup_place']);
			for ($i=0; $i<=count($pick)-1; $i++) { echo "&raquo;&nbsp;".$pick[$i]."<br>"; } ?>
		</td>
      </tr>
      <? } if($deptime != '' && $rettime != ''){?>
      <tr>
		<td valign="top" bgcolor="#F3F3F3"><strong>Time</strong></td>
		<td valign="top" bgcolor="#F3F3F3"><b>Departure:</b> <?=$deptime;?>&nbsp;<b><br>Return:</b> <?=$rettime;?></td>
      </tr>
      <? } //$sno=0; while($row=mysql_fetch_array($qur)){$sno++; ?>
	 <?php /*?> <tr>
			<td valign="top" bgcolor="#F3F3F3"><strong>Banner</strong></td>
			<td valign="top" bgcolor="#F3F3F3">
			<? if(!empty($row['tloc_banner_image'])){?>
			  <img src="images/view.gif" width="16" border="0" onMouseOver="bsimcall('inline',<?=$sno?>)" onMouseOut="bsimcall('none',<?=$sno?>)"/> 
			  <div id="bsrphoto<?=$sno?>" style="display:none; z-index:1; float:left; position:absolute;"><img src="<?=$row['tloc_banner_image'];?>" border="0"></div></td>
			<? }?>
	  </tr><?php */?>
	  <? //}?>
      <tr>
        <td colspan="2" valign="top" bgcolor="#F3F3F3">&nbsp;</td>
        </tr>
		<!--<tr>
		<td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Pickup Place</strong></td>
		<td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_pickup_place'];?></td>
		</tr>
		<tr>
		<td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Tour Notes</strong></td>
		<td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_tour_notes'];?></td>
		</tr>
		<tr>
		<td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Price Notes</strong></td>
		<td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_price_notes'];?></td>
		</tr>
		<tr>
		<td width="30%" valign="top" bgcolor="#F3F3F3"><strong>Google Map Url </strong></td>
		<td valign="top" bgcolor="#F3F3F3"><?=$row['tloc_gmapurl'];?></td>
		</tr>
		-->    </table></td>
  </tr>
  
  <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
<script language="javascript">
function bsimcall(bs,id)
{
document.getElementById("bsrphoto"+id).style.display=bs;
}
</script>