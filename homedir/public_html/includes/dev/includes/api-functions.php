<?
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";

/*function getSourceName($source_id)
{
	global $src;
	$src = getAllSources();
	$source = json_decode($src);
	$source_cities = $source->cities;
	foreach($source_cities as $scities){
		if($scities->id == $source_id)
			$source_name = $scities->name;
	}
	return $source_name;
}

function getDestinationName($source_id, $destination_id)
{
	global $dest;
	$dest = getAllDestinations($source_id);
	$source = json_decode($dest);
	$destination_cities = $source->cities;
	foreach($destination_cities as $dcities){
		if($dcities->id == $destination_id)
			$destination_name = $dcities->name;
	}
	return $destination_name;
}

function getBusDetails($chosenbusid, $sourceid, $destid, $date)
{	
	global $travels;
	$result = getAvailableTrips($sourceid, $destid, $date); 
	$travels = json_decode($result);
	
	foreach ($travels as $key => $values) 
	{	
		if(is_array($values))
		{
			foreach ($values as $k => $v) 
			{ 
			   foreach ($v as $k1 => $v1) 
			   {
				   	if(!strcmp($k1,'id')){
				   		$busid[]=$v1;
				   	}if(!strcmp($k1,'travels')){
						$busname[]=$v1;
					}if(!strcmp($k1,'arrivalTime')){
						$timtim = date('h:i A', mktime(0,$v1));
						$arrivaltime[]=$timtim;
					}if(!strcmp($k1,'departureTime')){
						$timtim2 = date('h:i A', mktime(0,$v1));
						$departureTime[]=$timtim2;
					}if(!strcmp($k1,'busType')){
						$busType[]=$v1;
					}
			   }
			}
		}
	}
	$operators = array_combine_array($busid, array('busName' => $busname), array('arrivalTime' => $arrivaltime), array('departureTime' => $departureTime), array('busType' => $busType));
	foreach($busid as $key => $value) {
		if($value == $chosenbusid) {
			$busName = $operators[$value]['busName'];
			$arrivalTime = $operators[$value]['arrivalTime'];
			$departureTime = $operators[$value]['departureTime'];
			$busType = $operators[$value]['busType'];
		}
	}
	return $busName.'#'.$arrivalTime.'#'.$departureTime.'#'.$busType;
}*/

/*function getBoardingPointLocation($boadring)
{
	$result = getBoardingPoint($boarding);
	$boarding = json_decode($result);
}*/
?>