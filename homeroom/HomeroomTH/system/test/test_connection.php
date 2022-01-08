<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conf/secret_info.php';

echo "<h3>DB INFO</h3>";
echo "dbserver : ".Config::dbserver."<br />";
echo "dbusername : ".Config::dbusername."<br />";
echo "dbpassword : ".Config::dbpassword."<br />";
echo "dbname : ".Config::dbname."<br />";
echo "<br />";

echo "<h3>Check Connection</h3>";
$con = mysql_connect(Config::dbserver,Config::dbusername,Config::dbpassword);
if ($con)
	echo "connect -> PASS";
else
	echo "connect -> ERROR : ". mysql_error();
echo "<br />";

if (mysql_query("SET NAMES UTF8"))
	echo "set utf8 -> PASS";
else
	echo "set utf8 -> ERROR : ". mysql_error();
echo "<br />";

if (mysql_select_db(Config::dbname,$con))
	echo "select db -> PASS";
else
	echo "select db -> ERROR : ". mysql_error();
echo "<br />";



?>