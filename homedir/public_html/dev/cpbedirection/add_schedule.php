<?php
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['schedule_add']) && $_SESSION['schedule_add']=='yes' ) ) ){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{
$schedule = str_replace("'","&#39;",$_POST['txt_schedule']);
$txt_sch_halt = str_replace("'","&#39;",$_POST['txt_sch_halt']);

	if(!empty($_GET['sch_id']))
	{
		query("update svr_tour_schedule set tloc_id_fk='".$_POST['txt_location']."',sch_day_number='".$_POST['txt_day_no']."',sch_time='".$_POST['txt_sch_time']."',sch_schedule='".$schedule."',sch_halt='".$txt_sch_halt."' where sch_id='".$_GET['sch_id']."'");
		header("location:manage_schedule.php");
	}
	else
	{
		query("insert into svr_tour_schedule(tloc_id_fk,sch_day_number,sch_time,sch_schedule,sch_halt,sch_status,sch_dateadded) values('".$_POST['txt_location']."','".$_POST['txt_day_no']."','".$_POST['txt_sch_time']."','".$schedule."','".$txt_sch_halt."',1,'".$now_time."')");
		header("location:manage_schedule.php");
		
	}
}
$edit = "Add";
if(!empty($_GET['sch_id']))
{
 $row = query("select * from svr_tour_schedule where sch_id='".$_GET['sch_id']."'");
	$schedule = fetch_array($row);
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Schedule </strong></td>

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
<form action="" method="post" name="form1" id="form1" onsubmit="return validate()" enctype="multipart/form-data">
			    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
				    <td align="right"><a href="manage_schedule.php"><strong>Manage Schedule</strong></a></td>
				  </tr> 
				  <tr>
					<td>&nbsp;</td>
				  </tr>
                  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="7" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="23%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
                            <tr>
                              <td width="25%" align="left" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                              <td align="left"><select name="txt_location" id="txt_location">
                                <option value="">--Select Location--</option>
								<?php
								  	$svr_query = query("select * from svr_to_locations where tloc_status=1  order by tloc_id desc");
									while($loc=fetch_array($svr_query))
									{
								  ?>
								   <option value="<?=$loc['tloc_id'];?>" <? if(!empty($_GET['sch_id'])){ if($loc['tloc_id']==$schedule['tloc_id_fk']){ echo "selected";} }?> ><?=$loc['tloc_name'];?></option>
								   <? }?>
                                </select>                              </td>
                            </tr>
                            
                            <tr >
                              <td width="25%"><strong> Day Number <span class="red">*</span></strong></td>
                              <td ><input name="txt_day_no" type="text" class="input" id="txt_day_no" size="30" value="<? if(!empty($_GET['sch_id'])){ echo $schedule['sch_day_number']; } ?>" /></td>
                            </tr>
                            <tr >
                              <td width="25%"><strong> Schedule Time <span class="red">*</span></strong></td>
                              <td ><input name="txt_sch_time" type="text"  class="input" id="txt_sch_time" size="30" value="<? if(!empty($_GET['sch_id'])){ echo $schedule['sch_time']; } ?>"/></td>
                            </tr>
                            <tr >
                              <td width="25%"><strong>Schedule <span class="red">*</span></strong></td>
                              <td ><textarea name="txt_schedule"  cols="50" rows="5" id="txt_schedule"><? if(!empty($_GET['sch_id'])){ echo $schedule['sch_schedule']; }?></textarea></td>
                            </tr>
                            <tr >
                              <td width="25%"><strong>Night Halt <span class="red">*</span></strong></td>
                              <td ><input name="txt_sch_halt" type="text" class="input" id="txt_sch_halt" size="30" value="<? if(!empty($_GET['sch_id'])){ echo $schedule['sch_halt']; }?>"  /></td>
                            </tr>
                            <tr align="center">
                              <td align="center">&nbsp;</td>
                              <td align="left">
							  <input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" /></td>
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
function validate()
	{
		var d = document.form1;
		if(d.txt_location.value==""){ alert("Please Select your Location"); d.txt_location.focus(); return false; }
		if(d.txt_day_no.value==""){ alert("Please Enter your Day Number"); d.txt_day_no.focus(); return false;} 	
		if(isNaN(d.txt_day_no.value)){alert("Please EnterDay Number"); d.txt_day_no.value="";  d.txt_day_no.focus(); return false;}
		if(d.txt_sch_time.value==""){ alert("Please Enter your Schedule Time"); d.txt_sch_time.focus(); return false; }
		if(d.txt_schedule.value==""){ alert("Please Enter your Schedule"); d.txt_schedule.focus(); return false; }
		if(d.txt_sch_halt.value==""){ alert("Please Enter your Night Halt"); d.txt_sch_halt.focus(); return false; }
	}
</script>