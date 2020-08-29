<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && in_array('tloc',$_SESSION['tm_priv'])))){}else{header("location:welcome.php");}
$img_err_msg='';
$acc_type = ''; $room_type = '';
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$loc_replace = str_replace("'","&#39;",$_POST['txtlocation']);
	$lcode_replace = str_replace("'","&#39;",$_POST['txtcode']);
	$subsubcat = str_replace("'","&#39;",$_POST['cmb_subsubcat']);
	$transport=str_replace("'","&#39;",$_POST['txttransport']);
	$pickpt=str_replace("'","&#39;",$_POST['txtpick']);
	$pick_place = ''; //str_replace("'","&#39;",$_POST['text_pickup_place']);
	$tour_notes = ''; //str_replace("'","&#39;",$_POST['text_tour_notes']);
	$price_notes = ''; //str_replace("'","&#39;",$_POST['text_price_notes']);
	$map_url = ''; //str_replace("'","&#39;",$_POST['text_map_url']);
	$places_covered = str_replace("'","&#39;",$_POST['txt_places_covered']);
	//$pick_places = str_replace("'","&#39;",$_POST['txt_pick_place']);
	$cost_includes = '';
	$cost_excludes = '';
	$note2 = ''; $note = ''; $pickup = ''; $attachments = '';
	$pdf_path = ''; $imagepath = ''; $b_image=''; $p_image='';
	
	if(!empty($_GET['img_id'])){ $cond = "and tloc_id != ".$_GET['img_id']; } else { $cond = ''; }
	$loc_q = mysql_query("select tloc_id from svr_to_locations where 1 ".$cond." and cat_id_fk = '".$_POST['cmb_cat']."' and subcat_id_fk = '".$_POST['cmb_subcat']."' and subsubcat_id_fk='".$_POST['cmb_subsubcat']."' and tloc_name = '".$_POST['txtlocation']."' and tloc_code = '".$_POST['txtcode']."'");
	$loc_name = mysql_num_rows($loc_q); if( $loc_name > 0 ) { $loc_name_error = 'Location name aleady exists'; }
	
	//$code_q = mysql_query("select tloc_id from svr_to_locations where 1 ".$cond." and tloc_code = '".$_POST['txtcode']."'");
	//$loc_code = mysql_num_rows($code_q); if( $loc_code > 0 ) { $loc_code_error = 'Location code aleady exists'; }
	
	if($_POST['cmb_cat'] == 1){
		$acc_type = ((isset($_POST['ac'])) ? $_POST['ac'] : '' ).'|'.((isset($_POST['non_ac'])) ? $_POST['non_ac'] : '');
	} if($_POST['cmb_cat'] == 2){
		$room_type = ((isset($_POST['standard'])) ? $_POST['standard'] : '' ).'|'.((isset($_POST['deluxe'])) ? $_POST['deluxe'] : '').'|'.((isset($_POST['luxury'])) ? $_POST['luxury'] : '');
	}
	$time = ((isset($_POST['departure'])) ? $_POST['departure'] : '' ).'|'.((isset($_POST['return'])) ? $_POST['return'] : '');
	
	$days = ((isset($_POST['nights'])) ? $_POST['nights'] : '' ).'|'.((isset($_POST['days'])) ? $_POST['days'] : '');
	
	$ref_no = (empty($_GET['img_id'])) ? rand(100000, 999999) : getdata("svr_to_locations",'tloc_ref_no', "tloc_id=".$_GET['img_id']);	
	$path = "../uploads/destination_locations/".$ref_no."/";	//chmod($path, 0777);
	//banner
	$i = 0; $attachments = ''; 
	if($_FILES["upload"]["size"] > 0){
	  foreach($_FILES["upload"]["error"] as $key => $err) {
		  if ($err == UPLOAD_ERR_OK) {
		  	  $filename = make_filename(basename($_FILES["upload"]['name'][$key]));
		      $attachments .= $filename."|";
			  if(!file_exists($path.$filename))	@mkdir($path, 0777, true);
			 // echo $error_codes[$error];
			 move_uploaded_file( $_FILES["upload"]["tmp_name"][$key], $path.$filename ) or die("Problems with Upload");
		  }
	  }
	}
	$attachments = ($attachments != '') ? substr($attachments, 0, -1) : '';
	
	if(!empty($_FILES['image']["size"]))
	{
		  $imgExtension = array('jpg','jpe','jpeg','gif');
		  $image_name = pathinfo($_FILES['image']['name']);
		  $extension = strtolower($image_name['extension']);
		  
		  if(in_array($extension, $imgExtension))
		  {
			  if($_FILES['image']["size"] >1)
			  {
				  $b_image=substr($_FILES['image']['name'],0,strpos($_FILES['image']['name'],'.'));
				  $b_image.=time();
				  $b_image.=strstr($_FILES['image']['name'],'.');
		  		  if(!file_exists($path.$b_image))	@mkdir($path, 0777, true);
				  
				  if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { 
				  	  $b_image=""; 
				  } else { 
				  	  resize_image($path.$b_image, 148); //width: 148; height: 159
				  	  if(!empty($_POST['old_img'])) @unlink($path.$_POST['old_img']);
				  }
				
				  $imagepath=$b_image;
			  }
		  }
		  else
		  {		
			  $img_err_msg = "you have to upload 'jpg , jpe , jpeg , gif' images only";
		  }
	}
	elseif(!empty($_POST['old_img']))
	{
	  $b_image=$_POST['old_img'];
	}
	if(!empty($_FILES['image_pdf']["size"]))
	{
		$pdfExtension = array('pdf');
		$pdf_name = pathinfo($_FILES['image_pdf']['name']);
		$pdfextension = strtolower($pdf_name['extension']);
		if(in_array($pdfextension,$pdfExtension))
		{
			if($_FILES['image_pdf']["size"] >1)
			{
				$p_image=substr($_FILES['image_pdf']['name'],0,strpos($_FILES['image_pdf']['name'],'.'));
				$p_image.=time();
				$p_image.=strstr($_FILES['image_pdf']['name'],'.');
				//$p_path="../uploads/destination_locations/".$ref_no."/";
				if(!file_exists($path.$p_image))	@mkdir($path, 0777, true);
				//unlink();
				if(!empty($_GET['img_id']))
				{
					$qry = mysql_query("select tloc_pdf from svr_to_locations where tloc_id='".$_GET['img_id']."'");
					$fet_qry=mysql_fetch_array($qry);
					$upd_pdf = $fet_qry['tloc_pdf'];
					@unlink($upd_pdf);
				}
				if(!move_uploaded_file($_FILES['image_pdf']['tmp_name'],$path.$p_image)) { $p_image=""; }
				chmod($path,0777);
				$pdf_path=$p_image;
			}
			else
			{
				$img_err_msg = "you should upload 'pdf' format only";
			}
		}
	}
	elseif(!empty($_POST['old_pdf']))
	{
		$p_image=$_POST['old_pdf'];
	}
	if(empty($img_err_msg) && empty($size_err_msg) && empty($loc_name_error) )//&& empty($loc_code_error)
	{
		if(!empty($_GET['img_id']))
		{
			//Cost Includes
			$costinc_in=""; $costinc_up="";
		
			// UPDATE & ADD Cost Includes
			for($p=1;$p<=$_POST['edit_counthiddenp_up'];$p++){		// for Updating ,Previous Cost Includes
				if(!empty($_POST['edit_cost_includes'.$p])){ $costinc_up.=$_POST['edit_cost_includes'.$p]."|";}
			}	$costinc_up=substr($costinc_up,0,-1);
			$b=$_POST['edit_counthiddenp_up'];
			$b=$b+1;
			for($b=$b;$b<=$_POST['edit_counthiddenp'];$b++){ // for Inserting, New Cost Includes
				if(!empty($_POST['edit_cost_includes'.$b])){$costinc_in.=$_POST['edit_cost_includes'.$b]."|";}
			}	$costinc_in=substr($costinc_in,0,-1);
				if(!empty($costinc_in)){$costinc_updt=$costinc_up."|".$costinc_in;} else {$costinc_updt=$costinc_up;}
			
			//Cost Excludes
			$costexc_in=""; $costexc_up="";
			
			// UPDATE & ADD Cost Includes
			for($p=1;$p<=$_POST['edit_ce_counthiddenp_up'];$p++){ // for Updating, Previous Cost Excludes
				if(!empty($_POST['edit_cost_excludes'.$p])){ $costexc_up.=$_POST['edit_cost_excludes'.$p]."|";}
			}	$costexc_up=substr($costexc_up,0,-1);
			$b=$_POST['edit_ce_counthiddenp_up'];
			$b=$b+1;
			for($b=$b;$b<=$_POST['edit_ce_counthiddenp'];$b++){	// for Inserting, New Cost Excludes
				if(!empty($_POST['edit_cost_excludes'.$b])){$costexc_in.=$_POST['edit_cost_excludes'.$b]."|";}
			}	$costexc_in=substr($costexc_in,0,-1);
				if(!empty($costexc_in)){$costexc_updt=$costexc_up."|".$costexc_in;} else {$costexc_updt=$costexc_up;}
			
			//Note2
			$note2_in=""; $note2_up="";
			
			// UPDATE & ADD Note2
			for($p=1;$p<=$_POST['edit_note2_counthiddenp_up'];$p++){ // for Updating ,Previous tnc
				$note2_up.=$_POST['edit_note2'.$p]."|";//if(!empty($_POST['edit_note2'.$p])){ //}
			}	$note2_up=substr($note2_up,0,-1);
			$b=$_POST['edit_note2_counthiddenp_up'];
			$b=$b+1;
			for($b=$b;$b<=$_POST['edit_note2_counthiddenp'];$b++){ // for Inserting  , New tnc
				$note2_in.=$_POST['edit_note2'.$b]."|";//if(!empty($_POST['edit_note2'.$b])){//}
			}	$note2_in=substr($note2_in,0,-1);
				if(!empty($note2_in)){$note2_updt=$note2_up."|".$note2_in;} else {$note2_updt=$note2_up;}
				
			// Notes
			$note_in=""; $note_up="";
			// UPDATE & ADD Note
			for($p=1;$p<=$_POST['edit_note_counthiddenp_up'];$p++){	// for Updating ,Previous tnc
				if(!empty($_POST['edit_note'.$p])){ $note_up.=$_POST['edit_note'.$p]."|";}
			}	$note_up=substr($note_up,0,-1);
			$b=$_POST['edit_note_counthiddenp_up'];
			$b=$b+1;
			for($b=$b;$b<=$_POST['edit_note_counthiddenp'];$b++){ // for Inserting  , New tnc
				if(!empty($_POST['edit_note'.$b])){$note_in.=$_POST['edit_note'.$b]."|";}
			}	$note_in=substr($note_in,0,-1);
				if(!empty($note_in)){$note_updt=$note_up."|".$note_in;} else {$note_updt=$note_up;}	
				
			// Pickup Places
			/*$pickup_in=""; $pickup_up="";
			// UPDATE & ADD pickup
			for($p=1;$p<=$_POST['edit_pickup_counthiddenp_up'];$p++){ // for Updating, Previous tnc
				if(!empty($_POST['edit_pickup'.$p])){ $pickup_up.=$_POST['edit_pickup'.$p]."|";}
			}	$pickup_up=substr($pickup_up,0,-1);
			$b=$_POST['edit_pickup_counthiddenp_up'];
			$b=$b+1;
			for($b=$b;$b<=$_POST['edit_pickup_counthiddenp'];$b++){ // for Inserting, New tnc
				if(!empty($_POST['edit_pickup'.$b])){$pickup_in.=$_POST['edit_pickup'.$b]."|";}
			}	$pickup_in=substr($pickup_in,0,-1);
			if(!empty($pickup_in)){$pickup_updt=$pickup_up."|".$pickup_in;} else {$pickup_updt=$pickup_up;}*/
			
			if(isset($_GET['img_id']) && !empty($_GET['img_id']))
			{	
				$check = getdata("svr_to_locations", "tloc_banner_image", "tloc_id=".$_GET['img_id']);
				
				///////////Banner
				$field = ($check != '') ? (($_FILES["upload"]['name'][0] != '') ? "tloc_banner_image = CONCAT(tloc_banner_image,'|".$attachments."')" : "tloc_banner_image=tloc_banner_image") : " tloc_banner_image='".$attachments."'";
				
				$up = mysql_query("update svr_to_locations set cat_id_fk = '".$_POST['cmb_cat']."', subcat_id_fk = '".$_POST['cmb_subcat']."', subsubcat_id_fk = '".$subsubcat."', tloc_floc_id = '".$_POST['cmb_from']."', tloc_name = '".$loc_replace."', tloc_code = '".$lcode_replace."', tloc_type = '".$days."', tloc_pickup_place = '".$pick_place."', tloc_tour_notes = '".$tour_notes."', tloc_price_notes = '".$price_notes."', tloc_image = '".$b_image."', tloc_gmapurl = '".$map_url."', tloc_cost_includes = '".$costinc_updt."',  tloc_places_covered = '".$places_covered."', tloc_featured = '".$_POST['featured']."', tloc_pdf = '".$p_image."', tloc_cost_excludes = '".$costexc_updt."', tloc_notes2 = '".$note2_updt."', tloc_notes = '".$note_updt."', tloc_acc_type = '".$acc_type."', tloc_time = '".$time."', tloc_transport = '".$transport."', tloc_pickup_point = '".$pickpt."', ".$field.", tloc_room_type = '".$room_type."', tloc_costpp = '".$_POST['txtcost']."', tloc_international = '".$_POST['international']."' where tloc_id = '".$_GET['img_id']."'");
				header("location:manage_to_location.php");
			}
		}
		else
		{	
			//Cost Includes - multiple
			for($p=1;$p<=20;$p++)
			{
				if(!empty($_POST['add_cost_includes'.$p]))
				{
					$cost_includes.=$_POST['add_cost_includes'.$p]."|";
				}
			}
			$cost_includes=substr($cost_includes,0,-1);
			
			//Cost Excludes - multiple
			for($p=1;$p<=20;$p++)
			{
				if(!empty($_POST['add_cost_excludes'.$p]))
				{
					$cost_excludes.=$_POST['add_cost_excludes'.$p]."|";
				}
			}
			$cost_excludes=substr($cost_excludes,0,-1);
			
			
			//tnc - multiple
			for($p=1;$p<=20;$p++)
			{
				if(!empty($_POST['add_note2'.$p]))
				{
					$note2.=$_POST['add_note2'.$p]."|";
				}
			}
			$note2=substr($note2,0,-1);
			
				//note - multiple
			for($p=1;$p<=20;$p++)
			{
				if(!empty($_POST['add_note'.$p]))
				{
					$note.=$_POST['add_note'.$p]."|";
				}
			}
			$note=substr($note,0,-1);
			
			//Pickup - multiple
			/*for($p=1;$p<=20;$p++)
			{
				if(!empty($_POST['add_pickup'.$p]))
				{
					$pickup.=$_POST['add_pickup'.$p]."|";
				}
			}
			$pickup=substr($pickup, 0, -1);*/
			
			$tloc_orderby=getdata('svr_to_locations','max(tloc_id)+1','1');
			
			mysql_query("insert into svr_to_locations(cat_id_fk, subcat_id_fk, subsubcat_id_fk,tloc_floc_id, tloc_name, tloc_code, tloc_type, tloc_tour_notes, tloc_price_notes, tloc_image, tloc_gmapurl, tloc_status, tloc_dateadded, tloc_orderby, tloc_cost_includes, tloc_places_covered, tloc_pdf, tloc_cost_excludes, tloc_notes2, tloc_notes, tloc_featured, tloc_acc_type, tloc_time, tloc_banner_image, tloc_room_type, tloc_transport, tloc_pickup_point, tloc_ref_no, tloc_costpp, tloc_international) values('".$_POST['cmb_cat']."', '".$_POST['cmb_subcat']."', '".$subsubcat."', '".$_POST['cmb_from']."', '".$loc_replace."', '".$lcode_replace."', '".$days."', '".$tour_notes."', '".$price_notes."', '".$b_image."', '".$map_url."', 1, '".$now_time."', '".$tloc_orderby."', '".$cost_includes."', '".$places_covered."', '".$p_image."', '".$cost_excludes."', '".$note2."', '".$note."', '".$_POST['featured']."', '".$acc_type."', '".$time."', '".$attachments."', '".$room_type."', '".$transport."', '".$pickpt."', '".$ref_no."', '".$_POST['txtcost']."', '".$_POST['international']."')");
			header("location:manage_to_location.php");
		}
	}
}
$edit = "Add";
if(!empty($_GET['img_id']))
{	
	$row = mysql_query("select * from svr_to_locations where tloc_id='".$_GET['img_id']."'");
	$result = mysql_fetch_array($row);
	$edit = "Update";
	
	$ref_no = $result['tloc_ref_no'];	
	$path = $site_url."uploads/destination_locations/".$ref_no."/";
	
	//delete attached files
	if(!empty($_GET['file']))
	{	
		$attachments = ''; 
		$attachment = explode('|', $result['tloc_banner_image']); 
		foreach($attachment as $attach){
			if($attach == $_GET['file']){ 
				$attachments .= ''; 
				$image_path = '../uploads/destination_locations/'.$result['tloc_ref_no'].'/'.$_GET['file'];
				if(file_exists($image_path)) @unlink($image_path);
			} else {
				$attachments .= $attach.'|';
			}
		} $attachments = substr($attachments, 0, -1);
		mysql_query("update svr_to_locations set tloc_banner_image = '".$attachments."' where tloc_id = ".$_GET['img_id']);
		header("location:add_to_location.php?img_id=".$_GET['img_id']);
	}
	// FOR EXPLODING Cost Includes
	$edit_phone=explode("|",$result['tloc_cost_includes']);
	$costinc_count=substr_count($result['tloc_cost_includes'],"|");
	// FOR EXPLODING Cost Excludes
	$edit_cost_excludes=explode("|",$result['tloc_cost_excludes']);
	$costexc_count=substr_count($result['tloc_cost_excludes'],"|");
	// FOR EXPLODING tnc
	$edit_note2=explode("|",$result['tloc_notes2']);
	$note2_count=substr_count($result['tloc_notes2'],"|");
	// FOR EXPLODING note
	$edit_note=explode("|",$result['tloc_notes']);
	$note_count=substr_count($result['tloc_notes'],"|");
	// FOR EXPLODING pickup places
	$edit_pickup=explode("|",$result['tloc_pickup_place']);
	$pickup_count=substr_count($result['tloc_pickup_place'],"|");
	// FOR ACCOMODATION
	list($ac, $non_ac) = (!empty($result['tloc_acc_type'])) ? explode('|', $result['tloc_acc_type']) : array_fill(0, 2, '');
	// FOR ROOM TYPE
	list($standard, $deluxe, $luxury) = (!empty($result['tloc_room_type'])) ? explode('|', $result['tloc_room_type']) : array_fill(0, 3, '');
	//Depature & return time
	list($deptime, $rettime) = (!empty($result['tloc_time'])) ? explode('|', $result['tloc_time']) : array_fill(0, 2, '');
	//Nights and Days
	list($night, $day) = (!empty($result['tloc_type'])) ? explode('|', $result['tloc_type']) : array_fill(0, 2, '');
	/*$edit_time=explode("|",$result['tloc_time']);
	$time_count=substr_count($result['tloc_time'],"|");*/
}
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
			  <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong> <a href="welcome.php">Home</a> &raquo; <?=$edit;?> Destination Location</strong></td>
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
<form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">
			    <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
				    <td align="right"><a href="manage_to_location.php"><strong>Manage Locations</strong></a></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
                    <td valign="top">
                      <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">
                            <tr>
                              <td width="2%" rowspan="34" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="24%" align="left" class="sub_heading_black">&nbsp;</td>
                              <td width="74%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>
                            </tr>
							<? if(!empty($size_err_msg)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$size_err_msg;?></strong></td></tr><? }?>
							<? if(!empty($img_err_msg)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$img_err_msg;?></strong></td></tr><? }?>
                            <? if(!empty($loc_name_error)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$loc_name_error;?></strong></td></tr><? }?>
                            <? if(!empty($loc_code_error)){ ?><tr><td colspan="2" class="red" align="center"><strong><?=$loc_code_error;?></strong></td></tr><? }?>
                            <tr>
                              <td class="sub_heading_black"><strong>Category <span class="red">*</span></strong></td>
                              <td align="left" id="cat_dropdown">
							  <select name="cmb_cat" id="cmb_cat" onchange="show_hide(this.value)">
							  <option value="">--Select Category--</option>
                                <?php
								  	$svr_query = mysql_query("select cat_id, cat_name from svr_categories where cat_status=1");
									while($loc=mysql_fetch_array($svr_query)){
									$cat_selected =  ((!empty($_GET['img_id']) && $loc['cat_id'] == $result['cat_id_fk']) || isset($_POST['cmb_cat']) && $_POST['cmb_cat'] == $loc['cat_id']) ? "selected" : '';?>
									<option value="<?=$loc['cat_id'];?>" <?=$cat_selected?> >
									  <?=$loc['cat_name'];?>
									</option>
									<? }?>
                              </select>							  
							  </td>
                            </tr>
							<? $interl_disp = ((!empty($_GET['img_id']) && !empty($result['tloc_international'])) || !empty($_POST['international'])) ? '' : 'none'; ?>
							<tr id="international_row" style="display:<?=$interl_disp;?>">
								<td class="sub_heading_black"><strong>Type</strong></td>
								<td align="left">
								<?  $interl = 0; if(($_POST)) { $interl = $_POST['international']; } 
									else { $interl = ($_GET['img_id']) ? $result['tloc_international'] : $_POST['international']; }?>
									<input type="radio" name="international" id="international" value="0" <?=($interl == 0) ? 'checked': '';?>>Domestic 
									<input type="radio" name="international" id="international" value="1" <?=($interl == 1) ? 'checked': '';?>>International
								</td>
							</tr>
                            <? $subcat_disp = ((!empty($_GET['img_id']) && !empty($result['subcat_id_fk'])) || !empty($_POST['cmb_subcat'])) ? '' : 'none'; ?>
                            <tr id="subcat_row" style="display:<?=$subcat_disp;?>">
                              <td class="sub_heading_black"><strong>Sub Category <span class="red">*</span></strong></td>
                              <td align="left" id="subcat_dropdown">
								<select name="cmb_subcat" id="cmb_subcat">
								  <option value="">Select Subcategory</option>
									<?php $cat = (!empty($_GET['img_id'])) ? $result['cat_id_fk'] : $_POST['cmb_cat'];
									$svr_query = mysql_query("select subcat_id, subcat_name from svr_subcategories where subcat_status=1 and cat_id_fk = '".$cat."' order by subcat_orderby");
									while($loc=mysql_fetch_array($svr_query)){?>
									<option value="<?=$loc['subcat_id'];?>" <? if(!empty($_GET['img_id']) && $loc['subcat_id']==$result['subcat_id_fk'])echo "selected";?>>
									  <?=$loc['subcat_name'];?></option><? }?>
								</select>                              
								</td>
                            </tr>
							<? $subsubcat_disp = ((!empty($_GET['img_id']) && !empty($result['subsubcat_id_fk'])) || !empty($_POST['cmb_subsubcat'])) ? '' : 'none'; ?>
                            <tr id="subsubcat_row" style="display:<?=$subsubcat_disp;?>">
                              <td class="sub_heading_black"><strong>Sub SubCategory <span class="red">*</span></strong></td>
                              <td align="left" id="subsubcat_dropdown">
								<select name="cmb_subsubcat" id="cmb_subsubcat">
								  <option value="">Select Sub Subcategory</option>
									<?php $subcat = (!empty($_GET['img_id'])) ? $result['subcat_id_fk'] : $_POST['cmb_subcat'];
									$svr_query = mysql_query("select subsubcat_id, subsubcat_name from svr_subsubcategories where subsubcat_status=1 and subcat_id_fk = '".$subcat."'");
									while($loc=mysql_fetch_array($svr_query)){?>
									<option value="<?=$loc['subsubcat_id'];?>" <? if(!empty($_GET['img_id']) && $loc['subsubcat_id']==$result['subsubcat_id_fk'])echo "selected";?>>
									  <?=$loc['subsubcat_name'];?></option><? }?>
								</select>                              </td>
                            </tr>
							<tr>
                              <td class="sub_heading_black"><strong>Tour Starts From <span class="red">*</span></strong></td>
                              <td align="left">
							  <select name="cmb_from" id="cmb_from">
							  <option value="">--Select From Location--</option>
                                <?php
								  	$svr_query = mysql_query("select floc_id, floc_name from svr_from_locations where floc_status=1 order by floc_name");
									while($loc=mysql_fetch_array($svr_query)){
									$from_selected =  ((!empty($_GET['img_id']) && $loc['floc_id'] == $result['tloc_floc_id']) || isset($_POST['cmb_from']) && $_POST['cmb_from'] == $loc['floc_id']) ? "selected" : '';?>
									<option value="<?=$loc['floc_id'];?>" <?=$from_selected?> ><?=$loc['floc_name'];?></option>
									<? }?>
                              </select>							  </td>
                            </tr>
                            <tr>
                              <td width="24%" class="sub_heading_black"><strong>Destination Location (Title) <span class="red">*</span></strong></td>
                              <td align="left"><input name="txtlocation" type="text" class="input" id="txtlocation" size="30" value="<? if(!empty($_POST['txtlocation'])){ echo $_POST['txtlocation'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_name']; } ?>" title="" /></td>
                            </tr>
							<tr>
                              <td class="sub_heading_black"><strong>Transport</strong></td>
                              <td align="left"><input name="txttransport" type="text" class="input" id="txttransport" size="30" value="<? if(!empty($_POST['txttransport'])){ echo $_POST['txttransport'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_transport']; } ?>" title="" /></td>
                            </tr>
							 <tr>
                              <td class="sub_heading_black"><strong>Pickup Point</strong></td>
                              <td align="left"><input name="txtpick" type="text" class="input" id="txtpick" size="30" value="<? if(!empty($_POST['txtpick'])){ echo $_POST['txtpick'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_pickup_point']; } ?>" title="" /></td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black"><strong>Cost PP</strong></td>
                              <td align="left"><input name="txtcost" type="text" class="input" id="txtcost" size="30"  value="<? if(!empty($_POST['txtcost'])){ echo $_POST['txtcost'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_costpp']; } ?>" title="" /></td>
                            </tr>
                            <tr>
                              <td width="24%" class="sub_heading_black"><strong>Location Code</strong></td>
                              <td align="left"><input name="txtcode" type="text" class="input" id="txtcode" size="30" value="<? if(!empty($_POST['txtcode'])){ echo $_POST['txtcode'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_code']; } ?>" title="" /></td>
                            </tr>
                            <tr>
                              <td width="24%" class="sub_heading_black"><strong>Location Type (No. of Days) <span class="red">*</span></strong></td>
                              <td align="left">
							  <input type="text" name="nights" id="nights" size="5" value="<? if(!empty($_POST['nights'])) echo $_POST['nights']; else if(!empty($_GET['img_id'])) echo $night ;?>" /> Nights 
							  <input type="text" name="days" id="days" size="5" value="<? if(!empty($_POST['days'])) echo $_POST['days']; else if(!empty($_GET['img_id'])) echo $day;?>"/> Days
							  
							  <?php /*?><input name="txttype" type="text" class="input" id="txttype" size="30"  value="<? if(!empty($_POST['txttype'])){ echo $_POST['txttype'];}else if(!empty($_GET['img_id'])){ echo $result['tloc_type']; } ?>" title="" /><?php */?></td>
                            </tr>
							 <tr>
                              <td valign="top" class="sub_heading_black"><strong>Places Covered</strong></td>
                              <td align="left"><textarea name="txt_places_covered" cols="50" rows="5" id="txt_places_covered"><? if(!empty($_POST['txt_places_covered'])){ echo $_POST['txt_places_covered'];} else if(!empty($_GET['img_id'])){ echo $result['tloc_places_covered'];} ?></textarea>
                              <br />
                              (enter palce names with <strong>comma</strong> seperated Ex: Delhi, Jammu)</td>
                            </tr>
							<tr>
						  <td width="24%"><strong>Time<span class="red">*</span></strong></td>
						  <td><!--<div id="sample1">-->
						  Departure <input name="departure" id="departure" value="<? if(!empty($_POST['departure'])) echo $_POST['departure']; else if(!empty($_GET['img_id'])) echo $deptime;?>" size="40" /> 						  
                          <!--</div>--></td>
						</tr>
					    <tr>
						      <td valign="top" class="sub_heading_black">&nbsp;</td>
						      <td align="left">Return <input name="return" id="return" value="<? if(!empty($_POST['return'])) echo $_POST['return']; else if(!empty($_GET['img_id'])) echo $rettime;?>" size="40" /></td>
				        </tr>
