<? if(!empty($_GET['id']) && $fetch_sam['ad_ag_id'] != $_SESSION[$svra.'ag_id']){ header('location:agent-account.php'); }?>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>
<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$pageName?></span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); 
if(!empty($_POST['source'])) $id = $_POST['source']; else if(!empty($_GET['id'])) $id = $fetch_sam['ad_type']; else $id = 2;
echo "<script type='text/javascript'>window.onload = function(){show_deposit_type(".$id.");}</script>";?>
<div class="fl" style="width:72%">
<div class="myprofile">
	<div class="fl"><h1>My Deposits</h1></div>
	<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svra.'ag_fname']?></span></h2></div>
	<div class="clear"></div>
</div>
<? if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.'</h3>'; }?>

<form name="deposit" id="deposit" method="post" enctype="multipart/form-data">
<div class="col fl">
<div class="form_styles form_wrapper">
<table width="100%" cellpadding="3" cellspacing="5">
<tr><td colspan="2">
<table width="100%">

<tr><td><strong>Deposit Type</strong></td><td >
<input type="radio" name="source" value="1" id="cash" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '1'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch_sam['ad_type'] == 1){ echo 'checked'; }?> /> Cash
<input type="radio" name="source" value="2" id="cheque" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '2'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch_sam['ad_type'] == 2){ echo 'checked'; } elseif(empty($_GET['id']) && $_POST['source'] != '1' && $_POST['source'] != '3') echo 'checked'; ?> /> Cheque
<input type="radio" name="source" value="3" id="trans" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '3'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch_sam['ad_type'] == 3){ echo 'checked'; }?> /> Bank Transfer
</td></tr>
<tr><td colspan="3" align="center"><hr /></td></tr>
</table></td></tr>

<tr><td><strong>Deposit Amount</strong></td><td><input type="text" name="amount" value="<? if(!empty($_POST['amount'])){echo $_POST['amount'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_amount'];}?>" size="20"/><br />(Enter without any commas and spaces e.g. 2300)</td></tr>

<tr><td><strong>Mobile Number</strong></td><td><input type="text" name="mobile" value="<? if(!empty($_POST['mobile'])){echo $_POST['mobile'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_mobile'];}else{echo $_SESSION[$svra.'ag_mobile'];}?>" size="20"/></td></tr>

<tr><td><strong>Transaction ID</strong></td><td><input type="text" name="transaction" id="transaction" value="<? if(!empty($_POST['transaction'])){echo $_POST['transaction'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_transaction'];}?>" size="20"/></td></tr>

<tr><td><strong>Deposited in Bank</strong></td>
<td><select name="bank" id="bank"><? foreach($bank as $key => $value){?>
<option value="<?=$key?>" <? if((!empty($_GET['id']) && $fetch_sam['ad_bank'] == $key) || $_POST['bank'] == $key) echo 'selected';?>><?=$value?></option>
<? }?></select></td></tr>

<tr id="cheq_draw_bank"><td><strong>Cheque Drawn on Bank</strong></td><td><input type="text" name="cq_drawn" size="20" value="<? if(!empty($_POST['cq_drawn'])){echo $_POST['cq_drawn'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_drawn'];}?>" /><br />(Enter short form e.g. ICICI, HDFC, SBI, SBM etc)</td></tr>

<tr id="cheq_issu_date"><td><strong>Cheque Issue Date</strong></td><td><input type="text" class="input2" id="tabOverInput" name="cq_datepicker" value="<? if(!empty($_POST['cq_datepicker'])){echo $_POST['cq_datepicker'];}elseif(!empty($_GET['id'])){echo date('F jS, Y H:i', strtotime($fetch_sam['ad_chq_issue_date']));}?>" /></td></tr>

<tr id="cheq_dd_no"><td><strong>Cheque or DD No.</strong></td><td><input type="text" name="cq_dd" size="20" value="<? if(!empty($_POST['cq_dd'])){echo $_POST['cq_dd'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_dd_no'];}?>"/></td></tr>

<tr id="acc_holdr_name"><td><strong>Account Holder Name</strong></td><td><input type="text" name="cq_holder" size="20" value="<? if(!empty($_POST['cq_holder'])){echo $_POST['cq_holder'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_acc_holder'];}?>"/></td></tr>

<tr><td colspan="2" align="center"><hr /></td></tr>

<tr><td><strong>Attach Deposit Slip</strong> (if applicable)</td><td><input type="file" name="attach" />
<input name="attach_hid" type="hidden" value="<? if(isset($_POST['attach'])){echo $_POST['attach'];}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_attach_slip'];} ?>">
<div><? if(!empty($_POST['attach_hid'])){echo basename($_POST['attach_hid']);}elseif(!empty($_GET['id'])){echo $fetch_sam['ad_attach_slip'];} ?></div></td></tr>

<tr><td colspan="2" align="center"><input name="submit" type="submit" class="sbmt_btn" value="Submit" onclick="return validate();" /></td></tr>

</table>
</td>
</tr>

</table>
</div>
<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>
</form>

</div>
<div class="clear"></div>
<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>
</div>

<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$fetch_sam['cnt_content'];?></div>	
</div>

<!--expandable meuu scripts-->
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>
<link rel="stylesheet" href="css/anytime.5.0.5.css">
<script language="javascript" src="js/anytime.5.0.5.js"></script>
<script>
$(document).ready(function() {
  var oneDay = 24*60*60*1000;
  var rangeFormat = "%M %D, %Y %H:%i";
  var rangeConv = new AnyTime.Converter({format:rangeFormat});
  $(".tabOverClear").click( function(e) { $("#datepicker1").val("").change(); } );
  $("#tabOverInput").AnyTime_picker({format:rangeFormat});
});
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
var chk_phone=/^\d{10}$/;
function validate()
{ 	
	var d = document.deposit; var deposit_type = getRadioVal(document.getElementById('deposit'), 'source');
	if(d.source[0].checked==false && d.source[1].checked==false && d.source[2].checked==false){
		alert('please select deposit type'); d.source[0].focus(); return false; }
	//if(d.agent.value==""){ alert("Please Select Agent"); d.agent.focus(); return false; }
	if(d.amount.value==""){ alert("Please Enter Amount"); d.amount.focus(); return false; }
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid Mobile Number");d.mobile.focus(); return false; }
	if(d.transaction.value==""){ alert("Please Enter Transaction ID"); d.transaction.focus(); return false; }
	if(d.bank.value==""){ alert("Please Select Bank"); d.bank.focus(); return false; } 
	if(deposit_type == 2){
		if(d.cq_drawn.value==""){ alert("Please Enter Cheque Drawn on Bank"); d.cq_drawn.focus(); return false; }
		if(d.cq_datepicker.value==""){ alert("Please Enter Issue Date"); d.cq_datepicker.focus(); return false; }	
		if(d.cq_dd.value==""){ alert("Please Enter Cheque or DD No."); d.cq_dd.focus(); return false; }
	}
	if(deposit_type == 2 || deposit_type == 3){
		if(d.cq_holder.value==""){ alert("Please Enter Account Holder's Name"); d.cq_holder.focus(); return false;}
	}
	if(d.attach.value=="" && d.attach_hid.value==""){ alert("Please Upload File"); d.attach.focus(); return false; }
}
</script>