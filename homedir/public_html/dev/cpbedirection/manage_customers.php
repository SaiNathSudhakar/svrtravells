<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('customers',$_SESSION['tm_priv']))) ){}else{header("location:welcome.php");}

$len=30; $start=0;
$link="manage_customers.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }
 
$cond = '1';  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['cb_search']);
	unset($_SESSION['cb_status']);
	header("location:manage_customers.php");
}
if(isset($_GET['status']))
{
	$_SESSION['cb_status'] = ($_GET['status'] != '') ? $_GET['status'] : '';
	header('location:manage_customers.php');
}
$cond .= (isset($_SESSION['cb_status']) && $_SESSION['cb_status'] != '') ? " and cust_status = '".$_SESSION['cb_status']."'" : "";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$_SESSION['cb_search'] = (!empty($_POST['search_but']) && !empty($_POST['search'])) ? $_POST['search'] : '';
	header('location:manage_customers.php');
}

if(!empty($_SESSION['cb_search'])){
	$search = array('cust_fname', 'cust_lname', 'cust_mobile', 'cust_landline', 'cust_email', 'cust_mobile', 'cust_address_1', 'cust_city', 'cust_state', 'cust_country', 'cust_pincode');
	foreach($search as $key => $value)
	{	
		$cond .= ($key == 0 ) ? ' and (' : 'or';
		$cond .= "(".$value." like '%".$_SESSION['cb_search']."%')" ;
	}
	$cond.=')';
}
	
$result = query("select * from svr_customers where $cond order by cust_id desc limit $start,$len");
$count_order=num_rows($result);

$page_query = query("select cust_id from svr_customers where $cond");
$total=num_rows($page_query);

if(!empty($_GET['del'])){
	query("delete from svr_customers where cust_id='".$_GET['del']."'");
	header("location:manage_customers.php?msg=del");
}
if(!empty($_GET['f_status']))
{
	if($_GET['f_status']=="active") { $status=1; } else { $status=0; }
	query("update svr_customers set cust_status=".$status." where cust_id='".$_GET['sid']."'");
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
<body><form name="yellow_cat" id="yellow_cat" method="post" action="">
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a>  &raquo; Manage  Customers</strong></td>
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
		  <td valign="top"><table width="95%" border="0" align="center" cellpadding="6" cellspacing="0" class="table">
            <tr>
              <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td width="0" align="left" valign="middle"><input name="search" type="text" class="lstbx2" id="search" onfocus="this.placeholder='';" onblur="this.placeholder='Search Keyword';" placeholder="Search Keyword" value="<? if(!empty($_SESSION['cb_search'])){ echo $_SESSION['cb_search'];}?>" size="20"/>
					  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
					  
					  <? if($_SESSION['cb_search'] != '' || $_SESSION['cb_status'] != ''){ ?>
                          <img src="images/reset.png" onclick="javascript:window.location='manage_customers.php?src=reset'" align="absmiddle" style="cursor:pointer;" value="Reset" title="Reset"/>   
                        <? } ?>
					  <div class="fr">
                        <select name="status" id="status" onchange="javascript:window.location='manage_customers.php?status='+this.value">
                            <option value="">Select Status</option>
                            <option value="1" <? if($_SESSION['cb_status'] != '' && $_SESSION['cb_status'] == 1){?>selected<? }?>>Active</option>
                            <option value="0" <? if($_SESSION['cb_status'] != '' && $_SESSION['cb_status'] == 0){?>selected<? }?>>Inactive</option>
                        </select>
                      </div> 
                      </td>
                    </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead>
                  <tr>
                    <td width="8%" height="20" class="tablehead"><strong>S.No</strong></td>
                    <td width="14%" class="tablehead"><strong>Name</strong></td>
					<td width="12%"class="tablehead"><strong>Email</strong></td>
					<!--<td width="12%"class="tablehead">Password</td>-->
					<td width="12%"class="tablehead"><strong>Mobile</strong></td>
					<td width="11%"class="tablehead"><strong>Phone</strong></td>
					<td width="15%"class="tablehead"><strong>City</strong></td>
					<td width="14%"class="tablehead"><strong>State</strong></td>
                    <td width="7%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <!--<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
                    <td width="7%" align="center" class="tablehead"><img src="images/<?=($_SESSION['cb_status'] == '0') ? 'in' : '';?>active.png" alt="Status" title="Status" width="16" height="16" /></td>
                  </tr>
                </thead>
                <?php //
				if($count_order>0)
				{
				  $sno=$start;	
				 //include_once("../includes/MD5Decryptor.php");
				  while($fetch=fetch_array($result))
				  { 
					$sno++;
					if($fetch['cust_status']==1){
						$f_status ='<a href="manage_customers.php?sid='.$fetch["cust_id"].'&f_status=inactive">
						<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
					}else if($fetch['cust_status']==0){
						$f_status='<a href="manage_customers.php?sid='.$fetch["cust_id"].'&f_status=active">
						<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
					}//echo $count_order;exit; 
					
					//$decryptors = array('Google', 'Gromweb');
					//$hash = $fetch['cust_password'];
					
					/*foreach($decryptors as $decrytor)
						if (NULL !== ($plain = MD5Decryptor::plain($hash, $decrytor))) {
							$password = $plain;	break;
						}*/
					?>
                <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
                  <td height="25" align="left"><?=$sno;?>.</td>
                  <td align="left"><?=to_title_case($fetch['cust_fname']." ".$fetch['cust_lname']);?></td>
				  <td align="left"><?=$fetch['cust_email']?></td>
				 <?php /*?> <td align="left"><? //=$password;?>
					  <span class="pwd" style="display:none">
						<span id="mask-pwd">******</span>
						<span id="pwd" class="pwd"><? //=$password;?></span>
					  </span>
				  </td><?php */?>
				  <td align="left"><?=$fetch['cust_mobile']?></td>
				  <td align="left"><?=$fetch['cust_landline']?></td>
				  <td align="left"><?=exists($fetch['cust_city'], $null, 1)?></td>
				  <td align="left"><?=exists($states[$fetch['cust_state']], $null, 1)?></td>
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
</form>
</body>
</html>