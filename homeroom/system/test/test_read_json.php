<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$json =  '{"name":"ter"}';

echo $json.'<br />';

$json_decode = json_decode($json,true);

foreach($json_decode as $key => $value)
	echo $key .' - '. $value;