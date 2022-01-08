<?php 

define( 'API_ACCESS_KEY', 'AAAA1gFIMUs:APA91bHT1Ub1s40r_4mK8RW1ho0AyhYDWstSbbsS0eT-8KG55btjWgkCjVQUWeV4andyg5O2aOvz57BJa6ODuFGZ39W535xGtn4sK5Yap7N6nKLL32m1NuE1Zo3aMAB5tNVAdKzx6aeC' );

class Firebase
{
	public static function register($user_id, $registration_id)
	{
		$data = array(
			'firebase_registration_id' => $registration_id,
		);

		return User::editUser($user_id, $data);
	}

	public static function notify($registrationIds, $msg)
	{
		$fields = array(
			'registration_ids' => $registrationIds,
			'notification' => $msg,
		);

		Log::addActionLog('SOS NOTIFICATION', 'Notification data ' . json_encode($fields), []);

		$headers = array(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

		curl_setopt($ch,CURLOPT_POST, true);

		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}
}