<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$user_id = $_REQUEST['user_id'];
$code = $_REQUEST['verification_code'];

// REQUIRED
$callarr = array(
	$user_id,
	$code,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$user = User::getUserByID($user_id);

if (!$user)
	repError('User not found');

$verify_code = $user['log_value2'] == $code;
$verify_datetime = date('Y-m-d H:i:s') < $user['log_value3'];

if (!$verify_code)
	repError('Verification failed');

if (!$verify_datetime)
	repError('Verification code expired');

$data = array(
	'tel' => $user['log_value1'],
	'log_value1' => '',
	'log_value2' => '',
	'log_value3' => '',
);

$result = User::editUser($user_id, $data);

$rep = array(
	'status' => $result,
);

rep('success',true,$rep);
?>