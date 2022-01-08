<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$function_id = $_REQUEST['function_id'];
$img_logo = $_REQUEST['img_logo'];

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
$data = array();

$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['function']);
foreach($structurelist as $structure)
{
	$restrictedkeys = array(
		'id',
		'code',
		);
	if(isset($_REQUEST[$structure['Field']]))
	{
		if(array_search($structure['Field'], $restrictedkeys) !== false)
		{
			if('code'!=$structure['Field'])
				repError('Restricted field used : '.$restrictedkeys);
		}
		else
		{
			if($function[$structure['Field']] != $_REQUEST[$structure['Field']])
				$data[$structure['Field']] = $_REQUEST[$structure['Field']];
		}
	}
}

if(!empty($data))
{
	$result = Func::editFunction($function_id,$data);

	if(!$result)
		repError('Failed to edit function data');
}

if(''!=$img_logo)
{
	$result = File::addImage_base64($function['code'].'_logo',$img_logo,'../../');

	if(!$result)
		repError('Failed to edit function image');
}

$_REQUEST['function_id'] = $function_id;

include 'getfunctionbyid.php';
?>