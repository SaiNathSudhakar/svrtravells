<?
ob_start();
include_once("includes/functions.php");
if(!isset($_SESSION[$svra.'ag_id'])){?><script language="javascript">self.close();</script><? } ?> 
<? if(!is_numeric($_GET['dep_id'])){header("location:index.php");} 

$qur = query("select ag_dep.*,ag.ag_fname, ag.ag_mobile, ag.ag_unique_id from svr_agents as ag 
left join svr_agent_deposits as ag_dep on ag_dep.ad_ag_id=ag.ag_id 
	where ad_id='".$_GET['dep_id']."'");
$row=fetch_array($qur); ?>

<style type="text/css">
body,td,th{font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;}
.curve-border{border: 1px solid #666; background: #ffffff ; color:#222222; -moz-border-radius: 3px; -webkit-border-radius: 3px;}
.blue_read:link{color:#333; font-weight:bold; text-decoration:none; margin-right:14px;font-size:12px;}
.blue_read:visited{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:hover{color:#FB8800; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:active{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
</style>
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0">
<!--  <tr>
    <td align="right"><a href="javascript:;" onClick="window.close();" class="blue_read">Close Window</a></td>
  </tr>-->
  <tr>
    <td><strong>Agent Deposit Details :</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Agent Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_fname'];?></td>
      </tr>
	  <? if(!empty($row['ag_dep_acc_holder'])){?>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Account Holder Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ad_acc_holder'];?></td>
      </tr>
	   <? }if(!empty($row['ag_mobile'])){?>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Mobile</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ag_mobile'];?></td>
      </tr>
      <? }if(!empty($row['ad_amount'])){?>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?='Rs.'.$row['ad_amount'];?></td>
      </tr>
	  <? } if(!empty($row['ad_type'])){?>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Deposit Type</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$deposit_type[$row['ad_type']];?></td>
      </tr>
      <? }if(!empty($row['ad_bank'])){?>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Bank Name</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$bank[$row['ad_bank']];?></td>
      </tr>
      <? }if(!empty($row['ad_order_id'])){?>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Order ID</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ad_order_id'];?></td>
      </tr>
      <? }if(!empty($row['ad_transaction'])){?>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Transaction ID</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ad_transaction'];?></td>
      </tr>
	  <? }if(!empty($row['ad_drawn'])){?>
      <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Cheque Drawn on Bank</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ad_drawn'];?></td>
      </tr>
	  <? }if(!empty($row['ad_chq_issue_date']) && $row['ad_chq_issue_date']!= '0000-00-00 00:00:00' && $row['ad_chq_issue_date']!= '1970-01-01 05:30:00'){?>
	   <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Cheque Issue Date</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=date('d/m/Y', strtotime($row['ad_chq_issue_date']));?></td>
      </tr>
	  <? }if(!empty($row['ad_dd_no'])){?>
	   <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Cheque or DD No.</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ad_dd_no'];?></td>
      </tr>
       <? }if(!empty($row['ad_attach_slip'])){?>
	  <tr>
        <td width="35%" valign="top" bgcolor="#F3F3F3"><strong>Attach Deposit Slip</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><a href="<?='uploads/agents/'.$row['ag_unique_id'].'/'.basename($row['ad_attach_slip']);?>" style="text-decoration:none;"><?=$row['ad_attach_slip'];?></a></td>
      </tr>
	  <? }?>
    </table></td>
  </tr>
 <!-- <tr>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>-->
</table>