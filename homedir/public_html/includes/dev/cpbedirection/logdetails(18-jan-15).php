<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['logdetails_manage']) && $_SESSION['logdetails_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

$cond=""; $dw_cond=""; $emp=""; $emp_name=''; $emp_st=''; $reports_ft='';

if($_SERVER['REQUEST_METHOD']=="POST")
{
	

if(isset($_POST['md']) && $_POST['md']=='m'){

	$fdate=$_POST['my1']."-".$_POST['mm1']."-01";

	$tdate=$_POST['my1']."-".$_POST['mm1']."-31";

	$reports_ft="[ 01-".$_POST['mm1']."-".$_POST['my1']." - 31-".$_POST['mm1']."-".$_POST['my1']." ]";

} else {

	$fdate=$_POST['dy1']."-".$_POST['dm1']."-".$_POST['dd1'];

	$tdate=$_POST['dy2']."-".$_POST['dm2']."-".$_POST['dd2'];

	$reports_ft="[ ".$_POST['dd1']."-".$_POST['dm1']."-".$_POST['dy1']." - ".$_POST['dd2']."-".$_POST['dm2']."-".$_POST['dy2']." ]";

}

$emp=$_POST['emp']; $emp_name=getdata("tm_emp","emp_name","emp_id='".$emp."'")." ".getdata("tm_emp","emp_lastname","emp_id='".$emp."'");

$cond.=" and login_regid='".$emp."' and (`login_dateadded`>='".$fdate."' && `login_dateadded`<='".$tdate."')";

}

$qur=mysql_query("select * from `tm_logindetails` where 1 ".$cond);

$cnt=mysql_num_rows($qur);
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Log-In & Log-Out Details</strong></td>

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

<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="red"><? if(isset($errmsg)){echo $errmsg;}?><? if(isset($_GET['msg'])){echo alerts_msg($_GET['msg']); }?></td>
            </tr>
            <tr>
              <td>
<table border="0" align="center" cellpadding="0" cellspacing="0">

              <form name="form_search" id="form_search" action="" method="post" onsubmit="return reports_valid()">

			  <tr>

                <td><table border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td align="left"><input name="md" type="radio" id="radiom" value="m" <? if(isset($_POST['md']) && $_POST['md']=='m'){echo 'checked';} else if(!isset($_POST['md'])){?> checked="checked"<? }?> onclick="show_div1(this.value);"/></td>

                    <td align="left" class="sub_heading">Month Wise</td>

                    <td align="left">&nbsp;</td>

                    <td align="left"><input name="md" type="radio" id="radiod" value="d" onclick="show_div1(this.value);" <? if(isset($_POST['md']) && $_POST['md']=='d'){?> checked="checked"<? }?>/></td>

                    <td align="left" class="sub_heading">Day Wise</td>

                    </tr>

                </table></td>

                <td width="10">&nbsp;</td>

                <td><div id="month" style="display:<? if(isset($_POST['md']) && $_POST['md']=='m'){echo 'block';} else if(isset($_POST['md']) && $_POST['md']=='d'){echo 'none';} else if(!isset($_POST['md'])){?>block<? }?>;">

                        <table border="0" cellspacing="0" cellpadding="0">

                          <tr>

                            <td><select name="mm1" class="select" id="mm1">

                                <option  value="">MM</option>

                                <option value="01"<? if(isset($_POST['mm1']) && $_POST['mm1']=='01'){echo 'selected';}?>>Jan</option>

                                <option value="02"<? if(isset($_POST['mm1']) && $_POST['mm1']=='02'){echo 'selected';}?>>Feb</option>

                                <option value="03"<? if(isset($_POST['mm1']) && $_POST['mm1']=='03'){echo 'selected';}?>>Mar</option>

                                <option value="04"<? if(isset($_POST['mm1']) && $_POST['mm1']=='04'){echo 'selected';}?>>Apr</option>

                                <option value="05"<? if(isset($_POST['mm1']) && $_POST['mm1']=='05'){echo 'selected';}?>>May</option>

                                <option value="06"<? if(isset($_POST['mm1']) && $_POST['mm1']=='06'){echo 'selected';}?>>Jun</option>

                                <option value="07"<? if(isset($_POST['mm1']) && $_POST['mm1']=='07'){echo 'selected';}?>>Jul</option>

                                <option value="08"<? if(isset($_POST['mm1']) && $_POST['mm1']=='08'){echo 'selected';}?>>Aug</option>

                                <option value="09"<? if(isset($_POST['mm1']) && $_POST['mm1']=='09'){echo 'selected';}?>>Sep</option>

                                <option value="10"<? if(isset($_POST['mm1']) && $_POST['mm1']=='10'){echo 'selected';}?>>Oct</option>

                                <option value="11"<? if(isset($_POST['mm1']) && $_POST['mm1']=='11'){echo 'selected';}?>>Nov</option>

                                <option value="12"<? if(isset($_POST['mm1']) && $_POST['mm1']=='12'){echo 'selected';}?>>Dec</option>

                            </select></td>

                            <td><select name="my1" class="select" id="my1">

                                <option  value="">YYYY</option>

                                <? for($y1=2012;$y1<=date("Y");$y1++) {?>

                                <option value="<?=$y1?>"<? if(isset($_POST['my1']) && $_POST['my1']==$y1){echo 'selected';}?>><?=$y1?></option><? }?>

                            </select></td>

                            </tr>

                        </table>

                    </div><div id="day" style="display:<? if(isset($_POST['md']) && $_POST['md']=='d'){echo 'checked';} else {?>none<? }?>;">

                          <table border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td><select name="dd1" class="select" id="dd1">

                                  <option value="">DD</option>

                                  <? for($i=1;$i<=31;$i++){ if($i<=9){$i="0".$i;}?>

                                  <option value="<?=$i?>"<? if(isset($_POST['dd1']) && $_POST['dd1']==$i){echo 'selected';}?>><?=$i;?>

                                  </option>

                                  <? }?>

                              </select></td>

                              <td><select name="dm1" class="select" id="dm1">

                                <option  value="">MM</option>

                                <option value="01"<? if(isset($_POST['dm1']) && $_POST['dm1']=='01'){echo 'selected';}?>>Jan</option>

                                <option value="02"<? if(isset($_POST['dm1']) && $_POST['dm1']=='02'){echo 'selected';}?>>Feb</option>

                                <option value="03"<? if(isset($_POST['dm1']) && $_POST['dm1']=='03'){echo 'selected';}?>>Mar</option>

                                <option value="04"<? if(isset($_POST['dm1']) && $_POST['dm1']=='04'){echo 'selected';}?>>Apr</option>

                                <option value="05"<? if(isset($_POST['dm1']) && $_POST['dm1']=='05'){echo 'selected';}?>>May</option>

                                <option value="06"<? if(isset($_POST['dm1']) && $_POST['dm1']=='06'){echo 'selected';}?>>Jun</option>

                                <option value="07"<? if(isset($_POST['dm1']) && $_POST['dm1']=='07'){echo 'selected';}?>>Jul</option>

                                <option value="08"<? if(isset($_POST['dm1']) && $_POST['dm1']=='08'){echo 'selected';}?>>Aug</option>

                                <option value="09"<? if(isset($_POST['dm1']) && $_POST['dm1']=='09'){echo 'selected';}?>>Sep</option>

                                <option value="10"<? if(isset($_POST['dm1']) && $_POST['dm1']=='10'){echo 'selected';}?>>Oct</option>

                                <option value="11"<? if(isset($_POST['dm1']) && $_POST['dm1']=='11'){echo 'selected';}?>>Nov</option>

                                <option value="12"<? if(isset($_POST['dm1']) && $_POST['dm1']=='12'){echo 'selected';}?>>Dec</option>

                            </select></td>

                              <td><select name="dy1" class="select" id="dy1">

                                <option  value="">YYYY</option>

                                <? for($y1=2012;$y1<=date("Y");$y1++) {?>

                                <option value="<?=$y1?>"<? if(isset($_POST['dy1']) && $_POST['dy1']==$y1){echo 'selected';}?>><?=$y1?></option><? }?>

                            </select></td>

                              <td>-</td>

                              <td><select name="dd2" class="select" id="dd2">

                                  <option value="">DD</option>

                                  <? for($j=1;$j<=31;$j++){ if($j<=9){$j="0".$j;}?>

                                  <option value="<?=$j?>"<? if(isset($_POST['dd2']) && $_POST['dd2']==$j){echo 'selected';}?>><?=$j;?></option>

                                  <? }?>

                              </select></td>

                              <td><select name="dm2" class="select" id="dm2">

                                <option  value="">MM</option>

                                <option value="01"<? if(isset($_POST['dm2']) && $_POST['dm2']=='01'){echo 'selected';}?>>Jan</option>

                                <option value="02"<? if(isset($_POST['dm2']) && $_POST['dm2']=='02'){echo 'selected';}?>>Feb</option>

                                <option value="03"<? if(isset($_POST['dm2']) && $_POST['dm2']=='03'){echo 'selected';}?>>Mar</option>

                                <option value="04"<? if(isset($_POST['dm2']) && $_POST['dm2']=='04'){echo 'selected';}?>>Apr</option>

                                <option value="05"<? if(isset($_POST['dm2']) && $_POST['dm2']=='05'){echo 'selected';}?>>May</option>

                                <option value="06"<? if(isset($_POST['dm2']) && $_POST['dm2']=='06'){echo 'selected';}?>>Jun</option>

                                <option value="07"<? if(isset($_POST['dm2']) && $_POST['dm2']=='07'){echo 'selected';}?>>Jul</option>

                                <option value="08"<? if(isset($_POST['dm2']) && $_POST['dm2']=='08'){echo 'selected';}?>>Aug</option>

                                <option value="09"<? if(isset($_POST['dm2']) && $_POST['dm2']=='09'){echo 'selected';}?>>Sep</option>

                                <option value="10"<? if(isset($_POST['dm2']) && $_POST['dm2']=='10'){echo 'selected';}?>>Oct</option>

                                <option value="11"<? if(isset($_POST['dm2']) && $_POST['dm2']=='11'){echo 'selected';}?>>Nov</option>

                                <option value="12"<? if(isset($_POST['dm2']) && $_POST['dm2']=='12'){echo 'selected';}?>>Dec</option>

                            </select></td>

                              <td><select name="dy2" class="select" id="dy2">

                                <option  value="">YYYY</option>

                                <? for($y2=2012;$y2<=date("Y");$y2++) {?>

                                <option value="<?=$y2?>"<? if(isset($_POST['dy2']) && $_POST['dy2']==$y2){echo 'selected';}?>><?=$y2?></option><? }?>

                            </select></td>

                            </tr>

                          </table>

                      </div></td>

                <td width="10">&nbsp;</td>

                <td><table border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td class="sub_heading">Select By :</td>

                        <td><select name="emp" class="select" id="emp">

                              <option value="">Select an Employee</option>

							  <? if(isset($_POST['emp'])) {$emp=$_POST['emp'];} else { $emp=''; } get_st_office_emp($emp);?>

                            </select></td>

                        <td>&nbsp;</td>

                        <td><input type="submit" name="Submit" id="Submit" value=" Go " class="btn_input" /></td>

                      </tr>

                    </table></td>

              </tr></form>

            </table>
			  </td>
            </tr>
            <tr>
              <td><table width="80%" border="0" align="center" cellpadding="5" cellspacing="1" style="border:solid 1px #CCCCCC; border-radius:2px;">
                          <tr>
                            <td colspan="6" align="left"><span class="main_heading">LOG-IN Details of :</span> <span class="main_heading_red"><?=$emp_name;?></span> &nbsp; <?=$reports_ft;?></td>
                          </tr>
                          <tr class="tablehead">
                            <td width="6%" align="center" style="background-color:#D5D5D5"><strong>S.No</strong></td>
                            <td width="23%" align="left" style="background-color:#D5D5D5"><strong>Log-In Date</strong></td>
                            <td width="19%" align="center" style="background-color:#D5D5D5"><strong>Log-In Time</strong></td>
                            <td width="18%" align="center" style="background-color:#D5D5D5"><strong>Login As</strong></td>
                            <td width="18%" align="center" style="background-color:#D5D5D5"><strong>IP Address</strong></td>
                            <td width="16%" align="center" style="background-color:#D5D5D5"><strong>Log-Out Time</strong></td>
                          </tr>
                          <? $i=0; $idval='';

				  while($row=mysql_fetch_array($qur)){  $i++;

				  $log_in=explode(" ",$row['logintime']);

				  ?>
							<tr bgcolor="#D4D4D4">
							
							<td align="center" bgcolor="#D5D5D5"><?=$i?></td>
							
							<td align="center" <? if($idval<>$row['login_dateadded']){?> bgcolor="#999" <? }?>><? if($idval==$row['login_dateadded']){}else{echo date("d-M-Y",strtotime($row['login_dateadded'])); $idval=$row['login_dateadded'];}?></td>
							
							<td align="center" bgcolor="#D5D5D5"><?=$log_in[1]?></td>
							
							<td align="center" bgcolor="#D5D5D5"><?=$row['login_user']?></td>
							
							<td align="center" bgcolor="#D5D5D5"><?=$row['ipaddress'];?></td>
							
							<td align="center" bgcolor="#D5D5D5"><? if($row['logouttime']!='0000-00-00 00:00:00'){echo $row['logouttime'];} else {echo "--";}?></td>
							</tr>
                          <? } if($cnt==0) {?>
                          <tr bgcolor="#FFFFFF">
                            <td colspan="6" align="center" class="red">No Records</td>
                          </tr>
                          <? }?>
                      </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>

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
<script language="javascript">

function show_div1(m){

	if(m=="m") {

	document.getElementById('month').style.display='block';

	document.getElementById('day').style.display='none';

	} else if(m=='d') {	

	document.getElementById('day').style.display='block';

	document.getElementById('month').style.display='none';

	}

}

function reports_valid(){

var d=document.form_search;

	if(d.md[0].checked==true){

		if(d.mm1.value==""){alert("Please Select From Month !"); d.mm1.focus(); return false; }

		if(d.my1.value==""){alert("Please Select From Year !"); d.my1.focus(); return false; }

	} else if(d.md[1].checked==true) {

		if(d.dd1.value==""){alert("Please Select From Date !"); d.dd1.focus(); return false; }

		if(d.dm1.value==""){alert("Please Select From Month !"); d.dm1.focus(); return false; }

		if(d.dy1.value==""){alert("Please Select From Year !"); d.dy1.focus(); return false; }

		if(d.dd2.value==""){alert("Please Select To Date !"); d.dd2.focus(); return false; }

		if(d.dm2.value==""){alert("Please Select To Month !"); d.dm2.focus(); return false; }

		if(d.dy2.value==""){alert("Please Select To Year !"); d.dy2.focus(); return false; }

	}

	if(d.ac_in.value==""){alert("Please Select Employee Status !"); d.ac_in.focus(); return false; }

	if(d.emp.value==""){alert("Please Select an Employee !"); d.emp.focus(); return false; }
}
</script>