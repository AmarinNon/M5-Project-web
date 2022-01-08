<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$facebook_id = $_REQUEST['facebook_id'];
$role = $_REQUEST['role'];

// REQUIRED
$callarr = array(
	$facebook_id,
	$role,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$userdata = User::getUserByFacebookID($facebook_id);

if($userdata)
{
	include 'login_facebook.php';
	exit();
}

$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['user']);
foreach($structurelist as $structure)
{
	$restrictedkeys = array(
		'id',

		'register',
		'lastlogin',
		);
	if(isset($_REQUEST[$structure['Field']]))
	{
		if(array_search($structure['Field'], $restrictedkeys) !== false)
			repError('Restricted field used');
		else
			$data[$structure['Field']] = $_REQUEST[$structure['Field']];
	}
}

if(!$data)
	repError('no data to register');

// REGISTER
$userid = User::register('facebook_'.$facebook_id,md5('facebook_'.$facebook_id),$role);

if(!$userid)
	repNoData('Unable to register',false);

User::editUser($userid,array('facebook_id' => $facebook_id));

$_REQUEST['user_id'] = $userid;

include 'getuserbyid.php';
?>