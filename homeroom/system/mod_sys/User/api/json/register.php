<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$role = $_REQUEST['role'];

// REQUIRED
$callarr = array(
	$username,
	$password,
	$role,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$userdata = User::getUserByUsername($username);

if($userdata)
	repError('Username already exists');

// REGISTER
$userid = User::register($username,$password,$role);

if(!$userid)
	repError('Unable to register');

// EDIT
$structurelist = DB::query("SHOW COLUMNS FROM ".Info::$sysTable['user']);
foreach($structurelist as $structure)
{
	$restrictedkeys = array(
		'id',

		'facebook_id',
		'google_id',

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

unset($data['username']);
unset($data['password']);
unset($data['role']);

if($data)
{

	$result = User::editUser($userid,$data);

	if(!$result)
		repError('Add additional data failed');
}

$_REQUEST['user_id'] = $userid;

include 'getuserbyid.php';
?>