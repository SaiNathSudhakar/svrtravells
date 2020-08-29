<script src="js/navmenu.js" type="text/javascript"></script>

<!--<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>-->
<!-- Navigation Start-->
<div class="navigation">
  <div class="bg">
  	<a href="index.php">Home</a>
	<span class="divied"></span>
	<span class="pagename">View Report</span>
  </div>
</div>
<!-- Navigation end-->
<div class="inner_content">
<? //include('includes/left.php'); ?>
<div class="fl" style="width:100%">
<div class="myprofile">
<div class="fl"><h1>Report</h1></div>
<div class="fr"><h2>Welcome: <span><?=($_SESSION[$svra.'ag_fname'] != '') ? $_SESSION[$svra.'ag_fname'] : $_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"><table width="100%" border="0" align="center" cellpadding="6" cellspacing="0">
        <tr>
          <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table"><tr><td>
          	<form name="yellow_cat" id="yellow_cat" method="post" action="">
          	<table border="0" align="left" cellpadding="2" cellspacing="2" class="table">
                <tr>
                  <td align="left" valign="middle" nowrap="nowrap" class="tablehead"> </td>
                  <td align="left" valign="middle">
                  <? if(!empty($_SESSION['ar_ag_id']) || !empty($_SESSION['ar_from_date']) || !empty($_SESSION['ar_to_date'])){ ?>
                  <img src="images/reset.png" align="absmiddle" alt="Reset" onClick="javascript:window.location = 'agent-report.php?src=reset'" title="Reset"/>
                  <? } ?>
                  </td> <td> From : </td> <td valign="bottom">
                    <input name="ar_from_date" type="text" class="input fl" id="ar_from_date" style="width:120px;" onFocus="this.placeholder=''" onBlur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ar_from_date'])){echo $_SESSION['ar_from_date'];}?>" />
                  </td><td> To : </td> <td valign="middle">
                    <input name="ar_to_date" type="text" class="input fl" id="ar_to_date" style="width:120px;" onFocus="this.placeholder=''" onBlur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ar_to_date'])){echo $_SESSION['ar_to_date'];}?>" />
                  </td>	<td>				  
                  <input name="search_but" type="submit" class="" id="" value="Go" title="Search"/>
                  </td>
                  <!--<td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>-->
                  </tr>
            </table>
          </form></td></tr></table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table" bordercolor="#F2F2F2">
            <thead style="display:<? //=(empty($search)) ? 'none' : '';?>">
              <tr>
                <td class="tablehead" bgcolor="#F9F9F9" height="20"><strong>S.No</strong></td>
                <td class="tablehead" bgcolor="#F9F9F9"><strong>Order ID /<br>Transaction</strong></td>
                <td class="tablehead" bgcolor="#F9F9F9" nowrap="nowrap"><strong>Opening Balance</strong></td>
                <td class="tablehead" bgcolor="#F9F9F9"><strong>Amount</strong></td>
                <td class="tablehead" bgcolor="#F9F9F9" nowrap="nowrap"><strong>Closing Balance</strong></td>
                <td class="tablehead" bgcolor="#F9F9F9" width="20%"><strong>Date &amp; Time</strong></td>
                </tr>
            </thead>
            <?php
        if($count_order>0)
        {
            $sno=$start;
            while($fetch=fetch_array($result))
            { 
                $sno++;
                if($fetch['ad_status']==1){
                    $f_status ='<a href="agent_report.php?sid='.$fetch["ad_id"].'&f_status=inactive">
                    <img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
                }else if($fetch['ad_status']==0){
                    $f_status='<a href="agent_report.php?sid='.$fetch["ad_id"].'&f_status=active">
                    <img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
                }		
            ?>
                <tr bgcolor="<? if($sno%2==0){ echo "#F9F9F9";} else {echo "#F2F2F2";}?>" style="display:<? //=(empty($search)) ? 'none' : '';?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><?=$fetch['ar_ord_id'];?><br><?=$fetch['ar_transaction_type'];?></td>
                  <td align="right" nowrap="nowrap"><?=($fetch['ar_opening_bal'] != '') ? 'Rs.'.number_format($fetch['ar_opening_bal'], 2) : '';?></td>
                  <td align="right" nowrap="nowrap"><?='Rs.'.number_format($fetch['ar_amount'], 2);?> 
                     <?=($fetch['ar_commission'] != '') ? '<br>Commission: Rs.'.number_format($fetch['ar_commission'], 2) : '';?>
					 <?=($fetch['ar_cancel_charges'] != '') ? '<br>Cancellation: Rs.'.number_format($fetch['ar_cancel_charges'], 2) : '';?>
                     <?=($fetch['ar_transaction_type'] != 'Deposit') ? '<br>Net Amount: Rs.'.number_format($fetch['ar_net_amount'], 2) : '';?></td>
                  <td align="right" nowrap="nowrap"><?='Rs.'.number_format($fetch['ar_closing_bal'], 2);?></td>
                  <td align="left"><?=date('d/m/Y h:i:s A', strtotime($fetch['ar_date_time']));?></td>
                </tr>
                <?
            }
        }
        else if($count_order==0)
        {
        ?>
            <tr>
              <td colspan="9" height="150" align="center" bgcolor="#F9F9F9">No Records Found</td>
            </tr>
          <? }?>
          </table></td>
        </tr>
      </table>
      </td>
    </tr>
    <? if($total>$len){ ?>
		<tr>
		  <td colspan="9"><table width="94%" border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr>
				<td><? page_Navigation_front($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? }?>
		<tr><td align="center">&nbsp;</td></tr>
</table>
</div>
</div>