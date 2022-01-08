<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$function_id = $_REQUEST['function_id'];

// REQUIRED
$callarr = array(
	$function_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$function = Func::getFunctionByID($function_id);

if(!$function)
	repError('No exists function ID in the system');

$result = Func::removeFunction($function_id,$function['module'],$function['code'],$function['name']);

if(!$result)
	repError('Failed to remove function');

repNoData(true,'success');
?>