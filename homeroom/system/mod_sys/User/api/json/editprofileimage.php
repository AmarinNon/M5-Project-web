<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];
$profile_image = $_REQUEST['profile_image'];

// REQUIRED
$callarr = array(
	$user_id,
	$profile_image,
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

// add image
$result = File::addImage_base64("user_profileimage_".$userdata['id'],$profile_image,'../../');
if(!$result)
	repError('Unable to edit user profile image');

$_REQUEST['user_id'] = $userdata['id'];

include 'getuserbyid.php';
?>