<tr>
<td valign="top" class="sub_heading_black"><strong>Cost Includes</strong></td>
<td align="left"><table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top"><? if(empty($_GET['img_id'])) {?>
<div id="phone_div">
<div id="add_divp">
<input type="hidden" name="add_hiddenp_1" id="add_hiddenp_1" value="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="73%" align="left"><input name="add_cost_includes1" type="text" class="box" id="add_cost_includes1" value="<? if(!empty($_POST['add_cost_includes1'])) echo $_POST['add_cost_includes1'];?>" size="60" /></td>
  <td width="27%" align="left"><input type="hidden" name="add_counthiddenp" id="add_counthiddenp" value="1" />
	  <img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="add_divp()"/></td>
</tr>
</table>
</div></div>
<? } else {?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="73%" align="left" valign="top"><div id="edit_divp">
	<?
	$p=1;
	for($pp=0;$pp<=$costinc_count;$pp++){	?>
	<div id='edit_subp_<?=$p;?>'>
	  <input type="hidden" name="edit_hiddenp_<?=$p;?>" id="edit_hiddenp_<?=$p;?>" value="1" />
	  <table border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="left"><input name="edit_cost_includes<?=$p;?>" type="text" class="box" id="edit_cost_includes<?=$p;?>" value='<?=$edit_phone[$pp];?>' size="60" /></td>
		  <td align="center">
		  <? if($p>1){?>
		  <img src="images/del.png" alt="Click to Delete" title="Click to Delete" onclick="close_edit_divp(<?=$p;?>)" width="16" height="16" border="0" style="cursor:pointer;" />
		  <? } else {?><img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="edit_divp()"/><? } ?></td>
		</tr>
	  </table>
	</div>
  <? $p++;}?>
</div></td>
<td width="27%" align="left" valign="top">
<input type="hidden" name="edit_counthiddenp_up" id="edit_counthiddenp_up" value="<?=$p-1;?>" />
<input type="hidden" name="edit_counthiddenp" id="edit_counthiddenp" value="<?=$p;?>" />											    </td>
</tr>
</table>
<script type="text/javascript"> js_editp=<?=$p-1?>; </script>
<? }?></td>
</tr>
</table></td>
</tr>
                            <tr>
                              <td valign="top" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top" class="sub_heading_black"><strong>Cost Excludes</strong></td>
                              <td align="left">
							  
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td align="left" valign="top"><? if(empty($_GET['img_id'])) {?>
	<div id="cost_exc_div">
		<div id="add_ce_divp">
		  <input type="hidden" name="add_ce_hiddenp_1" id="add_ce_hiddenp_1" value="1" />
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="73%" align="left"><input name="add_cost_excludes1" type="text" class="box" id="add_cost_excludes1" value="<? if(!empty($_POST['add_cost_excludes1'])) echo $_POST['add_cost_excludes1'];?>" size="60" /></td>
			  <td width="27%" align="left"><input type="hidden" name="add_ce_counthiddenp" id="add_ce_counthiddenp" value="1" />
				  <img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="add_ce_divp()"/></td>
			</tr>
		  </table>
		</div></div>
	  <? } else {?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="73%" align="left" valign="top"><div id="edit_ce_divp">
				<?
				$p=1;
				for($pp=0;$pp<=$costexc_count;$pp++){	?>
				<div id='edit_ce_subp_<?=$p;?>'>
				  <input type="hidden" name="edit_ce_hiddenp_<?=$p;?>" id="edit_ce_hiddenp_<?=$p;?>" value="1" />
				  <table border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td align="left"><input name="edit_cost_excludes<?=$p;?>" type="text" class="box" id="edit_cost_excludes<?=$p;?>" value='<?=$edit_cost_excludes[$pp];?>' size="60" /></td>
					  <td align="center">
					  <? if($p>1){?>
					  <img src="images/del.png" alt="Click to Delete" title="Click to Delete" onclick="close_edit_ce_divp(<?=$p;?>)" width="16" height="16" border="0" style="cursor:pointer;" />
					  <? } else {?><img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="edit_ce_divp()"/><? } ?></td>
					</tr>
				  </table>
				</div>
			  <? $p++;}?>
			</div></td>
			<td width="27%" align="left" valign="top">
<input type="hidden" name="edit_ce_counthiddenp_up" id="edit_ce_counthiddenp_up" value="<?=$p-1;?>" />
<input type="hidden" name="edit_ce_counthiddenp" id="edit_ce_counthiddenp" value="<?=$p;?>" />			</td>
		  </tr>
	  </table>
		<script type="text/javascript"> js_ce_editp=<?=$p-1?>; </script>
		<? }?></td>
  </tr>
