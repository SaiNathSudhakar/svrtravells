<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('pickm',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$cond = "1"; $cond_cat = '1'; $cat_fltr = $cat_fltr_pc = "";

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset"){
	unset($_SESSION["cat_fltr_pc"]);
	header("location:manage_pickup_points.php");
}

//category filter
if(!empty($_GET['cat_fltr']) || isset($cat_fltr_pc)){
	if(!empty($_GET['cat_fltr'])) { $_SESSION['cat_fltr_pc'] = $_GET['cat_fltr']; }
	$cat_fltr_pc = (isset($_SESSION['cat_fltr_pc'])) ? $_SESSION['cat_fltr_pc'] : '';
	
	if($cat_fltr_pc != ''){	
		$cat_fltr = " and tloc_id = ".$cat_fltr_pc; 
		$cond_cat .= " and tloc_id_fk = ".$cat_fltr_pc;
	}
}
$cond .= $cat_fltr;

$len=10; $start=0;
$link="manage_pickup_points.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
if(!empty($_GET['p_status']))
{	
	$status = ($_GET['p_status'] == 'active') ? 1 : 0;
	query("update svr_pickup_points set pick_status=".$status." where pick_id='".$_GET['sid']."'");
	header("location:manage_pickup_points.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/multiple-select.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="js/jquery.multiple.select.js"></script>
<script language="javascript" src="../js/script.js"></script>
<script>
$(function() { 
	$("#dest_name").multipleSelect({
		placeholder: 'Select Locations',
		multiple: false,
		single: true,
		filter: true
	});
});
</script>
</head>
<body>
<form name="yellow_cat" id="yellow_cat" method="post" action="">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><img src="images/spacer.gif" border="0" height="5" /></td>
        </tr>
        <tr>
          <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr>
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Pickup Points </strong></td>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="95%" border="0" align="center" cellspacing="0" cellpadding="6">
              <tr>
                <td>
				  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td align="left" valign="middle">
					  	<select name="dest_name" id="dest_name" onchange="window.location='manage_pickup_points.php?cat_fltr='+this.value">
                            <? 
							  $dest_q = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where tloc_status=1 and cat_id_fk = 1 order by tloc_orderby");
							  while($dest_fetch = fetch_array($dest_q)){	
							?>
                            <option value="<?=$dest_fetch['tloc_id'];?>"
							<? if($cat_fltr_pc == $dest_fetch['tloc_id']){?>selected<? }?>>
                            <?=$dest_fetch['tloc_name']; ?> <?=' ('.$dest_fetch['tloc_code'].')'; ?>
                            </option>
                            <? }?>
                          </select>
					  <? if(!empty($cat_fltr_pc)){ ?>
				      <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_pickup_points.php?src=reset'" title="Reset"/>
			          <? } ?>
			          <!--Status :--></td>
                      <td align="right" valign="middle" nowrap="nowrap" width="1%" style="display:none"><select name="cat_inact" id="cat_inact" class="textbox" style="width:80px" onchange="window.location='manage_pickup_points.php?status='+this.value">
                        <option value="1" <? //if($st_sel_location=='1'){?>selected="selected" <? //}?>>Active</option>
                        <option value="0" <? //if($st_sel_location=='0'){?>selected="selected" <? //}?>>In-Active</option>
                      </select>
					  </td><td align="right" valign="middle" nowrap="nowrap" width="1%">
                      <input type="button" name="add" onclick="javascript:window.location='add_pickup_points.php'" value="Add New" class="button" title="Add New"/></td>
                      </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                    <thead>
                      <tr>
                        <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                        <td width="25%" height="20" class="tablehead"><strong>Location</strong></td>
                        <td  class="tablehead"><strong> Place Name</strong></td>
                        <td height="20" class="tablehead"><strong>Time</strong></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
-->                      </tr>
                    </thead>
                    <? 
						$q = query("select tloc_name,pick_id,pick_name,pick_time,pick_status,pick_dateadded from svr_pickup_points left join svr_to_locations as tloc on tloc.tloc_id = svr_pickup_points.tloc_id_fk where 1 order by pick_id desc limit $start,$len");
						$count_order = num_rows($q);
						$sno = 0; if($count_order>0){
						while($fetch=fetch_array($q)){
						$sno++;
			
						if($fetch['pick_status']==1){
							$t_status ='<a href="manage_pickup_points.php?sid='.$fetch["pick_id"].'&p_status=inactive">
							<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
						}else if($fetch['pick_status']==0){
							$t_status='<a href="manage_pickup_points.php?sid='.$fetch["pick_id"].'&p_status=active">
							<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
						}
						?>
                    <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                      
                      <td width="5%" align="left"><?=$sno;?>.</td>
                      <td align="left"><?=$fetch['tloc_name'];?></td>
                      <td align="left"><?=$fetch['pick_name'];?></td>
                      <td align="left"><?=$fetch['pick_time'];?></td>
                      <td width="5%" align="center"><a href="javascript:;" onClick="popupwindow('view_pickup_points.php?p_id=<?=$fetch['pick_id']?>', 'Title', '650', '450');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><a href="add_pickup_points.php?p_id=<?=$fetch['pick_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
<!--<td width="5%" align="center"><?=$t_status;?></td>
-->                    </tr>
                    <? 
					} ?> 
					
					<? }else if($count_order==0){ ?>
                    <tr>
                      <td colspan="12" height="60" align="center" bgcolor="#CCC" class="red">No Records Found</td>
                    </tr>
                    <? }?> 
					
					<? //}?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
		<? if($total>$len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? }?>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</form>
</body>
</html>