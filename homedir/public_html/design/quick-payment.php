<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2" class="reg_row" id="payment_table" style="display:<?=$display;?>">
  <tr>
	<td align="left" valign="middle" bgcolor="#E9E9E9"><div class="head">Payment Details</div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">
	<table border="0" width="75%"><tr><td width="20%">Payment Option : </td><td><img src="images/payu.png" width="50" vspace="middle" /></td>
	  <td align="center"><input name="book" type="button" class="submit-btn" id="booknow" value="Submit & Pay Now" onclick="validate_booking();"/></td>
	</tr></table>
    </td>
  </tr>
  <tr bgcolor="#F7F7F7">
    <td align="left" valign="middle"><input id="terms" type="checkbox" name="terms" />
  
<? 	$qur=query("select cnt_content from svr_content_pages where cnt_id = 8");
	$row_loc=fetch_array($qur);
	if($row_loc['cnt_content'] != '') { ?>
    I here by agree to the <a href="#dealit" rel="facebox">Terms &amp; Conditions.</a></td>
    <div id="dealit">
		<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
		<div style="padding:20px;" class="facebox">
		<?=$row_loc['cnt_content'];?>
		</div><? }?>
	</div>
  </tr>
  <tr>
    <td align="left" valign="middle"><input id="chkPromotions" type="checkbox" name="chkPromotions" checked />
      I would like to be kept informed of special promotions and offers by SVR India Travels Pvt. Ltd.
	  <input type="hidden" name="ag_dp" id="ag_dp" value="<?=(!empty($_SESSION[$svra.'ag_deposit'])) ? $_SESSION[$svra.'ag_deposit'] : '';?>" />
	  <input type="hidden" name="agent" id="agent" value="<?=(!empty($_SESSION[$svra.'ag_id'])) ? $_SESSION[$svra.'ag_id'] : '';?>" />
	</td>
  </tr>
</table>