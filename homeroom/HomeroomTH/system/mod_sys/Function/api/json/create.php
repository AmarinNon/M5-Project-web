<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$name = $_REQUEST['name'];
$module = $_REQUEST['module'];
$user_id = $_REQUEST['user_id'];
$img_logo = $_REQUEST['img_logo'];

// REQUIRED
$callarr = array(
	$name,
	$module,
	$user_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

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
			if('code' != $structure['Field'])
				repError('Restricted field used');
		}
		else
			$data[$structure['Field']] = $_REQUEST[$structure['Field']];
	}
}

$function_id = Func::addFunction($data,$user_id);

if(!$function_id)
	repError('Failed to add function');

// add successful
$function = Func::getFunctionByID($function_id);

if(!is_null($img_logo))
	$result = File::addImage_base64($function['code'].'_logo',$img_logo,'../../');

$_REQUEST['function_id'] = $function_id;

include 'getfunctionbyid.php';
?>