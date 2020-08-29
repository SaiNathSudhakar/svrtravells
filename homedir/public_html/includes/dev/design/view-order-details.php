<script src="js/navmenu.js" type="text/javascript"></script>
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>
<!-- Navigation Start-->
<div class="navigation">
  <div class="bg">
  	<a href="index.php">Home</a>
	<span class="divied"></span>
	<? if($row['ord_type'] == 1){?>
	<a href="fixed-departure-tickets.php">Fixed Departure Tickets</a>
	<? }if($row['ord_type'] == 2){?>
	<a href="tour-package-tickets.php">Tour Package Tickets</a>
	<? }?>
	<span class="divied"></span>
	<span class="pagename">View Order Details</span>
  </div>
</div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
<div class="fl"><h1>My Order Details</h1></div>
<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svr.'cust_fname']; ?></span></h2></div>
<div class="clear"></div>
</div>
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="6" cellspacing="1" class="curve-border">
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
	  <? if($row['ord_type'] == 1) {?>
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
        <td valign="top" bgcolor="#F3F3F3"><span class="rupee">&#x20B9;</span> <?=number_format($row['ord_amount'], 2);?></td>
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
	  	} if($row['ord_drop_at'] != ''){?>
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
	  <? } if($row['ord_journey_date'] != '1970-01-01' || $row['ord_journey_date'] != '0000-00-00') {?>
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
</table>
</div>
</div>