<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#F2F2F2">
  <tr>
    <td align="left" valign="middle" bgcolor="#F2F2F2"><span class="heading">Tour Name</span></td>
    <td align="left" valign="middle" bgcolor="#F2F2F2" width="380"><span class="heading">Pickup Place</span></td>
    <td align="center" valign="middle" bgcolor="#F2F2F2"><span class="heading">Departure Time</span></td>
    <td align="center" valign="middle" bgcolor="#F2F2F2"><span class="heading">Journey Date</span></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#F9F9F9"><?=$row_loc['tloc_name'];?></td>
    <td align="left" valign="middle" bgcolor="#F9F9F9">Pickup Point :
	<span id="PickUpPointDiv"> 
	<select name="PickUpPoint" id="PickUpPoint" style="width:280px;" autocomplete="off">
		<option value="">--- Select ---</option>
		<? foreach($pickup_points as $key => $pickup_point){ if($pickup_point != ''){?>
			<option value="<?=$key?>"><?=$pickup_point?></option>
		<? }}?>
	</select></span>
    <p>Note : * marked Pickup Point will comprise of some service charge. </p>
    <div id="pickup_detail"></div>
    </td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><div id="pickup_time"><?=$deptime;?></div></td>
    <td align="center" valign="middle" bgcolor="#F9F9F9"><?=date('d-M-Y', strtotime($_GET['date']));?></td>
  </tr>
</table>