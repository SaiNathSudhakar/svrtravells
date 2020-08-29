<?
ob_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['agent_add']) && $_SESSION['agent_add']=='yes' ) ) ){}else{header("location:welcome.php");}
$max='svr-'.getdata("tm_emp","max(emp_id)+1","1");

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$issue_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['issue_date'])));
	
	$unqiue = getdata("svr_agents", "ag_unique_id", "ag_id=".$_POST['agent']);  //echo $unqiue; exit;
	$action = ''; $path = "../uploads/agents/".$unqiue."/";
	
	if($_POST['source'] == 1){ $drawn = ''; $issue_date = '0000-00-00 00:00:00'; $dd_no = ''; $acc = ''; }
	else if($_POST['source'] == 2){ 
		$drawn = (!empty($_POST['drawn'])) ? $_POST['drawn'] : ''; 
		$issue_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['issue_date']))); 
		$dd_no = (!empty($_POST['dd_no'])) ? $_POST['dd_no'] : ''; 
		$acc = (!empty($_POST['acc'])) ? $_POST['acc'] : ''; 
	}
	else if($_POST['source'] == 3){ 
		$drawn = ''; $issue_date = '0000-00-00 00:00:00'; $dd_no = ''; 
		$acc = (!empty($_POST['acc'])) ? $_POST['acc'] : ''; 
	}
	$tans_cond = (!empty($_GET['id'])) ? " and ad_id <> '".$_GET['id']."'" : "";
	$transc_id = getdata("svr_agent_deposits", "count(ad_id)", "ad_transaction='".$_POST['transaction']."' $tans_cond");
	
	if($transc_id == 0)
	{
	  if($_FILES['attach']['size'] >= 1){	
			$file_upload = $path.make_filename(basename($_FILES["attach"]['name'])); //echo $file_upload; exit;
			if(!file_exists($file_upload))	@mkdir($path, 0777, true);
			move_uploaded_file($_FILES['attach']['tmp_name'], $file_upload);
			$file_upload = basename($file_upload);
	  }
		
	  if(!empty($_GET['id'])){
			if($_FILES['attach']['size']==0){ 
				$file_upload = $_POST['attach_hid'];
			} else if($_FILES['attach']['size']>=1) {
				if(basename($_FILES['attach']['name'])<>$_POST['attach_hid']) {
					@unlink($path.$_POST['attach_hid']); 
				}
			}
	  } 
	  if(!empty($file_upload))
	  {
		if(!empty($_GET['id']))
		{	
			$row = getdata("svr_agent_deposits", "ad_req_status, ad_amount", "ad_id='".$_GET['id']."'", "1");
			
			mysql_query("update svr_agent_deposits set ad_ag_id='".$_POST['agent']."', ad_amount='".number_format($_POST['amount'], 2, '.', '')."', ad_transaction='".$_POST['transaction']."', ad_bank='".$_POST['bank']."', ad_drawn='".$drawn."',ad_chq_issue_date='".$issue_date."', ad_acc_holder='".$acc."', ad_attach_slip='".$file_upload."', ad_req_status='".$_POST['status']."', ad_dd_no='".$dd_no."' where ad_id='".$_GET['id']."'");
			
			if($row['ad_req_status'] == 0){
				if(($_POST['status'] == 1)){
					$action = " + ".$_POST['amount'];
				} else if(($_POST['status'] == 2)){
					$action = "";
				}
			} else if($row['ad_req_status'] == 1){
				if(($_POST['status'] == 0)){
					$action = " - ".$_POST['amount'];
				} else if(($_POST['status'] == 2)){
					$action = " - ".$_POST['amount'];
				}
			} else if($row['ad_req_status'] == 2){
				if(($_POST['status'] == 0)){
					$action = "";
				} else if(($_POST['status'] == 1)){
					$action = " + ".$_POST['amount'];
				}
			}
			$fkid = $_GET['id'];
		} else {
			
			mysql_query("insert into svr_agent_deposits (ad_id, ad_ag_id, ad_type, ad_amount, ad_transaction, ad_bank, ad_drawn, ad_chq_issue_date, ad_acc_holder, ad_attach_slip, ad_status, ad_addeddate, ad_req_status, ad_dd_no) values ('', '".$_POST['agent']."', '".$_POST['source']."', '".number_format($_POST['amount'], 2, '.', '')."', '".$_POST['transaction']."', '".$_POST['bank']."', '".$drawn."', '".$issue_date."', '".$acc."', '".$file_upload."', 1, '".$now_time."', '".$_POST['status']."', '".$dd_no."')");
			$action = ($_POST['status'] == 1) ? " + ".$_POST['amount'] : "";
			$fkid = mysql_insert_id();
		}
		
		$exists = ($_POST['status'] == 1) ? getdata("svr_agent_reports", "ar_ord_id", "ar_ag_id='".$_POST['agent']."' and ar_ord_id='".$_POST['transaction']."'") : '0';
		
		if(empty($exists) && $_POST['status'] == 1)
		{	
			$transc = 'Deposit';	
			$op_bal = getdata("svr_agent_reports", "ar_closing_bal", "ar_ag_id='".$_POST['agent']."' order by ar_id desc");
			$op_bal = number_format($op_bal, 2, '.', '');
			$cl_bal = number_format($op_bal + $_POST['amount'], 2, '.', '');
			$net = number_format($_POST['amount'], 2, '.', '');
			
			$ref_id = rand(1000000, 9999999);
			mysql_query("insert into svr_agent_reports (ar_id, ar_ag_id, ar_ref_id, ar_ord_id, ar_ad_id, ar_transaction_type, ar_opening_bal, ar_amount, ar_commission, ar_net_amount, ar_closing_bal, ar_cre_deb, ar_fk_id, ar_date_time) values( '', '".$_POST['agent']."', '".$ref_id."', '".$_POST['transaction']."', '', '".$transc."', '".$op_bal."', '".$_POST['amount']."', '', '".$net."', '".$cl_bal."', '1', '".$fkid."', '".$now_time."')");
		}
		
		mysql_query("update svr_agents set ag_deposit = (ag_deposit ".$action.") where ag_id = '".$_POST['agent']."'");
		$agent = getdata("svr_agents", "ag_fname, ag_email", "ag_id='".$_POST['agent']."'", "1");
		
		if($_POST['status'] != 0){
			$data['subject'] = 'Deposit Response from SVR'; //echo $data['subject']; exit;
			$data['content'] = "<table align='left'><tr><td>Dear ".$agent['ag_fname'].",</td></tr><tr><td>&nbsp;</td></tr>
			<tr><td>Your desposit request with Transactin ID ".$_POST['transaction']." has been ".$ag_dep_req_status[$_POST['status']].".</td></tr>
			<tr><td>&nbsp;</td></tr><tr><td>Thanks & Regards, <br>SVR Tours and Travels</td></tr></table>";
			$data['to_email'] = $agent['ag_email'];
			send_email($data);
		}
		header("location:manage_agent_deposits.php");
	  } else {
			$err = "Please upload deposit slip.";
	  }
	} else {
		$msg = "Transaction ID already exists";
	}
}
$edit = "Add";
if(!empty($_GET['id']))
{	
	//$result = mysql_query("select * from svr_agent_deposits where ad_id='".$_GET['id']."'");
	$result = mysql_query("select ad.*, ag.ag_mobile, ag.ag_unique_id from svr_agent_deposits as ad
	left join svr_agents as ag on ag.ag_id = ad.ad_ag_id
		where ad_id='".$_GET['id']."'");
	$fetch = mysql_fetch_array($result);
	$edit = "Update";	
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
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script language="javascript" src="../js/script.js"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<style type="text/css">.style1{font-weight: bold}</style>
<?
if(!empty($_POST['source'])) $id = $_POST['source']; else if(!empty($_GET['id'])) $id = $fetch['ad_type']; else $id = 2;
echo "<script type='text/javascript'>window.onload = function(){show_deposit_type(".$id.");}</script>";
?>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" width="11" height="13" /><strong style="font-size:12px"><a href="welcome.php"> Home </a> &raquo; <?=$edit;?> Agent </strong></td>
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
		  <td>
			<form method="post" name="form1" id="form1" enctype="multipart/form-data">
			    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
				    <td align="right"><a href="manage_agent_deposits.php"><strong>Manage Agent Deposits</strong></a></td>
				  </tr>
				  <tr>
				    <td><? if(!empty($msg)){ echo '<h3 align="center" class="msg error">'.$msg.'</h3>'; }?>
					<? if(!empty($err)){ echo '<h3 align="center" class="msg error">'.$err.'</h3>'; }?></td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
							  <td width="2%" rowspan="21" align="left" class="sub_heading_black">&nbsp;</td>
							  <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
							  <td width="53%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Deposit Type <span class="red">*</span></strong></td>
                              <td align="left">
							  	<input type="radio" name="source" value="1" id="cash" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '1'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch['ad_type'] == 1){ echo 'checked'; }?> /> Cash
								<input type="radio" name="source" value="2" id="cheque" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '2'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch['ad_type'] == 2){ echo 'checked'; } elseif(empty($_GET['id']) && $_POST['source'] != '1' && $_POST['source'] != '3') echo 'checked'; ?> /> Cheque
								<input type="radio" name="source" value="3" id="trans" onclick="return show_deposit_type(this.value)" <? if($_POST['source'] == '3'){ echo 'checked';} elseif(!empty($_GET['id']) && $fetch['ad_type'] == 3){ echo 'checked'; }?> /> Bank Transfer							  </td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Agent Name <span class="red">*</span></strong></td>
                              <td align="left">
							  <select name="agent" id="agent">
							  <? if(empty($_GET['id'])){?><option value="">--Select Agent--</option><? }?>
									<?php
								  	$svr_query = mysql_query("select ag_id, ag_fname from svr_agents where ag_status=1");
									while($row=mysql_fetch_array($svr_query)){ 
										if((!empty($_GET['id']) && $fetch['ad_ag_id'] == $row['ag_id']) || empty($_GET['id'])){?>
								   		<option value="<?=$row['ag_id'];?>"<? if(($fetch['ad_ag_id'] == $row['ag_id']) || $_POST['agent'] == $row['ag_id']){?>selected<? }?> >
									  	<?=$row['ag_fname'];?></option>
									<? }}?>
                              </select>							  
							  </td>
                            </tr>
						 <!--<tr>
						  <td align="left" class="sub_heading_black"><strong> Mobile Number <span class="red">*</span></strong></td>
						  <td align="left"><input name="mobile" type="text" id="mobile" onKeyPress="return NumbersOnly(this, event)" value="<? if(!empty($_POST['mobile'])){ echo $_POST['mobile'];} if(!empty($_GET['id'])){ echo $fetch['ag_mobile'];}?>" maxlength="15" /></td>
                         </tr>-->
						 
                        <tr>
						  <td align="left" class="sub_heading_black"><strong> Amount <span class="red">*</span></strong></td>
						  <td align="left"><input name="amount" type="text" id="amount" <? if(!empty($_GET['id']) && $fetch['ad_req_status'] == 1 || $fetch['ad_req_status'] == 2) echo "readonly";?> value="<? if(!empty($_POST['amount'])){ echo $_POST['amount'];} else if(!empty($_GET['id'])){ echo $fetch['ad_amount'];}?>"/></td>
                        </tr>
						
                    <tr>
						<td align="left" class="sub_heading_black"><strong> Deposited in Bank <span class="red">*</span></strong></td>
						<td align="left"><select name="bank" id="bank">
						<? foreach($bank as $key => $value){?>
						<option value="<?=$key?>" <? if((!empty($_GET['id']) && $fetch['ad_bank'] == $key) || $_POST['bank'] == $key) echo 'selected';?>><?=$value?></option><? }?></select></td>
                    </tr>	
							
					<tr>
					  <td align="left" class="sub_heading_black"><strong> Transaction ID <span class="red">*</span></strong></td>
                              <td align="left"><input name="transaction" <? if(!empty($_GET['id']) && $fetch['ad_req_status'] == 1 || $fetch['ad_req_status'] == 2) echo "readonly";?> type="text" id="transaction" value="<? if(!empty($_POST['transaction'])){ echo $_POST['transaction'];} elseif(!empty($_GET['id'])){ echo $fetch['ad_transaction'];}?>"/></td>
                    </tr>
                    <tr id="acc_holdr_name">
                      <td align="left" class="sub_heading_black"><strong> Account Holder Name <span class="red">*</span></strong></td>
                      <td align="left"><input name="acc" type="text" id="acc" value="<? if(!empty($_POST['acc'])){ echo $_POST['acc'];} elseif(!empty($_GET['id'])){ echo $fetch['ad_acc_holder'];}?>"/></td>
                    </tr>
					<tr id="cheq_draw_bank">
                      <td align="left" class="sub_heading_black"><strong> Cheque Drawn on Bank <span class="red">*</span></strong></td>
                      <td align="left"><input name="drawn" type="text" id="drawn" value="<? if(!empty($_POST['drawn'])){ echo $_POST['drawn'];} elseif(!empty($_GET['id'])){ echo $fetch['ad_drawn'];}?>"/></td>
                    </tr>			
                    <tr id="cheq_issu_date">
                      <td align="left" class="sub_heading_black"><strong> Cheque Issue Date <span class="red">*</span></strong></td>
                      <td align="left"><input name="issue_date" type="text" id="issue_date" value="<? if(!empty($_POST['issue_date'])){ echo $_POST['issue_date'];} elseif(!empty($_GET['id'])){ echo date('d/m/Y', strtotime($fetch['ad_chq_issue_date']));}?>"/></td>
                    </tr>
                    <tr id="cheq_dd_no">
                      <td align="left" class="sub_heading_black"><strong> Cheque or DD No. <span class="red">*</span></strong></td>
                      <td align="left"><input name="dd_no" type="text" id="dd_no" value="<? if(!empty($_POST['dd_no'])){ echo $_POST['dd_no'];} elseif(!empty($_GET['id'])){ echo $fetch['ad_dd_no'];;}?>"/></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                    </tr>
                    <tr>
                      <td align="left" class="sub_heading_black"><strong> Attached Deposit Slip <span class="red">*</span></strong></td>
                      <td align="left"><input name="attach" type="file" id="attach" />  
                        <input type="hidden" name="attach_hid" id="attach_hid" value="<? if(!empty($_GET['id'])){echo $fetch['ad_attach_slip'];} ?>" />
                        <? if(!empty($_GET['id'])){?><a href="<?=$site_url."uploads/agents/".$fetch['ag_unique_id']."/".$fetch['ad_attach_slip']?>" target="_blank"><?=basename($fetch['ad_attach_slip']);?></a><? }?></td>
                    </tr>
                    <tr>
                      <td align="left" class="sub_heading_black"><strong>Status</strong></td>
                      <td align="left"><? $check = ($fetch['ad_req_status'] == 1 || $fetch['ad_req_status'] == 2) ? '1' : '0'; ?>
                        <select name="status" id="status"style="width:140px;">
                            <? foreach($ag_dep_req_status as $key => $req){
                            if(($check == 1 && $key == $fetch['ad_req_status']) || $check == 0){
							$selected_status = ($fetch['ad_req_status'] == $key) ? 'selected' : ''; ?>
                            <option value="<?=$key?>" <?=$selected_status?>><?=$req?></option>
                            <? }}?>
                        </select>
                      </td>
                    </tr>
                     <tr>
                      <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                    </tr>
                    <tr align="center">
                      <td align="center">&nbsp;</td>
                      <td align="left"><input type="submit" name="Submit" id="Submit" value="<?=$edit;?>" class="btn_input" onclick="return validate();" /></td>
                    </tr>
                    </table>
					</td>
                  </tr>
              </table></form>
		  </td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
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
<script type="text/javascript">
$(document).ready(function() {
	$( "#issue_date" ).datepicker({
		showOn: "both",
		buttonImage: "images/calendar.png",
		dateFormat: "dd/mm/yy",
		buttonImageOnly: true,
		changeYear:true, 
		changeMonth:true, 
		showTime: true
	});
	setTimeout( "jQuery('.msg').fadeOut('slow');", 5000 );
});
	
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
var chk_phone=/^\d{10}$/;
function validate()
{ 	
	var d = document.form1; var numbers = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,4})?)$/;
	var deposit_type = getRadioVal(document.getElementById('form1'), 'source');
	if(d.source[0].checked==false && d.source[1].checked==false && d.source[2].checked==false){
		alert('please select deposit type'); d.source[0].focus(); return false; }
	if(d.agent.value==""){ alert("Please Select Agent"); d.agent.focus(); return false; }
	//if(!chk_phone.test(d.mobile.value)){alert("Enter Valid Mobile Number");d.mobile.focus(); return false; }
	if(d.amount.value==""){ alert("Please Enter Amount"); d.amount.focus(); return false; }
	if(!numbers.test(d.amount.value)){ alert("Please Enter Numeric Characters Only"); d.amount.focus(); return false; }
	if(d.bank.value==""){ alert("Please Select Bank"); d.bank.focus(); return false; } 
	if(d.transaction.value==""){ alert("Please Enter Transaction ID"); d.transaction.focus(); return false; }
	if(deposit_type == 2 || deposit_type == 3){
		if(d.acc.value==""){ alert("Please Enter Account Holder's Name"); d.acc.focus(); return false;}
	}if(deposit_type == 2){
		if(d.drawn.value==""){ alert("Please Enter Cheque Drawn on Bank"); d.drawn.focus(); return false; }
		if(d.issue_date.value==""){ alert("Please Enter Issue Date"); d.issue_date.focus(); return false; }	
		if(d.dd_no.value==""){ alert("Please Enter Cheque or DD No."); d.dd_no.focus(); return false; }
	}
	if(d.attach.value=="" && d.attach_hid.value==""){ alert("Please Upload File"); d.attach.focus(); return false; }
}
</script>