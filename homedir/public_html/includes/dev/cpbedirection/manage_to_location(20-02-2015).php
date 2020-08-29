<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['to_location_manage']) && $_SESSION['to_location_manage']=='yes' ) ) ){}else{header("location:welcome.php");}
$st_sel_location=1;
$cond="";
if(isset($_SESSION['ft_cat_location']) && !isset($_GET['status'])){
	$status="and tloc_status='".$_SESSION['ft_cat_location']."'"; 
	$st_sel_location=$_SESSION['ft_cat_location']; //exit;
}
else if(isset($_GET['status']))
{	
	$_SESSION['ft_cat_location']=$_GET['status'];
	$status=" and tloc_status='".$_SESSION['ft_cat_location']."'"; 
	$st_sel_location=$_SESSION['ft_cat_location'];
}
else{ 
	//$status=" and tloc_status=1";
}
$cond.=$status;
  
// Clearing Sessions
if(!empty($_GET['src']) && $_GET['src']=="reset")
{	
	unset($_SESSION['ft_cat_location']);
	unset($_SESSION['cat_title_location']);
	header("location:manage_to_location.php");
}
if(isset($_SESSION['cat_title_location'])){
	$cond.= " and (tloc_name like '%".$_SESSION['cat_title_location']."%')";
}

if(!empty($_GET['t_status'])){
	if($_GET['t_status']=="active"){$status=1;}else{$status=0;}
	mysql_query("update svr_to_locations set tloc_status=".$status." where tloc_id='".$_GET['sid']."'");
	header("location:manage_to_location.php");
}

$page_query = mysql_query("select tloc_id from svr_to_locations where 1 $cond");
$total = mysql_num_rows($page_query);

