<?php
// PLAN TO REMOVE THIS SOMEDAY !!!!!!!!!!!!!!!!!!

// 1. it stand alone here
// 2. it use for internal only which some how unorganize
// 3. it is old code
// 4. try to remove this someday
// solution.
// use api folder at front
// only problem is that one required apikey which default we don't have
// try to created one file separately secretly and navigate other file that use this to that new file
// then remove this !!!! 
include '../../def/defImport.php';

$outputsuccess = "fetch data successful";
$outputnodata = "no data";
$outputwarning = "invalid ajax call";

// select by id
if(isset($_GET['ajaxselectid']) && !empty($_GET['ajaxselectid'])) {

	if($_GET['code']!="" && $_GET['id']!="")
	{
		if($_GET['code']=='logaction' || $_GET['code']=='logsql' || $_GET['code']=='function' || $_GET['code']=='user' || $_GET['code']=='userapi')
			$table = Info::$sysTable[$_GET['code']];
		else
			$table = Info::moduleTablePrefix.$_GET['code'];

		$arr = array(
			"id" => $_GET['id']
			);
		$result = Query::select($table,$arr);

		$nameresult = Query::executeQuery("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".$table."';");

		if (!$result || mysql_num_rows($result) == 0)
		{
			$output['response_message'] = $outputnodata;
			$output['response_status'] = true;
			$output['response_rows'] = 0;
			$output['response_data'] = $wrap;

			echo json_encode($output);
		}
		else
		{
			$array = mysql_fetch_array($result);

			mysql_data_seek($nameresult, 0);
			while($name = mysql_fetch_array($nameresult))
				$wrap[$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];

			$output['response_message'] = $outputsuccess;
			$output['response_status'] = true;
			$output['response_rows'] = 1;
			$output['response_data'] = $wrap;

			echo json_encode($output);
		}
	}
	else
	{
		$output['response_message'] = $outputwarning;
		$output['response_status'] = false;
		$output['response_rows'] = -1;
		$output['response_data'] = null;

		echo json_encode($output);
	}
}

// select all
if(isset($_GET['ajaxgetall']) && !empty($_GET['ajaxgetall'])) {

	if($_GET['code']!="")
	{
		if($_GET['code']=='logaction' || $_GET['code']=='logsql' || $_GET['code']=='function' || $_GET['code']=='user')
			$table = Info::$sysTable[$_GET['code']];
		else
			$table = Info::moduleTablePrefix.$_GET['code'];

		$result = Query::getAllLast($table);

		$nameresult = Query::executeQuery("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".$table."';");

		if (!$result || mysql_num_rows($result) == 0)
		{
			$output['response_message'] = $outputnodata;
			$output['response_status'] = true;
			$output['response_rows'] = 0;
			$output['response_data'] = $wrap;

			echo json_encode($output);
		}
		else
		{
			$i = 0;
			mysql_data_seek($result, 0);
			while($array = mysql_fetch_array($result))
			{
				mysql_data_seek($nameresult, 0);
				while($name = mysql_fetch_array($nameresult))
					$wrap[$i][$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];

				$i++;
			}

			$output['response_message'] = $outputsuccess;
			$output['response_status'] = true;
			$output['response_rows'] = $i;
			$output['response_data'] = $wrap;

			echo json_encode($output);
		}
	}
	else
	{
		$output['response_message'] = $outputwarning;
		$output['response_status'] = false;
		$output['response_rows'] = -1;
		$output['response_data'] = null;

		echo json_encode($output);
	}
}
?>