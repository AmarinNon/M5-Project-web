<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];

// REQUIRED
$callarr = array(
	$user_id,
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

// REGISTER
$data = array(
	'google_id' => ''
	);
$result = User::editUser($user_id,$data);

if(!$result)
	repError('Unable to update data');

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>