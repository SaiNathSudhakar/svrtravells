<? ob_start();
include "includes/api-header.php";
include_once "includes/api-functions.php";
if(!empty($_GET['sourceList'])){
	$_SESSION['sourceList'] = $_GET['sourceList'];
	$_SESSION['sourceName'] = $_GET['sourceName'];
	$_SESSION['destinationList'] = $_GET['destinationList'];
	$_SESSION['destinationName'] = $_GET['destinationName'];
	$_SESSION['datepicker'] = $_GET['datepicker']; 
	$_SESSION[$svr.'busbook'] = (isset($_SESSION[$svr.'busbook'])) ? $_SESSION[$svr.'busbook'] : 'BUS'.rand(100000, 999999);
	header('location:BusServiceList.php');
}

if(empty($_SESSION[$svr.'busbook'])) header('location:BusBooking.php');
unset($_SESSION['chosenone']);

if($_SERVER['REQUEST_METHOD'] == "POST")
{	
	if(!empty($_POST['chosenone']))	{
		list($_SESSION['chosenone'], $_SESSION['travelName'], $_SESSION['arrivalTime'], $_SESSION['departureTime'], $_SESSION['travelType'], $_SESSION['canPolicy']) = explode('|', $_POST['chosenone']);
		//var_dump($_SESSION); exit;
		header('location:SeatLayout.php');
	}else{
		$_SESSION['Travel'] = $_POST['Travel'];
		header('location:BusServiceList.php');
	}
}
?>
<title>BUS SERVICE LIST</title>
<script type="text/javascript" src="api/js/jquery.tablesorter.min.js"></script>


<div class="navigation">
	<div class="bg">
        <a href="index.php">Home</a><span class="divied"></span>
        <a href="BusBooking.php">Bus Booking</a><span class="divied"></span>
        <span class="pagename">Bus Services List</span>
    </div>
</div>
<? include('travel-info.php');?>
<!--<link rel="stylesheet" href="api/css/jquery.colorbox.css">
<script type="text/javascript" src="api/js/jquery.colorbox.js"></script>-->
<link rel="stylesheet" href="api/css/chosen.css" />
<link rel="stylesheet" href="api/css/popup.css" />
<link href="api/css/BusServiceList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchForm(action)
{	
	document.getElementById('form2').action = action;
	document.getElementById('form2').submit();
}
</script>
<!--<form name='form2' id='form2' method='get' action='SeatLayout.php'>-->
<form name='form2' id='form2' method='post'>
<?php
$sourceid = $_SESSION['sourceList']; //$_GET['sourceList'];
$destid = $_SESSION['destinationList']; //$_GET['destinationList'];
$date = $_SESSION['datepicker']; //$_GET['datepicker'];

echo "<input type='hidden' name='sourceList' class='btnclass' value='".$sourceid."'/>";
echo "<input type='hidden' name='destinationList' class='btnclass' value='".$destid."'/>";  
echo "<input type='hidden' name='datepicker' class='btnclass' value='".$date."'/>";
if (isset($_SESSION['Travel']))
{
	$num_chosenTravels = count($_SESSION['Travel']);
}
//session_start(); 

global $result; //echo $sourceid.','.$destid.','.$date;
$result = getAvailableTrips($sourceid,$destid,$date); 
$_SESSION['listoftrips'] = $result;
$result2=json_decode($result); //var_dump($result2); exit;
$countRes = sizeof($result2);
$noResult = "<div class='mt10 mb10'><table border=1 cellpadding=10 cellspacing=10 align='center' width=100% style='border-collapse:collapse'>
	<tr height='100px'><td align=center>No Records Found</td></tr></table></div>";
$columns=array();
$i=1;
$j=0;
$l=0;
$ArrTime=array();
$AvailSeats=array();
$bType=array();
$canPol=array();
$boarding=array();
$departTime=array();
$Fare=array();
$rowbusid=array();
$busID=array();
$travelsList = array();
$TRAVELS = array();
$columnName=array();
$flagTravels= array();

