<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$imagecode = $_REQUEST['imagecode'];

// REQUIRED
$callarr = array(
	$imagecode
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$path = File::getPath($imagecode, '../../');

if($path=='' || is_null($path))
	repError('imagecode not found',false);

$wrap = array();
$wrap[0]['code'] = $imagecode;
$wrap[0]['url'] = $path;

rep('success',true,$wrap);
?>