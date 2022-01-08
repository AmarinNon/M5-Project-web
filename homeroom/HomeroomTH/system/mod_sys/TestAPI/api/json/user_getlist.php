<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

$userlist = Amst::select($code.'_user','*');

$wrap = array();
$i = 0;
foreach($userlist as $user)
{
	$wrap[$i]['user_id'] = $user['id'];
	$wrap[$i]['username'] = $user['username'];
	$wrap[$i]['password'] = $user['password'];

	$i++;
}

rep('success',true,$wrap);
?>