$len=25; $start=0;
$link="manage_to_location.php?a=a";
if(!empty($_GET['start'])) { $start=$_GET['start']; } 

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	if(!empty($_POST['search_but']))
	{	
		if(!empty($_POST['tit']) || $_POST['tit']!="Search Keyword")
		{			
			$_SESSION['cat_title_location']=$_POST['tit'];					
			$cond.= " and (tloc_name like '%".$_SESSION['cat_title_location']."%')" ;					 
		}
	}
	$result = mysql_query("select tloc_id, cat_name, subcat_name, subcat_id_fk, tloc_name, tloc_code, tloc_costpp, tloc_image, tloc_ref_no, tloc_orderby, tloc_status from svr_to_locations as tloc
		left join svr_subcategories as subcat on subcat.subcat_id = tloc.subcat_id_fk
			left join svr_categories cat on cat.cat_id = tloc.cat_id_fk
				where 1 ".$cond." order by tloc.tloc_orderby desc limit $start, $len");
	$count_order = mysql_num_rows($result);
}
$result = mysql_query("select tloc_id, cat_name, subcat_name, subcat_id_fk, tloc_name, tloc_code, tloc_costpp, tloc_image, tloc_ref_no, tloc_orderby, tloc_status from svr_to_locations as tloc
	left join svr_subcategories as subcat on subcat.subcat_id = tloc.subcat_id_fk
		left join svr_categories cat on cat.cat_id = tloc.cat_id_fk
			where 1 ".$cond." order by tloc.tloc_orderby desc limit $start, $len");
$count_order = mysql_num_rows($result);

//ORDER BY
if(!empty($_GET['id']) && !empty($_GET['stat']) && !empty($_GET['poss'])){
	$poss1=$_GET['poss']; //echo "poss1=".$poss1."<br>";
	if($_GET['stat']=='up'){ $poss2=$poss1+1; }else if($_GET['stat']=='down'){ $poss2=$poss1-1; } //echo "poss2=".$poss2."<br>";

	$pos1id=getdata("svr_to_locations","tloc_id","tloc_orderby='".$poss1."'"); //echo "pos1id=".$pos1id."<br>";
	$pos2id=getdata("svr_to_locations","tloc_id","tloc_orderby='".$poss2."'"); //echo "pos2id=".$pos2id."<br>";
	
	$updpos1=mysql_query("update svr_to_locations set tloc_orderby='".$poss2."' where tloc_id='".$pos1id."'");
	$updpos2=mysql_query("update svr_to_locations set tloc_orderby='".$poss1."' where tloc_id='".$pos2id."'");
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage   Destination  </strong><strong> Location</strong></td>
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
			<table width="95%" align="center" border="0" cellspacing="0" cellpadding="6" class="table">
			  <tr>
			  <td>	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table">
                    <tr>
                      <td width="5%" align="left" valign="middle" nowrap="nowrap" class="tablehead">Search : </td>
                      <td width="0" align="left" valign="middle"><input name="tit" type="text" class="lstbx2" id="tit" onfocus="if(this.value=='Search Keyword') this.value='';" onblur="if(this.value=='') this.value='Search Keyword';" value="<? if(!empty($_SESSION['cat_title_location'])){ echo $_SESSION['cat_title_location'];}else { ?>Search Keyword<? }?>" size="20"/></td>
                      <td width="1%"  align="left" valign="middle">&nbsp;</td>
                      <td width="5%" align="left" valign="middle"><input name="search_but" type="submit" class="button" id="search_but" value="Go" title="Search"/></td>
                      <td width="8%" align="left" valign="middle">&nbsp;</td>
					  <td width="1%" align="right">&nbsp;</td>
					  <td width="8%" align="right">&nbsp;</td>
					  <td width="1%" align="right">&nbsp;</td>
					  <td width="8%" align="right">&nbsp;</td>
                      <td width="1%" align="right">
					  <? if(isset($_SESSION['ft_cat_location']) || isset($_SESSION['cat_title_location'])){ ?>
                          <img src="images/refresh.png" onclick="javascript:window.location='manage_to_location.php?src=reset'" style="cursor:pointer;" height="24" width="24" value="Reset" title="Reset"/>   
                        <? } ?></td>
                      <td width="8%" align="right">&nbsp;</td>
                      <td width="1%" align="right">&nbsp;</td>
                      <td width="8%" align="right">&nbsp;</td>
					  <td width="1%" align="right">&nbsp;</td>
					  <td width="8%" align="right">&nbsp;</td>
                      <td width="8%" align="right" nowrap="nowrap" class="tablehead">Status : </td>
                      <td width="8%" align="right">
                      <select name="cat_inact" id="cat_inact" class="textbox" style="width:80px" onchange="window.location='manage_to_location.php?status='+this.value">
                          <option value="1" <? if($st_sel_location=='1'){?>selected="selected" <? }?>>Active</option>
                          <option value="0" <? if($st_sel_location=='0'){?>selected="selected" <? }?>>In-Active</option>
                      </select></td>
                      <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
                      <td width="0" align="right" valign="middle"><input type="button"  name="Cancel2"  onclick="javascript:window.location='add_to_location.php'" value="Add New" class="button" title="Add New"/></td>
                    </tr>
                </table></td>
				<!--<td align="right"><a href="add_to_location.php"><strong>Add Location</strong></a></td>-->
			  </tr>
			  <tr>
				<td>
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
		  <thead>
		  <tr>
			<td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>
			<td width="5%" class="tablehead">&nbsp;</td>
			<td width="15%" class="tablehead">Category &raquo; Sub Category</td>
			<td class="tablehead"><strong style="font-size:12px"> Destination </strong><strong> Location</strong></td>
			<td width="10%" class="tablehead">Cost PP</td>
			<td width="10%" class="tablehead"><strong>Location</strong> Code</td>
			<td width="" align="center" class="tablehead">Order By</td>
			<td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>
			<td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>
		  </tr>
		  </thead>
		  <?php
			$sno = $start; if($count_order>0){
		   while($fetch=mysql_fetch_array($result)){
		   $sno++;
			if($fetch['tloc_status']==1){
				$t_status ='<a href="manage_to_location.php?sid='.$fetch["tloc_id"].'&t_status=inactive">
				<img src="images/active.png" width="18" height="18" border="0" title="Click to In-Active" alt="Click to In-Active" /></a>';
			}else if($fetch['tloc_status']==0){
				$t_status='<a href="manage_to_location.php?sid='.$fetch["tloc_id"].'&t_status=active">
				<img src="images/inactive.png" width="18" height="18" border="0" title="Click to Active" alt="Click to Active" /></a>';
			}
		  ?>
		  <tr class="<? if($sno%2==0) { echo "tablerow2"; } else { echo "tablerow1"; } ?>">
			<td width="5%" height="25" align="left"><?=$sno;?>.</td>
			<td width="5%" align="left">
			<? $path = $site_url."uploads/destination_locations/".$fetch['tloc_ref_no']."/"; ?>
			<? $image = ($fetch['tloc_image'] != '') ? $path.$fetch['tloc_image'] : $default_thumb;?>
			<a href="<?=$image;?>"><img src="<?=$image;?>" height="50" width="50" border="0" /></a>
			</td>
			<td align="left">
			<?=$fetch['cat_name']; //getdata('svr_categories','cat_name','cat_id='.$fetch['cat_id_fk']);?>
			<? if($fetch['subcat_id_fk']>0) { ?>
			<br />&nbsp;&nbsp;&raquo; <?=$fetch['subcat_name']; //getdata('svr_subcategories','subcat_name','subcat_id='.$fetch['subcat_id_fk']);?>
			<? } ?></td>
			<td align="left"><?=$fetch['tloc_name'];?></td>
			<td width="15%"><? if(!empty($fetch['tloc_costpp'])) { ?><?=number_format($fetch['tloc_costpp']);?>/- <? } ?></td>
			<td width="15%"><?=$fetch['tloc_code'];?></td>
			<td align="center">
				<?php /*?><table border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td align="right"><? if($sno!=1){?>
						  <? if(!empty($fetch['tloc_orderby'])){?>
						  <a href="manage_to_location.php?moveid=<?=$fetch['tloc_id']?>&move=up&priority=<?=$fetch['tloc_orderby'];?>"><img src="images/uparrow.png" width="16" height="16" border="0" /></a>
						  <? } else {?>
						  <a href="manage_to_location.php?moveid=<?=$fetch['tloc_id']?>&move=up&priority=<?=$fetch['tloc_orderby'];?>"><img src="images/uparrow.png" width="16" height="16" border="0" /></a>
						  <? }}?>
						  <? if($sno!=$count_order){?>
						  <a href="manage_to_location.php?moveid=<?=$fetch['tloc_id']?>&move=down&priority=<?=$fetch['tloc_orderby'];?>"><img src="images/downarrow.png" width="16" height="16" border="0" /></a>
						  <? }?></td>
					  <td align="center"><strong><?=$fetch['tloc_orderby']?></strong></td>
					</tr>
				</table><?php */?>
				<table border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <? if($sno!=1){ ?>
					  <td align="left" valign="middle"><a href="manage_to_location.php?stat=up&id=<?=$fetch['tloc_id']?>&poss=<?=$fetch['tloc_orderby']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/uparrow.png" alt="move down" border="0" title="Click to move Up"></a></td>
					  <? } else { echo "<td align='center' valign='bottom'width='16'>&nbsp;</td>"; } 
					  if($sno!=$total){ ?>
					  <td align="right" valign="middle"><a href="manage_to_location.php?stat=down&id=<?=$fetch['tloc_id']?>&poss=<?=$fetch['tloc_orderby']?><? if(!empty($_GET['start'])){?>&start=<?=$_GET['start']?> <? }?>"><img src="images/downarrow.png" alt="move up" border="0"title="Click to move Down"></a></td>
					  <? } else { echo "<td align='center' valign='bottom'width='16'>&nbsp;</td>"; } ?>
					  <td align="right" valign="middle"><strong><?=$fetch['tloc_orderby']?></strong></td>
					</tr>
				</table>			</td>
			<td width="5%" align="center"><a href="javascript:;" onClick="popupwindow('view_to_location.php?img_id=<?=$fetch['tloc_id']?>', 'Title', '750', '550')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>
			<td width="5%" align="center"><a href="add_to_location.php?img_id=<?=$fetch['tloc_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>
			<? //if($st_sel_location==1 || $st_sel_location==0) {  if($st_sel_location==1){ $t_status="images/active.png";} else if($st_sel_location==0){ $t_status="images/inactive.png";}?> 
			<td width="5%" align="center"><? echo $t_status; ?></td>
			<? //}?>
		  </tr>
		  <? 
		  }} else if($count_order==0){ ?>
		  <tr><td colspan="16" height="150" align="center" bgcolor="#CCC">No Records Found</td></tr>
		  <? } ?>
		  </table>
		  </td>
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