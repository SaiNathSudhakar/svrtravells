<? ob_start();
include "includes/api-header.php";
include_once "includes/api-functions.php";
//$_SESSION[$svr.'busbook'] = (isset($_SESSION[$svr.'busbook'])) ? $_SESSION[$svr.'busbook'] : rand(100000, 999999); 
unset($_SESSION['Travel']);
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$_SESSION['sourceList'] = $_POST['sourceList'];
	$_SESSION['sourceName'] = $_POST['sourceName'];
	$_SESSION['destinationList'] = $_POST['destinationList'];
	$_SESSION['destinationName'] = $_POST['destinationName'];
	$_SESSION['datepicker'] = $_POST['datepicker']; 
	$_SESSION[$svr.'busbook'] = (isset($_SESSION[$svr.'busbook'])) ? $_SESSION[$svr.'busbook'] : 'BUS'.rand(100000, 999999);
	//print_r($_SESSION); exit;
	header('location:BusServiceList.php');
}
?>
<title>Bus Booking</title>
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<div class="navigation">
	<div class="bg">
	<a href="index.php">Home</a><span class="divied"></span>
	<span class="pagename">Bus Booking</span></div>
</div>

<!--<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/validation.js"></script>-->
<?php
//echo "<form method='get' action='BusServiceList.php' name='busbooking' id='busbooking' onSubmit=''>";
echo "<form method='post' action='' name='busbooking' id='busbooking' onSubmit=''>";
echo "<input type='hidden' name='sourceName' id='sourceName' class='btnclass' />";
echo "<input type='hidden' name='destinationName' id='destinationName' class='btnclass' />"; 
$sourceList = getSourcesAsDropDownList();
?>
<link href="css/form-styls.css" rel="stylesheet" type="text/css" />
<table cellpadding="10" cellspacing="1" border="0" style="border:1px solid #eaeaea;" width="100%">
<tr bgcolor="#F4F4F4">
  <td><h2>Book Bus Ticket</h2></td>
</tr>
<tr><td>
<table cellpadding="10" cellspacing="1" border="0">
	<tr>
		<td>From</td>
		<td id='sourceDP'><? echo "<p class='pos_fixed'>".$sourceList."</p>";?></td>
	</tr>
	<tr valign="middle">
		<td>To</td>
		<td><div id="destdiv" class='destination'><select name="destinationList" id="destinationList" class="chosen-select"><option value="">Select Destination</option></select></div></td>
	</tr>
<?php
function getSourcesAsDropDownList()
{	
	global $scr, $sourceId, $sourcename;
	$scr = getAllSources();
	$json_o = json_decode($scr);
	$cities = $json_o->cities;
	function my_sort($a,$b)
	{
		if (strcasecmp($a->name, $b->name)<0){ 
			return -1;
		}
		elseif (strcasecmp($a->name, $b->name)>0){
			return 1;
		}
		else {
			return 0;
		}
	}
	usort($cities, 'my_sort'); //onChange='getDestination(this.value)'
	$selectControlForSources = "<select id='sourceList' name='sourceList' class='input chosen-select'>";
	if(is_array($cities))
	{	
		$selectControlForSources .= "<option value=''>Select Source</option>";
		foreach($cities as $cities)
		{
			$selectControlForSources = $selectControlForSources."<option value=". $cities->id." >"
							.$cities->name."</option>";
		}
		$selectControlForSources = $selectControlForSources."</select>";
	}
	return $selectControlForSources;
}
?>
	<tr>
		<td>Date</td>
		<td><p class='input_date'><input type="text" id="datepicker" name="datepicker" class="input" placeholder="YYYY-MM-DD" autocomplete="off" /></p></td>
	</tr>
	<tr>
		<td></td>
		<td>
        	<p class='submit_button' id='submit_button'><input type="submit" value="Search Buses" class="submit" onClick="return validation()"/></p>
        	<p id="button_replacement" style="display:none;"><input type="submit" value="Searching..." class="submit" onclick="return false;" /></p>
        </td>
	</tr>
</table></td></tr></table>
<br /><br />
</form>
<!--</body>
</html>-->
<? include('includes/api-footer.php');?>
<script language="javascript" type="text/javascript">
$(function() {
	$( "#datepicker" ).datepicker({dateFormat:"yy-mm-dd",minDate:0});
	$('#sourceList').change(function(){
		$( "#sourceName" ).val($("#sourceList option:selected").text());
	});
	$('#destdiv').on('change', '#destinationList', function(){
		$( "#destinationName" ).val($("#destinationList option:selected").text());
	});
	
	$( "#sourceDP" ).on("change", "#sourceList", function() { 
		if($('#sourceList').val() != '') $( "#destdiv" ).html( "Loading..." );
		$.post( "destinationList.php", { sourceList: $('#sourceList').val() })
		.done(function( data ) { //alert(data);
			if( data != '' && $('#sourceList').val() != '') { 
				$( "#destdiv" ).html( data ); 
				$(".chosen-select").chosen(); 
			}
	  	});
	});
});
/**/function getXMLHTTP() 
{ 
	var xmlhttp=false;	
	try
	{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
		try
		{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1)
			{
				xmlhttp=false;
			}
		}
	}
	return xmlhttp;
}
	
function getDestination(chosensource)
{	
	var strURL = "destinationList.php?sourceList="+chosensource;
	var req = (chosensource) ? getXMLHTTP() : '';
	document.getElementById('destdiv').innerHTML = 'Loading...';
	
	if(req)
 	{	
		req.onreadystatechange = function()
		{
			if (req.readyState == 4) 
			{
				if (req.status == 200) 
				{
					//$("#destinationList").trigger("chosen:updated");
					//$("#destinationList").trigger("liszt:updated");
					$('.chosen-select').chosen();
					document.getElementById('destdiv').innerHTML = req.responseText;
					
				}
				else
				{
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}
		}
		req.open("GET",strURL,true);
		req.send(null);
 	} 
	else 
	{
		document.getElementById('destdiv').innerHTML="<select name='destinationList' id='destinationList' class='chosen-select'><option value=''>Select Destination</option></select>";
	}
}

function validation(){
	var d = document.busbooking;
	if(d.sourceList.value==""){alert("Please select Source");d.sourceList.focus();return false;}
	if(d.destinationList.value==""){alert("Please select Destination");d.destinationList.focus();return false;}
	if(d.datepicker.value==""){ alert("Please select Date");d.datepicker.focus(); return false;}
	
	if(d.sourceList.value!="" && d.destinationList.value!="" && d.datepicker.value!=""){
		document.getElementById("submit_button").style.display = "none";
    	document.getElementById("button_replacement").style.display = "";
	}
}
</script>

<link rel="stylesheet" href="api/css/chosen.css">
<script type="text/javascript" src="api/js/chosen.jquery.js"></script>
<script type="text/javascript">
$().ready(function(){
	var config = {
	  '.chosen-select'           : {},
	  '.chosen-select-deselect'  : {allow_single_deselect:true},
	  '.chosen-select-no-single' : {disable_search_threshold:10},
	  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
	  '.chosen-select-width'     : {width:"95%"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
	//$("#destinationList").trigger("chosen:updated");
});

//$().ready(function(){
	//$(".chosen-select").chosen({disable_search_threshold: 10});
	//$("#destinationList").trigger("chosen:updated");
//});
</script>