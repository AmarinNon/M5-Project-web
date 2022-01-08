<?php
include '../../def/defImport.php';
include '../def/output_json.php';

// GET PARAMETER
$apikey = $_REQUEST['apikey'];
$imagecode = $_REQUEST['imagecode'];

// REQUIRED
$callarr = array(
	$apikey,
	$imagecode
	);
if(array_search("", $callarr) !== false)
	repInvalidCall();

// CHECK USER
if(!User::login_api($apikey))
	repVerificationFailed();

// INITIAL DATA
$path = File::getPath($imagecode);

if($path=='' || is_null($path))
	repCustomNoData('imagecode not found',false);

// add path
// FIND LINK
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

if (strpos($pageURL,'api/json') !== false) 
{
	$pos = strpos($pageURL, 'api/json');

	$url = substr($pageURL,0,$pos);
}
else
	$url = 'ERROR';

$path = str_replace('../', '', $path);
$path = $url.$path;

$wrap[0]['path'] = $path;

// add encode 64
$file = file_get_contents($path);
$wrap[0]['encode64'] = base64_encode($file);

repGETData($wrap);
?>