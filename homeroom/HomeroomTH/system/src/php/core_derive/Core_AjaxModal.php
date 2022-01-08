<?php
include '../../../def/defImport.php';

// select by id
if(isset($_GET['id']) && !empty($_GET['id'])) {

	if($_GET['code']!="" && $_GET['id']!="")
	{
		if($_GET['code']=='logaction' || $_GET['code']=='logsql' || $_GET['code']=='function' || $_GET['code']=='user' || $_GET['code']=='userapi' || $_GET['code']=='userpermission' || $_GET['code']=='usermemo')
			$table = Info::$sysTable[$_GET['code']];
		else
			$table = Info::moduleTablePrefix.$_GET['code'];

		$result = DB::select($table, '*', array('id' => $_GET['id']));
		$nameresult = DB::query("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".$table."';");

		if (!$result)
		{
			$output['response_message'] = "no data";
			$output['response_status'] = true;
			$output['response_rows'] = 0;
			$output['response_data'] = null;

			echo json_encode($output);
		}
		else
		{
			$array = $result[0];

			foreach($nameresult as $name)
				$wrap[$name['COLUMN_NAME']] = $array[$name['COLUMN_NAME']];

			$output['response_message'] = "fetch data successful";
			$output['response_status'] = true;
			$output['response_rows'] = 1;
			$output['response_data'] = $wrap;

			echo json_encode($output);
		}
	}
	else
	{
		$output['response_message'] = "invalid ajax call";
		$output['response_status'] = false;
		$output['response_rows'] = -1;
		$output['response_data'] = null;

		echo json_encode($output);
	}
}
?>