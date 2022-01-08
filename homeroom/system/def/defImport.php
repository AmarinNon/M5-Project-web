<?php
// display error
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

// trigger buffering on every page
ob_start();

// anchor path
define('ROOT_PHP', dirname(dirname(__FILE__)));

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
$preroot = $protocol. "://" . $_SERVER['HTTP_HOST'] . substr(dirname(dirname(__FILE__)), strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
$preroot = str_replace('\\','/',$preroot);
define('ROOT_URL', $preroot);

// set timezone
define('TIMEZONE', 'Asia/Bangkok');
date_default_timezone_set('Asia/Bangkok');

// set session timeout 3600 = 1 hour
ini_set('session.gc_maxlifetime', 18000);
session_set_cookie_params(18000);
session_start();

// turn off magic quotes
if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
{
	$_POST = array_map( 'stripslashes', $_POST );
	$_GET = array_map( 'stripslashes', $_GET );
	$_COOKIE = array_map( 'stripslashes', $_COOKIE );
}

// load data
if(!class_exists('Info'))
	include ROOT_PHP.'/Info.php';
if(!function_exists("__autoload")) 
{
	function __autoload($class_name) 
	{
		if($class_name == 'Config')
		{
			if($_SERVER['REMOTE_ADDR']=='localhost' || $_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1')
				include ROOT_PHP.'/'.Info::$sysFile['Config-Localhost'].'.php';
			else
				include ROOT_PHP.'/'.Info::$sysFile['Config-Server'].'.php';
		}
		else
		{
			if(Info::$sysFile[$class_name]!=null || Info::$sysFile[$class_name]!="")
				include ROOT_PHP.'/'.Info::$sysFile[$class_name].'.php';
		}
	}
}
?>