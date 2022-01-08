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
	repError('User id not exists');

// REGISTER
$data = array();

$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['user']);
foreach($structurelist as $structure)
{
	$restrictedkeys = array(
		'id',
		'password',

		'facebook_id',
		'google_id',

		'register',
		'lastlogin',
		);
	if(isset($_REQUEST[$structure['Field']]))
	{
		if(array_search($structure['Field'], $restrictedkeys) !== false)
			repError('Restricted field used : '.$restrictedkeys);
		else
			$data[$structure['Field']] = $_REQUEST[$structure['Field']];
	}
}

if(!$data)
	repError('Please update value before submit');

$result = User::editUser($user_id,$data);

if(!$result)
	repNoData('Please update value before submit',false);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>