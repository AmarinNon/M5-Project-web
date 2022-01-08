<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$facebook_id = $_REQUEST['facebook_id'];

// REQUIRED
$callarr = array(
	$facebook_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// login user
$login_message = User::login_facebook($facebook_id);

if($login_message != 'success')
	repError($login_message);

$userdata = User::getUserByFacebookID($facebook_id);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>