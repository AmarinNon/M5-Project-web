<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$email = $_REQUEST['email'];

// REQUIRED
$callarr = array(
	$email,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

// FIND EXIST USER
$where = array(
	'OR' => array(
		'email' => $email,
		'username' => $email,
	),
);

$userdata = User::getUserByList($where);

if(!$userdata[0])
	repError('The email is incorrect.');

$user = $userdata[0];

$reset_link = ROOT_URL . '/../confirmreset.php?token=' . $user['password'] . '&user_id=' . $user['id'];

$to      = $email;
$subject = 'Reset password link';
$message = 'Reset password link: ' . $reset_link;
$headers = 'From: noreply@panta.xyz';

$sendmail = mail($to, $subject, $message, $headers);

$wrap = array('status' => $sendmail);

rep('success',true,$wrap);
?>