<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['cancel_orders_manage']) && $_SESSION['cancel_orders_manage']=='yes' ) ) ){}else{header("location:welcome.php");}

$result = query("select * from svr_book_details where book_status=3 order by book_id desc");

if(!empty($_GET['c_id'])){
	$del = query("delete from svr_book_details where book_id='".$_GET['c_id']."'");
	header("location:cancelorders.php");
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

			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Cancel Orders</strong></td>

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
		  <td><table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="4%" height="20" class="tablehead">S.No</td>
			<td width="32%" class="tablehead">User Details</td>
			<td width="34%" align="left" class="tablehead">Package Details</td>
			<td width="12%" align="center" class="tablehead">Order No.</td>
			<td width="12%" align="center" class="tablehead">Seat No.s</td>
			<td width="3%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<td width="3%" align="center" class="tablehead"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
			$count_order = num_rows($result);
		  	$sno = 0; if($count_order>0){
		    while($fetch=fetch_array($result)){
		    $sno++;
		  ?>
		  <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">
			<td width="4%" height="25" align="left" valign="top"><?=$sno;?>.</td>
			<td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="25%"><strong>Name</strong></td>
                <td width="5%" align="center"><strong>:</strong></td>
                <td><?=$fetch['book_full_name'];?></td>
              </tr>
              <tr>
                <td width="25%"><strong>E-Mail</strong></td>
                <td width="5%" align="center"><strong>:</strong></td>
                <td><?=$fetch['book_email_id'];?></td>
              </tr>
              <tr>
                <td width="25%"><strong>Mobile</strong></td>
                <td width="5%" align="center"><strong>:</strong></td>
                <td><?=$fetch['book_mobile_no'];?></td>
              </tr>
              <tr>
                <td><strong>Land</strong></td>
                <td align="center"><strong>:</strong></td>
                <td><?=$fetch['book_phone_no'];?></td>
              </tr>
            </table></td>

			<td align="center" valign="top">
			<?
			$qur=query("select pkg_to_id,pkg_date from `svr_packages` where pkg_id=".$fetch['packages_id_fk']);
			$row=fetch_array($qur);
			
			//$from_name =getdata('svr_from_locations','floc_name','floc_id='.$row['pkg_from_id']);
			//$to_name =getdata('svr_to_locations','tloc_name','tloc_id='.$row['pkg_to_id']);
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="25%"><strong>From</strong></td>
                <td width="5%"><strong>:</strong></td>
                <td width="70%"><? //=$from_name;?></td>
              </tr>
              <tr>
                <td><strong>To</strong></td>
                <td><strong>:</strong></td>
                <td><? //=$to_name;?></td>
              </tr>
              <tr>
                <td><strong>Date</strong></td>
                <td><strong>:</strong></td>
                <td><? $date = new DateTime($row['pkg_date']); echo $date->format('d-m-Y'); ?></td>
                </tr>
            </table></td>
			<td width="13%" align="center"><?=$fetch['book_orderid'];?></td>
			<td width="11%" align="center"><?=$fetch['book_seat_number'];?></td>
			<td width="3%" align="center"><a href="javascript:;" onClick="window.open('view_orders.php?c_id=<?=$fetch['book_id'];?>','no','scrollbars=yes,menubar=no,width=700,height=600')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<td width="3%" align="center" onclick="return confirm('Do you want to del this record');"><a href="cancelorders.php?c_id=<?=$fetch['book_id'];?>"><img src="images/del.png" alt="Delete" title="Delete" width="16" height="16" /></a></td>

			<? if(isset($_SESSION['tm_type']) && $_SESSION['tm_type']=='admin'){?>

			<? }?>
		  </tr>
		  <? 
		  }}
		  else if($count_order==0){?>
		  <tr><td colspan="13" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
		  <? } ?>
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