</table>							  </td>
                            </tr>
                            <tr>
                              <td valign="top" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            
							
                            <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black"><strong>Upload Image (Thumbnail) <span class="red">*</span></strong></td>
                              <td align="left"><input type="file" name="image" id="image">
                                  <? if(!empty($_GET['img_id'])){ ?>
                                  <input type="hidden" name="old_img" id="old_img" value="<?=$result['tloc_image'];?>" />
                                  <a href="javascript:;" onclick="window.open('view_image.php?img_id=<?=$result['tloc_id'];?>','no','scrollbars=yes,menubar=no,width=750,height=400')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a>
                                  <?php /*?><a href="#" onclick="window.open('<?=$result['tloc_image'];?>','no','scrollbars=yes,width=600,height=300')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a><?php */?>
                                  <? }?></td>
                            </tr>
							  <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
							<tr>
                              <td valign="top" class="sub_heading_black"><strong>Notes1</strong></td>
                              <td align="left">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td align="left" valign="top"><? if(empty($_GET['img_id'])) {?>
	<div id="note_div">
		<div id="add_note_divp">
		  <input type="hidden" name="add_note_hiddenp_1" id="add_note_hiddenp_1" value="1" />
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="73%" align="left"><input name="add_note1" type="text" class="box" id="add_note1" value="<? if(!empty($_POST['add_note1'])) echo $_POST['add_note1'];?>" size="60" /></td>
			  <td width="27%" align="left"><input type="hidden" name="add_note_counthiddenp" id="add_note_counthiddenp" value="1" />
				  <img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="add_note_divp()"/></td>
			</tr>
		  </table>
		</div></div>
	  <? } else {?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="73%" align="left" valign="top"><div id="edit_note_divp">
				<?
				$p=1;
				for($pp=0;$pp<=$note_count;$pp++){	?>
				<div id='edit_note_subp_<?=$p;?>'>
				  <input type="hidden" name="edit_note_hiddenp_<?=$p;?>" id="edit_note_hiddenp_<?=$p;?>" value="1" />
				  <table border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td align="left"><input name="edit_note<?=$p;?>" type="text" class="box" id="edit_note<?=$p;?>" value='<?=$edit_note[$pp];?>' size="60" /></td>
					  <td align="center">
					  <? if($p>1){?>
					  <img src="images/del.png" alt="Click to Delete" title="Click to Delete" onclick="close_edit_note_divp(<?=$p;?>)" width="16" height="16" border="0" style="cursor:pointer;" />
					  <? } else {?><img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="edit_note_divp()"/><? } ?></td>
					</tr>
				  </table>
				</div>
			  <? $p++;}?>
			</div></td>
			<td width="27%" align="left" valign="top">
<input type="hidden" name="edit_note_counthiddenp_up" id="edit_note_counthiddenp_up" value="<?=$p-1;?>" />
<input type="hidden" name="edit_note_counthiddenp" id="edit_note_counthiddenp" value="<?=$p;?>" />			</td>
		  </tr>
	  </table>
		<script type="text/javascript"> js_note_editp=<?=$p-1?>; </script>
		<? }?></td>
  </tr>
