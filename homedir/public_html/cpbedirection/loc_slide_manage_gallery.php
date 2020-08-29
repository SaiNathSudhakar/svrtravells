<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
//if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tloc',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$img_err_msg='';
$acc_type = ''; $room_type = '';


if(!empty($_REQUEST['albumid'])){
//$catid=" and ga_subid=".$_REQUEST['albumid'];}else{ $catid="";}
$catid=" and pkg_id=".$_REQUEST['albumid'];}else{ $catid="";}

//echo "select upl_id from `svr_upload_slide` where 1 ".$catid;
$qry = query("select upl_id from `svr_upload_slide` where 1 ".$catid);
$count=num_rows($qry);
$sql=query("Select * from svr_upload_slide where 1 ".$catid." order by upl_id desc limit $start,$len");
//if(!empty($_REQUEST['albumid'])){$sai_catname=GetIdName("ip_oursubcategory","oursubcat_name","oursubcat_id='".$_REQUEST['id']."' and oursubcat_status=1"); }else{ $sai_catname="";}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<script language="javascript"> var adminurl = '<?=$admin_url;?>'; </script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script language="javascript" src="js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/redmond/jquery-ui.css" />
<link href="css/site.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ptTimeSelect.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.ptTimeSelect.js"></script>

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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong> <a href="welcome.php">Home</a> &raquo; View Slide Images</strong></td>
			  <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
			  <td valign="top" class="grn_subhead" align="right"></td>
				</tr></table></td>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>

<form action="manage_gallery.php" method="post" name="form1" id="form1">
	<table width="97%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="25" align="right" valign="middle" bgcolor="#FFFFFF"><a href="manage_to_location.php"><strong>Manage Locations</strong></a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="300" valign="top" bgcolor="#FFFFFF" class="admin_border"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="box2">

                <tr>
                  <td width="100%" height="30" align="center" valign="middle"><span class="admin_heading"><?=$sai_catname?> Gallery Images</span></td>
                </tr>
                <tr  class="admin_bg">
                  <td><img src="../images/spacer.gif" width="1" height="1" /></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="40%" align="left"></td>
                              <td align="center" class="Mandatory"><? if(isset($delmsg)){ echo $delmsg;}else if(!empty($_GET['msg'])){ echo msg($_GET['msg']); }?></td>
                              <td width="40%" align="center" class="dash_innerstatus">&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                        <tr>
                          <td colspan="2"><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="5">
                              <tr>
                                <?php
								
								if($count>0){
								$i=0;
								$slide_qry = query("Select * from svr_upload_slide where slide_title is not null and 1 ".$catid."");
								while($row=fetch_array($slide_qry))
								{
								if( ($i%8)==0 ) {  echo '<tr>'; }$i++;

								?>
                                <td align="center"><table width="150"  border="0" cellpadding="1" cellspacing="1" bordercolor="#D9D9D9" bgcolor="#D9D9D9" class="brwn-bor">
                                    <tr>
                                      <td width="125" height="131" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF">
									  <?
									  //if(!empty($row['slide_simg']) && file_exists($row['slide_simg'])){
									  ?>
                                      <a href="javascript:load(<?=$row['upl_id']?>)" ><img src="<?=$row['slide_simg'];?>" width="200" height="135" border="0" /></a>
                                          <? //} else { ?>
<!--<img src="../images/svr-travels.jpg"  width="150" height="80" border="0" />
-->                                          <? //} ?></td>
                                    </tr>
                                    <tr bgcolor="#D9D9D9"><td align="left" valign="middle">
									<input type="hidden" name="albumid" id="albumid" value="<?=$_GET['albumid']?>"/>
									
									<input type="hidden" name="start" id="start" value="<?=$start;?>"/>
									<input type="checkbox" name="del[<? echo $row['upl_id']?>]" title="<?=$row['upl_id'] ?>" id="del" value="<?=$row['upl_id']?>" />Delete</a></td>
                                    </tr>
                                </table></td>
                                <?   if( ($i%4)==0 ) { echo '</tr>'; }	$i++;
} //while loop close
} else {

?>
                              </tr>
                              <tr>
                                <td height="200" align="center" valign="middle" class="norecords">Gallery Images Not Found</td>
                              </tr>
                              <? } ?>
                          </table></td>
                        </tr>
                        <? if($count>0){ ?>
                        <tr>
                         <td colspan="2" align="center"><input name="Submit" type="submit" class="RedButton" value="Delete Selected"  onclick="return delchk();" /></td>
                        </tr>
                        <? }?>
                    <tr>
                        <td align="right">&nbsp;</td>
                    </tr>
                      <tr>
                        <td align="right"><?php  if($count>$len){ $db->Navigation_3($start,$count,$link,$interval=5); } ?></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="6" align="center" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</form>

		  </td>
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
function check_valid()
{
var d=document.form1;

<?php for ($k=1;$k<=5;$k++) { ?>		
		if(d.prsimage<?php echo $k?>.value=="") {
			alert("Please Upload Image");
			d.prsimage<?php echo $k?>.focus();
			return false
	}else return true;	
<?php } ?>		
} 
</script>