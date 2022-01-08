<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$facebook_id = $_REQUEST['facebook_id'];
$user_id = $_REQUEST['user_id'];

// REQUIRED
$callarr = array(
	$user_id,
	$facebook_id,
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

// FIND EXIST FACEBOOK ID
$userdata = User::getUserByFacebookID($facebook_id);
if($userdata)
	repError('Facebook id is already exists');

// REGISTER
$data = array(
	'facebook_id' => $facebook_id
	);
$result = User::editUser($user_id,$data);

if(!$result)
	repError('Unable to update data');

include 'getuserbyid.php';
?>