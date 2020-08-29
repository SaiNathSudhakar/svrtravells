<? 
$cat = (empty($cat)) ? '1' : $cat; $pagecat = $cat; //var_dump($_SESSION);
if($cat == 1 && !empty($_GET['lid']))
{	
	list($avail_dates, $avail_seats, $lid) = get_available_dates($_GET['lid']); //print_r($avail_seats); exit;
	//$avail_dates = explode(',', $avail_dates);
}
?>
<script>
var availableDates = [<?=(!empty($avail_dates)) ? '"'.implode('","',  $avail_dates ).'"' : ''; ?>];
</script>

<div class="box fl">
<div class="trackorder fl">
<div id="tabs">
	<div class="tab_ac" id="mdiv1" onClick="tab('div1')" style="line-height:34px; padding:0 8px; display:none">Flights</div>
	<div class="tab_ac fl" id="mdiv2" onClick="tab('div2')" style="line-height:34px; padding:0 8px;">Bus Booking</div>
	<div class="tab_<?=($cat != '' && $cat == 1) ? 'on' : '';?>ac fl" id="mdiv3" onClick="tab('div3')" data-num="1">Fixed<br />Departure</div>
	<div class="tab_<?=($cat != '' && $cat == 2) ? 'on' : '';?>ac fl" id="mdiv4" onClick="tab('div4')" data-num="2" style="padding-right:18px; margin-right:0">Holiday<br />Packages</div>
</div>
<div class="trackborder">
<!--**Flight form section START**-->
<div id="div1" style="display:none; color:#FFFFFF; font-size:12px;"><br />
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="left" valign="top">
		<div class="fl mr20"><input name="" type="radio" value="" checked /> One Way</div>
		<div class="fl mr20"><input name="" type="radio" value="" />Return</div>
	</td>
  </tr>
  <tr>
	<td height="45" align="left" valign="top">
		<div class="fl mr40 orange" style="line-height:25px;">Leaving from<br /><input name="" type="text" value="city/airport" style="width:85px;"/></div>
		<div class="fl orange" style="line-height:25px;">Going to<br /><input name="" type="text" value="city/airport" style="width:85px;"/></div>
	</td>
  </tr>
  <tr>
	<td align="left" valign="top" height="55">
		<div class="fl mr20 orange" style="line-height:25px;">Departure Date<br /><input name="" type="text" value="dd-mm-yy" style="width:80px;"/><img src="images/calendar.png" class="ml5" id="datepicker-example8" height="16" width="16" /></div>
		<div class="fl orange" style="line-height:25px;">Return Date<br /><input name="" type="text" value="dd-mm-yy" style="width:80px;"/><img src="images/calendar.png" class="ml5" id="datepicker-example8" height="16" width="16" /></div>
	</td>
  </tr>
  <tr>
	<td align="left" valign="top" class="orange" height="20">Travels (upto per Booking)</td>
  </tr>
  <tr>
	<td align="left" valign="top" height="50">
	<div class="fl mr20 ">Adults (12+)<br />
	<select name="" style="width:50px">
		<option value="1">1</option> 
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
	</select>
	</div>
	<div class="fl mr20">Children (2-11)<br />
	<select name="" style="width:50px">
		<option value="0">0</option> 
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
	</div>
	<div class="fl">Infants(0-2)<br />
	<select name="" style="width:50px">
		<option value="0">0</option> 
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>    
	</div>
	</td>
  </tr>
  <tr>
	<td align="left" valign="top" class="orange" height="35">Class
	<select name="" style="width:100px">
		<option value="0">Economy</option> 
		<option value="1">Business</option>
		<option value="2">First</option>
	</select>    
	</td>
  </tr>
  <tr>
	<td  valign="top" align="center"><a href=""><input name="" type="button" class="submit-btn" value="Book Now" /></a></td>
  </tr>
</table>
<div class="clear"></div>   
</div>
<!--**Flight form section END**-->

