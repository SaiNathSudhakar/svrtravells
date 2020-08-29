<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2" id="registration_table">
  <tr>
	<td colspan="3" align="left" valign="middle" bgcolor="#E9E9E9" width="394px"><span class="head">Personal Details</span></td>
	<td align="left" valign="middle" bgcolor="#E9E9E9">Email ID:&nbsp;</td>
	<td align="center" valign="middle" bgcolor="#E9E9E9">:</td>
	<td width="" valign="middle" bgcolor="#E9E9E9">
		<input name="email" type="text" id="email" style="width:200px;" value="<?=$_SESSION[$svr.'cust_email']?>" <?=$atrributes?>>
		<input name="sumbit_contact" id="sumbit_contact" type="button" class="submit-btn" value="GO" <?=$disabled;?>>
	</td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="middle">Name <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle">
    <input type="hidden" name="customer" id="customer" value="<?=$_SESSION[$svr.'cust_id']?>">
	<select name="title" id="title" <?=$title_disabled?>>
	<? foreach($titles as $key => $value){?><option value="<?=$key?>" <? if($_SESSION[$svr.'cust_title'] == $key) echo 'selected';?>><?=$value?></option><? }?>
	</select>
	&nbsp;<input type="text" name="fname" id="fname" class="regdata" style="width:185px" value="<?=$_SESSION[$svr.'cust_fname']?>" <?=$atrributes?>></td>
    <td align="left" valign="middle">Address <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input type="text" name="address" id="address" class="textbox regdata" value="<?=$_SESSION[$svr.'cust_addr']?>" <?=$atrributes?>></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="middle" bgcolor="#F7F7F7">Mobile <span class="star">*</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="mobile" type="text" class="textbox regdata" id="mobile" value="<?=$_SESSION[$svr.'cust_mobile']?>" <?=$atrributes?>></td>
    <td valign="middle" bgcolor="#F7F7F7">City <span class="star">*</span></td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="city" type="text" class="textbox regdata" id="city" value="<?=$_SESSION[$svr.'cust_city']?>"></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top">State <span class="star">*</span></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top">
    <select name="state" id="state" class="textbox" <?=$state_disabled?>>
	<? foreach($states as $key => $value){?><option value="<?=$key?>" <? if($_SESSION[$svr.'cust_state'] == $key) echo 'selected';?>><?=$value?></option><? }?>
	</select> 
    </td>
    <td valign="middle">Country <span class="star">*</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle"><input name="country" type="text" class="textbox regdata" id="country" value="<?=$_SESSION[$svr.'cust_country']?>" <?=$atrributes?> /></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top" bgcolor="#F7F7F7">Emergency Contact No </td>
    <td align="center" valign="top" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="top" bgcolor="#F7F7F7"><input name="emergency" type="text" class="textbox" id="emergency"></td>
    <td valign="middle" bgcolor="#F7F7F7">Comments</td>
    <td align="center" valign="middle" bgcolor="#F7F7F7">:</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7"><input name="comments" type="text" class="textbox" id="comments"></td>
  </tr>
  <tr class="reg_row" style="display:<?=$display;?>">
    <td align="left" valign="top">Email ID <span class="star">*</span></td>
    <td align="center" valign="top">:</td>
    <td align="left" valign="top"><input name="emaill" type="text" class="textbox regdata" id="emaill" value="<?=$_SESSION[$svr.'cust_email']?>" <?=$atrributes?>></td>
    <td valign="top" class="pwd" style="display:none">Password <span class="star">*</span></td>
    <td align="center" valign="top" class="pwd" style="display:none">:</td>
    <td valign="top" class="pwd" style="display:none"><input name="password" type="password" class="textbox regdata" id="password" <?=$atrributes?>></td>
    <td colspan="3" valign="top" class="nopwd" style="display:none">&nbsp;</td>
  </tr>
</table>

<a href="#login-box" class="login-window"></a>
<div id="login-box" class="login-popup">
  <a href="#" class="close"><img src="images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
  <!--<form method="post" class="signin" action="">-->
	<fieldset class="txtbox">
		<label class="password">
			Enter Password <label id="txtErrMsg">Wrong Password</label>
			<input id="txtPassword" name="txtPassword" type="password" placeholder="Password">
			
		</label>
		<button class="submit button" id="txtSubmit" type="button">Sign in</button>			
	</fieldset>
 <!-- </form>-->
</div>