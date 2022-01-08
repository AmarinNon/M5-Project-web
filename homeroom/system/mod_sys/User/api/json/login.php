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

// login user
$login_message = User::login_server($username,$password);

if($login_message != 'success')
	repError($login_message);

$userdata = User::getUserByUsername($username);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>