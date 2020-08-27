<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// Stop PHPs dangerous name handling
function undefined_name_error($errno, $errstr, $errfile='', $errline=0, $errcontext=NULL) {
	if (stripos($errstr, 'Undefined') !== false) {
		error_log("PHP Fatal error:  $errstr in $errfile on line $errline");
		exit(255);
	}
	else {
		return false;
	}
}
set_error_handler('undefined_name_error', E_NOTICE);

ini_set('display_errors', '0');

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, must-revalidate');

// Database credentials
$db_creds = json_decode(file_get_contents('/home/w3bachsau_api/mysql_credentials.json', false));
define('MYSQL_USER', $db_creds->user);
define('MYSQL_PASS', $db_creds->pass);
unset($db_creds);

// API output function
function output($success, $data) {
	if ($success) {
		$output = array(true, $data);
		echo json_encode($output, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
	}
	else {
		$output = array(false, (string) $data);
		echo json_encode($output, JSON_UNESCAPED_UNICODE);
	}
	exit(0);
}
