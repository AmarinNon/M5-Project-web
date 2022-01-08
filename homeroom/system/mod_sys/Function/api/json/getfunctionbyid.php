<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$function_id = $_REQUEST['function_id'];

// REQUIRED
$callarr = array(
	$function_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$function = Func::getFunctionByID($function_id);

if(!$function)
	repError('Function ID does not exist');

$wrap['function_id'] = $function['id'];

$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['function']);
foreach($structurelist as $structure)
{
	if($structure['Field'] == 'id')
		$wrap['function_id'] = $function[$structure['Field']];
	else if($structure['Field'] == 'insertuserid')
		$wrap['user_id'] = $function[$structure['Field']];
	else
		$wrap[$structure['Field']] = $function[$structure['Field']];
}
$path = File::getPath($function['code'].'_logo','../../');
if($path)
	$wrap['img_logo'] = $path.'?v='.date('His',strtotime($function['updatedatetime']));
else
	$wrap['img_logo'] = ROOT_URL.'/mod_sys/Function/img/default-logo.png';

rep('success',true,$wrap);
?>