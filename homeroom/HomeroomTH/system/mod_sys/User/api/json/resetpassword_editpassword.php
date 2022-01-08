<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];
$oldpassword = $_REQUEST['oldpassword'];
$newpassword = $_REQUEST['newpassword'];

// REQUIRED
$callarr = array(
	$user_id,
	$oldpassword,
	$newpassword,
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

if($userdata['password'] != $oldpassword)
	repError('Old password is incorrect.');

// REGISTER
$data = array('password' => $newpassword);
$result = User::editUser($user_id,$data);

if(!$result)
	repNoData('Unable to edit code',false);

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>