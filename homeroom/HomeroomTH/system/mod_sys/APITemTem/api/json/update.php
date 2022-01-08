<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];

// REQUIRED
$callarr = array(
	$table,
	$id
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$data = array();

$data = array();

foreach ($_REQUEST as $key => $value)
{
	if($key=='id') continue;
	if($key=='table') continue;
	if($key=='code') continue;
	if($key=='apikey') continue;
	if($key=='action') continue;

	$data[$key] = $_REQUEST[$key];
}

if(!$data)
	repError('No data to update');

// UPDATE DATA
$where = array('id' => $id);
$result = Amst::update($table,$data,$where);

// IF FAILED
if (!$result)
	repError('Unable to update data');

include 'getbyid.php';
?>