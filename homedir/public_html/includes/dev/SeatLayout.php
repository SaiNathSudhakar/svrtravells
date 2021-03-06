<? ob_start();
include("includes/api-header.php");
include_once("includes/functions.php");
include_once "includes/api-functions.php";
if(empty($_SESSION[$svr.'busbook'])) header('location:BusBooking.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(empty($_POST['boardingLoc'])) { header('location:SeatLayout.php'); }
	$_SESSION['chkchk'] = sizeof($_POST['chkchk']);
	$_SESSION['boardingpointsList'] = $_POST['boardingpointsList'];
	$_SESSION['boardingTime'] = $_POST['boardingTime'];
	$_SESSION['boardingLoc'] = $_POST['boardingLoc'];
	$_SESSION['seatnames'] = $_POST['seatnames'];
	$_SESSION['fare'] = $_POST['fare'];
	
	$fare = number_format($_SESSION['fare'], 2, '.', ''); 
	$ag_deposit = getdata('svr_agent_reports', 'ar_closing_bal', "ar_ag_id = '".$_SESSION[$svra.'ag_id']."' order by ar_id desc");
	$dposit = number_format($ag_deposit, 2, '.', '');
	if(!empty($_SESSION[$svra.'ag_id']) && $dposit < $fare) {
		header('location:agent-insufficient-balance.php');
	} else {
		header('location:generateForm.php');
	}
} //echo $_SESSION['canPolicy']; exit;
?>
<title>SEAT LAYOUT</title>
<!--<div class="banner_inner"><img src="images/aboutus.jpg" alt="About SVR Travels" /></div>-->
<div class="navigation">
	<div class="bg">
        <a href="index.php">Home</a><span class="divied"></span>
        <a href="BusBooking.php">Bus Booking</a><span class="divied"></span>
        <a href="BusServiceList.php">Bus Service List</a><span class="divied"></span>
		<span class="pagename">Seat Layout</span>
    </div>
