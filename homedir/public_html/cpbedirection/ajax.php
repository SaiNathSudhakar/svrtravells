<?
ob_start();
//session_start();
include_once("../includes/functions.php");
include_once("login_chk.php");

////////////FARE CATEGORY PAGE////////////
if(!empty($_POST['fares_cat']) && !empty($_POST['fare_type'])) { 
	if($_POST['fare_type'] == 1) { 
		$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 1 and tloc_status = 1 order by tloc_orderby");
	?>
	<select name="sel_destination[]" class="sel_destination" multiple style="width:300px;">
	   <?php while($loc=fetch_array($svr_query)){ ?>
	   <option value="<?=$loc['tloc_id'];?>"><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
	   <? }?>
	</select>
<? } if($_POST['fare_type'] == 2) { ?>
	<? $svr_subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1 order by subcat_orderby"); ?>
	<select name="sel_destination[]" class="sel_destination" multiple style="width:300px;">
	   <?php while($sloc=fetch_array($svr_subq)){ 
			$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 2 and subcat_id_fk = '".$sloc['subcat_id']."' and tloc_status=1 order by tloc_orderby"); if(num_rows($svr_query) > 0) { ?>
			<optgroup label="<?=$sloc['subcat_name']?>">
			<? while($loc = fetch_array($svr_query)) { ?>
				<option value="<?=$loc['tloc_id'];?>">&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
	   <? }}?></optgroup> <? }?>
	</select>
	<? }
} else if(!empty($_POST['fare_type']) && !empty($_POST['fare_name'])) { 
	if($_POST['fare_type'] == 1){?>
	<input name="name" type="text" class="input" id="name" size="35" /> Eg. Adult
	<? } else if($_POST['fare_type'] == 2){?>
	  <select name="name" id="name" style="width:150px">
		<option value="">Select Vehicle</option>
		<? $q = query('select v.v_id, concat(veh.vp_name, " ", pax.vp_name, " PAX") as vehicle from svr_vehicles_with_pax as v
			left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
				left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id ');
		while($row = fetch_array($q)){?>
			<option value="<?=$row['v_id']?>"><?=$row['vehicle']?></option>
		<? }?>
	  </select>
	<? }
}

////////////FARES PAGE////////////
if(!empty($_POST['fares']) && !empty($_POST['fare_type'])) { 
	if($_POST['fare_type'] == 1) { 
		$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 1 and tloc_status=1 order by tloc_orderby");
	?>
	<select name="sel_destination" id="sel_destination" style="width:300px;">
    <option value="">--Select Location--</option>
	   <?php while($loc=fetch_array($svr_query)){ ?>
	   <option value="<?=$loc['tloc_id'];?>"><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
	   <? }?>
	</select>
<? } if($_POST['fare_type'] == 2) { 
		$subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk=2 and subcat_status=1 order by subcat_orderby");
	?>
	<select name="sel_subcategory" id="sel_subcategory" style="width:300px;">
       <option value="">Select Tour Package</option>
       <?php while($sub=fetch_array($subq)){ ?>
       <option value="<?=$sub['subcat_id'];?>"><?=$sub['subcat_name'];?></option>
       <? }?>
    </select>
	<?
	}
} if(!empty($_POST['fares']) && !empty($_POST['subcat'])) { 
	$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where subcat_id_fk = ".$_POST['subcat']." and tloc_status=1 order by tloc_orderby desc");?>
	<select name="sel_destination" id="sel_destination" style="width:300px;">
      <option value="">--Select Location--</option>
	   <?php while($loc=fetch_array($svr_query)){ ?>
	   <option value="<?=$loc['tloc_id'];?>"><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
	   <? }?>
	</select>
<? } if(!empty($_POST['fares']) && !empty($_POST['dest'])) {	
	$ac_query = query("select cat_id_fk, tloc_acc_type, tloc_room_type from svr_to_locations where tloc_id = ".$_POST['dest']);
	$ac = fetch_array($ac_query);
	if($ac['cat_id_fk'] == 1) $acc = $ac['tloc_acc_type'];
	else $acc = $ac['tloc_room_type'];
	
	$ac_types = explode('|', $acc);
	$ac_types = array_filter($ac_types);
?>
<table width="100%" align="left"><tr>
	<? $colspan = (sizeof($ac_types) == 0) ? '2' : (sizeof($ac_types)+1); ?>
    <td width="20%" colspan="<?=$colspan?>">&nbsp;</td>
    <? foreach($ac_types as $ac_type){?>
    <td align="left"><strong><?=($ac['cat_id_fk'] == 1) ? $accomodation_type[$ac_type] : $room_type[$ac_type];?> Fare</strong></td>
    <? }?>
  </tr>
  <? 
  	$cond = (!empty($ac['cat_id_fk'])) ? " and fc_type = ".$ac['cat_id_fk'] : ""; 
  	$fc_query = query("select fc_type, fc_id, fc_name, concat(veh.vp_name, ' ', pax.vp_name, ' PAX') as vehicle from svr_fare_category  as fc
		left join svr_vehicles_with_pax as v on v.v_id = fc.fc_name 
			left join svr_vehicles_pax as veh on veh.vp_id = v.v_vehicle_id 
				left join svr_vehicles_pax as pax on pax.vp_id = v.v_pax_id
					where 1 ".$cond." and fc_status = 1 and FIND_IN_SET('".$_POST['dest']."', fc_locations)");
  	$count = num_rows($fc_query);
	if($count > 0){ 
		 if(sizeof($ac_types) == 0){?><tr><td colspan="<?=$colspan+2?>" align="center">
		 <?=($ac['cat_id_fk'] == 1) ? 'Accomodation' : 'Room';?> Types for this Location not Set</td></tr><? }?>
	<? $i = 0;
	  while($fare_cat = fetch_array($fc_query)){?>
	  <tr>
		<td colspan="<?=$colspan;?>"><strong> <?=($fare_cat['fc_type'] == 1) ? $fare_cat['fc_name'] : $fare_cat['vehicle'];?></strong> <span class="red">*</span>
		<input type="hidden" name="fare_cat[]" value="<?=$fare_cat['fc_id'];?>"></td>
		<? foreach($ac_types as $key => $ac_type){?>
		<td><input type="text" name="fare[<?=$i?>][<?=$key?>]" value=""></td>
		<? }?>
	  </tr>
	  <? $i++; }?> 
	  <tr>
		<td colspan="<?=$colspan+2;?>">&nbsp;</td>
	  </tr><? if(sizeof($ac_types) > 0){ ?>
	  <tr>
	  	<td colspan="<?=$colspan+2;?>" align="center"><input type="submit" name="Submit" id="Submit" value=" Save " class="btn_input" /></td>
	  </tr><? }?>
	<? } else {?>
  		<tr><td colspan="<?=$colspan+2;?>" align="center">No Fare Categories Found</td></tr>
  	<? }?>
</table>
<? } 

////////////FROM LOCATION PAGE////////////
if(!empty($_POST['from_loc']) && !empty($_POST['type']) && empty($_POST['package']))
{	
	if($_POST['type'] == 1){ 
		$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 1 and tloc_status=1 order by tloc_orderby desc"); ?>
		<select name="sel_destination[]" id="sel_destination" multiple style="width:300px;" class="fixed">
		   <?php while($loc=fetch_array($svr_query)){ ?>
		   <option value="<?=$loc['tloc_id'];?>"><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
		   <? }?>
		</select>
<? } if($_POST['type'] == 2){ ?>
		<? $svr_subq = query("select cat_id_fk, subcat_id, subcat_name from svr_subcategories where cat_id_fk = 2 and subcat_status = 1 order by subcat_orderby"); ?>
		<select name="sel_destination[]" id="sel_destination" multiple style="width:300px;" class="package">
		   <?php while($sloc=fetch_array($svr_subq)){ 
		   		$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where cat_id_fk = 2 and subcat_id_fk = '".$sloc['subcat_id']."' and tloc_status=1 order by tloc_orderby desc"); if(num_rows($svr_query) > 0){?>
				<optgroup label="<?=$sloc['subcat_name']?>">
				<? while($loc = fetch_array($svr_query)){?>
		   			<option value="<?=$loc['tloc_id'];?>">&nbsp;&raquo;&nbsp;<?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
		   <? }}?></optgroup> <? }?>
		</select>
<? }
}

////////////PACKAGES PAGE//////////// ?>
<?php /*?><? if(!empty($_POST['package']) && $_POST['package'] == 1 && !empty($_POST['type']) && empty($_POST['from_loc']))
{	
	$svr_query = query("select floc_id, floc_name from svr_from_locations as floc
		left join svr_tour_locations as trl on floc.floc_id = trl.trl_floc_id
			where trl_type = ".$_POST['type']." and trl_status = 1 order by floc_id"); ?>
	<select name="sel_from_loc" id="sel_from_loc">
	   <option value="">Select From Location</option>
	   <?php while($row = fetch_array($svr_query)) { ?>
	   <option value="<?=$row['floc_id'];?>"><?=ucwords(strtolower($row['floc_name']));?></option>
	   <? }?>
	</select>
<? } else if(!empty($_POST['package']) && $_POST['package'] == 2 && !empty($_POST['type']) && !empty($_POST['from_loc'])) {	
	$svr_query = query("select group_concat(tloc.tloc_id order by tloc_orderby desc) as to_ids, group_concat(tloc.tloc_name order by tloc_orderby desc) as to_locations from svr_tour_locations as trl 
		left join svr_to_locations as tloc on FIND_IN_SET(tloc.tloc_id, trl.trl_tloc_id)
			where trl_floc_id = '".$_POST['from_loc']."' and trl_type = '".$_POST['type']."' group by trl_id");
	$row = fetch_array($svr_query);
	$to_locations = array_combine(explode(',', $row['to_ids']), explode(',', $row['to_locations'])); ?>
	<select name="sel_to_loc" id="sel_to_loc">
	   <option value="">Select To Location</option>
	   <?php foreach($to_locations as $key => $val) { ?>
	   <option value="<?=$key;?>"><?=ucwords(strtolower($val));?></option>
	   <? }?>
	</select>
<? } else ?><?php */?>
<? if(!empty($_POST['package']) && $_POST['package'] == 3  && !empty($_POST['dest'])) {	
	//&& !empty($_POST['type'])
	$ac_query = query("select cat_id_fk, tloc_acc_type, tloc_room_type from svr_to_locations where cat_id_fk = 1 and tloc_id = ".$_POST['dest']);
	$ac = fetch_array($ac_query);
	
	$acc = $ac['tloc_acc_type'];
		
	$ac_types = explode('|', $acc);
	$ac_types = array_filter($ac_types); ?>
	
	<table width="100%" align="left">
	  <tr>
		<td width="25%">&nbsp;</td>
		<? foreach($ac_types as $ac_type){?>
		  <td align="left"><strong><?=($ac['cat_id_fk'] == 1) ? $accomodation_type[$ac_type] : $room_type[$ac_type];?></strong></td>
		<? } ?>
	  </tr>
	  <tr>
		<td><strong>Seats Available</strong> <span class="red">*</span></td>
		<? foreach($ac_types as $key => $ac_type){ ?>
		  <td><!--<input type="text" name="seats[<?=$key?>]">-->
          	<select name="seats[<?=$key?>]" id="seats[<?=$key?>]" required>
                <option value="">Select Seats Available</option>
                <option value="12">12</option>
                <option value="25">25</option>
                <option value="27">27</option>
                <option value="40">40</option>
                <option value="45">45</option>
            </select></td>
		<? }?>
	  </tr>
	 </table>		
<? }

////////////DESTINATION LOCATIONS PAGE////////////
if(!empty($_POST['cat']) && !empty($_POST['to_loc']) && $_POST['to_loc'] == 1){
	$svr_query = query("select subcat_id, subcat_name from svr_subcategories where subcat_status = 1 and cat_id_fk = '".$_POST['cat']."' order by subcat_orderby"); ?>
    <select name="cmb_subcat" id="cmb_subcat">
  		<option value="">Select Subcategory</option>
		<? while($row = fetch_array($svr_query)){ ?>
		<option value="<?=$row['subcat_id'];?>"><?=$row['subcat_name'];?></option>
		<? }?>
    </select>
<? }if(!empty($_POST['subcat']) && !empty($_POST['to_loc']) && $_POST['to_loc'] == 2){
	$svr_query = query("select subsubcat_id, subsubcat_name from svr_subsubcategories where subsubcat_status = 1 and subcat_id_fk = '".$_POST['subcat']."'"); ?>
    <select name="cmb_subsubcat" id="cmb_subsubcat">
  		<option value="">Select SubSubcategory</option>
		<? while($row = fetch_array($svr_query)){ ?>
		<option value="<?=$row['subsubcat_id'];?>"><?=$row['subsubcat_name'];?></option>
		<? }?>
    </select>	
<? }?>

<? //Hotel Category Page
 if(!empty($_POST['subcat1'])) {
	$svr_query = query("select tloc_id, tloc_name, tloc_code from svr_to_locations where subcat_id_fk = ".$_POST['subcat1']." and tloc_status=1 order by tloc_orderby desc");?>
	<select name="sel_destination" id="sel_destination" style="width:300px;" required>
      <option value="">--Select Location--</option>
	   <?php while($loc=fetch_array($svr_query)){ ?>
	   <option value="<?=$loc['tloc_id'];?>"><?=ucwords(strtolower($loc['tloc_name'])).' ('.$loc['tloc_code'].')';?></option>
	   <? }?>
	</select>
 <? } 
 
 if(!empty($_POST['subcat2'])) {
	 $svr_query = query("select ht_loc_id, ht_loc_name from svr_hotel_location where ht_loc_status=1 order by ht_loc_name");?>
	<select name="hot_loc" id="hot_loc" style="width:300px;" required>
      <option value="">Select Hotel Location</option>
	   <?php while($loc=fetch_array($svr_query)){ ?>
	   <option value="<?=$loc['ht_loc_id'];?>"><?=$loc['ht_loc_name'];?></option>
	   <? }?>
	</select>
 <? }?>   