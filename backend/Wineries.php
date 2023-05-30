<?php
//include 'Config.php';

	$GLOBALS['conn'] = $connection; // stores the MYSQLi connection in Config.php for easy access

	header('Content-Type: application/json');
	header('Cache-Control: no-cache, no-store, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');

	$input_json = json_decode(file_get_contents("php://input"),true);// retrieve json from API call


?>