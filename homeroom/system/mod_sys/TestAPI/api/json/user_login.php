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

// LOGIN USER
$where = array(
	'username' => $username
	);
$user = Amst::get($code.'_user','*',$where);

if(!$user)
	repError('Username does not exists');

if($password != $user['password'])
	repError('Password incorrect');

$_REQUEST['user_id'] = $user['id'];

include 'user_getbyid.php';
?>