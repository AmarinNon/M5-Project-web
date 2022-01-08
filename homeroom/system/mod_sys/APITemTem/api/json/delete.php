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
$data = array('status' => 'DeActive');
// UPDATE DATA
$where = array('id' => $id);
$result = Amst::update($table,$data,$where);

// IF FAILED
if (!$result)
	repError('Unable to delete data');

repNoData('success');
?>