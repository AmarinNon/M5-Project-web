<?php
include '../../def/defImport.php';
include '../def/output_json.php';

// GET PARAMETER
$apikey = $_REQUEST['apikey'];
$code = $_REQUEST['code'];
$table = $_REQUEST['table'];

// REQUIRED
$callarr = array(
	$apikey,
	$code
	);
if(array_search("", $callarr) !== false)
	repInvalidCall();

// CHECK USER
if(!User::login_api($apikey))
	repVerificationFailed();

// INITIAL DATA
$targettable = $code;
if(isset($table) && $table!='')
	$targettable .= '_'.$table;

$result = Amst::getAllLast($targettable);

// CHECK IF DATA NOT EXISTS
if (!$result || mysql_num_rows($result) == 0)
	repGETNoData();

// SHOW RESULT
$nameresult = Amst::query("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".Info::moduleTablePrefix.$targettable."';");

$i = 0;
mysql_data_seek($result, 0);
while($array = mysql_fetch_array($result))
{
	mysql_data_seek($nameresult, 0);
	while($name = mysql_fetch_array($nameresult))
		$wrap[$i][$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];
	$i++;
}

repGETData($wrap);
?>