</table></td>
                            </tr>
                            <tr>
                              <td valign="top" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
							<tr>
                              <td valign="top" class="sub_heading_black"><strong>Notes2</strong></td>
                              <td align="left">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td align="left" valign="top"><? if(empty($_GET['img_id'])) {?>
	<div id="note2_div">
		<div id="add_note2_divp">
		  <input type="hidden" name="add_note2_hiddenp_1" id="add_note2_hiddenp_1" value="1" />
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="73%" align="left"><input name="add_note3" type="text" class="box" id="add_note3" value="<? if(!empty($_POST['add_note3'])) echo $_POST['add_note3'];?>" size="60" /></td>
			  <td width="27%" align="left"><input type="hidden" name="add_note2_counthiddenp" id="add_note2_counthiddenp" value="1" />
				  <img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="add_note2_divp()"/></td>
			</tr>
		  </table>
		</div></div>
	  <? } else {?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="73%" align="left" valign="top"><div id="edit_note2_divp">
				<?
				$p=1;
				for($pp=0;$pp<=$note2_count;$pp++){	?>
				<div id='edit_note2_subp_<?=$p;?>'>
				  <input type="hidden" name="edit_note2_hiddenp_<?=$p;?>" id="edit_note2_hiddenp_<?=$p;?>" value="1" />
				  <table border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td align="left"><input name="edit_note2<?=$p;?>" type="text" class="box" id="edit_note2<?=$p;?>" value='<?=$edit_note2[$pp];?>' size="60" /></td>
					  <td align="center">
					  <? if($p>1){?>
					  <img src="images/del.png" alt="Click to Delete" title="Click to Delete" onclick="close_edit_note2_divp(<?=$p;?>)" width="16" height="16" border="0" style="cursor:pointer;" />
					  <? } else {?><img src="images/add.png" width="16" height="16" border="0" style="cursor:pointer;" onclick="edit_note2_divp()"/><? } ?></td>
					</tr>
				  </table>
				</div>
			  <? $p++;}?>
			</div></td>
			<td width="27%" align="left" valign="top">
<input type="hidden" name="edit_note2_counthiddenp_up" id="edit_note2_counthiddenp_up" value="<?=$p-1;?>" />
<input type="hidden" name="edit_note2_counthiddenp" id="edit_note2_counthiddenp" value="<?=$p;?>" />			</td>
		  </tr>
	  </table>
		<script type="text/javascript"> js_note2_editp=<?=$p-1?>; </script>
		<? }?></td>
  </tr>