</div>
<? include('travel-info.php');?>
<link rel="stylesheet" href="api/css/seatlayout.css" type="text/css" />
<link rel="stylesheet" href="css/form-styls.css" type="text/css" />
<script language="javascript" type="text/javascript">
$().ready(function(){
$("form input").each(function(){
    var elem = $(this);
    var type = elem.attr("type");
    if(type == "checkbox") elem.prop("checked", "");
    else if(type == "text") elem.val("");
});
	/*$(".imagehover").tooltip({
   	 show: {
        effect: "slideDown",
        delay: 250
   	 }
	});#seatlayout_custom */
	//$('td:contains("<img src="api/images/no_seat.jpg">")').parent().remove();
	//$("td:empty").remove();
});
imgseaterArr=new Array(); 
imgladiesseaterArr=new Array();
imgvsleeperArr=new Array();
imgladiesvsleeperArr=new Array();
imghsleeperArr=new Array();
imgladieshsleeperArr=new Array();
for(var i=0;i<100;i++)
{	
	imgseaterArr[i]=new Array('api/images/ac_semi_sleeper_vacant.jpg','api/images/ac_sleeper_selected.jpg'); 
	imgladiesseaterArr[i]=new Array('api/images/non_ac_seater_ladies.jpg','api/images/ac_sleeper_selected.jpg'); 
	imgvsleeperArr[i]=new Array('api/images/volvo_sleeper_vertical_vacant.jpg','api/images/volvo_sleeper_vertical_selected.jpg');
	imgladiesvsleeperArr[i]=new Array('api/images/non_ac_vertical_sleeper_ladies.jpg','api/images/volvo_sleeper_vertical_selected.jpg');
	imghsleeperArr[i]=new Array('api/images/volvo_sleeper_vacant.jpg','api/images/volvo_sleeper_selected.jpg');
	imgladieshsleeperArr[i]=new Array('api/images/non_sleeper_ac_ladies.jpg','api/images/volvo_sleeper_selected.jpg');
}
function swapseater(chk,ind){ 
	img=document.images['img'+ind]; 
	if(chk){ 
		img.src=imgseaterArr[ind][1]; 
		img.alt=imgseaterArr[ind][1]; 
	} 
	else{ 
		img.src=imgseaterArr[ind][0]; 
		img.alt=imgseaterArr[ind][0]; 
	} 
}
function swapladiesseater(chk,ind){ 
	img=document.images['img'+ind]; 
	if(chk){ 
		img.src=imgladiesseaterArr[ind][1]; 
		img.alt=imgladiesseaterArr[ind][1]; 
	} 
	else{ 
		img.src=imgladiesseaterArr[ind][0]; 
		img.alt=imgladiesseaterArr[ind][0]; 
	} 
}
function swapvsleeper(chk,ind){ 
	img=document.images['vsleep'+ind]; 
	if(chk){ 
		img.src=imgvsleeperArr[ind][1]; 
		img.alt=imgvsleeperArr[ind][1]; 
	} 
	else{ 
		img.src=imgvsleeperArr[ind][0]; 
		img.alt=imgvsleeperArr[ind][0]; 
	} 
}
function swapladiesvsleeper(chk,ind){ 
	img=document.images['vsleep'+ind]; 
	if(chk){ 
		img.src=imgladiesvsleeperArr[ind][1]; 
		img.alt=imgladiesvsleeperArr[ind][1]; 
	} 
	else{ 
		img.src=imgladiesvsleeperArr[ind][0]; 
		img.alt=imgladiesvsleeperArr[ind][0]; 
	} 
}
function swaphsleeper(chk,ind){ 
	img=document.images['hsleep'+ind]; 
	if(chk){ 
		img.src=imghsleeperArr[ind][1]; 
		img.alt=imghsleeperArr[ind][1]; 
	} 
	else{ 
		img.src=imghsleeperArr[ind][0]; 
		img.alt=imghsleeperArr[ind][0]; 
	} 
}
function swapladieshsleeper(chk,ind){ 
	img=document.images['hsleep'+ind]; 
	if(chk){ 
		img.src=imgladieshsleeperArr[ind][1]; 
		img.alt=imgladieshsleeperArr[ind][1]; 
	} 
	else{ 
		img.src=imgladieshsleeperArr[ind][0]; 
		img.alt=imgladieshsleeperArr[ind][0]; 
	} 
}
function getXMLHTTP(){ 
	var xmlhttp=false;  
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e) {       
		try{            
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
	
	return xmlhttp;
}
function BoardingPoint(chosenboardingpoint) { 
	var e = document.getElementById("boardingpointsList");
	var boarding = e.options[e.selectedIndex].id;
	var board = boarding.split('#'); //alert('boarding');
	document.getElementById('boardingLoc').value = board[0];
	document.getElementById('boardingTime').value = board[1];
	
   	/*var strURL="BoardingPoint.php?boardingpointsList="+chosenboardingpoint+"&tripId=<?=$_SESSION['chosenone']?>";
   	var req = getXMLHTTP();
	if(req) {
        req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) {
					document.getElementById('selection').innerHTML=req.responseText;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}               
		}   
		req.open("GET",strURL,true);
		req.send(null);
	}*/
}
</script>
<?php
$base_url = "http://api.seatseller.travel/";

//echo "<form method='GET' action='generateForm.php' name='form3' onSubmit=''>";
echo "<form method='POST' name='form3' onSubmit=''>";

$image_seater_vacant="api/images/ac_semi_sleeper_vacant.jpg";
$image_seater_selected="api/images/ac_sleeper_selected.jpg";
$image_seater_unavailable="api/images/ac_semi_sleeper_unavailable.jpg";
$image_seater_ladies="api/images/non_ac_seater_ladies.jpg";

$image_sleeper_vacant="api/images/volvo_sleeper_available.jpg";
$image_sleeper_unavailable="api/images/volvo_sleeper_unavailable.jpg";
$image_sleeper_ladies="api/images/non_sleeper_ac_ladies.jpg";

$image_vertical_sleeper_vacant="api/images/volvo_sleeper_vertical_vacant.jpg";
$image_vertical_sleeper_unavailable="api/images/volvo_sleeper_vertical_unavailable.jpg";
$image_vertical_sleeper_ladies="api/images/non_ac_vertical_sleeper_ladies.jpg";

$image_empty_row="api/images/no_seat.jpg";

echo "<h3 align='center' style='margin-bottom:15px;'>SEAT LAYOUT</h3>";
$flag=0;  // for flaging if sleeper or seater bus
$flag2=0; // for flaging if completely vertical sleepers
$flagseatsleep1=0; // for seaters in lower
$flagseatsleep2=0; // for upper sleepers

$flaglsleep=0;  // flag if lower has sleepers
$flaglseat=0;  // flag if lower has seats   
$rowvalue=1;
$y=0;

// Getting the chosen bus id.
if(isset($_SESSION['chosentwo']))
{	
	$chosenbusid = $_SESSION['chosentwo']; //$_GET['chosentwo'];
	//echo "The chosen bus id on second page ( after the filtering) is".$chosenbusid;
}
else
{	
	$chosenbusid = $_SESSION['chosenone']; //$_GET['chosenone'];
	//echo "The chosen bus id on main page is".$chosenbusid;
}

$sourceid = $_SESSION['sourceList']; //$_GET['sourceList'];
$destinationid = $_SESSION['destinationList']; //$_GET['destinationList'];
$date = $_SESSION['datepicker']; //$_GET['datepicker'];

$result1 = getAvailableTrips($sourceid,$destinationid,$date); 
$tripdetails = getTripDetails($chosenbusid);     
$tripdetails2 = json_decode($tripdetails);
$seats = $tripdetails2->seats;
// foreach loop for the value variable
foreach ($tripdetails2 as $key => $value)
{
    if(is_array($value)) 
    {
        $s=array(array());
        $sleeper=array(array(array()));
        $seatsleep=array(array(array()));
        foreach ($value as $k => $v) 
        {
            foreach ($v as $k1 => $v1)//checking first for seater and sleeper bus
            {
                if(isset($v->zIndex)&&isset($v->length)&&isset($v->width))
                {
                    if ($v->zIndex==0) // checks lower berths
                    {
                        if (($v->length==2 && $v->width==1 )||($v->length==1 && $v->width==2 )) // both vertical and horizontal sleepers in Lower Berth
                        {
                            $flaglsleep=1;
                            $seatsleep[$v->zIndex][$v->row][$v->column]=$v;  
                        }
                        elseif ($v->length==1 && $v->width==1)
                        {
                            $flagseatsleep1=1; 
                            $flaglseat=1;
                            $seatsleep[$v->zIndex][$v->row][$v->column]=$v;
                        }
                    }
                    elseif ($v->zIndex==1) // only sleepers in upper berths
                    {
                        $seatsleep[$v->zIndex][$v->row][$v->column]=$v;
                        $flagseatsleep2=1;
                    }
                }
            }//ends foreach ($v as $k1 => $v1)
        }//ends foreach ($value as $k => $v)
        if (($flagseatsleep1==1)&&($flagseatsleep2==1)) // if it is a seater+sleeper
        {
            //echo "THIS IS SEATER+ SLEEPER";
            /*
            $seatsleep[0]  // this is seats/sleepers lower level;
            $seatsleep[1]   // these are sleepers upper level
            */
            $rowcountseater = count($seatsleep[0]);
            $max=0;
            $mini = array(); // holds the number of seats in every row
            for ($i=0; $i <=$rowcountseater; $i++)
            { 
             	if(isset($seatsleep[0][$i]))
                {
                	$mini[$i]=count($seatsleep[0][$i]);
                }
            }
            $min=max($mini);
            $posi=array();
            $countter=0;
            for ($j=0; $j <=$rowcountseater; $j++) // for finding the maximum number of seats in each row and using that as the limit in the for loop
            {
                $countter=0;
                $i=0;
                do
                { 
                    if(!empty($seatsleep[0][$j]))
                    {
                        if(empty($seatsleep[0][$j][$i]))
                        {
                            if (empty($seatsleep[0][$j][$i+1]))
                            {
                                if(isset($mini[$j]))
                                {
                                    if($countter==$mini[$j])        
                                    {
                                    	$posi[$j]=$i; 
                                    	break;
                                    }
                                }
                            }
                        }
                        else
                        { 
							$countter++;
                        	$pos=$i;
                        }
                    }
                    $i++;
                } 
                while (($i<$min*2));
            }
            $actual = max($posi);
            for($i=0;$i<=$rowcountseater;$i++)
            {
                if(!empty($seatsleep[0][$i]))
                {
                    if(count($seatsleep[0][$i])>$max)
                    {
                      $max=count($seatsleep[0][$i]);
                    }
                    if (count($seatsleep[0][$i])<$min) 
                    {
                      $min=count($seatsleep[0][$i]);
                    }
                }
            }
            $rowcountsleeper = count($seatsleep[1]); 
            $rowcountseater = count($seatsleep[0]);
            $sleeperperrowcount = count($seatsleep[1][0]);
            //For getting the number of seats per row in seater
			for($i=0;$i<=$rowcountseater;$i++)
			{
				if(!empty($seatsleep[0][$i]))
				{
					$flagS=0;
					$flagSL=0;
					$seatcount=count($seatsleep[0][$i]);
					if(!empty($seatsleep[0][$i][0]))
					{
						if(($seatsleep[0][$i][0]->length==2 && $seatsleep[0][$i][0]->width==1)||($seatsleep[0][$i][0]->length==1 && $seatsleep[0][$i][0]->width==2))
						{
						  	$flagSL=1;
						}
						else
						{
						  	$flagS=1;
						}
						for ($j=1; $j <$seatcount; $j++) 
						{ 
							if(!empty($seatsleep[0][$i][$j]))
							{
								if ($flagS==1 && (($seatsleep[0][$i][$j]->length==2 && $seatsleep[0][$i][$j]->width==1)||($seatsleep[0][$i][$j]->length==1 && $seatsleep[0][$i][$j]->width==2)))
								{
									$flagSL=1;
									break;
								}
								elseif ($flagSL==1 && ($seatsleep[0][$i][$j]->length==1 && $seatsleep[0][$i][$j]->width==1)) 
								{			
									$flagS=1;
									break;
								}
							}
						}
					}
				}
				if($flagS==1 && $flagSL==1)
				{
					break;
				}
			}
			if($flagS==1 && $flagSL==1)
			{
				$seatperrowcount=$min*2;
			}
			else
			{
				$seatperrowcount = $max;
			}
            // ends finding the limit for the seater loop (number of seats in a row)
            // FUNCTION CALL (1) UPPER BERTHS IN SEATER+SLEEPER
            generatelayout($rowcountsleeper,$sleeperperrowcount,$seatsleep,1,1);   
            //LOWER BERTHS
            // if seats and sleepers lower berths
            if ($flaglseat==1 && $flaglsleep==1)
            {
                generatelayout($rowcountseater,$actual,$seatsleep,0,1);
            }
            elseif ($flaglseat==1 && $flaglsleep==0) 
            {
                generatelayout($rowcountseater,$seatperrowcount,$seatsleep,0,1);
            }
        } //ends if it is a seater+sleeper
        // If its not sleeper+seater -> basic seater/ sleeper
        elseif((($flagseatsleep1==0)&&($flagseatsleep2==0))||(($flagseatsleep1==1)&&($flagseatsleep2==0))||(($flagseatsleep1==0)&&($flagseatsleep2==1)))
        {
            $sleepersize=array(array(array()));
            foreach ($value as $k => $v) 
            {
				foreach ($v as $k1 => $v1) 
				{
					if(isset($v->length)&&isset($v->width))
					{
						if($v->length==1 && $v->width==1) // condition for seater or semi-sleeper
						{
							$flag=2;
							if(!strcmp($k1,'row'))
							{
								$s[$v1][$v->column]=$v;
							}
						}
						else if(($v->length==2 && $v->width==1)||($v->length==1 && $v->width==2)) // condition for horizontal sleeper
						{  
							$flag=1;
							if($v->length==2 && $v->width==1)
							{ 
							   $flag2=1;
							}
							if(!strcmp($k1,'row'))
							{
								if($v1>=$rowvalue){ $rowvalue=$v1;}
								$sleeper[$v->zIndex][$v1][$v->column]=$v;
								$sleepersize[$v->zIndex][$v1][$v->column]=$v->column;
							}
						}
					}
				}
			}
			$rowcountseater = count($s);  
			$seatperrowcount = count($s[0]);
			$c=0;
			for($i=0;$i<=$rowvalue;$i++)
			{
			  if(!empty($sleeper[0][$i])){$c++;}
			}
			$rowcountsleeper=$c;
			// If it is a sleeper
			if ($flag==1)
			{
				if (!empty($sleeper[0][$rowvalue]))
				{  
				 	$sleeperperrowcount0= count($sleeper[0][$rowvalue]);
				}
				else
				{ 
					$sleeperperrowcount0=0;
				}
				if (!empty($sleeper[1][$rowvalue]))
				{   
					$sleeperperrowcount1= count($sleeper[1][$rowvalue]);
				} // change made here
				else
				{
					$sleeperperrowcount1=0;
				}
				$sleeperperrowcount = max($sleeperperrowcount1,$sleeperperrowcount0);
				$MAXX=0;
				for ($i=1; $i >=0 ; $i--)
				{   
					for ($j=0; $j <=$rowvalue; $j++)
					{
					   if(!empty($sleepersize[$i][$j])) 
						{
							$X=max($sleepersize[$i][$j]);  
						}else{
							$X=0; 
						}
						if($X>$MAXX)
						{
							$MAXX = $X;
						}
					}
					if($flag2==1) // horizontal + vertical sleepers
					{
						//generate seatlayout 
						generatelayout($rowvalue,$MAXX,$sleeper,$i,0);
					}else{
						$Z=$sleeperperrowcount+1;
						generatelayout($rowvalue,$Z,$sleeper,$i,0);
					}
				}
			}
			elseif ($flag==2) // If it is seater
			{
				if(!empty($s))
				{
					generateLayoutSeater($rowcountseater,$seatperrowcount,$s);
				}
			}
        } // ends if NOT sleeper+seater
    } // ends if(is_array($value))
}// foreach loop for the value variable ends

echo "<table align='center' cellpadding='2' cellspacing=2><tr>";
echo "<td><img src='api/images/icon_available.png' /><td><td align='left' colspan='' valign='top'>Available</td>";
echo "<td><img src='api/images/icon_unavailable.png' /><td><td align='left' colspan='' valign='top'>Booked</td>";
echo "<td><img src='api/images/icon_selected.png' /><td><td align='left' colspan='' valign='top'>Selected</td>";
echo "<td><img src='api/images/icon_ladies.png' /><td><td align='left' colspan='' valign='top'>Ladies Seat</td>";
echo "</tr></table><br>";
	
echo "<table cellpadding=10 cellspacing=1 border=0 style='border:1px solid #eaeaea;' width='100%'>
<tr bgcolor='#F4F4F4'><td><h2>Seats and Boarding Points Information</h2></td></tr>
<tr><td>";
echo "<table cellpadding=5 cellspacing=1 border=0>";

echo "<tr><td width=50>SEAT(S) : <input type='hidden' name='seatnames' id='t'></td><td id='seats'>-</td></tr>";
//echo "<tr><td><textarea id='t' name='seatnames' class='input' readonly>Seats:</textarea></td><td>Right</td></tr>";
echo "<tr><td width=50>FARE : <input type='hidden' name='fare' id='f' val='0.00'><input type='hidden' name='farelist' id='flist'></td><td id='fare'>Rs. 0</td></tr>";
echo "<tr><td colspan=2><div style='bold'> BOARDING POINTS</div></td></tr>";
$result2=json_decode($result1); //var_dump($result2);
foreach ($result2 as $key => $values) 
{	
    if(is_array($values))
    {	
        foreach ($values as $k => $v) 
        {	
           	foreach ($v as $k1 => $v1) 
           	{
                if($v->id==$chosenbusid)
                {
					$v2 = listofboardingpoints($v->boardingTimes);
					$b = "<tr><td colspan=2>".$v2."</td></tr>";
					break;
                }
            }
        }
    }else{
        foreach ($values as $k1 => $v1) 
        {
          	if($values->id==$chosenbusid)
            {
				$v2 = listofboardingpoints($values->boardingTimes);
				$b = "<tr><td colspan=2>".$v2."</td></tr>";  
				break;
            }
        }
    }
}
echo $b;
function listofboardingpoints($v1, $i)
{	
    $listout="<select onChange='BoardingPoint(this.value)' id='boardingpointsList' name='boardingpointsList' class='input'>";
	$listout.="<option value=''>Select Location</option>";
	if(is_array($v1))
	{
		foreach ($v1 as $v1)  
		{
			$timehold = $v1->time;
			$timehold2 = date('h:i A', mktime(0,$timehold)); //getTime($timehold);
			$listout = $listout."<option id='".$v1->location."#".$timehold2."' value=".$v1->bpId."> LOCATION:".$v1->location." TIME: ".$timehold2."</option>";  
		}
		$listout = $listout."</select>";
	}else{
		$timehold = $v1->time;
		$timehold2 = date('h:i A', mktime(0,$timehold)); //getTime($timehold);
		$listout = $listout."<option id='".$v1->location."#".$timehold2."' value=".$v1->bpId."> LOCATION:".$v1->location." TIME: ".$timehold2."</option>";  
		$listout = $listout."</select>";
	}
	return $listout;
}
$y=0;
function generatelayout($rowcountsleeper,$sleeperperrowcount,$seatsleep,$UpperLower,$horVer)
{
    if($UpperLower==1)
	{
		echo "<br><h3 align='center'>UPPER SECTION</h3>";
		$i=1;
		if($horVer==1)
		{
			$klimit = ($sleeperperrowcount*2+1) ;
		}
		elseif ($horVer==0) 
		{
			$klimit = $sleeperperrowcount+1 ;
		}
	}
    elseif ($UpperLower==0)
	{
		echo "<br><h3 align='center'>LOWER SECTION</h3>";
		$i=0;
		$klimit=$sleeperperrowcount;
	}
	$x=0;
	global $y;
	echo "<table align='center' cellpadding='' cellspacing='' width='' class='seatlayout_img_custom' id='seatlayout_custom'><tbody>";
	$l=0;
	for ($j=0; $j <=$rowcountsleeper; $j++) 
	{ 
		echo "<tr>";
		for ($k=0; $k <=$klimit; $k++) 
		{ 
		   if(!empty($seatsleep[$i][$j][$k]))
		   { 
				if($seatsleep[$i][$j][$k]->length==2 && $seatsleep[$i][$j][$k]->width==1)
				{
					if(!strcmp($seatsleep[$i][$j][$k]->available,'true'))    
					{
						if(!strcmp($seatsleep[$i][$j][$k]->ladiesSeat,'true'))
						{
							echo "<td><div id='c_b' class='container'><label for='hsleep".$i.$j.$k."'><img name='hsleep".$y."'src='api/images/non_sleeper_ac_ladies.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover'/><input type='checkbox' name='chkchk[]' class='checkbox' id='hsleep".$i.$j.$k."' value='".$seatsleep[$i][$j][$k]->name."' onclick='swapladieshsleeper(this.checked,".$y++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
						}else{
							echo "<td><div id='c_b' class='container'><label for='hsleep".$i.$j.$k."'><img name='hsleep".$y."'src='api/images/volvo_sleeper_vacant.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover'/><input type='checkbox' name='chkchk[]' class='checkbox' id='hsleep".$i.$j.$k."' value='".$seatsleep[$i][$j][$k]->name."'onclick='swaphsleeper(this.checked,".$y++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
						}
					}else{
						echo "<td><div class='container_un'><img src='api/images/volvo_sleeper_unavailable.jpg'/>
						<input type='checkbox' name='empty' style='visibility:hidden;width:0px;'/></div></td>";
					} 
				}
				elseif ($seatsleep[$i][$j][$k]->length==1 && $seatsleep[$i][$j][$k]->width==2) 
				{
					if(!strcmp($seatsleep[$i][$j][$k]->available,'true'))    
					{
						if(!strcmp($seatsleep[$i][$j][$k]->ladiesSeat,'true'))
						{
							echo "<td><div id='c_b' class='container_vert'><label for='vsleep".$i.$j.$k."'><img name='vsleep".$y."'src='api/images/non_ac_vertical_sleeper_ladies.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover'/><input type='checkbox' class='checkbox' name='chkchk[]' id='vsleep".$i.$j.$k."' value='".$seatsleep[$i][$j][$k]->name."' onclick='swapvsleeper(this.checked,".$y++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
						}else{
							echo "<td><div id='c_b' class='container_vert'><label for='vsleep".$i.$j.$k."'><img name='vsleep".$y."'src='api/images/volvo_sleeper_vertical_vacant.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover'/><input type='checkbox' class='checkbox' name='chkchk[]' id='vsleep".$i.$j.$k."' value='".$seatsleep[$i][$j][$k]->name."'onclick='swapvsleeper(this.checked,".$y++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
						}
					}else{
						echo "<td><div class='container_vert_un'><img src='api/images/volvo_sleeper_vertical_unavailable.jpg'/>
						<input type='checkbox' name='empty' style='visibility:hidden;width:0px;'/></div></td>";
				   	} 
				}
				elseif ($seatsleep[$i][$j][$k]->length==1 && $seatsleep[$i][$j][$k]->width==1) 
				{
					$storeseatname=$seatsleep[$i][$j][$k]->name;
					if(!strcmp($seatsleep[$i][$j][$k]->available,'true'))
					{
						if(!strcmp($seatsleep[$i][$j][$k]->ladiesSeat,'true'))
						{
							echo "<td><div id='c_b'class='container'><label for='seat".$j.$k."'><img name='img".$l."' id='".$k.$j."' src='api/images/non_ac_seater_ladies.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover'/><input type='checkbox' class='checkbox' name='chkchk[]' id='seat".$j.$k."' value='".$seatsleep[$i][$j][$k]->name."' onclick='swapladiesseater(this.checked,".$l++.")' style='visibility:hidden;width:0px;'/></label></div></td>" ;
						} 
						else
						{
						 	echo "<td><div id='c_b'class='container'><label for='seat".$j.$k."'><img name='img".$l."' id='".$k.$j."'src='api/images/ac_semi_sleeper_vacant.jpg' title='Seat Number:".$seatsleep[$i][$j][$k]->name." | Fare: ".$seatsleep[$i][$j][$k]->fare."' class='imagehover' /><input type='checkbox' class='checkbox' name='chkchk[]' id='seat".$j.$k."' value='".$seatsleep[$i][$j][$k]->name."' onclick='swapseater(this.checked,".$l++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
						}  
					}
					else
					{
						echo "<td><div class='container_un'><img src='api/images/ac_semi_sleeper_unavailable.jpg'/>
						<input type='checkbox' name='empty' style='visibility:hidden;width:0px;'/></div></td>";
					}    
				}
			}
			if(empty($seatsleep[$i][$j][$k]))
			{
				if (empty($seatsleep[$i][$j])) 
				{
					echo "<td><img src='api/images/no_seat.jpg'/></td>";
				}
				elseif (!empty($seatsleep[$i][$j])) 
				{
					echo "<td></td>";
				}
			}
		}
		echo "</tr>";
	}
	echo "</tbody></table><br>";
}
function generateLayoutSeater($rowcountseater,$seatperrowcount,$s)
{
   if(!empty($s))
   { 
     echo "<table align='center' border='0' cellpadding='' cellspacing='' class='seatlayout_img_custom' id='seatlayout_custom'><tbody>";
     $k=0;
     for ($i=0; $i <=$rowcountseater; $i++) 
     { 
        echo "<tr>";
        for ($j=0; $j <= $seatperrowcount; $j++) 
        {	
            if(!empty($s[$i][$j]))
            {	
                $storeseatname=$s[$i][$j]->name;
                if(!strcmp($s[$i][$j]->available,'true'))    
                {
                   if(!strcmp($s[$i][$j]->ladiesSeat,'true'))
                   {	
                    	echo "<td><div id='c_b'class='container'><label for='seat".$i.$j."'><img name='img".$k."' id='".$j.$i."' src='api/images/non_ac_seater_ladies.jpg' title='Seat Number:".$s[$i][$j]->name." | Fare: ".$s[$i][$j]->fare."' class='imagehover'/><input type='checkbox' class='checkbox' name='chkchk[]' id='seat".$i.$j."' value='".$s[$i][$j]->name."' onclick='swapladiesseater(this.checked,".$k++.")' style='visibility:hidden;width:0px;'/></label></div></td>" ;
                   }else{
                 		echo "<td><div id='c_b'class='container'><label for='seat".$i.$j."'><img name='img".$k."' id='".$j.$i."' src='api/images/ac_semi_sleeper_vacant.jpg' title='Seat Number:".$s[$i][$j]->name." | Fare: ".$s[$i][$j]->fare."' class='imagehover' /><input  type='checkbox' class='checkbox' name='chkchk[]' id='seat".$i.$j."' value='".$s[$i][$j]->name."' onclick='swapseater(this.checked,".$k++.")' style='visibility:hidden;width:0px;'/></label></div></td>";
                    }
                }else{
                	echo "<td><div class='container_un'><img src='api/images/ac_semi_sleeper_unavailable.jpg'/>
					<input type='checkbox' name='empty' style='visibility:hidden;width:0px;'/></div></td>";
                }  
            }
            if(empty($s[$i][$j]))
            {	
                if(empty($s[$i])) 
                {	
                    echo "<td><img src='api/images/no_seat.jpg'/></td>";
                }
            	elseif(!empty($s[$i])) 
              	{	
                	echo "<td></td>";
              	}
            }
        }
    	echo "</tr>";
    }
	echo "</table><br>";
	
	//Sarah
	/*echo "<table align='center' cellpadding='2' cellspacing=2><tr>";
	echo "<td align='center' colspan='' valign='top'>Available</td><td><img src='api/images/icon_available.png' /><td>";
	echo "<td align='center' colspan='' valign='top'>Booked</td><td><img src='api/images/icon_unavailable.png' /><td>";
	echo "<td align='center' colspan='' valign='top'>Selected</td><td><img src='api/images/icon_selected.png' /><td>";
	echo "<td align='center' colspan='' valign='top'>Ladies Seat</td><td><img src='api/images/icon_ladies.png' /><td>";
	echo "</tr></table><br>";*/
	
   }
}
?>
<script type="text/javascript">
function swapImage(id,primary,secondary) 
{	
    src = document.getElementById(id).src;
    if (src.match(primary)) {
      document.getElementById(id).src = secondary;
    } else {
      document.getElementById(id).src = primary;
    }
}
function updateTextArea() 
{	
	var allVals = [];
	$('#c_b :checked').each(function() {
		if($('input.checkbox').filter(':checked').length == 6) {
			$('input.checkbox:not(:checked)').attr('disabled', 'disabled');
		} else { 
			$('input.checkbox').removeAttr('disabled');
		}	
		allVals.push($(this).val());
	});
	$('#t').val(allVals)
}
$(function(){
	$('#c_b input').click(updateTextArea);
	updateTextArea(); //$('#checkbox').is(':checked')
	var total_fare = 0.00;
	$('.checkbox').click(function(){
		var seats = $('#t').val();
		$('#seats').html(seats);
		var seatarr = seats.split(',');
		if(seatarr.length > 6){	return false; }
		var sThisVal = ($(this).is(':checked') ? "1" : "0");
		var title1 = $(this).prev().attr("title");
		var title2 = title1.split('|');
		var title3 = title2[1].split(':');
		var fare = title3[1].trim(); //alert(sThisVal);
		
		if(sThisVal == 1) {
		 	total_fare = parseFloat(total_fare) + parseFloat(fare);
		} else if(sThisVal == 0) {
			total_fare = parseFloat(total_fare) - parseFloat(fare);
		}
		total_fare = parseFloat(Math.round(total_fare * 100) / 100).toFixed(2);
		$('#fare').html('Rs. ' + total_fare);
		$('#f').val(total_fare);
		if(seatarr.length == 6) alert('Max 6 Seats can be booked per ticket.');
	});
});
</script>

<? 
//echo "<tr><td colspan=2><div id='selection'></div></td></tr>";
echo "<tr><td colspan=2>";
echo "<input type='hidden' name='datepicker' class='btnclass' value='".$date."'/>";
echo "<input type='hidden' name='sourceList' class='btnclass' value='".$sourceid."'/>";
echo "<input type='hidden' name='destinationList' class='btnclass' value='".$destinationid."'/>";      
echo "<input type='hidden' name='chosenone' class='btnclass' value='".$chosenbusid."'/>"; //chosenbus
echo "<input type='hidden' name='boardingLoc' id='boardingLoc' class='btnclass' />";
echo "<input type='hidden' name='boardingTime' id='boardingTime' class='btnclass' />";
echo "<p id='submit_button'><input type='submit' name='chosesubmit' class='submit' value='Continue' onClick='return validation()'></p>";
echo "<p id='button_replacement' style='display:none;'><input type='submit' value='Processing...' class='submit' onclick='return false;' /></p>";
echo "</td></tr>";
echo "</table>";
echo "</td></tr></table></form><br>";

include("includes/api-footer.php");?>

<script>
function validation(){
	var d=document.form3;
	if(d.seatnames.value==""){alert("Please select Seat");d.seatnames.focus();return false;}
	if(d.boardingpointsList.value==""){alert("Please select Boarding Points");d.boardingpointsList.focus();return false;}
	
	if(d.seatnames.value!="" && d.boardingpointsList.value!=""){
		document.getElementById("submit_button").style.display = "none";
    	document.getElementById("button_replacement").style.display = "";
	}	
}
</script>