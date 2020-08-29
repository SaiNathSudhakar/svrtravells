<?
ob_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('deposit',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

$len=30; $start=0;
$link="manage_agent_deposits.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['cb_search']);
	unset($_SESSION['cb_agent']);
	unset($_SESSION['cb_req_status']);
	//header("location:manage_agent_deposits.php");
}
if(isset($_GET['req_status']))
{
	$_SESSION['cb_req_status'] = ($_GET['req_status'] != '') ? $_GET['req_status'] : '';
	header('location:manage_agent_deposits.php');
}
$cond .= (isset($_SESSION['cb_req_status']) && $_SESSION['cb_req_status'] != '') ? " and ad_req_status = '".$_SESSION['cb_req_status']."'" : "";

if(isset($_GET['ag_id']))
{
	$_SESSION['cb_agent'] = (!empty($_GET['ag_id'])) ? $_GET['ag_id'] : '';
	header('location:manage_agent_deposits.php');
}
$cond .= (!empty($_SESSION['cb_agent']) && $_SESSION['cb_agent'] != '') ? " and ag_id = '".$_SESSION['cb_agent']."'" : "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	$_SESSION['cb_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	header('location:manage_agent_deposits.php');
}
if(!empty($_SESSION['cb_search']))
{	
	$search = array('ag_fname', 'ag_lname', 'ag_uname', 'ag_deposit', 'ag_address', 'ag_city', 'ag_country', 'ag_pincode', 'ag_mobile', 'ag_landline', 'ag_authority', 'ag_pancard', 'ag_email', 'ad_transaction', 'ad_amount', 'ad_type', 'ad_order_id');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".trim($_SESSION['cb_search'])."%')";
	}
	$cond.=')';
}

