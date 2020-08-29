<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<script src="js/navmenu.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/site.css" rel="stylesheet" type="text/css">
<div class="banner_inner"><img src="images/booknow.jpg" alt="Booknow" /></div>

<style type="text/css">
.table{border-spacing:1px; background:#d5d5d5; border-bottom:1px solid #ebebeb}
.table td{background:#FFFFFF; padding:4px 10px;}
.table .tablehead{background:url(images/tabg.gif) repeat-x top center; font-size:12px; font-weight:bold; color:#000; padding-left:10px;}
.table .tableheadlite{background:url(images/tabb.gif) repeat-x top center; font-size:12px; font-weight:bold; color:#000; padding-left:10px;}
.table .tablerow1 td{background:#f5f5f5;}
.table .tablerow2 td{background:#FFFFFF;}
.table td.paging{background:#FFF; padding:10px;}

.table .tablerowerr td{ background:#EC8484;} /*#D60810 or #D26060*/
.curve-border { border: 1px solid #666; background: #ffffff ; color:#222222; -moz-border-radius: 3px; -webkit-border-radius: 3px;}
.blue_read:link{color:#333; font-weight:bold; text-decoration:none; margin-right:14px;font-size:12px;}
.blue_read:visited{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:hover{color:#FB8800; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
.blue_read:active{color:#333; font-weight:bold; text-decoration:none; margin-right:14px; font-size:12px;}
</style>

<!-- Navigation Start-->
<div class="navigation"><div class="bg"><a href="index.php">Home</a><span class="divied"></span><span class="pagename"><?=$pageName?></span></div></div>
<!-- Navigation end-->
<div class="inner_content">
<? include('includes/left.php'); ?>
<div class="fl" style="width:72%">
<div class="myprofile">
	<div class="fl"><h1>Instant Recharge</h1></div>
	<div class="fr"><h2>Welcome: <span><?=$_SESSION[$svra.'ag_fname'];?></span></h2></div>
	<div class="clear"></div>
</div>

<form name="recharge" id="recharge" method="post" enctype="multipart/form-data">
<div class="col fl">
<div class="form_styles form_wrapper">
<table width="100%" cellpadding="3" cellspacing="5">
<tr><td colspan="2"><? if(!empty($msg)){ echo '<h3 align="center" class="msg">'.$msg.'</h3>'; }?></td></tr>

<tr><td><strong>Amount</strong></td><td>
<input type="text" name="amount" value="" size="60"/> <!--<br />(Minimum Amount for deposit recharge <span class="rupee bold red">&#x20B9;</span> 1000)--></td></tr>

<tr><td colspan="2" align="center"><input name="submit" type="submit" class="sbmt_btn" value="Recharge" onClick="return validat()"/></td></tr>
</table>
<!--</td>
</tr>

</table>-->
</div>
<br />
<div align="center"><h4>Your IP: <?=$_SERVER['REMOTE_ADDR'];?></h4><p>(For monitoring purpose we are storing your IP)</p></div>
</div>
</form>

</div>
<div class="clear"></div>
<div class="mt30"><h3>* <a href="#dealit" rel="facebox">Terms & Conditions</a></h3></div>
</div>

<div id="dealit">
<div class="facebox signup_head"><h1>Terms & Conditions</h1></div>
<div style="padding:20px;" class="facebox"><?=$fetch_sam['cnt_content'];?></div>	
</div>

<!--expandable meuu scripts-->
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/accordin-int.js"></script>
<!--<script>
function show(id){
	if(id==1){ //cash
		document.getElementById('cheq_draw_bank').style.display="none";
		document.getElementById('cheq_issu_date').style.display="none";
		document.getElementById('cheq_dd_no').style.display="none";
		document.getElementById('acc_holdr_name').style.display="none";
	}
	else if(id==2){ //cheque
		document.getElementById('cheq_draw_bank').style.display="";
		document.getElementById('cheq_issu_date').style.display="";
		document.getElementById('cheq_dd_no').style.display="";
		document.getElementById('acc_holdr_name').style.display="";
	}
	else if(id==3){ //trans
		document.getElementById('cheq_draw_bank').style.display="none";
		document.getElementById('cheq_issu_date').style.display="none";
		document.getElementById('cheq_dd_no').style.display="none";
		document.getElementById('acc_holdr_name').style.display="";
	}
}
</script>
<link rel="stylesheet" href="css/anytime.5.0.5.css">
<script language="javascript" src="js/anytime.5.0.5.js"></script>
<script>
$(document).ready(function() {
  var oneDay = 24*60*60*1000;
  var rangeFormat = "%M %D, %Y %H:%i";
  var rangeConv = new AnyTime.Converter({format:rangeFormat});
  //$("#rangeToday").click( function(e) { $("#tabOverInput1").val(rangeConv.format(new Date())).change(); } );
  $(".tabOverClear").click( function(e) { $("#datepicker1").val("").change(); } );
  $("#datepicker1").AnyTime_picker({format:rangeFormat});
  $("#datepicker1").change(
    function(e) {
      try {
        var fromDay = rangeConv.parse($("#datepicker1").val()).getTime();
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
<script>
var chk_phone=/^\d{10}$/;
function validation()
{
	var d = document.deposit;	
	if(d.amount.value==""){ alert("Please enter Amount");d.amount.focus(); return false;}
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid mobile number");d.mobile.focus(); return false;}
	if(d.trans.value==""){ alert("Please Enter Transcaction ID");d.trans.focus(); return false;}
	if(d.bank.value==""){ alert("Please select Bank");d.bank.focus(); return false;}
	if(d.attach.value==""){ alert("Please Upload Attachment");d.attach.focus(); return false;}
	//if(isNaN(d.landline.value) || d.landline.value==""){alert("Please Enter valid phone number"); d.landline.focus(); return false;}	
}
</script>-->