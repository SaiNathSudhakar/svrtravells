<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['customer_manage']) && $_SESSION['costomer_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

$page_query = mysql_query("select cust_id from  svr_customers");
$total=mysql_num_rows($page_query);
$len=10; $start=0;
$link="manage_customers.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
			
$result = mysql_query("select * from svr_customers where 1 order by cust_id desc limit $start,$len");
$count_order=mysql_num_rows($result);

if(!empty($_GET['del'])){
	mysql_query("delete from svr_customers where cust_id='".$_GET['del']."'");
	header("location:manage_customers.php?msg=del");
}
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	mysql_query("update svr_customers set cust_status=".$status." where cust_id='".$_GET['sid']."'");
	header("location:manage_customers.php");
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
<script language="javascript" src="../js/script.js"></script>
<script src="js/jquery-1.9.1.min.js" language="javascript"></script>
<script language="javascript" src="js/script.js"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; <a href="#">Users</a> &raquo; Manage  Customers</strong></td>
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
		  <td valign="top"><table width="95%" border="0" align="center" cellpadding="6" cellspacing="0">
            <tr>
              <td align="right"><!--<a href="add_cms.php"><strong>Add CMS</strong></a>--></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="8%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td width="14%" class="tablehead"><strong>Name</strong></td>
					<td width="12%"class="tablehead"><strong>Email</strong></td>
					<td width="12%"class="tablehead">Password</td>
					<td width="12%"class="tablehead"><strong>Mobile</strong></td>
					<td width="11%"class="tablehead"><strong>Phone</strong></td>
					<td width="15%"class="tablehead"><strong>City</strong></td>
					<td width="14%"class="tablehead"><strong>State</strong></td>
                    <td width="7%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
                    <td width="7%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
                  </tr>
                </thead>
                <?php
				if($count_order>0)
				{
				  $sno=$start;	
				  include_once("../includes/MD5Decryptor.php");
				  while($fetch=mysql_fetch_array($result))
				  { 
					$sno++;
					if($fetch['cust_status']==1){
						$f_status ='<a href="manage_customers.php?sid='.$fetch["cust_id"].'&f_status=inactive">
						<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
					}else if($fetch['cust_status']==0){
						$f_status='<a href="manage_customers.php?sid='.$fetch["cust_id"].'&f_status=active">
						<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
					}
					
					$decryptors = array('Google', 'Gromweb');
					$hash = $fetch['cust_password'];
					
					foreach($decryptors as $decrytor)
						if (NULL !== ($plain = MD5Decryptor::plain($hash, $decrytor))) {
							$password = $plain;	break;
						}
					?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><?=to_title_case($fetch['cust_fname']." ".$fetch['cust_lname']);?></td>
				  <td align="left"><?=$fetch['cust_email']?></td>
				  <td align="left"><?=$password;?>
					  <span class="pwd" style="display:none">
						<span id="mask-pwd">******</span>
						<span id="pwd" class="pwd"><?=$password;?></span>
					  </span>
				  </td>
				  <td align="left"><?=$fetch['cust_mobile']?></td>
				  <td align="left"><?=$fetch['cust_landline']?></td>
				  <td align="left"><?=exists($fetch['cust_city'], $null, 1)?></td>
				  <td align="left"><?=exists($state[$fetch['cust_state']], $null, 1)?></td>
                  <td width="7%" align="center"><a href="javascript:;" onclick="popupwindow('view_customer.php?custom_id=<?=$fetch['cust_id']?>', 'Title', '650', '450');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
                  <td width="7%" align="center"><? echo $f_status; ?></td>
                </tr>
                <?
			}
		}
		else if($count_order==0)
		{
		?>
		<tr>
		  <td colspan="12" height="150" align="center" bgcolor="#CCC">No Records Found</td>
		</tr>
		<? } ?>
              </table></td>
            </tr>
          </table>
		  </td>
		</tr>
		<? if($total>$len){ ?>
		<tr>
		  <td><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><? page_Navigation_second($start,$total,$link); ?></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<? }?>
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