<? ob_start(); //session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");
if((isset($_SESSION['tm_type'])) && ($_SESSION['tm_type']=='admin' || ($_SESSION['tm_type']=='subadmin' && isset($_SESSION['seasons_manage']) && $_SESSION['seasons_manage']=='yes' ) ) ){}else{header("location:welcome.php");}if($_SERVER['REQUEST_METHOD']=="POST"){$email="";	for($e=0;$e<=10;$e++)	{		if(!empty($_POST['email'.$e]))		{		$email.=$_POST['email'.$e].", ";		}	}$email=substr($email,0,-2);$email_replace=str_replace("'","&#39;",$email);	if(!empty($_GET['s_id']))	{	$up=mysql_query("update svr_tour_seasons set tloc_id_fk='".$_POST['dest_name']."',season_season='".$email_replace."',season_bustype='".$_POST['sel_bustype']."' where season_id='".$_GET['s_id']."'");	header("location:add_manage_seasons.php");	}else{	mysql_query("insert into svr_tour_seasons(tloc_id_fk,season_season,season_bustype,season_status,season_dateadded) values('".$_POST['dest_name']."','".$email_replace."','".$_POST['sel_bustype']."',1,'".$now_time."')");	 header("location:add_manage_seasons.php");	}}if(!empty($_GET['s_id'])){	$row = mysql_query("select * from svr_tour_seasons where season_id='".$_GET['s_id']."'");	$result = mysql_fetch_array($row);}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta name="Website Design, Development, Maintenance & Powered by BitraNet Pvt. Ltd.," CONTENT="http://www.bitranet.com"><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"><link href="css/site.css" rel="stylesheet" type="text/css"><link href="css/styles.css" rel="stylesheet" type="text/css" /><script language="javascript" src="../includes/script_valid.js"></script></head><body><table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">  <tr>    <td align="left" valign="top" bgcolor="#FFFFFF" class="head_bg brdrb"><? include_once("header.php");?></td>  </tr>  <tr>    <td valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">        <tr>          <td><img src="images/spacer.gif" border="0" height="5" /></td>        </tr>        <tr>          <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">              <tr>                <td valign="middle" width="50%"><img src="images/home-icon.gif" alt="" width="11" height="13" /><strong style="font-size:12px"> <a href="welcome.php">Home</a> &raquo; Manage Seasons </strong></td>                <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">                    <tr>                      <td valign="top" class="grn_subhead" align="right">&nbsp;</td>                    </tr>                  </table></td>              </tr>            </table></td>        </tr>        <tr>          <td>&nbsp;</td>        </tr>        <tr>          <td><form action="" method="post" name="form1" id="form1" onsubmit="return chk_valid()" enctype="multipart/form-data">              <table width="65%" border="0" align="center" cellpadding="0" cellspacing="0">                <tr>                  <td>&nbsp;</td>                </tr>                <tr>                  <td valign="top"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="1" class="bor_task datatable">                      <tr>                        <td width="2%" rowspan="9" align="left" class="sub_heading_black">&nbsp;</td>                        <td width="25%" align="left" class="sub_heading_black">&nbsp;</td>                        <td width="75%" align="right" style="font-size:11px; color:#666666;"><span class="red">*</span> Fields are Compulsory</td>                      </tr>                      <tr>                        <td width="25%" class="sub_heading_black"><strong>Destination Name <span class="red">*</span></strong></td>                        <td align="left"><select name="dest_name" id="dest_name">                            <option value="">--- Select ---</option>                            <?							  $dest_name = mysql_query("select * from svr_to_locations where tloc_status=1 order by tloc_id desc");							  while($dest_fetch = mysql_fetch_array($dest_name)){							    ?>                            <option value="<?=$dest_fetch['tloc_id'];?>"<? if(!empty($_GET['s_id'])){ if($dest_fetch['tloc_id']==$result['tloc_id_fk']){ echo "selected";} }?>>                            <?=$dest_fetch['tloc_name']; ?>                            </option>                            <? }?>                          </select>                        </td>                      </tr>                      <tr>                        <td width="25%" valign="top" class="sub_heading_black"><strong>Seasons <span class="red">*</span></strong></td>                        <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">                            <? if(empty($_GET['id'])) {?>                            <tr>                              <td align="left"><div id="mastere">                                  <div id="ac_gce">                                    <input type="hidden" name="ac_gc_valide_1" id="ac_gc_valide_1" value="1" />                                    <table border="0" cellspacing="0" cellpadding="0">                                      <tr>                                        <td align="left"><input name="email1" type="text" class="box" id="email1" value="<? if(!empty($_GET['s_id'])){ echo $result['season_season'];}?>" size="35" /></td>                                        <td>&nbsp;</td>                                        <td align="center"><input type="hidden" name="p_email" id="p_email" value="1" />                                          <img src="images/add.png" style="cursor:pointer;" border="0" onclick="add_ac_gce()"/></td>                                      </tr>                                    </table>                                  </div>                                </div></td>                            </tr>                            <? } else {?>                            <tr>                              <td align="left"><div id="ac_gce1">                                  <? $e=1; for($ee=0;$ee<=$m;$ee++){ ?>                                  <div id='ac_gc_sub_<?=$e;?>'>                                    <input type="hidden" name="ac_gc_valide1_<?=$e;?>" id="ac_gc_valide1_<?=$e;?>" value="1" />                                    <table border="0" cellpadding="0" cellspacing="0">                                      <tr>                                        <td align="left"><input name="email<?=$e;?>" type="text" class="box" id="email<?=$e;?>" value='<?=$ex_email[$ee];?>' size="35" /></td>                                        <td align="center"><? if($e>1){?>                                          <img src="images/del.png"  onclick="close_ac_gce1(<?=$e;?>)" width="16" height="16" border="0" style="cursor:pointer;" />                                          <? } if($e==1 || $e==0){?>                                          <img src="images/add.png" style="cursor:pointer;" border="0"  onclick="add_ac_gce1()"/>                                          <? }?></td>                                      </tr>                                    </table>                                  </div>                                  <? $e++;}?>                                </div>                                <input type="hidden" name="p_email_up" id="p_email_up" value="<?=$e-1;?>" />                                <input type="hidden" name="p_email" id="p_email" value="<?=$e;?>" />                                <script type="text/javascript">js_acgce1=<?=$e-1;?>;</script></td>                            </tr>                            <? }?>                          </table></td>                        <!--<input name="txt_seasons" type="text" class="input" id="txt_seasons" size="30"  value="<? //if(!empty($_GET['s_id'])){ echo $result['season_season'];}?>" title="" />-->                      </tr>                      <tr>                        <td width="25%" class="sub_heading_black"><strong>Bus Type <span class="red">*</span></strong></td>                        <td align="left"><select name="sel_bustype" id="sel_bustype">                            <option value="">--- Select Bustype---</option>                            <option value="AC"<? if(!empty($_GET['s_id'])){ if($result['season_bustype']=='AC'){ echo "selected";}}?>>AC</option>                            <option value="Non_AC"<? if(!empty($_GET['s_id'])){ if($result['season_bustype']=='Non_AC'){ echo "selected";}}?>>Non AC</option>                          </select></td>                      </tr>                      <tr align="center">                        <td align="center">&nbsp;</td>                        <td align="left"><input type="submit" name="Submit" id="Submit" value="<? if(!empty($_GET['s_id'])){ echo "Edit";}else { echo "Add";}?>  " class="btn_input" onclick="return check_valid();" /></td>                      </tr>                    </table></td>                </tr>              </table>            </form></td>        </tr>        <tr>          <td>&nbsp;</td>        </tr>        <tr>          <td><table width="95%" border="0" cellspacing="0" cellpadding="6">              <tr>                <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">                    <thead>                      <tr>                        <td width="5%" height="20" class="tablehead"><strong>S.No</strong></td>                        <td colspan="2" class="tablehead"><strong>Destination Location � Season</strong></td>                        <td width="15%" class="tablehead"><strong>Bus Type </strong></td>                        <td width="5%" align="center" class="tablehead"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></td>                        <td width="5%" align="center" class="tablehead"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></td>                        <td width="5%" align="center" class="tablehead"><img src="images/active.png" alt="Status" title="Status" width="16" height="16" /></td>                      </tr>                    </thead>					<?php					if(!empty($_GET['s_status'])){						if($_GET['s_status']=="active")						{							$status=1;						}else{							$status=0;						}					mysql_query("update svr_tour_seasons set season_status=".$status." where season_id='".$_GET['sid']."'");					header("location:add_manage_seasons.php");					}					$qry = mysql_query("select tloc_id, tloc_name from svr_to_locations where tloc_status=1");					$h=0;					while($qry_arr=mysql_fetch_array($qry)){					$h++;					?>                    <tr>                      <td height="25" align="left"><?=$h;?>.</td>                      <td colspan="6" align="left"><strong><?=$qry_arr['tloc_name'];?></strong></td>                    </tr>                    <?						$result = mysql_query("select * from svr_tour_seasons where tloc_id_fk=".$qry_arr['tloc_id']);						$count_order = mysql_num_rows($result);						$sno = 0; if($count_order>0){						while($fetch=mysql_fetch_array($result)){						$sno++;										if($fetch['season_status']==1){							$s_status ='<a href="add_manage_seasons.php?sid='.$fetch["season_id"].'&s_status=inactive">							<img src="images/active.png" width="18" height="18" border="0" title="click to inactive" /></a>';						}else if($fetch['season_status']==0){							$s_status='<a href="add_manage_seasons.php?sid='.$fetch["season_id"].'&s_status=active">							<img src="images/inactive.png" width="18" height="18" border="0" title="click to active" /></a>';						}					?>                    <tr class="<? if($sno%2==0){ echo "tablerow2";} else {echo "tablerow1";}?>">                      <td width="5%" height="25" align="left">&nbsp;</td>                      <td width="5%" align="left"><?=$sno;?>.</td>                      <td align="left"><?=$fetch['season_season'];?></td>                      <td width="15%" align="left"><?=$fetch['season_bustype'];?></td>                      <td width="5%" align="center"><a href="javascript:;" onClick="window.open('view_season.php?s_id=<?=$fetch['season_id'];?>','no','scrollbars=yes,menubar=no,width=600,height=350')"><img src="images/view.gif" alt="View" title="View" width="16" height="16" /></a></td>                      <td width="5%" align="center"><a href="add_manage_seasons.php?s_id=<?=$fetch['season_id'];?>"><img src="images/edit.png" alt="Edit" title="Edit" width="16" height="16" /></a></td>                      <td width="5%" align="center"><?=$s_status;?></td>                    </tr>                    <? 		  			}} else if($count_order==0){ ?>                    <tr>                      <td colspan="12" height="50" align="center" bgcolor="#CCC" class="red">No Records Found</td>                    </tr>                    <? }}?>                  </table></td>              </tr>            </table></td>        </tr>        <tr>          <td align="center">&nbsp;</td>        </tr>      </table></td>  </tr>  <tr>    <td class="fbg"><? include_once("footer.php");?></td>  </tr></table></body></html><script type="text/javascript">function check_valid(){  if(document.getElementById('dest_name').value==''){ alert("Please select your location"); document.getElementById('dest_name').focus(); return false;}  if(document.getElementById('sel_bustype').value==''){ alert("Please select Bus type"); document.getElementById('sel_bustype').focus(); return false;}  if(document.getElementById('email<?=$e;?>').value==''){ alert("Please enter season months"); document.getElementById('email<?=$e;?>').focus(); return false;}}</script><script language="javascript">var js_acgce=1;function add_ac_gce(){	js_acgce++;	document.form1.p_email.value=js_acgce; 	var contentID = document.getElementById('mastere');	var newTBDiv = document.createElement('div');	newTBDiv.setAttribute('id','ac_gce'+js_acgce);	tmp_var ="<input type='hidden' title="+js_acgce+" name='ac_gc_valide_"+js_acgce+"' id='ac_gc_valide_"+js_acgce+"' value='1'>"	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";	tmp_var+="<td><input name='email"+js_acgce+"' type='text' class='box' id='email"+js_acgce+"' size='35'/></td>";	tmp_var+="<td>&nbsp;</td>";	tmp_var+="<td align='center'><img src='images/del.png' title='Click to Delete !' style='cursor:pointer;' alt='Click to Delete !' border='0' onclick='javascript:close_ac_gce("+js_acgce+")' /></td></tr></table>";	newTBDiv.innerHTML=tmp_var;	contentID.appendChild(newTBDiv);}function close_ac_gce(ac_gce_id){	document.getElementById("ac_gce"+ac_gce_id).style.display='none';	document.getElementById("mastere").removeChild(document.getElementById("ac_gce"+ac_gce_id));	document.getElementById("ac_gc_valide_"+ac_gce_id).value="0";}function add_ac_gce1(){	js_acgce1++;	document.form1.p_email.value=js_acgce1; 	var contentID = document.getElementById('ac_gce1');	var newTBDiv = document.createElement('div');	newTBDiv.setAttribute('id','ac_gc_sub_'+js_acgce1);	tmp_var ="<input type='hidden' name='ac_gc_valide1_"+js_acgce1+"' id='ac_gc_valide1_"+js_acgce1+"' value='1'>"	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";	tmp_var+="<td><input name='email"+js_acgce1+"' type='text' class='box' id='email"+js_acgce1+"' size='35'/></td>";	tmp_var+="<td align='center'><img src='images/del.png' style='cursor:pointer;' title='Click to Delete !' alt='Click to Delete !' border='0' onclick='javascript:close_ac_gce1("+js_acgce1+")'/></tr></table>";	newTBDiv.innerHTML=tmp_var;	contentID.appendChild(newTBDiv);}function close_ac_gce1(ac_gce1_id){	document.getElementById("ac_gc_sub_"+ac_gce1_id).style.display='none';	document.getElementById("ac_gce1").removeChild(document.getElementById("ac_gc_sub_"+ac_gce1_id));	document.getElementById("ac_gc_valide1_"+ac_gce1_id).value="0";}</script>