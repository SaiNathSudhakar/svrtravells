<?
ob_start();
//session_start();
include_once("../includes/functions.php");
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type'])) { ?>
	<script language="javascript">self.close();</script>
	<? } if(!empty($_GET['t_id'])){	if(!is_numeric($_GET['t_id'])) header("location:../index.php");}
	
$q = "select ord_journey_date, ord_return_date, floc_name, floc_id, ord_id, ord_order_id, ord_journey_date, ord_return_date, ord_pkg_id, ord_amount, ord_type, ord_acc_type, ord_room_type, ord_vehicle_type, ord_fc_qty, ord_tot_adult, ord_tot_child, ord_no_of_persons, ord_seat_number, ord_pickup_from, ord_pickup_place, ord_pickup_place_detail, ord_pickup_time, ord_drop_at, ord_drop_place, ord_drop_place_detail, ord_drop_time, ord_emergency_number, ord_comments, ord_total_amount, ord_request_status, tloc_name, tloc_code, tloc_room_type, tloc_type, cust_fname, cust_lname, cust_email, cust_mobile, cust_address_1, cust_address_2, cust_city, cust_state, cust_country, cust_pincode, group_concat(fc.fc_id) as fc_ids, ord_fc_qty as fc_qtys, veh.vp_name as vehicle from svr_book_order as ord
	left join svr_fare_category as fc on FIND_IN_SET(fc.fc_id, ord.ord_fc_id)
		left join svr_vehicles_pax as veh on veh.vp_id = ord.ord_room_type
			left join svr_customers as cust on cust.cust_id = ord.ord_cust_id
				left join svr_to_locations as tloc on tloc.tloc_id = ord.ord_tloc_id
					left join svr_from_locations as floc on floc.floc_id = tloc.tloc_floc_id where ord_id='".$_GET['t_id']."'";
$qur = query($q);
$row = fetch_array($qur);

list($standard, $deluxe, $luxury) = (!empty($row['tloc_room_type'])) ? explode('|', $row['tloc_room_type']) : array_fill(0, 3, '');

$code = ($row['tloc_code'] != '') ? ' ('.$row['tloc_code'].') ' : ' ';
list($nights, $days) = (!empty($row['tloc_type'])) ? explode('|', $row['tloc_type']) : array_fill(0, 2, '');
$day_night = $nights.' Nights / '.$days.' Days';
$product_info = $row['tloc_name'].$code.$day_night;
?>
<link href="css/view_styles.css" rel="stylesheet" type="text/css" />
<table width="90%" border="0" align="center" cellpadding="6" cellspacing="0">
  
  <tr>
    <td><strong>Order Details :</strong></td>
    <td align="right"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" bgcolor="#E7E7E7" class="curve-border">
	 <tr>
        <td width="25%" valign="top" bgcolor="#F3F3F3"><strong>Name </strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_fname']." ".$row['cust_lname'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>E-Mail ID</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_email'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Mobile No.</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_mobile'];?></td>
      </tr>
	  <? if($row['cust_landline'] != ''){?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Land Phone No.</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_landline'];?></td>
      </tr>
	  <? }?>
      
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Order ID</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_order_id'];?></td>
      </tr>
	  <? if($row['ord_type'] == 1){?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat(s) Count</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_no_of_persons'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Seat No.s</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_seat_number'];?></td>
      </tr>
	  <? }?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>From Location</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['floc_name'];?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>To Location</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$product_info;?></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Amount</strong></td>
        <td valign="top" bgcolor="#F3F3F3">Rs. <?=number_format($row['ord_amount'], 2);?></td>
      </tr>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>No. of Persons</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_no_of_persons'];?>&nbsp;&nbsp;Adults (<?=$row['ord_tot_adult'];?>)&nbsp;&nbsp;Children (<?=$row['ord_tot_child'];?>) </td>
      </tr>
	  	  
	  <? if($row['ord_type'] == 2){
	 		if($row['ord_pickup_from']!= 0){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Pickup From</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$pickup_drop[$row['ord_pickup_from']];?></td>
      </tr>
	  <? } switch($row['ord_pickup_from']) {
			case 1 : $pickup_place = "Airport"; $pickup_place_details = "Flight No"; break;
			case 2 : $pickup_place = "Railway Station"; $pickup_place_details = "Train No"; break;
			case 3 : $pickup_place = "Address"; $pickup_place_details = "Street No"; break;
	  	} if($row['ord_pickup_place']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong><?=$pickup_place;?></strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_pickup_place'];?></td>
      </tr>
	  <? } if($row['ord_pickup_place_detail']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong><?=$pickup_place_details;?></strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_pickup_place_detail'];?></td>
      </tr>
	  <? } if($row['ord_pickup_time']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Expected Arrival Time</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_pickup_time'];?></td>
      </tr>
	  <? } switch($row['ord_pickup_from']) {
			case 1 : $drop_place = "Airport"; $drop_place_details = "Flight No"; break;
			case 2 : $drop_place = "Railway Station"; $drop_place_details = "Train No"; break;
			case 3 : $drop_place = "Address"; $drop_place_details = "Street No"; break;
	  	}
	  ?><? if($row['ord_drop_at'] != ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Drop At</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$pickup_drop[$row['ord_drop_at']];?></td>
      </tr>
	  <? } if($row['ord_drop_place']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong><?=$drop_place;?></strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_drop_place'];?></td>
      </tr>
	  <? } if($row['ord_drop_place_detail']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong><?=$drop_place_details;?></strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_drop_place_detail'];?></td>
      </tr>
	  <? } if($row['ord_drop_time']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Departure Time</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_drop_time'];?></td>
      </tr>
	  <? } if($row['ord_room_type']!= ''){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Room Type</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$room_type[$row['ord_room_type']];?></td>
      </tr>
	  <? }}?>
	  <? if($row['ord_type'] == 1){?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Bus Type</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$accomodation_type[$row['ord_acc_type']];?></td>
      </tr>
	  <? }?>
	  
	  <? if($row['ord_journey_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') {?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Journey Date</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=date('F d, Y',strtotime($row['ord_journey_date']));?></td>
      </tr>
	  <? } if($row['ord_return_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') {?>
	  <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Return Date</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=date('F d, Y',strtotime($row['ord_return_date']));?></td>
      </tr>
	  <? } if($row['ord_emergency_number'] != '') {?>
	  <tr>
	    <td valign="top" bgcolor="#F3F3F3"><strong>Emergency Number</strong></td>
	    <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_emergency_number'];?></td>
	  </tr>
	  <? } if($row['ord_comments'] != '') {?>
	  <tr>
	    <td valign="top" bgcolor="#F3F3F3"><strong>Comments</strong></td>
	    <td valign="top" bgcolor="#F3F3F3"><?=$row['ord_comments'];?></td>
	  </tr>
	  <? } if($row['cust_address_1'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Address 1</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_address_1'];?></td>
      </tr>
	  <? } if($row['cust_address_2'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Address 2</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_address_2'];?></td>
      </tr>
	  <? } if($row['cust_city'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>City</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_city'];?></td>
      </tr>
	  <? } if($row['cust_state'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>State</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$states[$row['cust_state']];?></td>
      </tr>
	  <? } if($row['cust_pincode'] != '') {?>
      <tr>
        <td valign="top" bgcolor="#F3F3F3"><strong>Pincode</strong></td>
        <td valign="top" bgcolor="#F3F3F3"><?=$row['cust_pincode'];?></td>
      </tr>
	  <? }?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><a href="javascript:;" onclick="window.close();" class="blue_read">Close Window</a></td>
  </tr>
</table>
