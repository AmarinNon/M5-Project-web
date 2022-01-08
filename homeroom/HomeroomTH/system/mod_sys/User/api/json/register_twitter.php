<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$twitter_id = $_REQUEST['twitter_id'];
$role = $_REQUEST['role'];

// REQUIRED
$callarr = array(
	$twitter_id,
	$role,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$userdata = User::getUserByTwitterID($twitter_id);

if($userdata)
{
	include 'login_twitter.php';
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
$userid = User::register('twitter_'.$twitter_id,md5('twitter_'.$twitter_id),$role);

if(!$userid)
	repNoData('Unable to register',false);

User::editUser($userid,array('twitter_id' => $twitter_id));

$_REQUEST['user_id'] = $userid;

include 'getuserbyid.php';
?>