</table>							  </td>
                            </tr>
							 <tr>
                              <td valign="top" class="sub_heading_black"><b>Banner Images</b></td>
                              <td align="left"><input name="upload[]" type="file" multiple="true"/>
						<? if(!empty($_GET['img_id']) && !empty($result['tloc_banner_image'])){
							$files = explode('|', $result['tloc_banner_image']);
							foreach($files as $key => $file)
								if($file)
									echo '<a href='.$path.$file.'>'.($key+1).'. '.basename($file).'</a>
									  	  <a href="add_to_location.php?img_id='.$_GET['img_id'].'&file='.$file.'"><i class="delicon"></i></a>&nbsp';
						   }?><br>(Hold the <strong>CTRL key </strong>to select multiple images of 800 x 225 dimension)</td>
                            </tr>
                            
                              <tr>
                              <td valign="top" class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black"><strong>Featured?</strong></td>
                              <td align="left"><input type="radio" name="featured" value="1" <? if(isset($_POST['featured']) && $_POST['featured']==1){echo "checked='checked'"; }else if(!empty($_GET['img_id'])){ if($result['tloc_featured']==1){?>checked="checked"<? }}?> /> Yes
					<input type="radio" name="featured" value="0" <? if(isset($_POST['featured']) && $_POST['featured']==0){echo "checked='checked'"; }else if(!empty($_GET['img_id'])){ if($result['tloc_featured']==0){?>checked="checked"<? }} else if(empty($_POST['featured'])){?> checked="checked"<? }?> /> No</td>
                            </tr>
                            <tr id="acc_type_row" style="display:<?=(!empty($_GET['img_id']) && $result['cat_id_fk']==1)? '' : 'none';?>">
                              <td class="sub_heading_black"><strong>Accomodation Types</strong></td>
                              <td align="left">
                    <input type="checkbox" name="ac" value="1" <?=(isset($_POST['ac']) || (!empty($_GET['img_id']) && !empty($ac))) ? "checked" : '';?> /> AC
					<input type="checkbox" name="non_ac" value="2" <?=(isset($_POST['non_ac']) || (!empty($_GET['img_id']) && !empty($non_ac))) ? "checked" : '';?> /> Non-AC                              </td>
                            </tr>
                            <tr  id="room_type_row" style="display:<?=(!empty($_GET['img_id']) && $result['cat_id_fk']==2)? '' : 'none';?>">
                              <td class="sub_heading_black"><strong>Room Types</strong></td>
                              <td align="left">
                    <input type="checkbox" name="standard" value="1" <?=(isset($_POST['standard']) || (!empty($_GET['img_id']) && !empty($standard))) ? "checked" : '';?> /> Standard
					<input type="checkbox" name="deluxe" value="2" <?=(isset($_POST['deluxe']) || (!empty($_GET['img_id']) && !empty($deluxe))) ? "checked" : '';?> /> Deluxe
					<input type="checkbox" name="luxury" value="3" <?=(isset($_POST['luxury']) || (!empty($_GET['img_id']) && !empty($luxury))) ? "checked" : '';?> /> Luxury                              </td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black">&nbsp;</td>
							  <td colspan="2" align="left"><input type="submit" name="Submit" id="Submit" value=" <?=$edit;?> " class="btn_input" onclick="return check_valid();" /></td>
                            </tr>
                            <tr>
                              <td class="sub_heading_black">&nbsp;</td>
                              <td align="left">&nbsp;</td>
							  <td align="left">&nbsp;</td>
                            </tr>
                    </table>
					</td>
                  </tr>
              </table></form>
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
  if(document.getElementById('cmb_cat').value==''){ alert("Please select Category"); document.getElementById('cmb_cat').focus(); return false;}
  if(document.getElementById('cmb_cat').value != 1){
  	if(document.getElementById('cmb_subcat').value==''){ alert("Please select SubCategory"); document.getElementById('cmb_subcat').focus(); return false;}
  }
  
  if(document.getElementById('cmb_subcat').value == 24 || document.getElementById('cmb_subcat').value == 25){
  	if(document.getElementById('cmb_subsubcat').value == ''){ alert("Please select SubSubCategory"); document.getElementById('cmb_subsubcat').focus(); return false;}
  }
  
  if(document.getElementById('cmb_from').value == ''){ alert("Please select Tour Starting From Location"); document.getElementById('cmb_from').focus(); return false; }
  if(document.getElementById('txtlocation').value==''){ alert("Please enter your location"); document.getElementById('txtlocation').focus(); return false;}
  if(document.getElementById('txtcode').value==''){ alert("Please enter location code"); document.getElementById('txtcode').focus(); return false;}
  if(document.getElementById('nights').value==''){ alert("Please enter number of nights"); document.getElementById('nights').focus(); return false;}
  if(isNaN(document.getElementById('nights').value)){ alert("Please enter numeric value"); document.getElementById('nights').focus(); return false;}
  if(document.getElementById('days').value==''){ alert("Please enter number of days"); document.getElementById('days').focus(); return false;}
  if(isNaN(document.getElementById('days').value)){ alert("Please enter numeric of value"); document.getElementById('days').focus(); return false;}
  if(document.getElementById('txt_places_covered').value==''){ alert("Please enter places"); document.getElementById('txt_places_covered').focus(); return false;}
  //if(document.getElementById('s1Time1').value==''){ alert("Please select departure time"); document.getElementById('s1Time1').focus(); return false;}
  //if(document.getElementById('s1Time2').value==''){ alert("Please select return time"); document.getElementById('s1Time2').focus(); return false;}
  if(document.getElementById('departure').value==''){ alert("Please enter departure time"); document.getElementById('departure').focus(); return false;}
  if(document.getElementById('return').value==''){ alert("Please enter return time"); document.getElementById('return').focus(); return false;}
  //if(document.getElementById('add_pickup1').value==''){ alert("Please enter pickup places"); document.getElementById('add_pickup1').focus(); return false;}
  if(document.getElementById('add_cost_includes1').value==''){ alert("Please enter Cost Includes"); document.getElementById('add_cost_includes1').focus(); return false;}
  if(document.getElementById('add_cost_excludes1').value==''){ alert("Please enter Cost Excludes"); document.getElementById('add_cost_excludes1').focus(); return false;}
  //if(document.getElementById('add_tnc1').value==''){ alert("Please enter Terms & Conditions"); document.getElementById('add_tnc1').focus(); return false;}
  if(document.getElementById('image').value==''){ alert("Please select image"); document.getElementById('image').focus(); return false;}
  if(document.getElementById('add_note1').value==''){ alert("Please enter Notes"); document.getElementById('add_note1').focus(); return false;}
}

