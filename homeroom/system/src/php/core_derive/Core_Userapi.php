<?php
class UserAPI
{
	static function login($apikey)
	{
		$arr = array(
			"apikey" => $apikey
			);
		$result = Query::select(Info::$sysTable['userapi'],$arr);

		if (!$result || mysql_num_rows($result) == 0)
			return false; 	// wrong api key

		// login successful //
		$userInfoArray = mysql_fetch_array($result);

		// save to session
		$_SESSION['userid'] = $userInfoArray['id'];
		$_SESSION['logintype'] = 'api';

		// update userlogin date
		$arr = array(
			"lastlogin" => "value:NOW()"
			);
		$result = Query::edit(Info::$sysTable['userapi'],$userInfoArray['id'],$arr);
		if(!$result)
			Log::addActionLog("system","Unable to update lastest login time to : ". $username,null);

		return true;
	}

	static function register($fullname)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomstring = '';
		for ($i=1; $i<=10; $i++)
			$randomstring .= $characters[rand(0, strlen($characters) - 1)];

		$arr = array(
			'fullname' => $fullname,
			'apikey' => $randomstring,
			'status' => 'Active'
			);
		$result = Query::add(Info::$sysTable['userapi'], $arr);

		if(!$result) {
			Log::addActionLog("system","[".$fullname."] failed to registered API",$arr);
			return false;
		}

		Log::addActionLog("system","[".$fullname."] register API",$arr);

		return true;
	}

	static function editInfo($userapiid, $fullname, $apikey, $status)
	{
		$result = self::getUserInfo($userapiid);

		if (!$result || mysql_num_rows($result) == 0)
			return false; // api not existed

		$arr = array(
			'fullname' => $fullname,
			'apikey' => $apikey,
			'status' => $status
			);
		$result = Query::edit(Info::$sysTable['userapi'], $userapiid, $arr);

		if(!$result)
			return false; // error

		Log::addActionLog("system","[".$fullname."] edit API INFO",$arr);

		return true;
	}

	static function removeUser($userapiid)
	{
		$oldapi = self::getUserInfo($userapiid);

		if (!$oldapi || mysql_num_rows($oldapi) == 0)
			return false; // api not existed

		$oldapi = mysql_fetch_array($oldapi);

		$result = Query::removeByID(Info::$sysTable['userapi'],$userapiid);

		if(!$result)
			return false; // error

		Log::addActionLog("system","[". $oldapi['fullname'] ."] api remove from the system",null);

		return true;
	}

	static function getUser()
	{
		return Query::getAll(Info::$sysTable['userapi']);
	}

	static function getUserLast()
	{
		return Query::getAllLast(Info::$sysTable['userapi']);
	}

	static function getUserOrderBy($order)
	{
		return Query::getAllOrderBy(Info::$sysTable['userapi'],$order);
	}

	static function getUserLastOrderBy($order)
	{
		return Query::getAllLastOrderBy(Info::$sysTable['userapi'],$order);
	}

	static function getUserInfo($userapiid)
	{
		return Query::getByID(Info::$sysTable['userapi'],$userapiid);
	}

	static function getUserInfoByAPIKey($apikey)
	{
		return Query::getByTargetValue(Info::$sysTable['userapi'],'apikey',$apikey);
	}
}
?>