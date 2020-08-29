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
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$pageName?></span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
	<div class="fl"><h1><?=$pageName?></h1></div>
	<div class="fr"><h2>Welcome: <span><?=(!empty($fetch['ag_fname'])) ? $fetch['ag_fname'] : $_SESSION[$svra.'ag_fname']?></span></h2></div>
	<div class="clear"></div>
</div>

<div class="col">
<div class="form_styles form_wrapper">
<table width="100%" cellpadding="2" cellspacing="2" class="table">
<tr>
<td height="25%" colspan="6" style="color:#006633;font-size:16px" align="center">Note : we will not be accepting cheques drawn on Osmanabad District Central Co-operative Bank.</td>
</tr>

<tr>
<td  class="tablehead">Cash Deposit Timing</td>
<td  class="tablehead">Via Contact No. </td>
<td  class="tablehead">Fax no.</td>
<td  class="tablehead" colspan="3">Email</td>

</tr>
<tr>
<td nowrap="nowrap">10:00AM to 01:00PM & 01:30PM to 06:30PM</td>
<td>080-40433077 </td>
<td nowrap="nowrap">080-40433044</td>
<td  colspan="3">updates@via.com / update1@via.com</td>

</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="5" align="center" >
<tr>
  <td colspan="2" >&nbsp;</td>
</tr>
<tr><td colspan="2"><center><h1><span style="color:#000000">All payments in Favour of </span>"SVR Travels Pvt Ltd."</h1></center></td></tr>

<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" class="table">
<tr>
<td height="25%" class="tablehead">Sno.</td>
<td nowrap="nowrap" class="tablehead">Bank Name</td>
<td class="tablehead">Branch</td>
<td nowrap="nowrap" class="tablehead">Account Number</td>
<td nowrap="nowrap" class="tablehead">IFSC Code</td>
<td class="tablehead" nowrap="nowrap">Download</td>
</tr>

<tr>
<td>1.</td>
<td>ICICI BANK </td>
<td nowrap="nowrap">SAIFABAD - HYDERABAD</td>
<td nowrap="nowrap">110905500130</td>
<td nowrap="nowrap">ICIC0001109</td>
<td nowrap="nowrap"><a href="uploads/bank_details/SVR_ICICI_Deposit_Slip.pdf" target="_blank">Download</a></td>
</tr>

<tr>
<td>2.</td>
<td>SBI BANK </td>
<td nowrap="nowrap">SAIFABAD - HYDERABAD</td>
<td nowrap="nowrap">32528573952</td>
<td nowrap="nowrap">SBIN00007315</td>
<td nowrap="nowrap"><a href="uploads/bank_details/SVR_ICICI_Deposit_Slip.jpg" target="_blank">Download</a></td>
</tr>
</table></td></tr>
</table>
</div>
<br />

</div>

</div>
<div class="clear"></div>
<!--<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>-->
</div>
