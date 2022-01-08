<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$twitter_id = $_REQUEST['twitter_id'];

// REQUIRED
$callarr = array(
	$twitter_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// login user
$login_message = User::login_twitter($twitter_id);

if($login_message != 'success')
	repError($login_message);

$userdata = User::getUserByTwitterID($twitter_id);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>