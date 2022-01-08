<?php
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
  if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) ) {
    $_POST = array_map( 'stripslashes', $_POST );
    $_GET = array_map( 'stripslashes', $_GET );
    $_COOKIE = array_map( 'stripslashes', $_COOKIE );
  }

  define('CURRENT_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

  require_once 'SystemZaa.php';
  require_once 'Homeroom.php';
?>