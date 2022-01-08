<?php
$debug = false;

if($debug)
{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
else
{
	error_reporting(0);
	ini_set('display_errors', 0);
}

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
	header('Content-Type: application/json');
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}

// OPERATION
function repError($message)
{
	$output['response_message'] = $message;
	$output['response_status'] = false;

	LogginAPICall('API ERROR : '.$message);

	if(!$result)
		$output['response_message'];

	echo json_encode($output);
	exit();
}

function rep($message, $status, $wrap = array(), $customData = array())
{
	$output['response_message'] = $message;
	$output['response_status'] = $status;
	$output['response_rows'] = count($wrap);
	$output['response_data'] = $wrap;

	$output = array_merge($output, $customData);

	echo json_encode($output);
	exit();
}

function repNoData($message, $status)
{
	$output['response_message'] = $message;
	$output['response_status'] = $status;

	echo json_encode($output);
	exit();
}
?>