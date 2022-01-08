<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$filecode = $_REQUEST['filecode'];

// REQUIRED
$callarr = array(
	$filecode
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$path = File::getPath($filecode, '../../');

if($path=='' || is_null($path))
	repError('filecode not found',false);

$wrap = array();
$wrap[0]['code'] = $filecode;
$wrap[0]['url'] = $path;

rep('success',true,$wrap);
?>