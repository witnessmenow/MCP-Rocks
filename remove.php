<?php

require_once('common.php');

$firebaseKey = urlencode($_GET['key']);
$external = $_SERVER['REMOTE_ADDR'];

deleteGivenEntry($externalIP, $firebaseKey);
		
?>	