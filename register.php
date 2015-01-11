<?php

require_once('common.php');

$internal = urlencode($_GET['internalIp']);
$game = urlencode ($_GET['game']);
$timestamp = urlencode (time());
$external = $_SERVER['REMOTE_ADDR'];


$url = getFirebaseURL($external);

//Validate that required parameters are passed
if(empty($internal))
{
	echo "ERROR: Please provide an \"internalIP\" parameter";
}
else if(empty($game))
{
	echo "ERROR: Please provide a \"game\" parameter";
}
else
{
	//All parameters were passed.

	//remove duplicates if we have them
	checkForDuplicateServer($url, $external, $internal);

	registerGameWithFirebase($url, $game, $internal, $timestamp);
}

//Servers can not run multiple games on the same IP address and port number,
//So if we find a dup lets remove it
function checkForDuplicateServer($url, $externalIP, $internal)
{
	$json = getListOfGamesJson($url);
	if(count($json) != 0)
	{
		foreach ($json as $key => $value) 
		{
			if($internal == $value->internalIp)
			{
				deleteGivenEntry($externalIP, $key);
			}
		}
	}

}

function registerGameWithFirebase($url, $game, $internal, $timestamp)
{
	$data = array('game' => $game, 'internalIp' => $internal, 'time' => $timestamp);	
	$server_output = sendPost($url, $data);
	echo $server_output;

}		
		
?>	