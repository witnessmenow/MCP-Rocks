<?php

require_once('common.php');

$internal = urlencode($_GET['internalIp']);
$game = urlencode ($_GET['game']);
$external = $_SERVER['REMOTE_ADDR'];

$url = getFirebaseURL($external);
$json = getListOfGamesJson($url);

if(count($json) != 0)
{
	foreach ($json as $value) 
	{
		if($internal == $value->internalIp)
		{
			if($game == $value->game)
			{
				echo "true";
			}
		}
	}
}
			
?>	