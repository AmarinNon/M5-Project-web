<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$filecode = $_REQUEST['filecode'];
$filedata = $_FILES['filedata'];

// REQUIRED
$callarr = array(
	$filecode,
	$filedata
);

foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// INITIAL DATA
$result = File::addFile($filecode, $filedata, '../../');
if(!$result)
	repError('Unable to add file');

include 'file_get.php';
?>