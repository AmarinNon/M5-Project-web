<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$message = $_REQUEST['message'];

// REQUIRED
$callarr = array(
	$message,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$wrap['message'] = $message;

rep('Success',true,$wrap);
?>