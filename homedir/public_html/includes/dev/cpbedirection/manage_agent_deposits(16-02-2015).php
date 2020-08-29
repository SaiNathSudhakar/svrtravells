<?
ob_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['deposit_manage']) && $_SESSION['deposit_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

$page_query = mysql_query("select ad_id from  svr_agent_deposits");
$total=mysql_num_rows($page_query);
$len=10; $start=0;
$link="manage_agent_deposits.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
			
$result = mysql_query("select ad.*, ag.ag_fname from svr_agent_deposits as ad
left join svr_agents as ag on ad.ad_ag_id = ag.ag_id
	where 1 order by ad_id desc limit $start, $len");
$count_order=mysql_num_rows($result);

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
				
		$ref_id = rand(1000000, 9999999);
		mysql_query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_date_time) values( '', '".$row['ad_ag_id']."', '".$ref_id."', '".$row['ad_transaction']."', '', '".$transc."', '".$op_bal."', '".$row['ad_amount']."', '', '".$net."', '".$cl_bal."', '', now())");
	}
	
	mysql_query("update svr_agents set ag_deposit = (ag_deposit".$action.") where ag_id = '".$row['ad_ag_id']."'");
	
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
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			  <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
				</tr></table></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td valign="top"><table width="95%" border="0" align="center" cellpadding="6" cellspacing="0">
            <tr>
				<td align="right"><a href="add_agent_deposit.php"><strong>Add Agent Deposit</strong></a></td>
			  </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="8%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td width="14%" class="tablehead"><strong>Agent Name</strong></td>
					<!--<td width="12%"class="tablehead" nowrap="nowrap"><strong>Account Holder Name</strong></td>-->
					<td width="12%"class="tablehead"><strong>Mobile</strong></td>
					<td width="11%"class="tablehead"><strong>Amount</strong></td>
					<td width="15%"class="tablehead"><strong>Deposit Type</strong></td>
					<td width="14%"class="tablehead"><strong>Transaction ID</strong></td>
                    <td width="4%"class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
                    <td width="7%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
                    <td width="7%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
                    <td width="7%" align="center" class="tablehead">Status</td>
                  </tr>
                </thead>
                <?php
				if($count_order>0)
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
						  <td align="left"><?=$fetch['ad_mobile']?></td>
						  <td align="left"><?=$fetch['ad_amount'];?></td>
						  <td align="left"><?=$deposit_type[$fetch['ad_type']];?></td>
						  <td align="left"><?=(!empty($fetch['ad_transaction'])) ? $fetch['ad_transaction'] : $fetch['ad_order_id'];?></td>
						  <td align="left">
                          <? if($fetch['ad_type'] != 4){?><a href="add_agent_deposit.php?id=<?=$fetch['ad_id'];?>">
                          <img src="images/edit.png" alt="Edit" title="Edit" /></a><? }?></td>
						  <td width="7%" align="center"><a href="javascript:;" onclick="popupwindow('view_agent_deposit.php?dep_id=<?=$fetch['ad_id']?>', 'Title', '750', '550');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
						  <td width="7%" align="center"><? echo $f_status; ?></td>
						  <td width="7%" align="center"><? $check = ($fetch['ad_req_status'] == 1 || $fetch['ad_req_status'] == 2) ? '1' : '0'; ?>
						  <form name="status" id="status" method="post">
							<select name="status" id="status"style="width:140px;" onchange="window.location='manage_agent_deposits.php?req_status='+this.value+'&id=<?=$fetch['ad_id']?>'">
                            <? if($fetch['ad_type'] != 4){ ?>
								<? foreach($req_status as $key => $req){if(($check == 1 && $key == $fetch['ad_req_status']) || $check == 0){
								$selected_status = ($fetch['ad_req_status'] == $key) ? 'selected' : ''; ?>
								<option value="<?=$key?>" <?=$selected_status?>><?=$req?></option>
								<? }}?>
                            <? } else if($fetch['ad_type'] == 4){?>    
                            	<option value="1" <?=$selected_status?>>Successful</option>
                            <? }?>
							</select>
						  </form>
						  </td>
						</tr>
						<?
					}
				}
				else if($count_order==0)
				{
				?>
                <tr>
                  <td colspan="13" height="150" align="center" bgcolor="#CCC">No Records Found</td>
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
</body>
</html>