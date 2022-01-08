<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



echo "1. ".$_SERVER["DOCUMENT_ROOT"]."<br />";
echo "2. ".dirname(__FILE__)."<br />";
echo "3. ".basename(__FILE__)."<br />";
echo "4. ".$_SERVER["HTTP_REFERER"]."<br />";
echo "4.1. ".$_SERVER["HTTP_HOST"]."<br />";
echo "5. ".$_SERVER['HTTP_REFERER'].basename(__FILE__)."<br />";

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
$filenamepattern = '/'.basename(__FILE__).'/';
echo "6. ".$protocol."://".$_SERVER['HTTP_HOST'].preg_replace($filenamepattern,"",$_SERVER['REQUEST_URI'])."<br />";

echo "6.1. ".$_SERVER['HTTP_HOST']."<br />";
echo "6.2. ".$_SERVER['REQUEST_URI']."<br />";

$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

if (strpos($pageURL,'mod_ex/700trail') !== false) 
{
	$pos = strpos($pageURL, 'mod_ex/700trail');
	$url = substr($pageURL,0,$pos);
}
else
	$url = 'ERROR';
echo "7. ".$url."<br />";

?>