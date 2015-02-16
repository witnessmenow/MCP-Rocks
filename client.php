<?php

require_once('common.php');

$timestamp = urlencode (time());
$external = $_SERVER['REMOTE_ADDR'];

$url = getFirebaseURL($external);
$json = getListOfGames($url);

echo "Found the following games on the same IP as you";
echo "<br>";
echo "<br>";

if(count($json) != 0)
{
	foreach ($json as $value) 
	{
		$internal = urldecode ($value->internalIp);
		echo "<a href=\"http://".$internal."\">Game: " . $value->game . " - IP: ". $internal."</a>";
		echo "<br>";
	}
}
			
?>	