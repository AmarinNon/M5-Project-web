<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$table = $_REQUEST['table'];
$id1 = $_REQUEST['id1'];
$id2 = $_REQUEST['id2'];

// REQUIRED
$callarr = array(
	$table,
	$id1,
	$id2,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$result = Amst::swap($table,$id1,$id2);

// IF FAILED
if (!$result)
	repError('Unable to swap data');

repNoData('success');
?>