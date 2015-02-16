<?php

require_once('common.php');

$timestamp = urlencode (time());
$external = $_SERVER['REMOTE_ADDR'];

$url = getFirebaseURL($external);
echo getListOfGamesJson($url);
			
?>	