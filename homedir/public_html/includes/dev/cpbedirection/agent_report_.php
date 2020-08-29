<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['deposit_manage']) && $_SESSION['deposit_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['ar_ag_id']);
	unset($_SESSION['ar_from_date']);
	unset($_SESSION['ar_to_date']);
	header("location:agent_report.php");
}

$page_query = mysql_query("select ar_id from svr_agent_reports where ar_cre_deb = 0");
$total=mysql_num_rows($page_query);

$len=10; $start=0; $cond = "1";
$link="agent_report.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; }

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	$cond_ord = " order by ar_id desc";
	$agent = $_POST['agent'];
	$from = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ar_from_date'])));
	$to = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ar_to_date'])));
	if($agent != '') { 
		$cond .= " and ar_ag_id = '".$agent."'"; 
		$_SESSION['ar_ag_id'] = $_POST['agent']; 
		$cond_ord = " order by ar_id asc";
	}
	if($from != '0000-00-00' && $to != '0000-00-00' && $from != '1970-01-01' && $to != '1970-01-01') { 
		$cond .= " and ar_date_time between '".$from."' and '".$to."'"; 
		$_SESSION['ar_from_date'] = $_POST['ar_from_date']; $_SESSION['ar_to_date'] = $_POST['ar_to_date'];
		$cond_ord = " order by ar_id asc";
	}
}
	
$result = mysql_query("select ar.*, ag.ag_fname from svr_agent_reports as ar
	left join svr_agents as ag on ar.ar_ag_id=ag.ag_id
		where $cond and ar_cre_deb = 0 $cond_ord limit $start, $len");
$count_order = mysql_num_rows($result);
$search = (empty($_SESSION['ar_ag_id']) && empty($_SESSION['ar_from_date']) && empty($_SESSION['ar_to_date'])) ? '0' : '1';
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
<script src="js/jquery-ui.js" type="text/javascript"></script>
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Agent Report </strong></td>
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
              <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table"><tr><td>
			  <form name="yellow_cat" id="yellow_cat" method="post" action="">
			  <table border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td align="left" valign="middle">
					  Agent : 
					  	<select name="agent" id="agent">
                            <option value="">Select Agent</option>
							<? 	$q = mysql_query("select ag_id, ag_fname, ag_lname from svr_agents where ag_status = 1");
							  	while($fetch = mysql_fetch_array($q)){ ?>
                            <option value="<?=$fetch['ag_id'];?>"
							<? if($_SESSION['ar_ag_id'] == $fetch['ag_id']){?>selected<? }?>>
							<?=$fetch['ag_fname'].' '.$fetch['ag_lname']; ?></option><? }?>
                          </select>
					  <? if(!empty($_SESSION['ar_ag_id']) || !empty($_SESSION['ar_from_date']) || !empty($_SESSION['ar_to_date'])){ ?>
				      <img src="images/reset.png" align="absmiddle" alt="Reset" onclick="javascript:window.location = 'agent_report.php?src=reset'" title="Reset"/>
			          <? } ?>
					  </td> <td> From : </td> <td>
                        <input name="ar_from_date" type="text" class="input fl" id="ar_from_date" style="width:120px;" onfocus="this.placeholder=''" onblur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ar_from_date'])){echo $_SESSION['ar_from_date'];}?>" />
					  </td><td> To : </td> <td>
                        <input name="ar_to_date" type="text" class="input fl" id="ar_to_date" style="width:120px;" onfocus="this.placeholder=''" onblur="this.placeholder=' DD/MM/YYYY* '" placeholder=" DD/MM/YYYY* " value="<? if(!empty($_SESSION['ar_to_date'])){echo $_SESSION['ar_to_date'];}?>" />
					  </td>	<td>				  
					  <input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/>
					  </td>
                      <!--<td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>-->
                      </tr>
                </table>
			  </form></td></tr></table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
                <thead style="display:<?=(empty($search)) ? 'none' : '';?>">
                  <tr>
                    <td height="20" class="tablehead"><strong>S.No</strong></td>
                    <td class="tablehead"><strong>Agent Name</strong></td>
					<td class="tablehead"><strong>Order ID</strong></td>
					<td class="tablehead"><strong>Transaction</strong></td>
					<td class="tablehead"><strong>Opening Balance</strong></td>
					<td class="tablehead"><strong>Amount</strong></td>
					<td class="tablehead"><strong>Closing Balance</strong></td>
                    <td class="tablehead">Date and Time</td>
                    <!--<td width="7%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
                    <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>-->
                    </tr>
                </thead>
                <?php
			if($count_order>0)
			{
				$sno=$start;
				while($fetch=mysql_fetch_array($result))
				{ 
					$sno++;
					if($fetch['ad_status']==1){
						$f_status ='<a href="agent_report.php?sid='.$fetch["ad_id"].'&f_status=inactive">
						<img src="images/active.png" width="18" height="18" border="0" alt="Click to In-Active" title="Click to In-Active" /></a>';
					}else if($fetch['ad_status']==0){
						$f_status='<a href="agent_report.php?sid='.$fetch["ad_id"].'&f_status=active">
						<img src="images/inactive.png" width="18" height="18" border="0" alt="Click to Active" title="Click to Active" /></a>';
					}		
				?>
					<tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>" style="display:<?=(empty($search)) ? 'none' : '';?>">
					  <td height="25" align="left"><?=$sno;?>.</td>
					  <td align="left"><?=to_title_case($fetch['ag_fname']);?></td>
					  <td align="left"><?=$fetch['ar_ord_id'];?></td>
					  <td align="left"><?=$fetch['ar_transaction_type'];?></td>
					  <td align="left"><?=($fetch['ar_opening_bal'] != '') ? 'Rs. '.number_format($fetch['ar_opening_bal'], 2) : '';?></td>
					  <td align="left"><?=$fetch['ar_amount'];?></td>
					  <td align="left"><?=$fetch['ar_closing_bal'];?></td>
					  <td align="left"><?=date('d/m/Y h:i:s A', strtotime($fetch['ar_date_time']));?></td>
					  <!--<td width="7%" align="center"><a href="javascript:;" onclick="popupwindow('view_agent_deposit.php?dep_id=<?=$fetch['ad_id']?>', 'Title', '750', '550');"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>-->
					</tr>
					<?
				}
			}
		  	else if($count_order==0)
		  	{
		  	?>
                <tr>
                  <td colspan="11" height="150" align="center" bgcolor="#CCC">No Records Found</td>
                </tr>
                <? } if(empty($search)){ ?>
				<tr>
                  <td colspan="11" height="150" align="center" bgcolor="#CCC">&nbsp;</td>
                </tr>
				<? }?>
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
		<tr><td align="center">&nbsp;</td></tr>
    </table></td>
  </tr>
  <tr>
    <td class="fbg"><? include_once("footer.php");?></td>
  </tr>
</table>
</body>
</html>