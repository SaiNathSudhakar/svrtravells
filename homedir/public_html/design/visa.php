<link rel="stylesheet" href="css/anytime.5.0.5.css">
<script language="javascript" src="js/anytime.5.0.5.js"></script>
<script>
$(document).ready(function() {
  var oneDay = 24*60*60*1000;
  var rangeFormat = "%M %D, %Y %H:%i";
  var rangeConv = new AnyTime.Converter({format:rangeFormat});
  $(".tabOverClear").click( function(e) { $("#tabOverInput1").val("").change(); } );
  $("#tabOverInput1").AnyTime_picker({format:rangeFormat});
  $("#tabOverInput1").change(
    function(e) {
      try {
        var fromDay = rangeConv.parse($("#tabOverInput1").val()).getTime();
        var dayLater = new Date(fromDay+oneDay);
        //dayLater.setHours(0,0,0,0);
        //var ninetyDaysLater = new Date(fromDay+(90*oneDay));
       // ninetyDaysLater.setHours(23,59,59,999);
        $("#tabOverInput2").
          AnyTime_noPicker().
          removeAttr("disabled").
          //val(rangeConv.format(dayLater)).
          AnyTime_picker( {
            earliest: dayLater,
            format: rangeFormat
            /*latest: ninetyDaysLater*/
            } );
        }
      catch(e) {
        $("#tabOverInput2").val("").attr("disabled","disabled");
        }
      });
});
</script>

<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<!-- mid content Start-->
<div class="inner_content">
  <div class="enquiry" align="center">
<? if(empty($_GET['st'])){ ?>
	<h1>Visa Form</h1>
	<p>Send us your queries and comments.</p>
	<?=($error != '') ? '<p class="error">'.$error.'</p>' : ''; ?>
	<div id="error"></div>
	<form name="visa_form" id="visa_form" method="post">
		<div class="form_styles form_wrapper">
	
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<input name="travel_date" type="text" id="tabOverInput1" class="tabOverInput" placeholder="Travel Date *" autocomplete="off">
		 
		<input name="name" type="text" id="name" maxlength="75" placeholder="Name *">
		<select name="people" id="people">
			<option value="">Select No. of People *</option>
			<? for($i = 1; $i <= 10; $i++){?>
				<option value="<?=$i?>"><?=$i?></option>
			<? }?>
		</select>
		
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<input name="email" type="text" id="email" maxlength="100" placeholder="E-Mail *">
		<input name="phone" type="text" id="phone" maxlength="12" placeholder="Phone / Mobile no *">
		
		<textarea name="address" id="address" placeholder="Address *"></textarea>
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<input name="city" type="text" id="city" maxlength="75" placeholder="City *">
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<select name="state" id="state">
			<? foreach($states as $key => $value){?>
				<option value="<?=$key?>"><?=$value?></option>
			<? }?>
		</select>
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<input name="country" type="text" id="country" maxlength="75" placeholder="Country *">
		<div class="clear" style="line-height:5px">&nbsp;</div>
		<span style="line-height:30px;" class="fl">This helps SVR Travels prevent automated Enquiries.</span>
		<div class="clear"></div>
		<span style="line-height:30px;" class="fl">Please give your Phone no. or Mobile no. or both</span>
		<div class="clear"></div>
		<table border="0" cellpadding="0" cellspacing="0" class="captd">
		  <tr>
			<td>Security Question:</td>
			<td><strong><span class="star" id="rndnumber"></span></strong></td>
			<td></td>
			<td><table border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td align="left">
				  	<input name="rnd1" class="input-text" id="rnd1" placeholder="Result?" size="25" maxlength="5" type="text" />
					<input name="cap_sum" id="cap_sum" value="9" type="hidden" />
				  </td>
				  <td width="20" align="left"><span class="ml10 mt5 fl"><img src="images/refresh.gif" width="16" height="16" align="absmiddle" style="cursor:pointer;" title="Click Here To Reload Captcha" onclick="return captcha();" /></span></td>
				</tr>
			</table></td>
		  </tr>
		</table>
		<input name="Submit" type="submit" id="enq_submit" class="sbmt_btn" value="SUBMIT" onClick="return validate_enqury()" />
		</div>
	</form>
	<br />
	<h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4>
	<p>(For monitoring purpose we are storing your IP)</p>
<? } else { ?>  
	<h1>Enquiry Success</h1>
	<p>Thanks for your Mail, We will get back to you shortly.</p>
<? }?>
  </div>
</div>