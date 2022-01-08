<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];
$twitter_id = $_REQUEST['twitter_id'];

// REQUIRED
$callarr = array(
	$user_id,
	$twitter_id,
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
$userdata = User::getUserBytwitterID($twitter_id);
if($userdata)
	repError('Twitter id is already exists');

// REGISTER
$data = array(
	'twitter_id' => $twitter_id
	);
$result = User::editUser($user_id,$data);

if(!$result)
	repError('Unable to update data');

include 'getuserbyid.php';
?>