<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];
$google_id = $_REQUEST['google_id'];

// REQUIRED
$callarr = array(
	$user_id,
	$google_id,
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

// FIND EXIST GOOGLE ID
$userdata = User::getUserByGoogleID($google_id);
if($userdata)
	repError('Google id is already exists');

// REGISTER
$data = array(
	'google_id' => $google_id
	);
$result = User::editUser($user_id,$data);

if(!$result)
	repError('Unable to update data');

include 'getuserbyid.php';
?>