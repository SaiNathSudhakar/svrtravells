<?php
include_once "api/library/OAuthStore.php";
include_once "api/library/OAuthRequester.php";
include_once "SSAPICaller.php";

$storesource = $_POST['sourceList'];
$scr = getAllDestinations($storesource);
$json_o = json_decode($scr);
$destcities = $json_o->cities;
//var_dump($destcities);

if(sizeof($destcities) <= 1) { $destcities = array($destcities); }

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
usort($destcities, 'my_sort'); //onChange='validateForm($storesource,this.value)'
$selectControlForDestination = "<select id='destinationList' name='destinationList' class='input chosen-select'>";
if(is_array($destcities))
{
	$selectControlForDestination .= "<option value=''>Select Destination </option>";
	foreach ($destcities as $destcities) 
	{
		$selectControlForDestination = $selectControlForDestination."<option value=". $destcities->id.">"
							. $destcities->name."</option>";
	}
	$selectControlForDestination = $selectControlForDestination."</select>";
}
$destinationList = $selectControlForDestination;
echo $destinationList; ?>