if (isset($_SESSION['Travel']))
{
  	$num_chosenTravels =count($_SESSION['Travel']);
	for ($p=0; $p < $num_chosenTravels ; $p++) 
	{
		$flagTravels[$p]=0;
	}
}
foreach ($result2 as $key => $values) 
{
    if(is_array($values))
    {
        foreach ($values as $k => $v) 
        {
           foreach ($v as $k1 => $v1) 
           {
              if(!strcmp($k1,'travels'))
              {
                  $travelsList[$j++]=$v1;
              }
           }
        }
    }
}
$travelsListnew=array_unique($travelsList);
//$_SESSION['TravelsList'] = $travelsListnew;
if($countRes > 0){
echo "<div id='container'>";
echo "<div id='content'>";
echo "<div class='side-by-side clearfix'> <div>";
$dropdownTravels = "<select data-placeholder='Choose a Travel' multiple='multiple' class='chosen-select' style='width:400px;' id='Travel[]' name='Travel[]'>";
for ($t=0; $t<$j; $t++) 
{ 
  if(!empty($travelsListnew[$t]))
  { 
	$p=0;
	if (isset($_SESSION['Travel']))
	{	
		foreach($_SESSION['Travel'] as $chosen)
		{	
			if( strpos($travelsListnew[$t], $chosen ) !== false)
			{
				$flagTravels[$p++]=1;
			}
			else
			{
				$flagTravels[$p++]=0;
			}
		}
		$flagTT=0;
		for ($q=0; $q <$p; $q++) 
		{	
			if($flagTravels[$q]==1)
			{
				$flagTT=1;
				break;
			}
		}
		if($flagTT==1)
		{
			$dropdownTravels = $dropdownTravels."<option value=".$travelsListnew[$t]." selected >" .$travelsListnew[$t]."</option>";
		}
		else
		{
			$dropdownTravels = $dropdownTravels."<option value=".$travelsListnew[$t].">" .$travelsListnew[$t]."</option>";
		}
	}
	else
		$dropdownTravels = $dropdownTravels."<option value=".$travelsListnew[$t].">" .$travelsListnew[$t]."</option>";
  }
}
$dropdownTravels=$dropdownTravels."</select>"; ?>
<? echo "<h4 style='font-family:verdana;color:#914FCB;'>Travels</h4>";
echo $dropdownTravels;?>
<!--<div class='T_button'>-->
	<span class="ml10 mb20"><input type='button' class="btn" onClick="searchForm('BusServiceList.php')" value='Filter by Travels'></span>
    <span class="ml10 mb20"><input type='button' class="btn" onclick="location.href = 'BusBooking.php';" value='Modify'></span>
<!--</div>-->
<? echo "</div></div>"; }?>
<script type="text/javascript" src="api/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="api/js/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" type="text/css" href="api/css/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="api/js/chosen.jquery.js"></script>
<script type="text/javascript">
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
</script>
<script> 
$().ready(function(){
$.tablesorter.addParser({ 
    // set a unique id 
    id: 'thousands',
    is: function(s) { 
        // return false so this parser is not auto detected 
        return false; 
    }, 
    format: function(s) { //alert(s);
        // format your data for normalization 
		var es = s.split(" ");;
		var s = es[0].trim();
        return s.replace('Rs.','').replace(/,/g,'');
    }, 
    // set type, either numeric or text 
    type: 'numeric' 
});

	$( "#CSSTableGenerator td:first-child" ).css( "border-left", "1px solid #e2e2e2" );
	$( ".myTable td:first-child" ).css( "border-left", "1px solid #333" );
	//$( "#CSSTableGenerator tr:last-child" ).css( "border-bottom", "1px solid #e2e2e2" );
	$( "#CSSTableGenerator" ).tablesorter({ 
		headers: {
            4: {//zero-based column index
                sorter:'thousands'
            }
        },
		sortList: [[3,0],[4,0],[0,0],[1,0],[2,0],[5,0]],  
		selectorHeaders: 'thead th.sortable',
		widgets: ['zebra'],
   		widgetZebra: {css: ["","alt"]}
	});
	$('.fancybox').fancybox({ 
		'width' : '500px', 
		'autoSize' : false,
		/*onStart: function(){
			var id = $(this).attr('id');
			idnum = id.slice(3);
			$('#fan'+idnum).hide();
			$('#load'+idnum).show();
		},
		afterClose: function() {
			$('#fan'+idnum).show();
			$('#load'+idnum).hide();
		  }
		helpers: {
            overlay: {
                opacity: 0.98,
                css: { 'background-color': '#fff' }
            }
        }*/
	});
	$( "#CSSTableGenerator tr:nth-child(odd), .myTable tr:nth-child(odd)" ).addClass('alt');
	
});
</script>
<!--</div>
</div>-->
<br />
<? //var_dump($result2);
//$n = 53;
//echo str_pad($n + 1, 4, 0, STR_PAD_LEFT);
$fareArr=array(array());
foreach ($result2 as $key => $value) 
{
    if(is_array($values))
    {
        $countrows=0;
        foreach ($values as $k => $v)
        {
        	$countrows++;
            foreach ($v as $k1 => $v1)
            {
            	if(!strcmp($k1, 'fares'))
                {
					if(is_array($v1))
					{
						foreach($v1 as $k2=> $v2)
						{
					  		$fareArr[$countrows][$k2]=$v2;
						}
					}
				  	else
				  	{
						$fareArr[$countrows]=$v1;
				  	}
                }
            }
        }
    }
    else
    {
      foreach ($values as $k => $v)
      {
		if(!strcmp($k, 'fares'))
	  	{
			if(is_array($v))
		  	{
				foreach($v as $k1=> $v1)
				{
					$fareArr[0][$k1]=$v1;
				}
		  	}
		  	else
			{  
				$fareArr[0]=$v;
			}
	  	}
      }
    }
}

