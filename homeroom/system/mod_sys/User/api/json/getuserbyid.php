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

// FIND EXIST USER
$userdata = User::getUserByID($user_id);

if(!$userdata)
	repNoData('user_id not exists ['.$user_id.']',false);

$i = 0;
$wrap[$i]['user_id'] = $userdata['id'];

$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['user']);

foreach($structurelist as $structure)
{
	if($structure['Field'] == 'id')
	{
		$wrap[$i]['user_id'] = $userdata[$structure['Field']];
		$wrap[$i]['user_id_encrypt'] = md5($userdata[$structure['Field']]);
	}
	else
		$wrap[$i][$structure['Field']] = $userdata[$structure['Field']];
}

$path = File::getPath('user_profileimage_'.$userdata['id'],'../../');
if($path)
	$wrap[$i]['profile_image'] = $path.'?v='.time();
else
	$wrap[$i]['profile_image'] = ROOT_URL.'/mod_sys/User/img/default-profile.png';

rep('success',true,$wrap);
?>