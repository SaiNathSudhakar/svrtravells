<?
ob_start();
session_start();

//echo '<pre>', print_r($_SESSION); exit;
//include_once("login_chk.php");
include_once("../includes/functions.php");
//echo '<pre>', print_r($_SESSION); exit;
//if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['places_covered_manage']) && $_SESSION['places_covered_manage']=='yes' ) ) ){}else{header("location:welcome.php");}
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
<script language="javascript" src="../includes/script_valid.js"></script>
</head>
<body>
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
          <td><table width="95%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td align="right"><a href="add_places_covered.php"><strong>Add Places Covered</strong></a></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                    <thead>
                      <tr>
                        <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                        <td colspan="2" class="tablehead"><strong>Destination Location &nbsp; &raquo; &nbsp; Place Name</strong></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
<!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
-->                      </tr>
                    </thead>
					<?php
					if(!empty($_GET['p_status'])){
						if($_GET['p_status']=="active")
						{
							$status=1;
						}else{
							$status=0;
						}
					query("update svr_places_covered set place_status=".$status." where place_id='".$_GET['sid']."'");
					header("location:manage_places_covered.php");
					}
					$qry = query("select tloc_id, tloc_name from svr_to_locations where tloc_status=1");
					$h=0;
					while($qry_arr=fetch_array($qry)){
					$h++;
					?>
                    <tr>
                      <td height="25" align="left"><?=$h;?>.</td>
                      <td colspan="5" align="left"><strong><?=$qry_arr['tloc_name'];?></strong></td>
                    </tr>
                    <?
						$result = query("select * from svr_places_covered where tloc_id_fk=".$qry_arr['tloc_id']);
						$count_order = num_rows($result);
						$sno = 0; if($count_order>0){
						while($fetch=fetch_array($result)){
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
                      <td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_places_covered.php?p_id=<?=$fetch['place_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=650')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><a href="add_places_covered.php?p_id=<?=$fetch['place_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
<!--<td width="5%" align="center"><?=$t_status;?></td>
-->                    </tr>
                    <? 
					}} else if($count_order==0){ ?>
                    <tr>
                      <td colspan="11" height="60" align="center" bgcolor="#CCC" class="red">No Records Found</td>
                    </tr>
                    <? }}?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</body>
</html>