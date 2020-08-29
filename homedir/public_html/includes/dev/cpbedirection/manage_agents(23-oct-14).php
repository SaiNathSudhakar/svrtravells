<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['agent_manage']) && $_SESSION['agent_manage']=='yes'))){}else{header("location:welcome.php");}

if(isset($_GET['st'])) {$st=$_GET['st']; } else {$st=1;}
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Agents </strong></td>
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
          <td>
		  <table width="95%" border="0" cellspacing="0" cellpadding="6" align="center">
			  <tr>
				<td align="right"><a href="add_agent.php"><strong>Add Agent</strong></a></td>
			  </tr>
			  <tr>
				<td>
				  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
						  <thead>
				<tr>
				  <td width="3%" height="20" class="tablehead"><strong>S.No</strong></td>
				
				  <td width="10%" class="tablehead"><strong>Name</strong></td>
				  <td width="10%" class="tablehead">User Name </td>
				  <td width="10%" class="tablehead">Email</td>
				  <td width="10%" class="tablehead">Mobile Number </td>
				  <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="Edit" title="Edit" width="16" height="16" /></td>
				  <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
				  <td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Edit" title="Edit" width="16" height="16" /></td>
				</tr>
						  </thead>
						  <?php
							if(!empty($_GET['e_status'])){
								if($_GET['e_status']=="active")
								{
									$status=1;
								}else{
									$status=0;
								}
							mysql_query("update svr_agents set ag_status=".$status." where ag_id='".$_GET['sid']."'");
							header("location:manage_agents.php");
							}
						  
							$array = mysql_query("select * from svr_agents");
							$count_order = mysql_num_rows($array);
							$sno = 0; if($count_order>0){
							while($fetch=mysql_fetch_array($array)){
							$sno++;
							
							//$cnt_user=getdata("tm_users","count(emp_id_fk)","emp_id_fk='".$fetch['emp_id']."'");
							
							if($fetch['ag_status']==1){
								$t_status ='<a href="manage_agents.php?sid='.$fetch["ag_id"].'&e_status=inactive">
								<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
							}else if($fetch['ag_status']==0){
								$t_status='<a href="manage_agents.php?sid='.$fetch["ag_id"].'&e_status=active">
								<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
							}
							
						  ?>
						  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
							<td width="5%" height="25" align="left"><?=$sno;?></td>
	<?php /*?><td width="5%" align="left">
<?
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin') ) )
{if($st==1){?><a href="add_emp_privileges.php?id=<?=$fetch['emp_id'];?>">
<? if($cnt_user==1){?>
	<img src="images/access.gif" alt="Admin-User Privileges !" title="Admin-User Privileges !" width="38" height="37" border="0" />
		<? }else{?>		
	<img src="images/key.gif" alt="Add as Admin-User !" title="Add as Admin-User !" width="16" height="16" border="0" />
		<? }?></a><? }else{
		echo '--';
	}}?>
</td><?php */?>
							<td align="left"><?=$fetch['ag_fname'];?> <?=$fetch['ag_lname'];?></td>
							<td width="15%" align="left"><?=$fetch['ag_uname'];?></td>
							<td width="15%" align="left"><?=$fetch['ag_email'];?></td>
							<td width="15%" align="left"><?=$fetch['ag_mobile'];?></td>
							<td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_agent.php?e_id=<?=$fetch['ag_id'];?>','no','scrollbars=yes,menubar=no,width=670,height=550')"><img src="images/view.gif" alt="Edit" title="Edit" width="16" height="16" /></a></td>
							<td width="5%" align="center"><a href="add_agent.php?e_id=<?=$fetch['ag_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
							<td width="5%" align="center"><?=$t_status;?></td>
						  </tr>
						  <? 
						  }} else if($count_order==0){?>
						  <tr>
							<td colspan="14" height="150" align="center" bgcolor="#CCC">No Records Found</td>
						  </tr>
						  <? }?>
					  </table>
				</td>
			  </tr>
			</table>
		  </td>
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