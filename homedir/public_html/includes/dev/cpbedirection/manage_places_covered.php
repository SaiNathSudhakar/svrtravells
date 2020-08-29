<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('placovm',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$cond = "1"; $cond_cat = '1'; $cat_fltr = $cat_fltr_pc = "";

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset"){
	unset($_SESSION["cat_fltr_pc"]);
	header("location:manage_places_covered.php");
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
$link="manage_places_covered.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 
if(!empty($_GET['p_status']))
{	
	$status = ($_GET['p_status'] == 'active') ? 1 : 0;
	mysql_query("update svr_places_covered set place_status=".$status." where place_id='".$_GET['sid']."'");
	header("location:manage_places_covered.php");
}

$qry = mysql_query("select tloc_id, tloc_name from svr_to_locations where $cond and tloc_status=1");
$total = mysql_num_rows($qry);
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Places Covered </strong></td>
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
					  	<select name="dest_name" id="dest_name" onchange="window.location='manage_places_covered.php?cat_fltr='+this.value">
                            <? 
							  $dest_q = mysql_query("select tloc_id, tloc_name, tloc_code from svr_to_locations where tloc_status=1 order by tloc_orderby");
							  while($dest_fetch = mysql_fetch_array($dest_q)){	
							?>
                            <option value="<?=$dest_fetch['tloc_id'];?>"
							<? if($cat_fltr_pc == $dest_fetch['tloc_id']){?>selected<? }?>>
                            <?=$dest_fetch['tloc_name']; ?> <?=' ('.$dest_fetch['tloc_code'].')'; ?>
                            </option>
                            <? }?>
                          </select>
					  <? if(!empty($cat_fltr_pc)){ ?>
				      <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'manage_places_covered.php?src=reset'" title="Reset"/>
			          <? } ?>
			          <!--Status :--> 
                        <?php /*?><select name="cat_inact" id="cat_inact" class="textbox" style="width:80px" onchange="window.location='manage_places_covered.php?status='+this.value">
                          <option value="1" <? //if($st_sel_location=='1'){?>selected="selected" <? //}?>>Active</option>
                          <option value="0" <? //if($st_sel_location=='0'){?>selected="selected" <? //}?>>In-Active</option>
                      </select><?php */?></td>
                      <td align="right" valign="middle" nowrap="nowrap"><input type="button" name="add" onclick="javascript:window.location='add_places_covered.php'" value="Add New" class="button" title="Add New"/></td>
                      </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                    <thead>
                      <tr>
                        <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                        <td colspan="2" class="tablehead"><strong>Destination Location &nbsp; &raquo; &nbsp; Place Name</strong></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
                      </tr>
                    </thead>
					<?php
					$qry = mysql_query("select tloc_id, tloc_name from svr_to_locations where $cond and tloc_status=1 order by tloc_orderby desc limit $start, $len");
					$h = $start; 
					while($qry_arr=mysql_fetch_array($qry)){ $h++; ?>
                    <tr>
                      <td height="25" align="left"><?=$h;?>.</td>
                      <td colspan="5" align="left"><strong><?=$qry_arr['tloc_name'];?></strong></td>
                    </tr>
                    <? //echo "select * from svr_places_covered where tloc_id_fk=".$qry_arr['tloc_id']; exit;
						$q = mysql_query("select * from svr_places_covered where tloc_id_fk=".$qry_arr['tloc_id']);
						$count_order = mysql_num_rows($q);
						$sno = 0; if($count_order>0){
						while($fetch=mysql_fetch_array($q)){
						$sno++;
			
						if($fetch['place_status']==1){
							$t_status ='<a href="manage_places_covered.php?sid='.$fetch["place_id"].'&p_status=inactive">
							<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
						}else if($fetch['place_status']==0){
							$t_status='<a href="manage_places_covered.php?sid='.$fetch["place_id"].'&p_status=active">
							<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
						}
						?>
                    <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                      <td width="5%" height="25" align="left">&nbsp;</td>
                      <td width="5%" align="left"><?=$sno;?>.</td>
                      <td align="left"><?=$fetch['place_name'];?></td>
                      <td width="5%" align="center"><a href="javascript:;" onClick="popupwindow('view_places_covered.php?p_id=<?=$fetch['place_id']?>', 'Title', '650', '450');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><a href="add_places_covered.php?p_id=<?=$fetch['place_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><?=$t_status;?></td>
                    </tr>
                    <? 
					}
					
					  ?> 
					
					<? }else if($count_order==0){ ?>
                    <tr>
                      <td colspan="11" height="60" align="center" bgcolor="#CCC" class="red">No Records Found</td>
                    </tr>
                    <? }?> 
					
					<? }?>
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