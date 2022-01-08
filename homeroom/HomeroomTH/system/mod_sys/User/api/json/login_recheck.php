<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id_encrypt = $_REQUEST['user_id_encrypt'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

// REQUIRED
$callarr = array(
	$user_id_encrypt,
	$username,
	$password,
	);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$userdata = User::getUserByUsername($username);

if(!$userdata)
	repError('Recheck failed Lx01');

if(md5($userdata['id']) != $user_id_encrypt)
	repError('Recheck failed Lx02');

if($userdata['password'] != $password)
	repError('Recheck failed Lx03');

RepNoData(true,'success');
?>