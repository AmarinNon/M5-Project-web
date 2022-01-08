<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$google_id = $_REQUEST['google_id'];

// REQUIRED
$callarr = array(
	$google_id,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// login user
$login_message = User::login_google($google_id);

if($login_message != 'success')
	repError($login_message);

$userdata = User::getUserByGoogleID($google_id);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>