<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$table = $_REQUEST['table'];
$where = $_REQUEST['where'];

// REQUIRED
$callarr = array(
	$table,
	$where,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// PREPARE WHERE FIX FOR [] FRON CLIENT SIDE
foreach($where as $wherekey => $wheredata)
{
	if('AND' == $wherekey || 'OR' == $wherekey)
	{
		foreach($wheredata as $whereinkey => $whereindata)
		{
			if (strpos($whereinkey, '{{') !== false) 
			{
				$newkey = str_replace('{{', '[', $whereinkey);
				$newkey = str_replace('}}', ']', $newkey);

				$where[$wherekey][$newkey] = $where[$wherekey][$whereinkey];
				unset($where[$wherekey][$whereinkey]);
			}
			else
				$newkey = $whereinkey;
			
			if(is_numeric($whereindata))
				$where[$wherekey][$newkey] = ($whereindata+0);
		}
	}

	if (strpos($wherekey, '{{') !== false) {
		$newkey = str_replace('{{', '[', $wherekey);
		$newkey = str_replace('}}', ']', $newkey);

		$where[$newkey] = $where[$wherekey];
		unset($where[$wherekey]);
	}
	else
		$newkey = $wherekey;

	if(is_numeric($wheredata))
		$where[$newkey] = ($wheredata+0);
}

// INITIAL DATA
$count = Amst::count($table,$where);

// SHOW RESULT
$wrap = array();
$wrap['total_row'] = $count;

rep('success',true,$wrap);
?>