<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// FIND EXIST USER
$userlist = User::getUser();

$i = 0;
foreach($userlist as $user)
{
	$wrap[$i]['user_id'] = $user['id'];

	$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['user']);

	foreach($structurelist as $structure)
	{
		if($structure['Field'] == 'id')
			$wrap[$i]['user_id'] = $user[$structure['Field']];
		else
			$wrap[$i][$structure['Field']] = $user[$structure['Field']];
	}

	$path = File::getPath('user_profileimage_'.$user['id'],'../../');
	if($path)
		$wrap[$i]['profile_image'] = $path.'?v='.time();
	else
		$wrap[$i]['profile_image'] = ROOT_URL.'/mod_sys/User/img/default-profile.png';

	$i++;
}

rep('success',true,$wrap);
?>