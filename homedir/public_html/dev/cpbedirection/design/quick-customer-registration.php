<form method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2" id="registration_table">
  <tr>
	<td colspan="3" align="left" valign="middle" bgcolor="#E9E9E9" width="394px"><span class="head">Personal Details</span></td>
	<!--<td align="left" valign="middle" bgcolor="#E9E9E9">Email ID:&nbsp;</td>
	<td align="center" valign="middle" bgcolor="#E9E9E9">:</td>
	<td width="" valign="middle" bgcolor="#E9E9E9">
		<input name="email" type="text" id="email" style="width:200px;" value="<?=$_SESSION[$svr.'cust_email']?>" <?=$atrributes?>>
		<input name="sumbit_contact" id="sumbit_contact" type="button" class="submit-btn" value="GO" <?=$disabled;?>>
	</td>-->
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="middle">Name <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle">
    <input type="hidden" name="customer" id="customer" value="<?=$_SESSION[$svr.'cust_id']?>">
	<select name="title" id="title" <?=$title_disabled?> required>
	<? foreach($titles as $key => $value){?><option value="<?=$key?>" <? if($_SESSION[$svr.'cust_title'] == $key) echo 'selected';?>><?=$value?></option><? }?>
	</select>
	&nbsp;<input type="text" name="fname" id="fname" class="regdata" style="width:185px" required></td>
    <td align="left" valign="middle">Address <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input type="text" name="address" id="address" class="textbox regdata" required></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="middle" bgcolor="#F7F7F7">Mobile <span class="star">*</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="mobile" type="text" class="textbox regdata" id="mobile" maxlength="13" required></td>
    <td valign="middle" bgcolor="#F7F7F7">City <span class="star">*</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="city" type="text" class="textbox regdata" id="city" required></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top">State <span class="star">*</span></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top">
    <select name="state" id="state" class="textbox" <?=$state_disabled?> required>
	<? foreach($states as $key => $value){?><option value="<?=$key?>" <? if($_SESSION[$svr.'cust_state'] == $key) echo 'selected';?>><?=$value?></option><? }?>
	</select> 
    </td>
    <td valign="middle">Country <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input name="country" type="text" class="textbox regdata" id="country" required/></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top" bgcolor="#F7F7F7">Emergency Contact No </td>
    <td align="center" valign="top" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="top" bgcolor="#F7F7F7"><input name="emergency" type="text" class="textbox" id="emergency" required></td>
    <td valign="middle" bgcolor="#F7F7F7">Comments</td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="comments" type="text" class="textbox" id="comments"></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top">Email ID <span class="star">*</span></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top"><input name="email" type="email" class="textbox regdata" id="email" required></td>
    <td valign="top" class="pwd" style="display:none">Password <span class="star">*</span></td>
    <td align="center" valign="top" class="pwd" style="display:none">:</td>
    <td valign="top" class="pwd" style="display:none"><input name="password" type="password" class="textbox regdata" id="password" value="password"></td>
    <td colspan="3" valign="top" class="nopwd" style="display:none">&nbsp;</td>
    <td align="left" valign="top">Payment Details<span class="star">*</span></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top"><textarea name="ord_payment_det" id="ord_payment_det" required></textarea></td>
    <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input type="submit" class="submit-btn" value="Confirm Booking" /></td></tr>
  </tr>
</table>
</form>