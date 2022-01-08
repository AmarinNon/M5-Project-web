<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$imagecode = $_REQUEST['imagecode'];
$imagedata = $_REQUEST['imagedata'];

// REQUIRED
$callarr = array(
	$imagecode,
	$imagedata
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$result = File::addImage_base64($imagecode,$imagedata,'../../');
if(!$result)
	repError('Unable to add image');

include 'image_get.php';
?>