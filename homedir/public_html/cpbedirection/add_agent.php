<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('agents',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$max='svr-'.getdata("tm_emp","max(emp_id)+1","1");

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$title=$_POST['title'];
	$first_name =str_replace("'","&#39;",$_POST['fname']);
	$last_name =str_replace("'","&#39;",$_POST['lname']);
	$display_name =str_replace("'","&#39;",$_POST['txt_displayname']);
	$user_name =str_replace("'","&#39;",$_POST['uname']);
	$password =str_replace("'","&#39;",$_POST['password']);
	
	$q = query("select ag_id from svr_agents where ag_email = '".$email."'");
	$count = num_rows($q);
	
	$unique = (!empty($_GET['e_id'])) ? 'SAG'.rand(10000,99999) : '';
	$path = "../uploads/agents/".$unique."/";
	
	//var_dump($_FILES);exit;
	if($_FILES['image']["size"] > 0)
	{
		  $imgExtension = array('jpg','jpe','jpeg','gif');
		  $image_name = pathinfo($_FILES['image']['name']);
		  $extension = strtolower($image_name['extension']);
		  
		  if(in_array($extension,$imgExtension))
		  {
			  if($_FILES['image']["size"] > 1)
			  {
				  $b_image=substr($_FILES['image']['name'],0,strpos($_FILES['image']['name'],'.'));
				  $b_image.=time();
				  $b_image.=strstr($_FILES['image']['name'],'.');
				  //echo $path.$b_image;exit;
		  		  if(!file_exists($path.$b_image))	@mkdir($path, 0777, true);
				  
				  if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { $b_image=""; } else { 
				  	  resize_image($path.$b_image, 75); //width: 148; height: 159
					  if(!empty($_POST['old_img'])) @unlink($path.$_POST['old_img']);
				  }
				  $imagepath=$b_image;
			  }
		  }else{		
			  $img_err_msg = "You have to upload 'jpg , jpe , jpeg , gif' images only";
		  }
	}elseif(!empty($_POST['old_img']))
	{
	  $b_image=$_POST['old_img'];
	}
	
	if(!empty($_GET['e_id']))
	{
		query("update svr_agents set ag_title='".$title."', ag_unique_id='".$unique."', ag_fname='".$first_name."',ag_lname='".$last_name."',ag_gender='".$_POST['gender']."',ag_email='".$_POST['email']."',ag_mobile='".$_POST['mobile']."',ag_landline='".$_POST['landline']."',ag_uname='".$user_name."',ag_address='".$_POST['address']."',ag_city='".$_POST['city']."',ag_state='".$_POST['state']."',ag_country='".$_POST['country']."',ag_pincode='".$_POST['pincode']."',ag_authority='".$_POST['authority']."',ag_pancard='".$_POST['pancard']."',ag_logo='".$b_image."' where ag_id='".$_GET['e_id']."'");
		header("location:manage_agents.php");
		
	} else {
	
		$qry = query("select ag_uname,ag_email from svr_agents where ag_uname='".$user_name."' and ag_email='".$_POST['email']."'");
		$user_cnt=num_rows($qry);	
			
		if($user_cnt==0)
		{
			query("insert into svr_agents(ag_id, ag_title, ag_unique_id, ag_fname, ag_lname, ag_gender, ag_uname, ag_password, ag_address, ag_city, ag_state, ag_country, ag_pincode, ag_mobile, ag_landline, ag_email, ag_authority, ag_pancard, ag_logo, ag_status, ag_added_date) values('','".$title."','".$unique."','".$first_name."','".$last_name."','".$_POST['gender']."','".$user_name."','".md5($password)."','".$_POST['address']."','".$_POST['city']."','".$_POST['state']."','".$_POST['country']."','".$_POST['pincode']."','".$_POST['mobile']."','".$_POST['landline']."','".$_POST['email']."','".$_POST['authority']."','".$_POST['pancard']."','".$b_image."',1,'".$now."')");
			
			$iid = insert_id();
			
			header("location:manage_agents.php");
			
		} else{
		
			$err_msg='<font color=red>Already Exists, Please try with new one.</font>';
		}
	}
}
$edit = "Add";
if(!empty($_GET['e_id'])){
	$result = query("select * from svr_agents where ag_id='".$_GET['e_id']."'");
	$fetch = fetch_array($result);
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
			<form method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
			    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
				    <td align="right"><a href="manage_agents.php"><strong>Manage Agents</strong></a></td>
				  </tr>
				  <tr>
				    <td><? if(!empty($err_msg)) { echo $err_msg; } ?></td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="20" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="53%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Title <span class="red">*</span></strong></td>
                              <td align="left"><select name="title" id="title" <?=$title_disabled?>>
								<? foreach($titles as $key => $value){?>
									<option value="<?=$key?>" <? if(!empty($_GET['e_id']) && $fetch['ag_title'] == $key) echo 'selected';?>><?=$value?></option>
								<? }?>
								</select></td>
                            </tr>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> First Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="fname" type="text" id="fname" value="<? if(!empty($_POST['fname'])){ echo $_POST['fname'];}  if(!empty($_GET['e_id'])){ echo $fetch['ag_fname'];}?>" /></td>
                            </tr>
							
                            <tr>
                              <td align="left" class="sub_heading_black"><strong> Last Name <span class="red">*</span></strong></td>
                              <td align="left"><input name="lname" type="text" id="lname" value="<? if(!empty($_POST['lname'])){ echo $_POST['lname'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_lname'];}?>"/></td>
                            </tr>
							
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Gender <span class="red">*</span></strong></td>
                              <td align="left"><input name="gender" type="radio" id="gender" value="1"
							  <? 
								  if(!empty($_POST['gender']) && $_POST['gender']=='1'){ echo "checked";}
								  if(!empty($_GET['e_id'])){ if($fetch['ag_gender']=='1'){ echo "checked";}}?>/>Male
								  <input name="gender" type="radio" id="gender" value="2"
							  <? 
								  if(!empty($_POST['gender']) && $_POST['gender']=='2'){ echo "checked";}
								  if(!empty($_GET['e_id'])){ if($fetch['ag_gender']=='2'){ echo "checked";}}?> />Female</td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Username <span class="red">*</span></strong></td>
                              <td align="left"><input name="uname" type="text" id="uname" value="<? if(!empty($_POST['uname'])){ echo $_POST['uname'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_uname'];}?>"/></td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Email <span class="red">*</span></strong></td>
                              <td align="left"><input name="email" type="text" id="email" value="<? if(!empty($_POST['email'])){ echo $_POST['email'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_email'];}?>"/></td>
                            </tr>
							<? if(empty($_GET['e_id'])){?>
							<tr>
                              <td align="left" class="sub_heading_black"><strong> Password <span class="red">*</span></strong></td>
                              <td align="left"><input name="password" type="password" id="password" value="<? if(!empty($_POST['password'])){ echo $_POST['password'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_password'];}?>"/></td>
                            </tr>
							<? }?>
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Mobile Number <span class="red">*</span></strong></td>
                              <td align="left"><input name="mobile" type="text" id="mobile" onKeyPress="return NumbersOnly(this, event)" value="<? if(!empty($_POST['mobile'])){ echo $_POST['mobile'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_mobile'];}?>" maxlength="15" /></td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong>Landline Number <span class="red">*</span></strong></td>
                              <td align="left"><input name="landline" type="text" id="landline" onKeyPress="return NumbersOnly(this, event)" value="<? if(!empty($_POST['landline'])){ echo $_POST['landline'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_landline'];}?>" maxlength="15" /></td>
                            </tr>
							
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Authority Level <span class="red">*</span></strong></td>
                              <td align="left"><input name="authority" type="text" id="authority" value="<? if(!empty($_POST['authority'])){ echo $_POST['authority'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_authority'];}?>"/></td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong>Pan Card <span class="red">*</span></strong></td>
                              <td align="left"><input name="pancard" type="text" id="pancard" value="<? if(!empty($_POST['pancard'])){ echo $_POST['pancard'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_pancard'];}?>"/></td>
                            </tr>
							
							<!--<tr>
							    <td align="left" class="sub_heading_black"><strong>Deposit <span class="red">*</span></strong></td>
							    <td align="left"><input name="deposit" type="text" id="pancard" value="<? if(!empty($_POST['deposit'])){ echo $_POST['deposit'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_deposit'];}?>"/></td>
					    	</tr>-->

                            <tr>
                              <td colspan="2" align="left" class="sub_heading_black"><hr class="style1" /></td>
                            </tr>
							
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>Address <span class="red">*</span></strong></td>
                              <td align="left"><textarea name="address" type="text" id="address"><? if(!empty($_POST['address'])){ echo $_POST['address'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_address'];}?></textarea></td>
                            </tr>
							
                            <tr>
                              <td align="left" class="sub_heading_black"><strong>City<span class="red">*</span></strong></td>
                              <td align="left"><input name="city" type="text" id="city" value="<? if(!empty($_POST['city'])){ echo $_POST['city'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_city'];}?>" /></td>
                            </tr>
                           <tr>
                              <td align="left" class="sub_heading_black"><strong>State <span class="red">*</span></strong></td>
                              <td align="left">
							  	<select name="state" id="state">
								<? foreach($states as $key => $value){
									$selected_state=($fetch['ag_state']==$key )? 'selected': '';?>
										<option value="<?=$key?>"<?=$selected_state?>><?=$value?></option><? }?>
								</select>												
							  </td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong>Country <span class="red">*</span></strong></td>
                              <td align="left"><input name="country" type="text" id="country" value="<? if(!empty($_POST['country'])){ echo $_POST['country'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_country'];}?>" maxlength="15" /></td>
                            </tr>
							
							  <tr>
                              <td align="left" class="sub_heading_black"><strong>Pincode <span class="red">*</span></strong></td>
                              <td align="left"><input name="pincode" type="text" id="pincode" value="<? if(!empty($_POST['pincode'])){ echo $_POST['pincode'];} if(!empty($_GET['e_id'])){ echo $fetch['ag_pincode'];}?>"/></td>
                            </tr>
							
							<tr>
                              <td align="left" class="sub_heading_black"><strong>Image<span class="red">*</span></strong></td>
                              <td align="left"><input type="file" name="image" id="image" multiple="multiple">
							  <? if(!empty($_GET['e_id'])) { $path = 'agents/'.$fetch['ag_unique_id'].'/'; ?>
							  <input type="hidden" name="old_img" id="old_img" value="<?=$fetch['ag_logo'];?>" />
							  <? //if(getimagesize($path.$fetch['ag_logo']) > 0){ ?>
							  <a href="javascript:;" onclick="window.open('view_agent_thumb.php?vid=<?=$fetch['ag_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=400')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
							  <?  }//}?></td>
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
	if(d.title.value==""){ alert("Please Enter Title"); d.title.focus(); return false; }
	if(d.fname.value==""){ alert("Please Enter First Name"); d.fname.focus(); return false; }
	if(d.lname.value==""){ alert("Please Enter Last Name"); d.lname.focus(); return false;} 	
	if(d.gender[0].checked==false && d.gender[1].checked==false){alert('please select your gender'); d.gender[0].focus(); return false; }
	if(d.uname.value==""){ alert("Please Enter Username"); d.uname.focus(); return false;} 
	if(!chk_email.test(d.email.value)){alert("Please Enter Valid Email Address");d.email.focus();return false;}
	//if(d.email.value==""){ alert("Please Enter Email"); d.email.focus(); return false;} 
	if(d.password.value==""){ alert("Please Enter Password"); d.password.focus(); return false;} 
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid mobile number");d.mobile.focus(); return false;}
	//if(d.landline.value.length < 10){ alert("Please enter correct phone number."); d.landline.focus(); return false;}
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