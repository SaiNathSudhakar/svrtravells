<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/site.css" rel="stylesheet" type="text/css">
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>
<style type="text/css">
.table{border-spacing:1px; background:#d5d5d5; border-bottom:1px solid #ebebeb; width:100%;}
.table td{background:#FFFFFF; padding:4px 10px;}
.table .tablehead{background:url(images/tabg.gif) repeat-x top center; font-size:12px; font-weight:bold; color:#000; padding-left:10px;}
.table .tableheadlite{background:url(images/tabb.gif) repeat-x top center; font-size:12px; font-weight:bold; color:#000; padding-left:10px;}
.table .tablerow1 td{background:#f5f5f5;}
.table .tablerow2 td{background:#FFFFFF;}
.table td.paging{background:#FFF; padding:10px;}
.table .tablerowerr td{ background:#EC8484;} /*#D60810 or #D26060*/
.curve-border { border: 1px solid #666; background: #ffffff ; color:#222222; -moz-border-radius: 3px; -webkit-border-radius: 3px;}
.blue_read:link{color:#333; font-weight:bold; text-decoration:none; margin-right:14px;font-size:12px;}
.blue_read:visited{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:hover{color:#FB8800; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:active{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
</style>

<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$pageName?></span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
	<div class="fl"><h1><?=$pageName?></h1></div>
	<div class="fr"><h2>Welcome: <span><?=(!empty($fetch['ag_fname'])) ? $fetch['ag_fname'] : $_SESSION[$svra.'ag_fname']?></span></h2></div>
	<div class="clear"></div>
</div>

<div class="col">
<div class="form_styles form_wrapper">
<table width="100%" cellpadding="3" cellspacing="5" >
<tr><td colspan="2"><? if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.'</h3>'; }?></td></tr>
<tr><td align="left">Current Balance: <span class="rupee">&#x20B9;</span> 
<? $closing_bal = getdata('svr_agent_reports', 'ar_closing_bal', "ar_ag_id = '".$_SESSION[$svra.'ag_id']."' order by ar_id desc"); echo $closing_bal;
//=($_SESSION[$svra.'ag_deposit'] != '') ? number_format($_SESSION[$svra.'ag_deposit'], 2) : '0';?></td>
<td align="right"><a href="agent-deposits.php"><img src="images/add.png" alt="View" title="View" width="16" height="16" /></a></td></tr>
<tr><td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" class="table">
<tr>
<td height="25%" class="tablehead">Sno.</td>
<td nowrap="nowrap" class="tablehead">Transaction ID</td>
<td class="tablehead">Amount</td>
<td nowrap="nowrap" class="tablehead">Deposit Type</td>
<td nowrap="nowrap" class="tablehead">Status</td>
<td class="tablehead" nowrap="nowrap">Added Date</td>
<td class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" /></td>
<td class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
</tr>
<?php
if($count_order>0){
	$sno=$start;
	while($fetch=mysql_fetch_array($result)){ $sno++;
?>
<tr>
<td><?=$sno;?>.</td>
<td><?=($fetch['ad_transaction'] != '') ? $fetch['ad_transaction'] : $fetch['ad_order_id'];?></td>
<td nowrap="nowrap"><span class="rupee">&#x20B9;</span> <?=number_format($fetch['ad_amount'], 2);?></td>
<td nowrap="nowrap"><?=$deposit_type[$fetch['ad_type']];?></td>
<td nowrap="nowrap"><?=$req_status[$fetch['ad_req_status']];?></td>
<td nowrap="nowrap"><?=date('M d, Y',strtotime($fetch['ad_addeddate']));?></td>
<td><? if(($fetch['ad_type'] != 4) && $fetch['ad_req_status'] == 0){?>
<a href="agent-deposits.php?id=<?=$fetch['ad_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" /></a><? }?></td>
<td><a href="javascript:;" onclick="popupwindow('view-agent-histroy.php?dep_id=<?=$fetch['ad_id']?>', 'Title', '750', '550');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
</tr>
<? }} else if($count_order==0){?>
<tr>
  <td colspan="13" height="150" align="center" bgcolor="#CCC">No Records Found</td>
</tr>
<? } ?>
 </table>
</td></tr>
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
</table>
</div>
<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>


</div>
<div class="clear"></div>
<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>
</div>

<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$fetch['cnt_content'];?></div>	
</div>

<!--expandable meuu scripts-->
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>