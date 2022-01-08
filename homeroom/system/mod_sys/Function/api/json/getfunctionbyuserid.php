<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];

// REQUIRED
$callarr = array(
	$user_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$where = array(
	'ORDER' => 'sortorderid ASC',
	'insertuserid' => $user_id
	);
$functionlist = Func::getFunctionBy($where);

$i = 0;
foreach($functionlist as $function)
{
	$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['function']);
	foreach($structurelist as $structure)
	{
		if($structure['Field'] == 'id')
			$wrap[$i]['function_id'] = $function[$structure['Field']];
		else if($structure['Field'] == 'insertuserid')
			$wrap[$i]['user_id'] = $function[$structure['Field']];
		else
			$wrap[$i][$structure['Field']] = $function[$structure['Field']];
	}

	$path = File::getPath($function['code'].'_logo','../../');
	if($path)
		$wrap[$i]['img_logo'] = $path.'?v='.date('His',strtotime($function['updatedatetime']));
	else
		$wrap[$i]['img_logo'] = ROOT_URL.'/mod_sys/Function/img/default-logo.png';
	
	$i++;
}

rep('success',true,$wrap);
?>