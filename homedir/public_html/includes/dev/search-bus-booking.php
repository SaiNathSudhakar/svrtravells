<? 
include_once "includes/api-functions.php";
unset($_SESSION['Travel']);
$sourceList = getSourcesAsDropDownList();
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<br />
<form method='get' action='BusServiceList.php' name='busbooking' id='busbooking' onSubmit=''>
<input type='hidden' name='sourceName' id='sourceName' class='btnclass' />
<input type='hidden' name='destinationName' id='destinationName' class='btnclass' />
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="55" align="left" valign="top">
		<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" class="fl mr15" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">I'm here</span>		
		</div>
		<div class="ml30" style="line-height:30px; margin-bottom:10px">Tour starting from <br />
		<!--<div class="fl orange" style="line-height:25px;">From<br />-->
		<? echo "<p class='pos_fixed'>".$sourceList."</p>";?></div>
	</td>
	</tr>
	<tr valign="middle">
		<td height="55" align="left" valign="top">
		 <div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/marker.png" class="fl mr15" />I want to go to<br />
		<!--<div class="fl orange" style="line-height:25px;">To<br />-->
		<div id="destdiv" class='destination ml30'>
		<select name="destinationList" id="destinationList" style="width:200px;"><option value="">Select Destination</option></select></div></div>
		</td>
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
	usort($cities, 'my_sort');
	$selectControlForSources = "<select onChange='getDestination(this.value)' id='sourceList' style='width:200px;' name='sourceList' class='input'>";
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
} ?>
	<tr>
		<td align="left" valign="top" height="65">
			<div class="fl orange" style="line-height:25px; font-size:16px">
			<img src="images/watch.png" class="fl mr15 mt10" />
			<span style="display:block; border-bottom: solid 1px #8486ba; float:left; width:180px">When</span></div>
			<div class="ml30">Departure Date<br />
			<input type="text" id="datepicker" name="datepicker" class="input" placeholder="YYYY-MM-DD" autocomplete="off" readonly />
			</div>
		</td>
	</tr>
	<tr>
		<td height="50" align="right"><input name="book" type="button" class="submit-btn" value="Search Buses" onclick="return validation();"/></td>
	</tr>
</table>
</form>
<div class="clear"></div>
<script language="javascript" type="text/javascript">
$(function() {
	$( "#datepicker" ).datepicker({
		showOn: "both",
		buttonImage: "images/calendar.png",
		dateFormat: "yy-mm-dd",
		buttonImageOnly: true,
		changeYear:true, 
		changeMonth:true, 
		minDate: 1
	});
	$('#sourceList').change(function(){
		$( "#sourceName" ).val($("#sourceList option:selected").text());
	});
	$('#destdiv').on('change', '#destinationList', function(){
		$( "#destinationName" ).val($("#destinationList option:selected").text());
	});
});
function getXMLHTTP() 
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
	var strURL = "search-bus-destination.php?sourceList="+chosensource;
	var req = (chosensource) ? getXMLHTTP() : '';
	document.getElementById('destdiv').innerHTML = 'Loading...';
	
	if(req)
 	{	
		req.onreadystatechange = function()
		{
			if (req.readyState == 4) 
			{	//alert(req.responseText);
				if (req.status == 200) 
				{	
					document.getElementById('destdiv').innerHTML=req.responseText;
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
		document.getElementById('destdiv').innerHTML="<select name='destinationList'><option value=''>Select Destination</option></select>";
	}
}
function validation(){
	var d=document.busbooking;
	if(d.sourceList.value==""){alert("Please select Source");d.sourceList.focus();return false;}
	if(d.destinationList.value==""){alert("Please select Destination");d.destinationList.focus();return false;}
	if(d.datepicker.value==""){ alert("Please select Date");d.datepicker.focus(); return false;}
	d.submit();
}
</script>