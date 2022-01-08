<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$google_id = $_REQUEST['google_id'];
$role = $_REQUEST['role'];

// REQUIRED
$callarr = array(
	$google_id,
	$role,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$userdata = User::getUserByGoogleID($google_id);

if($userdata)
{
	include 'login_google.php';
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
$userid = User::register('google_'.$google_id,md5('google_'.$google_id),$role);

if(!$userid)
	repNoData('Unable to register',false);

User::editUser($userid,array('google_id' => $google_id));

$_REQUEST['user_id'] = $userid;

include 'getuserbyid.php';
?>