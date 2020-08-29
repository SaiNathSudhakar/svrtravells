<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['schedule_manage']) && $_SESSION['schedule_manage']=='yes' ) ) ){}else{header("location:welcome.php");}
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Schedule </strong></td>
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
          <td><table width="95%" align="center" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td align="right"><a href="add_schedule.php"><strong>Add </strong><strong style="font-size:12px">Schedule</strong></a></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                    <thead>
                      <tr>
                        <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                        <td colspan="2" class="tablehead"><strong>Destination Location » Night Halt</strong></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
                        <td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
                      </tr>
                    </thead>
					<?php
					if(!empty($_GET['sch_status'])){
						if($_GET['sch_status']=="active")
						{
							$status=1;
						}else{
							$status=0;
						}
					mysql_query("update svr_tour_schedule set sch_status=".$status." where sch_id='".$_GET['sch_id']."'");
					header("location:manage_schedule.php");
					}
					$qry = mysql_query("select tloc_id, tloc_name from svr_to_locations where tloc_status=1");
					$h=0;
					while($qry_arr=mysql_fetch_array($qry)){
					$h++;
					?>
                    <tr>
                      <td height="25" align="left"><?=$h;?>.</td>
                      <td colspan="5" align="left"><strong><?=$qry_arr['tloc_name'];?></strong></td>
                    </tr>
					<?
					$result = mysql_query("select * from svr_tour_schedule where tloc_id_fk=".$qry_arr['tloc_id']);
					$sch_count = mysql_num_rows($result);
					$sno = 0; if($sch_count>0){
					while($fetch=mysql_fetch_array($result)){
					$sno++;
					
					if($fetch['sch_status']==1){
						$sch_status ='<a href="manage_schedule.php?sch_id='.$fetch["sch_id"].'&sch_status=inactive">
						<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
					}else if($fetch['sch_status']==0){
						$sch_status='<a href="manage_schedule.php?sch_id='.$fetch["sch_id"].'&sch_status=active">
						<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
					}
					?>
                    <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
                      <td width="5%" height="25" align="left">&nbsp;</td>
                      <td width="5%" align="left"><?=$sno;?>.</td>
                      <td align="left"><?=$fetch['sch_halt'];?></td>
                      <td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_schedule.php?sch_id=<?=$fetch['sch_id'];?>','no','scrollbars=yes,menubar=no,width=600,height=350')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><a href="add_schedule.php?sch_id=<?=$fetch['sch_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
                      <td width="5%" align="center"><? echo $sch_status; ?></td>
                    </tr>
                    <? 
					}} else if($sch_count==0){ ?>
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