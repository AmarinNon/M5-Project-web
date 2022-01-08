<?php
include '../../def/defImport.php';
include '../def/output_json.php';

// GET PARAMETER
$apikey = $_REQUEST['apikey'];
$code = $_REQUEST['code'];
$table = $_REQUEST['table'];
$editid = $_REQUEST['editid'];

// REQUIRED
$callarr = array(
	$apikey,
	$code,
	$editid
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

$arr = array();

$nameresult = Amst::query("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".Info::moduleTablePrefix.$targettable."';");
mysql_data_seek($nameresult, 0);
while($name = mysql_fetch_array($nameresult))
{
	if($name['COLUMN_NAME']=='id') continue;

	if(isset($_REQUEST['edit'.$name['COLUMN_NAME']]))
		$arr[$name['COLUMN_NAME']] = $_REQUEST['edit'.$name['COLUMN_NAME']];

	if(isset($_POST['edit'.$name['COLUMN_NAME']]))
		$arr[$name['COLUMN_NAME']] = $_POST['edit'.$name['COLUMN_NAME']];
}

// EDIT DATA
$result = Amst::edit($targettable,$editid,$arr);

// CHECK IF UNABLE TO EDIT
if ($result==0)
	repOperationFailed();

// SHOW RESULT
$resultdata = Amst::getByID($targettable,$editid);
$i = 0;
mysql_data_seek($resultdata, 0);
while($array = mysql_fetch_array($resultdata))
{
	mysql_data_seek($nameresult, 0);
	while($name = mysql_fetch_array($nameresult))
		$wrap[$i][$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];
	$i++;
}

repOperationSuccess($wrap);
?>