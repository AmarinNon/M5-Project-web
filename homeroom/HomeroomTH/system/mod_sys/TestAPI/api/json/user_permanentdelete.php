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

$where = array(
	'id' => $user_id
	);
$user = Amst::get($code.'_user','*',$where);

if(!$user)
	repError('User ID does not exists');

$result = Amst::delete($code.'_user',$where);

if($result)
	repNoData('Success',true);
else
	repError('Unable to delete user [error]');
?>