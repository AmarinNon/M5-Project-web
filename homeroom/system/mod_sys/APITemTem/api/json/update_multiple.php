<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$updatelist = $_REQUEST['updatelist'];

// REQUIRED
$callarr = array(
	$updatelist,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
foreach($updatelist as $updates)
{
	$data = array();
	foreach ($updates as $key => $value)
	{
		if($key=='id') continue;
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
		repError('No data to update');

	// UPDATE DATA
	$where = array('id' => $updates['id']);
	$result = Amst::update($table,$data,$where);

	// IF FAILED
	if (!$result)
		repError('Unable to update data');
}

repNoData('success',true);
?>