if (isset($_SESSION['Travel'])){?>
<? if($countRes > 0){?>
<div class="mt10 mb10"><!--#1 Filtered Result-->
<table frame='box' border="0" cellpadding="0" cellspacing="0" align="center" width="100%" id="CSSTableGenerator">
<?php 
  foreach($_SESSION['Travel'] as $chosen)
  { 
      echo "<tbody>";
      foreach ($result2 as $key => $values) 
      {
      	$i=1;
        if(is_array($values))
        {   
            foreach ($values as $k => $v) {
      		  $j=0;
              foreach ($v as $k1 => $v1) 
              {
				if(!strcmp($k1,'arrivalTime')||!strcmp($k1,'availableSeats')||!strcmp($k1,'busType')||!strcmp($k1,'cancellationPolicy')||!strcmp($k1,'departureTime')||!strcmp($k1,'fares')||!strcmp($k1,'id')||!strcmp($k1, 'travels')||!strcmp($k1, 'boardingTimes') || !strcmp($k1, 'droppingTimes'))
                { 
                	if (!strcmp($k1,'arrivalTime')) {
                 		$hold1=date('h:i A', mktime(0,$v1));//getTime($v1);
                 		$ArrTime[$i]=$hold1;
                 		$columnName[0]=$k1;
                	}
                	if(!strcmp($k1,'availableSeats')){
                  		$AvailSeats[$i]=$v1;
                 		$columnName[1]=$k1;
                	}
                	if(!strcmp($k1,'busType')){
                  		$bType[$i]=$v1;
                 		$columnName[2]=$k1;
                	}
                	if(!strcmp($k1, 'cancellationPolicy')){
                  		$canPol[$i]=$v1;
                	}
					//sarah
                	if(!strcmp($k1, 'boardingTimes')){
                  		$boarding[$i]=$v1;
                	}
					if(!strcmp($k1, 'droppingTimes')){
                  		$dropping[$i]=$v1;
                	}
                	if(!strcmp($k1,'departureTime')){
                   		$hold2=date('h:i A', mktime(0,$v1));//getTime($v1);
                    	$departTime[$i]=$hold2;
                        $columnName[3]=$k1;
                	}
                	if(!strcmp($k1,'fares')){
                  		if(is_array($v1))
                      	{
                         	$num=count($v1);
                          	$fares='';
                      		for ($l=0; $l <$num ; $l++) { 
                          		$fares=((!empty($fares)) ? $fares." <br>" : '')."Rs.".$v1[$l];
                            }
                      		$Fare[$i]=$fares;
						}
                      	else
                      	{
                        	$Fare[$i]='Rs.'.$v1;
                      	}
                 		$columnName[4]=$k1;
                	}
                	if(!strcmp($k1,'id')){
                   		$busID[$i]=$v1;
                	}
                	if (!strcmp($k1,'travels')) {
                 		$TRAVELS[$i]=$v1;
                        $columnName[5]=$k1;
                	}
                  	if(!strcmp($k1,'travels'))
                 	{ 
                  		if( strpos($v1, $chosen ) !== false)
                  		{	
							 //$altcls = ( $i%2 == 0 ) ? 'alt' : ''; class=".$altcls."
							 echo "<tr>";
							 //echo "<td><span>".$i."</span></td>";
							 echo "<td style='text-align:center;'>".$ArrTime[$i]."</td>";
							 echo "<td style='text-align:center;'>".$AvailSeats[$i]."</td>";
							 echo "<td style='text-align:left;'>".$bType[$i]."</td>";
							 echo "<td style='text-align:center;'>".$departTime[$i]."</td>";
							 echo "<td style='text-align:center;'>".$Fare[$i]."</td>";
							 echo "<td style='text-align:left;'>".$TRAVELS[$i]."</td>"; 
							 //chosentwo
							 echo "<td style='text-align:center'><button type='submit' name='chosenone' class='btn' value='".$busID[$i].'|'.$TRAVELS[$i].'|'.$ArrTime[$i].'|'.$departTime[$i].'|'.$bType[$i].'|'.$canPol[$i]."' />View Seats</button></td>";
							 echo "<td style='text-align:center'>
							 <a href='#can".$i."' class='fancybox' id='fan".$i."'><img src='api/images/more_info.png' height='24'></a>";
							 echo "<a href='javascript:;' class='loadbox' id='#load".$i."' style='display:none'><img src='api/images/loading.png' height='32'></a>";
							 //echo $canPol[$i].' , '.$i.', '.$fareArr;
							 echo "<div class='hide'><div id='can".$i."' style='padding:10px;' class='nano'>
							 <h2>".$TRAVELS[$i]."</h2><br>";
							 //echo "AC: ".$v->AC."<br>";
							 //echo "ID Proof Required: ".$v->idProofRequired. "<br>";
							 //echo "mTicket Enabled: ".$v->mTicketEnabled."<br><br>";
			 ////////////////*******echo canPolicy($canPol[$i],$i,$fareArr);
			 				 echo canPolicy($canPol[$i],$i,$fareArr);
							 echo "<br>";
							 echo boardingpoints($boarding[$i]);
							 echo "<br>";
							 echo droppingpoints($dropping[$i]);
							 echo "</div></div></td></tr>";
                  		}
                 	}
                }
              }
		  	  $i++;
            }
        }
      }
  }
  echo "<thead><tr>";
  echo "<th class='sortable'><span>Arrival Time</span></th>";
  echo "<th class='sortable'><span>Seats</span></th>";
  echo "<th class='sortable'><span>Bus Type</span></th>";
  echo "<th class='sortable'><span>Departure Time</span></th>";
  echo "<th class='sortable'><span>Fares</span></th>";
  echo "<th class='sortable'><span>Travels</span></th>";
  echo "<th><span>Seat Layout</span></th>";
  echo "<th>Info</th>";
  echo "</tr></thead>";?>
  </table></div>
<?
} else {
	echo $noResult;
}
}
else 
{
if($countRes > 0){
?>

<div class="mt10 mb10"><!--#2 Full Result-->
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" id="CSSTableGenerator">
<?php
//var_dump($result2);
//Sarah - Main Results
foreach ($result2 as $key => $values) { 
    if(is_array($values))
    {   
		$countrows=0;
        foreach ($values as $k => $v) {
            $hold=''; //$altcls = ( $countrows%2 == 0 ) ? 'alt' : ''; class=".$altcls."
            echo "<tr>";
            $countrows++;
            $countkeys=0;
            foreach ($v as $k1 => $v1) 
            {	
                if(!strcmp($k1,'arrivalTime')||!strcmp($k1,'availableSeats')||!strcmp($k1,'busType')||!strcmp($k1,'cancellationPolicy')||!strcmp($k1,'departureTime')||!strcmp($k1, 'travels'))
                {
                   $countkeys++;
                   if (!strcmp($k1,'departureTime')) {
                    	$timtim = date('h:i A', mktime(0,$v1));//getTime($v1);
                    	echo "<td style='text-align:center'>".$timtim."</td>";
						$dpt = $timtim;
                    	$columns[$i++]=$k1;
                   }
                   elseif (!strcmp($k1,'arrivalTime')) {
						$timtim2 = date('h:i A', mktime(0,$v1));//getTime($v1);
						echo "<td style='text-align:center'>".$timtim2."</td>";
						$art = $timtim2;
						$columns[$i++]=$k1;
                   }
                   elseif (!strcmp($k1,'cancellationPolicy')) {
				   		$canPol = $v1;
                     	$hold= canPolicy($v1,$countrows,$fareArr);
                   }
                   elseif(!strcmp($k1,'travels')){
                        echo "<td style='text-align:left;'>".$v1."</td>";
                    	$columns[$i++]=$k1; $travels = $v1;
                   }
                   elseif (!strcmp($k1,'availableSeats')) {
                     	echo "<td style='text-align:center;'>".$v1."</td>";
                     	$columns[$i++]=$k1;
                   }
                   else { 
						echo "<td style='text-align:left'>".$v1."</td>";
						$bt = $v1;
               			$columns[$i++]=$k1;}
                   }
                   elseif(!strcmp($k1,'fares')) {
                		$countkeys++;
                  		$columns[$i++]=$k1;
               
					   	if( is_array($v1))
						{
							$num=count($v1);
							$fares='';
							for ($l=0; $l <$num ; $l++) { 
								$fares=((!empty($fares)) ? $fares." <br>" : '')."Rs.".$v1[$l];
							}
							echo "<td class='fares' style='text-align:center;'>".$fares."</td>";
						}
						else
						{
							echo "<td style='text-align:center;'>Rs.".$v1."</td>";
						}
            
                   }
                   elseif(!strcmp($k1,'id'))
                   {    
				   		$rowbusid[$countrows]=$v1;
						$storebusid=$v1;
                   }
                   elseif (!strcmp($k1,'boardingTimes')) {
                     	$boarding = boardingpoints($v1);
                   }
                   elseif (!strcmp($k1,'droppingTimes')) {
                     	$dropping = droppingpoints($v1);
                   }
            }
             echo "<td style='text-align:center'><button type='submit' name='chosenone' class='btn' value='".$storebusid.'|'.$travels.'|'.$art.'|'.$dpt.'|'.$bt.'|'.$canPol."' />View Seats</button></td>";		
			 echo "<td style='text-align:center'><a href='#can".$countrows."' class='fancybox'> <img src='api/images/more_info.png' height='24'></a>";
			 echo "<div class='hide'><div id='can".$countrows."' style='padding:10px;'>
			 <h2>".$travels."</h2><br>";
			 //echo "AC: ".$v->AC."<br>";
			 //echo "ID Proof Required: ".$v->idProofRequired. "<br>";
			 //echo "mTicket Enabled: ".$v->mTicketEnabled."<br><br>";
			 echo $hold;
			 echo "<br>";
			 echo $boarding;
			 echo "<br>";
			 echo $dropping;
			 echo "</div></div></td></tr>";
        }
    }
    else
    {
		if(!isset($values))
		{
			echo "No services for this particular route";
		}
		else // if only one service for the particular route
		{
			$countkeys=0;
			$countrows=1;
			echo "<td style='text-align:center'>".$countrows."</td>";
			foreach ($values as $k1 => $v1)
			{
				if(!strcmp($k1,'arrivalTime')||!strcmp($k1,'availableSeats')||!strcmp($k1,'busType')||!strcmp($k1,'cancellationPolicy')||!strcmp($k1,'departureTime')||!strcmp($k1,'id')||!strcmp($k1, 'travels'))
				{
			   		$countkeys++;
			   		if (!strcmp($k1,'departureTime')) {
						$timtim = date('h:i A', mktime(0,$v1));//getTime($v1);
						echo "<td style='text-align:center'>".$timtim."</td>";
						$dpt = $timtim;
						$columns[$i++]=$k1;
					}
				 	elseif (!strcmp($k1,'arrivalTime')) {
						$timtim2 = date('h:i A', mktime(0,$v1));//getTime($v1);
						echo "<td style='text-align:center'>".$timtim2."</td>";
						$art = $timtim2;
						$columns[$i++]=$k1;
				 	}
				 	elseif (!strcmp($k1,'cancellationPolicy')) {
						$canPol = $v1;
				 		$hold= canPolicy($v1,0,$fareArr);
				 	}
				 	elseif(!strcmp($k1,'travels')) {
						echo "<td style='text-align:left;'>".$v1."</td>";
						$columns[$i++]=$k1;
				 	}
				 	elseif (!strcmp($k1,'availableSeats')) {
						echo "<td style='text-align:center;'>".$v1."</td>";
						$columns[$i++]=$k1;
				 	}
				 	else {
						echo "<td style='text-align:left'>".$v1."</td>";
						$bt = $v1;
						$columns[$i++]=$k1;
					}
				}
				elseif(!strcmp($k1,'fares'))
				{
					$countkeys++;
					$columns[$i++]=$k1;
					if( is_array($v1))
					{
						$num=count($v1);
						$fares='';
						for ($l=0; $l <$num ; $l++) { 
							$fares=((!empty($fares)) ? $fares." <br>" : '')."Rs.".$v1[$l];
						}
						echo "<td style='text-align:center;' class='fares'>".$fares."</td>";
					}
					else
					{
						echo "<td style='text-align:center;'>Rs.".$v1."</td>";
					}
				}
				elseif(!strcmp($k1,'id'))
				{    
					$rowbusid[$countrows]=$v1;
					$storebusid=$v1;
				}
				elseif (!strcmp($k1,'boardingTimes')) {
					$boarding = boardingpoints($v1);
				}
				elseif (!strcmp($k1,'droppingTimes')) {
					$dropping = droppingpoints($v1);
				}
			}
			 echo "<td style='text-align:center'><button type='submit' name='chosenone' class='btn' value='".$storebusid.'|'.$travels.'|'.$art.'|'.$dpt.'|'.$bt.'|'.$canPol."' />View Seats</button></td>";
			 echo "<td style='text-align:center'><a href='#can".$countrows."' class='fancybox'> <img src='api/images/more_info.png' height='24'></a>";
			 echo "<div class='hide'><div id='can".$countrows."' style='padding:10px;' class='nano'>
			 <h2>".$travels."</h2><br>";
			 //echo "AC: ".$v->AC."<br>";
			 //echo "ID Proof Required: ".$v->idProofRequired. "<br>";
			 //echo "mTicket Enabled: ".$v->mTicketEnabled."<br><br>";
			 echo $hold;
			 echo "<br>";
			 echo $boarding;
			 echo "<br>";
			 echo $dropping;
			 echo "</div></div></td></tr>";
		}
	}
}
$columns[$countkeys]='Seat Layout';
echo "<thead>";
echo "<tr>";
for ($i=1; $i < $countkeys+1; $i++) { 
	$cls = ($i != $countkeys) ? 'sortable' : ''; 
	$col = ($columns[$i] == 'availableSeats') ? 'Seats': $columns[$i];
	echo "<th class='".$cls."'><span>".preg_replace('/(?<!\ )[A-Z]/', ' $0', ucwords($col))."</span></th>";
}
echo "<th>Info</th>";
echo "</tr>"; 
echo "</thead>";

?>
</table>
</div>
<?php 
} else {
	echo $noResult;
}
} 
echo "<br /></div></div>";?>
</form>
<?
//////////////// FUNCTIONS ////////////////
function canPolicy($v1,$countrows,$fareArr)//
{	
	$STORE = '';
	$STORE.='<table width="100%" cellpadding=3 cellspacing=3 class="myTable">
	<tr><th colspan=2><h2>Cancellation Policy</h2></th></tr>
	<tr><th align="left">Cancellation Time</th><th align="left">Charges</th></tr>';
	$cancellationcharges = explode(';', $v1);
	$limit = count($cancellationcharges);
	for ($i=0; $i <$limit ; $i++) { 
		if(!empty($cancellationcharges[$i])) 
		{	
			$ccount = strlen($cancellationcharges[$i]);
			$substr = str_split($cancellationcharges[$i]);
			$colon_count = 0;
			$p1='';
			$p2='';
			for ($j=0; $j<$ccount; $j++) { 
				if($substr[$j]==':'){
					$colon_count++;
				}
				if($colon_count<=1){
					$p1.=$substr[$j];
				}
				else{
					$p2.=$substr[$j];
				}
			}$STORE.='<tr>';
			$p2=ltrim($p2,':');
			$p1=explode(':', $p1);
			$p2=explode(':', $p2); //var_dump($p2);
			
			if($p1[0]==0) {				   
				$STORE.="<td> From ".$p1[1]." hrs to the time of departure </td>";
			}
			elseif ($p1[1]==-1) {
				$STORE.= "<td> Till ".$p1[0]." hrs before the departure time </td>";
			}
			else {
				$STORE.= "<td> Between ".$p1[1]." hrs and ".$p1[0]." hrs before the departure time</td>";
			}
			$canCharge='Rs.';
			if($p2[1]=='0')
			{ 
				if(is_array($fareArr[$countrows]))
				{
					$p=0;
					$farecount=count($fareArr[$countrows]);
					while($p<$farecount)
					{ 
						$temp=($p2[0]/100)*$fareArr[$countrows][$p];
						$canCharge.=$temp."/";
						$p++;
					}
				}
				else
				{ 
					$canCharge.=($p2[0]/100)*$fareArr[$countrows];
				}
				$canCharge=rtrim($canCharge,"/");
			}
			elseif ($p2[1]=='1') {
		  		$canCharge.= $p2[0];
			}
		 $STORE.= "<td>".$canCharge."</td></tr>";
		}
	}
	$STORE.="</table>";
	return $STORE;
}
function boardingpoints($v1)
{	
    $listout=''; // border=1 style="border-collapse:collapse; border:1px solid #eaeaea;"
	$listout.='<table width="100%" cellpadding=3 cellspacing=3 class="myTable">
	<tr><th colspan=2><h2>Boarding Points</h2></th></tr>
	<tr><th align="left">Location</th><th align="left">Time</th></tr>';
	if(is_array($v1))
	{
		foreach ($v1 as $v1) {
			$timehold = $v1->time;
			$timehold2 = date('h:i A', mktime(0,$timehold));
			$listout =$listout."<tr><td width='70%'>".$v1->location."</td><td>".$timehold2."</td></tr>";  
		}
	}
	else
	{
		$timehold = $v1->time;
		$timehold2 = date('h:i A', mktime(0,$timehold));
		$listout =$listout."<tr><td width='70%'>".$v1->location."</td><td>".$timehold2."</td></tr>"; 
	}
	$listout=$listout."</table>";
	return $listout;
}

function droppingpoints($v1)
{
	$listout='';
	$listout.='<table width="100%" cellpadding=3 cellspacing=3 class="myTable">
	<tr><th colspan=2><h2>Dropping Points</h2></th></tr>
	<tr><th align="left">Location</th><th align="left">Time</th></tr>';
	if(is_array($v1))
	{
		foreach ($v1 as $v1) {
			$timehold = $v1->time;
			$timehold2 = date('h:i A', mktime(0,$timehold));
			$listout =$listout."<tr><td width='70%'>".$v1->location."</td><td>".$timehold2."</td></tr>";  
		}
	}
	else
	{
		$timehold = $v1->time;
		$timehold2 = date('h:i A', mktime(0,$timehold));
		$listout =$listout."<tr><td width='70%'>".$v1->location."</td><td>".$timehold2."</td></tr>"; 
	}
	$listout=$listout."</table>";
	return $listout;
}

$_SESSION['busrowid'] = $rowbusid;

include('includes/api-footer.php');?>