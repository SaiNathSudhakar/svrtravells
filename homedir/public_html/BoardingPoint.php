<? include("includes/api-functions.php"); ?>
<form action='' method='POST'>
<?php 
    include_once "api/library/OAuthStore.php";
    include_once "api/library/OAuthRequester.php";
    include_once "SSAPICaller.php";
	
    $storeboardingpointId=($_GET['boardingpointsList']!='')?$_GET['boardingpointsList']:'';
	$tripId=($_GET['tripId']!='')?$_GET['tripId']:'';
    $result = ($storeboardingpointId != '') ? getBoardingPoint($storeboardingpointId, $tripId) : '';
	
   // $result2 =  (isJson($result)) ? json_decode($result) : '';
    $result2 =  json_decode($result);
	//var_dump($result2);
	if($result2 != ''){
		echo "<table border='1' cellpadding=5 cellspacing=5 style='border-collapse:collapse'><tbody>";
		foreach ($result2 as $key => $value) {
			echo "<tr><td style='font-weight:bold; color:green;'>".$key."</td><td>".$value."</td></tr>";
		}
		echo "</tbody></table>";
	}

?>
</form>