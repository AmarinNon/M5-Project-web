<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$table = $_REQUEST['table'];

// REQUIRED
$callarr = array(
	$table
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$data = array();

foreach ($_REQUEST as $key => $value)
{
	if($key=='table') continue;
	if($key=='code') continue;
	if($key=='apikey') continue;
	if($key=='action') continue;

	$data[$key] = $_REQUEST[$key];
}

if(!$data)
	repError('No data to insert data['.implode(',', $data).']');

// ADD DATA
$result = Amst::insert($table,$data);

// IF FAILED
if (!$result)
	repError('Unable to insert data');

$_REQUEST['id'] = $result;

include 'getbyid.php';
?>