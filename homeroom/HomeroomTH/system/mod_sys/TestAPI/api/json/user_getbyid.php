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
$where = array(
	'id' => $user_id
	);
$user = Amst::get($code.'_user','*',$where);

if(!$user)
	repError('User ID does not exists');

$wrap['user_id'] = $user['id'];
$wrap['username'] = $user['username'];
$wrap['password'] = $user['password'];

rep('success',true,$wrap);
?>