$page_query = mysql_query("select ad.ad_id from svr_agent_deposits as ad
	left join svr_agents as ag on ad.ad_ag_id = ag.ag_id
		where $cond order by ad_id desc");
$total = mysql_num_rows($page_query);
$result = mysql_query("select ad.*, ag.ag_fname, ag.ag_mobile from svr_agent_deposits as ad
	left join svr_agents as ag on ad.ad_ag_id = ag.ag_id
		where $cond order by ad_id desc limit $start, $len");

if(!empty($_GET['del'])){
	mysql_query("delete from svr_agent_deposits where ad_id='".$_GET['del']."'");
	header("location:manage_agent_deposits.php?msg=del");
}
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	mysql_query("update svr_agent_deposits set ad_status=".$status." where ad_id='".$_GET['sid']."'");
	header("location:manage_agent_deposits.php");
}

if(isset($_GET['req_status']) && !empty($_GET['id']))
{	
	$row = getdata("svr_agent_deposits", "ad_req_status, ad_ag_id, ad_transaction, ad_amount", "ad_id='".$_GET['id']."'", "1");
	
	$action = ''; //echo $row['ad_req_status'].' '.$row['ad_ag_id'].' '.$row['ad_amount']; exit;
	if($row['ad_req_status'] == 0){
		if(($_GET['req_status'] == 1)){
			$action = " + ".$row['ad_amount'];
		} else if(($_GET['req_status'] == 2)){
			$action = "";
		}
	} else if($row['ad_req_status'] == 1){
		if(($_GET['req_status'] == 0)){
			$action = " - ".$row['ad_amount'];
		} else if(($_GET['req_status'] == 2)){
			$action = " - ".$row['ad_amount'];
		}
	} else if($row['ad_req_status'] == 2){
		if(($_GET['req_status'] == 0)){
			$action = "";
		} else if(($_GET['req_status'] == 1)){
			$action = " + ".$row['ad_amount'];
		}
	}
	
	$exists = ($_GET['req_status'] == 1) ? getdata("svr_agent_reports", "ar_ord_id", "ar_ag_id='".$row['ad_ag_id']."' and ar_ord_id='".$row['ad_transaction']."'") : '0';
	
	if(empty($exists) && $_GET['req_status'] == 1)
	{	
		$transc = 'Deposit';	
		$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$row['ad_ag_id']."' order by ar_id desc");
		$op_bal = number_format($op_bal, 2, '.', '');
		$cl_bal = number_format($op_bal + $row['ad_amount'], 2, '.', '');
		$net = number_format($row['ad_amount'], 2, '.', '');
		
		$ref_id = rand(1000000, 9999999); $fkid = $_GET['id'];
		mysql_query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$row['ad_ag_id']."', '".$ref_id."', '".$row['ad_transaction']."', '', '".$transc."', '".$op_bal."', '".$row['ad_amount']."', '', '".$net."', '".$cl_bal."', '1', '".$fkid."', '".$now_time."')");
	}
	
	mysql_query("update svr_agents set ag_deposit = (ag_deposit".$action.") where ag_id = '".$row['ad_ag_id']."'");
	$agent = getdata("svr_agents", "ag_fname, ag_email", "ag_id='".$row['ad_ag_id']."'", "1");
	if($_GET['req_status'] != 0){
		$data['subject'] = 'Deposit Response from SVR';
		$data['content'] = "<table align='left'><tr><td>Dear ".$agent['ag_fname'].",</td></tr><tr><td>&nbsp;</td></tr>
		<tr><td>Your desposit request with Transactin ID ".$row['ad_transaction']." has been ".$ag_dep_req_status[$_GET['req_status']].".</td></tr>
		<tr><td>&nbsp;</td></tr><tr><td>Thanks & Regards, <br>SVR Tours and Travels</td></tr></table>";
		$data['to_email'] = $agent['ag_email'];
		send_email($data);
	}
	mysql_query("update svr_agent_deposits set ad_req_status=".$_GET['req_status']." where ad_id='".$_GET['id']."'");
	
	header("location:manage_agent_deposits.php");
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
<script language="javascript" src="../js/script.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Agent Deposits</strong></td>
			  <td valign="top" align="right"><a href="add_agent_deposit.php"><strong>Add Agent Deposit</strong></a></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td valign="top"><table width="95%" border="0" align="center" cellpadding="6" cellspacing="0" class="table">
            <tr>
				<td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td width="0" align="left" valign="middle">
					  <select name="agent" id="agent" onchange="javascript:window.location='manage_agent_deposits.php?ag_id='+this.value">
						<option value="">Select Agent</option>
						<? 	$q = mysql_query("select ag_id, ag_fname, ag_lname from svr_agents where ag_status = 1");
							while($fetch = mysql_fetch_array($q)){ ?>
						<option value="<?=$fetch['ag_id'];?>"
						<? if($_SESSION['cb_agent'] == $fetch['ag_id'] && $_SESSION['cb_agent'] != ''){?>selected<? }?>>
						<?=$fetch['ag_fname'].' '.$fetch['ag_lname']; ?></option><? }?>
					  </select>
					  
					  <input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['cb_search'])){ echo $_SESSION['cb_search'];}?>" size="20"/>
					  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
					  <? if($_SESSION['cb_search'] != '' || $_SESSION['cb_agent'] != '' || $_SESSION['cb_req_status'] != ''){ ?>
                          <img src="images/reset.png" onclick="javascript:window.location='manage_agent_deposits.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
                        <? } ?>
                        <div class="fr">
                        <select name="req_status" id="req_status" onchange="javascript:window.location='manage_agent_deposits.php?req_status='+this.value">
                            <option value="">Select Status</option>
                            <? 	foreach($ag_dep_req_status as $key => $value){?>
                            <option value="<?=$key;?>"
                            <? if($_SESSION['cb_req_status'] != '' && $_SESSION['cb_req_status'] == $key){?>selected<? }?>>
                            <?=$value;?></option><? }?>
                        </select>
                        </div>
                      </td>
                    </tr>
                </table></td>
			  </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="3%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td class="tablehead"><strong>Agent Name</strong></td>
					<!--<td width="12%"class="tablehead" nowrap="nowrap"><strong>Account Holder Name</strong></td>-->
					<td width="10%" class="tablehead"><strong>Mobile</strong></td>
					<td width="10%" class="tablehead"><strong>Amount</strong></td>
					<td width="10%" class="tablehead"><strong>Deposit Type</strong></td>
					<td width="11%" class="tablehead"><strong>Transaction ID</strong></td>
                    <td width="9%" class="tablehead">Joined Date</td>
                    <td width="5%" align="center"class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>-->
                    <td width="5%" align="center" class="tablehead">Status</td>
                  </tr>
                </thead>
                <?php
				if($total>0)
				{	
					$sno=$start;
					while($fetch=mysql_fetch_array($result))
					{ 
						$sno++;
						if($fetch['ad_status']==1){
							$f_status ='<a href="manage_agent_deposits.php?sid='.$fetch["ad_id"].'&f_status=inactive">
							<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
						}else if($fetch['ad_status']==0){
							$f_status='<a href="manage_agent_deposits.php?sid='.$fetch["ad_id"].'&f_status=active">
							<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
						}		
						?>
						<tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
						  <td height="25" align="left"><?=$sno;?>.</td>
						  <td align="left"><?=to_title_case($fetch['ag_fname']);?></td>
						  <!--<td align="left"><?=$fetch['ad_acc_holder']?></td>-->
						  <td align="left"><?=$fetch['ag_mobile']?></td>
						  <td align="right"><?='Rs.'.number_format($fetch['ad_amount'], 2, '.', '');?></td>
						  <td align="left"><?=$deposit_type[$fetch['ad_type']];?></td>
						  <td align="left"><?=(!empty($fetch['ad_transaction'])) ? $fetch['ad_transaction'] : $fetch['ad_order_id'];?></td>
						  <td align="left"><?=date('d/m/Y', strtotime($fetch['ad_addeddate']));?></td>
						  <td align="center">
                          <? if($fetch['ad_type'] != 4){?><a href="add_agent_deposit.php?id=<?=$fetch['ad_id'];?>">
                          <img src="images/edit.png" alt="Edit" title="Edit" /></a><? }?></td>
						  <td align="center"><a href="javascript:;" onclick="popupwindow('view_agent_deposit.php?dep_id=<?=$fetch['ad_id']?>', 'Title', '750', '550');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
						  <!--<td align="center"><?=($fetch['ad_req_status'] == 0) ? $f_status : '';?></td>-->
						  <td align="center"><? $check = ($fetch['ad_req_status'] == 1 || $fetch['ad_req_status'] == 2) ? '1' : '0'; ?>
						  <!--<form name="status" id="status" method="post">-->
							<select name="status" id="status" style="width:100px;" onchange="window.location='manage_agent_deposits.php?req_status='+this.value+'&id=<?=$fetch['ad_id']?>'">
                            <? if($fetch['ad_type'] != 4){ ?>
								<? foreach($ag_dep_req_status as $key => $req){
								if(($check == 1 && $key == $fetch['ad_req_status']) || $check == 0){
								$selected_status = ($fetch['ad_req_status'] == $key) ? 'selected' : ''; ?>
								<option value="<?=$key?>" <?=$selected_status?>><?=$req?></option>
								<? }}?>
                            <? } else if($fetch['ad_type'] == 4){?>    
                            	<option value="1" <?=$selected_status?>>Successful</option>
                            <? }?>
							</select>
						  <!--</form>-->						  
                          </td>
						</tr>
						<?
					}
				}
				else if($total==0)
				{
				?>
                <tr>
                  <td colspan="14" height="150" align="center" bgcolor="#CCC">No Records Found</td>
                </tr>
                <? } ?>
              </table></td>
            </tr>
          </table>
		  </td>
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