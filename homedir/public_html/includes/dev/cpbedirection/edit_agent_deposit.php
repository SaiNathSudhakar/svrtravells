<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['agent_add']) && $_SESSION['agent_add']=='yes' ) ) ){}else{header("location:welcome.php");}
$max='svr-'.getdata("tm_emp","max(emp_id)+1","1");

if($_SERVER['REQUEST_METHOD']=="POST"){

$file_upload="../uploads/deposits/".$_FILES["attach"]["name"];
	move_uploaded_file($_FILES["attach"]["tmp_name"],$file_upload);
	if(!empty($_GET['e_id'])){
	
		mysql_query("update svr_agent_deposits set ad_ag_id='".$_POST['agent']."',ad_amount='".$_POST['amount']."',ad_transaction='".$_POST['trans']."',ad_bank='".$_POST['bank']."',ad_mobile='".$_POST['mobile']."',ad_drawn='".$_POST['drawn']."',ad_acc_holder='".$_POST['acc']."',ad_attach_slip='".basename($file_upload)."' where ad_id='".$_GET['e_id']."'");
		header("location:manage_agent_deposits.php");
	}
		header("location:manage_agent_deposits.php");
		}
	//}
$edit = "Add";
if(!empty($_GET['e_id'])){
	$result = mysql_query("select * from svr_agent_deposits where ad_id='".$_GET['e_id']."'");
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
<script language="javascript" src="../includes/script_valid.js"></script>
<style type="text/css">
.style1 {font-weight: bold}
</style>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?>  Agent</strong></td>
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
<form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
			    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
				    <td align="right"><a href="manage_agent_deposits.php"><strong>Manage Agent Deposits</strong></a></td>
				  </tr>
				  <tr>
				    <td>
					<? if(!empty($err_msg)){echo $err_msg;}?>
					&nbsp;</td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
						  <td width="2%" rowspan="19" align="left" class="sub_heading_black">&nbsp;</td>
						  <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
						  <td width="53%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                     </tr>
						
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Agent Name <span class="red">*</span></strong></td>
                              <td align="left">
							  <!--<input name="aname" type="text" id="aname" value="<? //if(!empty($_POST['aname'])){ echo $_POST['aname'];}  if(!empty($_GET['e_id'])){ echo $fetch['ag_fname'];}?>" />-->
							  <select name="agent" id="agent">
							  <option value="">--Select Agent--</option>
                                <?php
								  	$svr_query = mysql_query("select ag_id, ag_fname from svr_agents where ag_status=1");
									while($loc=mysql_fetch_array($svr_query)){ ?>
                               <option value="<?=$loc['ag_id'];?>"<? if($fetch['ad_ag_id'] == $loc['ag_id']){?>selected<? }?> >
                                  <?=$loc['ag_fname'];?></option>
                                <? }?>
                              </select>
							  </td>
                            </tr>
						 <tr>
						  <td align="left" class="sub_heading_black"><strong> Mobile Number <span class="red">*</span></strong></td>
						  <td align="left"><input name="mobile" type="text" id="mobile" onKeyPress="return NumbersOnly(this, event)" value="<? if(!empty($_POST['mobile'])){ echo $_POST['mobile'];} if(!empty($_GET['e_id'])){ echo $fetch['ad_mobile'];}?>" maxlength="15" /></td>
                         </tr>
						 
                        <tr>
						  <td align="left" class="sub_heading_black"><strong> Amount <span class="red">*</span></strong></td>
						  <td align="left"><input name="amount" type="text" id="amount" value="<? if(!empty($_POST['amount'])){ echo $_POST['amount'];} if(!empty($_GET['e_id'])){ echo $fetch['ad_amount'];}?>"/></td>
                        </tr>
						
                      <tr>
						  <td align="left" class="sub_heading_black"><strong> Bank <span class="red">*</span></strong></td>
						  <td align="left"><select name="bank" id="bank">
						 <? foreach($bank as $key => $value){?>
						<option value="<?=$key?>" <? if(!empty($_GET['e_id']) && $fetch['ad_bank'] == $key) echo 'selected';?>><?=$value?></option><? }?></select></td>
                    </tr>	
							
					  <tr>
					  <td align="left" class="sub_heading_black"><strong> Transaction ID <span class="red">*</span></strong></td>
                              <td align="left"><input name="trans" type="text" id="trans" value="<? if(!empty($_POST['trans'])){ echo $_POST['trans'];} if(!empty($_GET['e_id'])){ echo $fetch['ad_transaction'];}?>"/></td>
                       </tr>
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Cheque Drawn on Bank <span class="red">*</span></strong></td>
                              <td align="left"><input name="drawn" type="text" id="drawn" value="<? if(!empty($_POST['drawn'])){ echo $_POST['drawn'];} if(!empty($_GET['e_id'])){ echo $fetch['ad_drawn'];}?>"/></td>
                            </tr>	
								<? if(empty($_GET['e_id'])){?>
							 <tr>
                              <td align="left" class="sub_heading_black"><strong> Account Holder Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="acc" type="password" id="acc" value="<? if(!empty($_POST['acc'])){ echo $_POST['acc'];} if(!empty($_GET['e_id'])){ echo $fetch['ad_acc_holder'];}?>"/></td>
                            </tr>
							<? }?>	
									
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Cheque Issue Date <span class="red">*</span></strong></td>
                              <td align="left"><?=$fetch['ad_chq_issue_date'];?></td>
                            </tr>
							  <tr>
                              <td align="left" class="sub_heading_black"><strong> Cheque or DD No. <span class="red">*</span></strong></td>
                              <td align="left"><?=$fetch['ad_dd_no'];?></td>
                            </tr>
							 <tr>
                              <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                            </tr>
                          
						    <tr>
                              <td align="left" class="sub_heading_black"><strong> Attached Deposit Slip <span class="red">*</span></strong></td>
                              <td align="left"><input name="attach" type="file" id="attach" value="<? if(isset($_POST['attach'])) echo $_POST['attach']; else if(!empty($_GET['e_id']))echo $fetch['ad_attach_slip'];?>" size="25" onfocusout="return alt_title();" onmouseout="alt_title()"/>  
						<input type="hidden" name="hiddenimage" id="hiddenimage" value="<? if(!empty($_GET['e_id'])){echo $fetch['ad_attach_slip'];} ?>" />
						<? if(!empty($_GET['e_id'])){?><a href="<?=$site_url."uploads/deposits/".$fetch['ad_attach_slip']?>" target="_blank"><?=basename($fetch['ad_attach_slip']);?></a><? }?></td>
                            </tr>
							 <tr>
                              <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value="<?=$edit;?>" class="btn_input" onclick="return validate();" /></td>
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
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
var chk_phone=/^\d{10}$/;
function validate()
{
	var d = document.form1;
	if(d.fname.value==""){ alert("Please Enter First Name"); d.fname.focus(); return false; }
	if(d.lname.value==""){ alert("Please Enter Last Name"); d.lname.focus(); return false;} 	
	if(d.gender[0].checked==false && d.gender[1].checked==false){alert('please select your gender'); d.gender[0].focus(); return false; }
	if(d.uname.value==""){ alert("Please Enter Username"); d.uname.focus(); return false;} 
	if(!chk_email.test(d.email.value)){alert("Please Enter Valid Email Address");d.email.focus();return false;}
	//if(d.email.value==""){ alert("Please Enter Email"); d.email.focus(); return false;} 
	if(d.password.value==""){ alert("Please Enter Password"); d.password.focus(); return false;} 
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid mobile number");d.mobile.focus(); return false;}
	if(d.landline.value.length < 10){ alert("Please enter correct phone number."); d.landline.focus(); return false;}
	if(d.authority.value==""){ alert("Please Enter Authority Level"); d.authority.focus(); return false; }
	if(d.pancard.value==""){ alert("Please Enter Pan Card No."); d.pancard.focus(); return false;} 
	if(d.address.value==""){ alert("Please Enter Address"); d.address.focus(); return false;}
	if(d.city.value==""){ alert("Please Enter City Name"); d.city.focus(); return false;}
	if(d.state.value==""){ alert("Please Enter State Name"); d.state.focus(); return false;}
	if(d.country.value==""){ alert("Please Enter Country Name"); d.country.focus(); return false;}	
	if(d.pincode.value==""){ alert("Please Enter Pincode"); d.pincode.focus(); return false; }
}
function NumbersOnly(MyField, e, dec)
{
var key;
var keychar;
if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
if ((key==null) || (key==0) || (key==8) ||
    (key==9) || (key==13) || (key==27) )
   return true;
else if ((("0123456789()+-").indexOf(keychar) > -1))
   return true;
else if (dec && (keychar == "."))
   {
   MyField.form.elements[dec].focus();
   return false;
   }
else
   return false;
}
</script>