<!--**Bus form section START**-->
<div id="div2" style="display:none; color:#FFFFFF; font-size:12px;"><br />

<div class="clear"></div>   
</div>
<!--**Bus form section END**-->

<!--**Fixed Departure section START**-->
<div id="div3" style="display:<?=($cat == 1) ? 'block' : 'none'?>; color:#FFFFFF; font-size:13px;"><br />
<form name="fixed_departures" id="fixed_departures" method="post">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="55" colspan="2" align="left" valign="top">
		<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" class="fl mr15" height="24" width="18" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">I'm here</span>		
		</div>
		<? $pagecat = $cat;?>
		<input type="hidden" name="category" class="category" value="<?=$cat?>" />
		<div class="ml30" style="line-height:30px; margin-bottom:10px">Tour starting from <br />
		<div id="fd_from_dropdown">
		<select name="fdfromloc" id="fdfromloc" style="width:180px;">
			<option value="">--- Select Departure City ---</option>
			<?  $svr_query = mysql_query("select distinct(floc_id), floc_name from `svr_to_locations` as tloc
				left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id
					where tloc_status = 1 and cat_id_fk = 1 order by tloc_orderby");
				while($row = mysql_fetch_array($svr_query)){
					$selected = (!empty($from) && $row['floc_id'] == $from && $cat == 1) ? "selected" : "";?>
					<option value="<?=$row['floc_id'];?>" <?=$selected?>><?=$row['floc_name'];?></option>
			<? }?>
		</select>
		</div></div>
		</td>
	</tr>
	<tr>
		<td height="55" colspan="2" align="left" valign="top">
		  <div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" class="fl mr15" height="24" width="18" />I want to go to<br />
			<div id="fd_to_dropdown">
				<select name="fdtoloc" id="fdtoloc" class="ml30" style="width:180px;">
					<option value="">--- Select Arrival City ---</option>
					<? if(!empty($to)){
						$svr_query = mysql_query("select distinct(tloc_id), tloc_name from svr_to_locations as tloc
						left join svr_from_locations as floc on tloc.tloc_floc_id = floc.floc_id
							where tloc_status = 1 and tloc_floc_id = '".$from."' and cat_id_fk = 1 order by tloc_orderby");
						while($row = mysql_fetch_array($svr_query)){ 
							$selected = (!empty($to) && $row['tloc_id'] == $to && $cat == 1) ? "selected" : "";?>
							<option value="<?=$row['tloc_id'];?>" <?=$selected?>><?=ucwords(strtolower($row['tloc_name']));?></option>
					<? }}?>
				</select>
			</div>
		  </div>		
		</td>
	</tr>
	<tr>
		<td height="85" colspan="2" align="left" valign="top" id="cmb_date">
		<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/watch.png" height="19" width="19" class="fl mr15 mt10" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">When</span></div>
			<div class="ml30">Departure Date<br />
			<? $date = ($pagecat == 1 && !empty($_GET['date'])) ? $_GET['date'] : ''; ?>
			<input type="text" class="input2" id="datepicker1" name="datepicker1" size="20" maxlength="100" value="<?=$date?>" readonly >
		</div></td>
	</tr>
	<tr>
		<td valign="top" align="right" id="seat_avail_div">&nbsp;</td>
		<td valign="top" align="right"><input name="book" type="button" class="submit-btn" value="Book Now" onclick="javascript:validate(1);"/></td>
	</tr>
</table>
</form>
<div class="clear"></div>   
</div>
<!--**Fixed Departure section END**-->

<!--**Holiday Packages section START**-->
<div id="div4" style="display:<?=($cat == 2) ? 'block' : 'none'?>; color:#FFFFFF; font-size:13px;"><br />
<form name="holiday_package" id="holiday_package" method="post">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="55" colspan="2" align="left" valign="top">
		<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" height="24" width="18" class="fl mr15" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">I'm here</span>		
		</div>
		<? //$cat = (!empty($_GET['cid'])) ? $_GET['cid'] : $cat;?>
		<input type="hidden" name="category" class="category" value="<?=$cat?>" />
		<div class="ml30" style="line-height:30px; margin-bottom:10px">Tour starting from <br />
		<div id="hp_from_dropdown">
		<select name="hpfromloc" id="hpfromloc" style="width:180px;">
			<option value="">--- Select Departure City ---</option>
			<?  $svr_query = mysql_query("select distinct(floc_id), floc_name from `svr_to_locations` as tloc
				left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id
					where tloc_status = 1 and cat_id_fk = 2");
				while($row = mysql_fetch_array($svr_query)){
					$selected = (!empty($from) && $row['floc_id'] == $from && $cat == 2) ? "selected" : "";?>
					<option value="<?=$row['floc_id'];?>" <?=$selected?>><?=$row['floc_name'];?></option>
			<? }?>
		</select>
		</div></div>
		</td>
	</tr>
	<tr>
		<td height="55" colspan="2" align="left" valign="top">
		  <div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" height="24" width="18" class="fl mr15" />I want to go to<br />
			<div id="hp_to_dropdown">
				<select name="hptoloc" id="hptoloc" class="ml30" style="width:180px;">
					<option value="">--- Select Arrival City ---</option>
					<? if(!empty($to)){
						$svr_query = mysql_query("select distinct(tloc_id), tloc_name from svr_to_locations as tloc
							left join svr_from_locations as floc on tloc.tloc_floc_id = floc.floc_id
								where tloc_floc_id = '".$from."' and cat_id_fk = 2 order by tloc_id desc");
						while($row = mysql_fetch_array($svr_query)){ 
							$selected = (!empty($to) && $row['tloc_id'] == $to && $cat == 2) ? "selected" : "";?>
							<option value="<?=$row['tloc_id'];?>" <?=$selected?>><?=ucwords(strtolower($row['tloc_name']));?></option>
					<? }}?>
				</select>
			</div>
		  </div>		
		</td>
	</tr>
	<tr>
		<td height="85" colspan="2" align="left" valign="top" id="cmb_date">
		<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/watch.png" height="19" width="19" class="fl mr15 mt10" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">When</span></div>
			<div class="ml30">Departure Date<br />
			<? $date = ($pagecat == 2 && !empty($_GET['date'])) ? $_GET['date'] : ''; ?>
			<input type="text" class="input2" id="datepicker2" name="datepicker2" size="20" maxlength="100" readonly value="<?=$date?>">
		</div></td>
	</tr>
	<tr>
		<td valign="top" align="right" id="seat_avail_div">&nbsp;</td>
		<td valign="top" align="right"><input name="book" type="button" class="submit-btn" value="Book Now" onclick="javascript:validate('2');"/></td>
	</tr>
</table>
</form>
<div class="clear"></div>   
</div>
<!--**Holiday Packages section END**-->

</div>
</div>
<div class="clear"></div>
</div>
<?  $url = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
	if($url != 'index') {?>
<div class="fr">
	<div id='calendar'></div>
	<div class="clear"></div>
</div>
<? }?>

<link href='css/fullcalendar/fullcalendar.css' rel='stylesheet' />
<!--<link href='css/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />-->
<style>
.fc-event {	background: #fff !important;color: #000 !important;	}
/* for vertical events */
.fc-event-bg { display: none !important;}
.fc-event .ui-resizable-handle {display: none !important;}
</style>
<script src='js/fullcalendar/moment.min.js'></script>
<script src='js/fullcalendar/fullcalendar.min.js'></script>
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: { left: 'prev,next today', center: 'title', right: '' },
        events: [ <? foreach($avail_seats as $date => $seats){ ?>{ title: '( <?=$seats;?> Vacant )', url: 'fixed-departure-booking.php?lid=<?=$lid?>&date=<?=date('d-m-Y', strtotime($date));?>', start: '<?=$date;?>'},<? }?>]
    });
});
</script>