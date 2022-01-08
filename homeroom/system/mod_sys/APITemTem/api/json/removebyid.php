<?php
include '../../def/defImport.php';
include '../def/output_json.php';

// GET PARAMETER
$apikey = $_REQUEST['apikey'];
$code = $_REQUEST['code'];
$table = $_REQUEST['table'];
$removeid = $_REQUEST['removeid'];

// REQUIRED
$callarr = array(
	$apikey,
	$code,
	$removeid
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

$nameresult = Amst::query("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".Info::moduleTablePrefix.$targettable."';");

// FETCH DATA BEFORE DELETE
$resultdata = Amst::getByID($targettable,$removeid);
$i = 0;
mysql_data_seek($resultdata, 0);
while($array = mysql_fetch_array($resultdata))
{
	mysql_data_seek($nameresult, 0);
	while($name = mysql_fetch_array($nameresult))
		$wrap[$i][$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];
	$i++;
}

// CHECK IF DATA NOT AVAILABLE
if ($i==0)
	repOperationFailed();

// EDIT DATA
$result = Amst::removeByID($targettable,$removeid);

// CHECK IF UNABLE TO EDIT
if ($result==0)
	repOperationFailed();

repOperationSuccess($wrap);
?>