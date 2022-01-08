<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

// REQUIRED
$callarr = array(
	$username,
	$password,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$where = array('username' => $username);
if(Amst::has($code.'_user',$where))
	repError('Username already exists');

// INSERT USER
$data = array(
	'username' => $username,
	'password' => $password,
	);
$user_id = Amst::insert($code.'_user',$data);

if(0 == $user_id)
	repError('Unable to register [error]');

$_REQUEST['user_id'] = $user_id;

include 'user_getbyid.php';
?>