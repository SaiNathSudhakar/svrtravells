<?
ob_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agentsm',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}

$len=30; $start=0;
$link="manage_agents.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

if(isset($_GET['st'])) {$st=$_GET['st']; } else {$st=1;}

if(!empty($_GET['e_status'])){
	if($_GET['e_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_agents set ag_status=".$status." where ag_id='".$_GET['sid']."'");
	header("location:manage_agents.php");
}

$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['cb_search']);
	unset($_SESSION['cb_status']);
	header("location:manage_agents.php");
}
if(isset($_GET['status']))
{
	$_SESSION['cb_status'] = ($_GET['status'] != '') ? $_GET['status'] : '';
	header('location:manage_agents.php');
}
$cond .= (isset($_SESSION['cb_status']) && $_SESSION['cb_status'] != '') ? " and ag_status = '".$_SESSION['cb_status']."'" : "";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$_SESSION['cb_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	header('location:manage_agents.php');
}

if(!empty($_SESSION['cb_search']))
{	
	$search = array('ag_fname', 'ag_lname', 'ag_uname', 'ag_deposit', 'ag_address', 'ag_city', 'ag_country', 'ag_pincode', 'ag_mobile', 'ag_landline', 'ag_authority', 'ag_pancard', 'ag_email');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".trim($_SESSION['cb_search'])."%')" ;
	}
	$cond.=')';
}
$q = mysql_query("select * from svr_agents where $cond order by ag_id desc limit $start, $len");

$count_q = mysql_query("select * from svr_agents where $cond order by ag_id desc");
$total = mysql_num_rows($count_q);

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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Agents </strong></td>
                <td valign="top" align="right"><a href="add_agent.php"><strong>Add Agent</strong></a>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
		  <table width="95%" border="0" cellspacing="0" cellpadding="6" align="center" class="table">
			  <tr>
				<td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td width="0" align="left" valign="middle"><input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['cb_search'])){ echo $_SESSION['cb_search'];}?>" size="20"/>
					  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
					  
					  <? if($_SESSION['cb_search'] != '' || $_SESSION['cb_status'] != ''){ ?>
                          <img src="images/reset.png" onclick="javascript:window.location='manage_agents.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
                      <? }?>
                      <div class="fr">
                        <select name="status" id="status" onchange="javascript:window.location='manage_agents.php?status='+this.value">
                            <option value="">Select Status</option>
                            <option value="1" <? if($_SESSION['cb_status'] != '' && $_SESSION['cb_status'] == 1){?>selected<? }?>>Active</option>
                            <option value="0" <? if($_SESSION['cb_status'] != '' && $_SESSION['cb_status'] == 0){?>selected<? }?>>Inactive</option>
                        </select>
                      </div>
                      </td>
                    </tr>
                </table></td>
			  </tr>
			  <tr>
				<td>
				  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
					  <thead>
						<tr>
						  <td width="3%" height="20" class="tablehead"><strong>S.No</strong></td>
						  <td width="10%" class="tablehead"><strong>Name</strong></td>
						  <td width="10%" class="tablehead">Username</td>
						  <td width="10%" class="tablehead">Email</td>
						  <!--<td width="10%" class="tablehead">Password</td>-->
						  <td width="10%" class="tablehead">Mobile Number</td>
						  <td width="10%" class="tablehead">Joined Date</td>
						  <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
						  <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
						  <td width="5%" align="center" class="tablehead"><img src="images/lock.png" alt="ChangePassword" title="ChangePassword" width="16" height="16" /></td>
						  <td width="5%" align="center" class="tablehead">
                          <img src="images/<?=($_SESSION['cb_status'] == '0') ? 'in' : '';?>active.png" alt="Edit" title="Status" width="16" height="16" /></td>
						</tr>
					  </thead>
					<?php
					$sno = 0; 
					//include_once("../includes/MD5Decryptor.php");
					if($total>0){
						while($fetch=mysql_fetch_array($q)){
						$sno++;
						if($fetch['ag_status']==1){
							$t_status ='<a href="manage_agents.php?sid='.$fetch["ag_id"].'&e_status=inactive">
							<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
						}else if($fetch['ag_status']==0){
							$t_status='<a href="manage_agents.php?sid='.$fetch["ag_id"].'&e_status=active">
							<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
						}
				
						//$decryptors = array('Google', 'Gromweb');
						//$hash = $fetch['ag_password'];
						
						/*foreach($decryptors as $decrytor)
							if (NULL !== ($plain = MD5Decryptor::plain($hash, $decrytor))) {
								$password = $plain;	break;
							}*/
					  ?>
					  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
						<td align="left" height="25"><?=$sno;?></td>
						<td align="left"><?=$fetch['ag_fname'];?> <?=$fetch['ag_lname'];?></td>
						<td align="left"><?=$fetch['ag_uname'];?></td>
						<td align="left"><?=$fetch['ag_email'];?></td>
						<?php /*?><td width="15%" align="left"><?=$password;?></td><?php */?>
						<td align="left"><?=$fetch['ag_mobile'];?></td>
						<td align="left"><?=date('d/m/Y', strtotime($fetch['ag_added_date']));?></td>
						<td align="center"><a href="javascript:;" onClick="window.open('view_agent.php?e_id=<?=$fetch['ag_id'];?>','no','scrollbars=yes,menubar=no,width=670,height=550')"><img src="images/view.gif" alt="Edit" title="Edit" width="16" height="16" /></a></td>
						<td align="center"><a href="add_agent.php?e_id=<?=$fetch['ag_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
						<td align="center"><a href="edit_agent_password.php?c_id=<?=$fetch['ag_id'];?>"><img src="images/lock.png" alt="ChangePassword" title="ChangePassword" width="16" height="16" /></a></td>
						<td align="center"><?=$t_status;?></td>
					  </tr>
					  <? 
					  }} else if($total==0){?>
					  <tr>
						<td colspan="16" height="150" align="center" bgcolor="#CCC">No Records Found</td>
					  </tr>
					  <? }?>
				  </table>
				</td>
			  </tr>
			</table>
		  </td>
        </tr>
		<? if($total > $len){ ?>
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