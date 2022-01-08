<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

// GET PARAMETER
$tel = $_REQUEST['tel'];
$user_id = $_REQUEST['user_id'];

// REQUIRED
$callarr = array(
	$tel,
	$user_id,
);
foreach($callarr as $call)
{
	if(is_null($call))
		repError('Missing Parameter');
}

$code = sprintf("%04d", rand(0, 9999));

$user = User::getUserByID($user_id);

if (!$user)
	repError('User not found');

$message = "Panta%20verification%20code:%20" . $code . ".";
$request = "method=send&username=wolves&password=62cf22&from=OTP&to=" . $tel . "&message=" . $message;
$urlWithoutProtocol = "http://www.thsms.com/api/rest?".$request;
$isRequestHeader = FALSE;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$productivity = curl_exec($ch);

Log::addActionLog('SMS', 'User id : ' . $user['id'] . '<br>Tel : ' . $tel . '<br>Result : ' . $productivity, []);

curl_close($ch);

$exp_datetime = date('Y-m-d H:i:s', strtotime('+5 mins'));

$data = array(
	'log_value1' => $tel,
	'log_value2' => $code,
	'log_value3' => $exp_datetime,
);

$result = User::editUser($user_id, $data);

$rep = array(
	'status' => $result,
	// 'tel' => $tel,
	// 'code' => $code,
	// 'exp_datetime' => $exp_datetime,
);

rep('success',true,$rep);
?>