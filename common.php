<?php

require_once('Secret.php');

function convertExternalIPToSavable($externalIP)
{
	$modified = str_replace(".","_",$externalIP);
	return $modified;
}

function getFirebaseURL($externalIP, $includeJsonEnding = true)
{
	$baseUrl = getBaseUrl();
	$listName = getListName();
	
	if($includeJsonEnding)
	{
		$jsonEnding = ".json";
	}
	else
	{
		$jsonEnding = "";
	}
	
	$modified = convertExternalIPToSavable($externalIP);
	$url = $baseUrl . "/" . $listName . "/" . $modified . $jsonEnding;

	return $url;
}

//Gets list of games and encodes as Json
function getListOfGamesJson($url)
{
	$result = file_get_contents($url);
	//$json = json_encode($result);
	return $result;
}

//Gets list of games and decodes as Json
function getListOfGames($url)
{
	$result = file_get_contents($url);
	$json = json_decode($result);
	return $json;
}

function deleteGivenEntry($externalIP, $firebaseKey)
{
	$url = getFirebaseURL($externalIP, false);
	$url = $url . "/" . $firebaseKey . ".json";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
}

function sendPost($url, $data)
{
	$data_string = json_encode($data); 
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				$data_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);         
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);

	curl_close ($ch);
	
	return $server_output;
}

function updateTimestampOfGivenEntry($externalIP, $firebaseKey)
{
	$url = getFirebaseURL($externalIP, false);
	$url = $url . "/" . $firebaseKey . ".json";
	
	$timestamp = urlencode (time());
	
	$data = array('time' => $timestamp);
	$data_string = json_encode($data); 

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");   
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				$data_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);         
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);
	echo $server_output;
	curl_close ($ch);
}
		
?>	