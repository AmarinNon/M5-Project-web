<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$insertlist = $_REQUEST['insertlist'];

// REQUIRED
$callarr = array(
	$insertlist
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

foreach($insertlist as $inserts)
{
	// INITIAL DATA
	$data = array();

	foreach ($inserts as $key => $value)
	{
		if($key=='table') {
			$table = $value;
			continue;
		}
		if($key=='code') continue;
		if($key=='apikey') continue;
		if($key=='action') continue;

		$data[$key] = $value;
	}

	if(!$data)
		repError('No data to insert data['.implode(',', $data).']');

	// ADD DATA
	$result = Amst::insert($table,$data);

	// IF FAILED
	if (!$result)
		repError('Unable to insert data');
}

repNoData('success',true);
?>