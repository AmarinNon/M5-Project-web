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
$where = array('id' => $id);
$list = Amst::get($table,'*',$where);

// CHECK IF DATA NOT EXISTS
if (!$list)
	repNoData('No data',false);

// SHOW RESULT
foreach($list as $key => $value)
	$wrap[0][$key] = $value;

rep('success',true,$wrap);
?>