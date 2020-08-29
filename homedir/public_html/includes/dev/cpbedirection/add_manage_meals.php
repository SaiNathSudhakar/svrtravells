<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['meals_manage']) && $_SESSION['meals_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

if($_SERVER['REQUEST_METHOD']=="POST")
{
$meals = str_replace("'","&#39;",$_POST['txt_meal']);
	if(!empty($_GET['meal_id']))
	{
		mysql_query("update svr_tour_meal set tloc_id_fk='".$_POST['txt_location']."',meal_day_number='".$_POST['txt_meal_no']."',meal_meals='".$meals."' where meal_id='".$_GET['meal_id']."' ");	
		header("location:add_manage_meals.php");
	}
	else
	{
		mysql_query("insert into svr_tour_meal(tloc_id_fk,meal_day_number,meal_meals,meal_status,meal_dateadded) values('".$_POST['txt_location']."','".$_POST['txt_meal_no']."','".$meals."',1,'".$now_time."')");
		header("location:add_manage_meals.php");
	}
}
if(!empty($_GET['meal_id']))
{
    $row = mysql_query("select * from svr_tour_meal where meal_id='".$_GET['meal_id']."'");
    $meal = mysql_fetch_array($row);
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
                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Meals</strong></td>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td valign="top" class="grn_subhead" align="right">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
              <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                      <tr>
                        <td width="2%" rowspan="5" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="35%" align="left" class="sub_heading_black">&nbsp;</td>
                        <td width="63%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                      </tr>
                      <tr>
                        <td align="left" class="sub_heading_black"><strong>Destination Location <span class="red">*</span></strong></td>
                        <td align="left"><select name="txt_location" id="txt_location">
                            <option value="">--Select Location--</option>
                            <?php
								  	$svr_query = mysql_query("select * from svr_to_locations where tloc_status=1  order by tloc_id desc");
									while($test=mysql_fetch_array($svr_query))
									{
								  ?>
                            <option value="<?=$test['tloc_id'];?>" <? if(!empty($_GET['meal_id'])){ if($test['tloc_id']==$meal['tloc_id_fk']){ echo "selected";} }?>>
                            <?=$test['tloc_name'];?>
                            </option>
                            <? }?>
                          </select></td>
                      </tr>
                      <tr>
                        <td align="left" class="sub_heading_black"><strong>Meals Day No <span class="red">*</span></strong></td>
                        <td align="left"><input name="txt_meal_no" type="text" class="input" id="txt_meal_no" size="30" value="<? if(!empty($_GET['meal_id'])){ echo $meal['meal_day_number']; } ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" class="sub_heading_black"><strong>Meals <span class="red">*</span></strong></td>
                        <td align="left"><input name="txt_meal" type="text"  class="input" id="txt_meal" size="30" value="<? if(!empty($_GET['meal_id'])){ echo $meal['meal_meals']; } ?>"/></td>
                      </tr>
                      <tr align="center">
                        <td align="center">&nbsp;</td>
                        <td align="left"><input type="submit" name="Submit" id="Submit" value="<? if(!empty($_GET['meal_id'])){ echo "Edit";}else { echo "Add";}?>" class="btn_input" onclick="return validate();" /></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
              <thead>
                <tr>
                  <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
                  <td colspan="2" class="tablehead"><strong>Destination Location &nbsp; &raquo; &nbsp;Meals</strong></td>
                  <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                  <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
                  <td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
                </tr>
              </thead>
			<?php
			if(!empty($_GET['meal_status'])){
				if($_GET['meal_status']=="active"){
					$meal_stat=1;
				}else{
					$meal_stat=0;
				}
			mysql_query("update svr_tour_meal set meal_status=".$meal_stat." where meal_id='".$_GET['meal_id']."'");
			header("location:add_manage_meals.php");
			}
			$qry = mysql_query("select tloc_id, tloc_name from svr_to_locations where tloc_status=1");
			$h=0;
			while($qry_arr=mysql_fetch_array($qry)){
			$h++;
			?>
              <tr>
                <td height="25" align="left"><?=$h;?>.</td>
                <td colspan="5" align="left"><strong><?=$qry_arr['tloc_name'];?></strong></td>
              </tr>
              <?
				   $result = mysql_query("select * from svr_tour_meal where tloc_id_fk=".$qry_arr['tloc_id']);
				   $meal_count = mysql_num_rows($result);
				   $sno = 0;
				   if($meal_count>0)
				   {
					   while($fetch=mysql_fetch_array($result))
					   {
						   $sno++;
								if($fetch['meal_status']==1)
								{
									$ml_status ='<a href="add_manage_meals.php?meal_id='.$fetch["meal_id"].'&meal_status=inactive">
									<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';
								}
								else if($fetch['meal_status']==0)
								{
									$ml_status='<a href="add_manage_meals.php?meal_id='.$fetch["meal_id"].'&meal_status=active">
									<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';
								}
						
			  ?>
              <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";} ?>">
                <td width="5%" height="25" align="left">&nbsp;</td>
                <td width="5%" align="left"><?=$sno;?>
                  .</td>
                <td align="left"><?=$fetch['meal_meals'];?></td>
                <td width="5%" align="center"><a href="javascript:;" onClick="window.open('meals_view.php?meal_id=<?=$fetch['meal_id'];?>','no','scrollbars=yes,menubar=no,width=600,height=350')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                <td width="5%" align="center"><a href="add_manage_meals.php?meal_id=<?=$fetch['meal_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
                <td width="5%" align="center"><? echo $ml_status; ?></td>
              </tr>
              <? 
			  }} else if ($meal_count==0){ ?>
              <tr>
                <td colspan="11" height="60" align="center" bgcolor="#CCC" class="red">No Records Found</td>
              </tr>
              <? }}?>
            </table></td>
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
	if(d.txt_meal_no.value==""){ alert("Please Enter your Meals Day Number"); d.txt_meal_no.focus(); return false;} 	
	if(d.txt_meal.value==""){ alert("Please Enter your Meals"); d.txt_meal.focus(); return false; }
}
</script>