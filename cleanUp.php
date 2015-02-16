<?php

require_once('common.php');

//30 minutes
$timelimitSeconds = 60*30;


deleteStaleGame($timelimitSeconds);

function deleteStaleGame($timelimitSeconds)
{
	$baseUrl = getBaseUrl();
	$listName = getListName();
	
	$url = $baseUrl . "/" . $listName . ".json";
	
	$json = getListOfGamesJson($url);
	
	$currentTime = urlencode (time());
	$cutOffTime = $currentTime - $timelimitSeconds;
	
	if(count($json) != 0)
	{
		foreach ($json as $externalIP => $gamesListUnderIP) 
		{
			foreach ($gamesListUnderIP as $key => $value) 
			{
				if($cutOffTime > $value->time)
				{
					deleteGivenEntry($externalIP, $key);
					echo "Deleted: " . $key;
					echo "<br>";
				}
			}
		}
	}
	
}	
		
?>	