//ADD Cost Includes - multiple
var js_addp=1;
function add_divp()
{
	js_addp++;
	document.form1.add_counthiddenp.value=js_addp; 
	var contentID = document.getElementById('phone_div');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','add_divp'+js_addp);
	tmp_var="<input type='hidden' name='add_hiddenp_"+js_addp+"' id='add_hiddenp_"+js_addp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='add_cost_includes"+js_addp+"' type='text' class='box' 	id='add_cost_includes"+js_addp+"' size='60'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td><img src='images/del.png'  title='Click to Delete !' alt='Click to Delete !' borde='0' style='cursor:pointer;' onclick='javascript:close_add_divp("+js_addp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_add_divp(js_addpid)
{
	document.getElementById("add_divp"+js_addpid).style.display='none';
	document.getElementById("phone_div").removeChild(document.getElementById("add_divp"+js_addpid));
	document.getElementById("add_hiddenp_"+js_addpid).value="0";
}
//ADD Cost Includes - multiple
//Edit
function edit_divp(){
	js_editp++;
	document.form1.edit_counthiddenp.value=js_editp; 
	var contentID = document.getElementById('edit_divp');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','edit_subp_'+js_editp); 		 
	tmp_var ="<input type='hidden' name='edit_hiddenp_"+js_editp+"' id='edit_hiddenp_"+js_editp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='edit_cost_includes"+js_editp+"' type='text' class='box' id='edit_cost_includes"+js_editp+"' size='60'/></td>";
	tmp_var+="<td align='center'><img src='images/del.png'  title='Click to Delete' alt='Click to Delete' borde='0' style='cursor:pointer;' onclick='javascript:close_edit_divp("+js_editp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_edit_divp(js_editp)
{
	document.getElementById("edit_subp_"+js_editp).style.display='none';
	document.getElementById("edit_divp").removeChild(document.getElementById("edit_subp_"+js_editp));
	document.getElementById("edit_hiddenp_"+js_editp).value="0";
}

//ADD Cost Excludes - multiple
var js_ce_addp=1;
function add_ce_divp()
{
	js_ce_addp++;
	document.form1.add_ce_counthiddenp.value=js_ce_addp; 
	var contentID = document.getElementById('cost_exc_div');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','add_ce_divp'+js_ce_addp);
	tmp_var="<input type='hidden' name='add_ce_hiddenp_"+js_ce_addp+"' id='add_ce_hiddenp_"+js_ce_addp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='add_cost_excludes"+js_ce_addp+"' type='text' class='box' id='add_cost_excludes"+js_ce_addp+"' size='60'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td><img src='images/del.png'  title='Click to Delete !' alt='Click to Delete !' borde='0' style='cursor:pointer;' onclick='javascript:close_add_ce_divp("+js_ce_addp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_add_ce_divp(js_ce_addpid)
{
	document.getElementById("add_ce_divp"+js_ce_addpid).style.display='none';
	document.getElementById("cost_exc_div").removeChild(document.getElementById("add_ce_divp"+js_ce_addpid));
	document.getElementById("add_ce_hiddenp_"+js_ce_addpid).value="0";
}

//Edit
function edit_ce_divp(){
	js_ce_editp++;
	document.form1.edit_ce_counthiddenp.value=js_ce_editp; 
	var contentID = document.getElementById('edit_ce_divp');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','edit_ce_subp_'+js_ce_editp); 		 
	tmp_var ="<input type='hidden' name='edit_ce_hiddenp_"+js_ce_editp+"' id='edit_ce_hiddenp_"+js_ce_editp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='edit_cost_excludes"+js_ce_editp+"' type='text' class='box' id='edit_cost_excludes"+js_ce_editp+"' size='60'/></td>";
	tmp_var+="<td align='center'><img src='images/del.png'  title='Click to Delete' alt='Click to Delete' borde='0' style='cursor:pointer;' onclick='javascript:close_edit_ce_divp("+js_ce_editp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_edit_ce_divp(js_ce_editp)
{
	document.getElementById("edit_ce_subp_"+js_ce_editp).style.display='none';
	document.getElementById("edit_ce_divp").removeChild(document.getElementById("edit_ce_subp_"+js_ce_editp));
	document.getElementById("edit_ce_hiddenp_"+js_ce_editp).value="0";
}

//ADD tnc - multiple
var js_note2_addp=1;
function add_note2_divp()
{
	js_note2_addp++;
	document.form1.add_note2_counthiddenp.value=js_note2_addp; 
	var contentID = document.getElementById('note2_div');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','add_note2_divp'+js_note2_addp);
	tmp_var="<input type='hidden' name='add_note2_hiddenp_"+js_note2_addp+"' id='add_note2_hiddenp_"+js_note2_addp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='add_note2"+js_note2_addp+"' type='text' class='box' id='add_note2"+js_note2_addp+"' size='60'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td><img src='images/del.png'  title='Click to Delete !' alt='Click to Delete !' borde='0' style='cursor:pointer;' onclick='javascript:close_add_note2_divp("+js_note2_addp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_add_note2_divp(js_note2_addpid)
{
	document.getElementById("add_note2_divp"+js_note2_addpid).style.display='none';
	document.getElementById("note2_div").removeChild(document.getElementById("add_note2_divp"+js_note2_addpid));
	document.getElementById("add_note2_hiddenp_"+js_note2_addpid).value="0";
}

//Edit
function edit_note2_divp(){
	js_note2_editp++;
	document.form1.edit_note2_counthiddenp.value=js_note2_editp; 
	var contentID = document.getElementById('edit_note2_divp');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','edit_note2_subp_'+js_note2_editp); 		 
	tmp_var ="<input type='hidden' name='edit_note2_hiddenp_"+js_note2_editp+"' id='edit_note2_hiddenp_"+js_note2_editp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='edit_note2"+js_note2_editp+"' type='text' class='box' id='edit_note2"+js_note2_editp+"' size='60'/></td>";
	tmp_var+="<td align='center'><img src='images/del.png'  title='Click to Delete' alt='Click to Delete' borde='0' style='cursor:pointer;' onclick='javascript:close_edit_note2_divp("+js_note2_editp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_edit_note2_divp(js_tnc_editp)
{
	document.getElementById("edit_note2_subp_"+js_note2_editp).style.display='none';
	document.getElementById("edit_note2_divp").removeChild(document.getElementById("edit_note2_subp_"+js_note2_editp));
	document.getElementById("edit_note2_hiddenp_"+js_note2_editp).value="0";
}

//ADD notes - multiple
var js_note_addp=1;
function add_note_divp()
{
	js_note_addp++;
	document.form1.add_note_counthiddenp.value=js_note_addp; 
	var contentID = document.getElementById('note_div');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','add_note_divp'+js_note_addp);
	tmp_var="<input type='hidden' name='add_note_hiddenp_"+js_note_addp+"' id='add_note_hiddenp_"+js_note_addp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='add_note"+js_note_addp+"' type='text' class='box' id='add_note"+js_note_addp+"' size='60'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td><img src='images/del.png'  title='Click to Delete !' alt='Click to Delete !' borde='0' style='cursor:pointer;' onclick='javascript:close_add_note_divp("+js_note_addp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_add_note_divp(js_note_addpid)
{
	document.getElementById("add_note_divp"+js_note_addpid).style.display='none';
	document.getElementById("note_div").removeChild(document.getElementById("add_note_divp"+js_note_addpid));
	document.getElementById("add_note_hiddenp_"+js_note_addpid).value="0";
}

//Edit
function edit_note_divp(){
	js_note_editp++;
	document.form1.edit_note_counthiddenp.value=js_note_editp; 
	var contentID = document.getElementById('edit_note_divp');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','edit_note_subp_'+js_note_editp); 		 
	tmp_var ="<input type='hidden' name='edit_note_hiddenp_"+js_note_editp+"' id='edit_note_hiddenp_"+js_note_editp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='edit_note"+js_note_editp+"' type='text' class='box' id='edit_note"+js_note_editp+"' size='60'/></td>";
	tmp_var+="<td align='center'><img src='images/del.png'  title='Click to Delete' alt='Click to Delete' borde='0' style='cursor:pointer;' onclick='javascript:close_edit_note_divp("+js_note_editp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_edit_note_divp(js_note_editp)
{
	document.getElementById("edit_note_subp_"+js_note_editp).style.display='none';
	document.getElementById("edit_note_divp").removeChild(document.getElementById("edit_note_subp_"+js_note_editp));
	document.getElementById("edit_note_hiddenp_"+js_note_editp).value="0";
}

//ADD pickup places - multiple
var js_pickup_addp=1;
function add_pickup_divp()
{
	js_pickup_addp++;
	document.form1.add_pickup_counthiddenp.value=js_pickup_addp; 
	var contentID = document.getElementById('pickup_div');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','add_pickup_divp'+js_pickup_addp);
	tmp_var="<input type='hidden' name='add_pickup_hiddenp_"+js_pickup_addp+"' id='add_pickup_hiddenp_"+js_pickup_addp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='add_pickup"+js_pickup_addp+"' type='text' class='box' id='add_pickup"+js_pickup_addp+"' size='60'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td><img src='images/del.png'  title='Click to Delete !' alt='Click to Delete !' borde='0' style='cursor:pointer;' onclick='javascript:close_add_pickup_divp("+js_pickup_addp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_add_pickup_divp(js_pickup_addpid)
{
	document.getElementById("add_pickup_divp"+js_pickup_addpid).style.display='none';
	document.getElementById("pickup_div").removeChild(document.getElementById("add_pickup_divp"+js_pickup_addpid));
	document.getElementById("add_pickup_hiddenp_"+js_pickup_addpid).value="0";
}

//Edit
function edit_pickup_divp(){
	js_pickup_editp++;
	document.form1.edit_pickup_counthiddenp.value=js_pickup_editp; 
	var contentID = document.getElementById('edit_pickup_divp');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','edit_pickup_subp_'+js_pickup_editp); 		 
	tmp_var ="<input type='hidden' name='edit_pickup_hiddenp_"+js_pickup_editp+"' id='edit_pickup_hiddenp_"+js_pickup_editp+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='edit_pickup"+js_pickup_editp+"' type='text' class='box' id='edit_pickup"+js_pickup_editp+"' size='60'/></td>";
	tmp_var+="<td align='center'><img src='images/del.png' title='Click to Delete' alt='Click to Delete' borde='0' style='cursor:pointer;' onclick='javascript:close_edit_pickup_divp("+js_pickup_editp+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_edit_pickup_divp(js_pickup_editp)
{
	document.getElementById("edit_pickup_subp_"+js_pickup_editp).style.display='none';
	document.getElementById("edit_pickup_divp").removeChild(document.getElementById("edit_pickup_subp_"+js_pickup_editp));
	document.getElementById("edit_pickup_hiddenp_"+js_pickup_editp).value="0";
}

$(document).ready(function(){
	// find the input fields and apply the time select to them.
	$('#sample1 input').ptTimeSelect();
	$('#sample2 input').ptTimeSelect();
});

function show_hide(id){ 
	if(id==1){
		document.getElementById('acc_type_row').style.display="";
		document.getElementById('room_type_row').style.display="none";
		document.getElementById('international_row').style.display = "";
	}else if(id==2){
		document.getElementById('room_type_row').style.display="";
		document.getElementById('acc_type_row').style.display="none";
		document.getElementById('international_row').style.display = "none";
	}else{
		document.getElementById('room_type_row').style.display="none";
		document.getElementById('acc_type_row').style.display="none";
		document.getElementById('international_row').style.display = "none";
	}
}
</script>