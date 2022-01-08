<?php
class User
{
	static function login_initial($user,$type)
	{
		if('admin' == $type)
		{
			$_SESSION['amst_userid'] = 0;
			$_SESSION['amst_username'] = Config::adminid;
			$_SESSION['amst_userhash'] = Config::adminpw;
			$_SESSION['amst_userRole'] = Config::adminrole;
			$_SESSION['amst_isLogin'] = true;
		}
		else if('server'==$type)
		{
			// check banned
			if($user['status']=='Banned')
				return "You've been banned from the system";
			else if($user['status']=='Deleted')
				return "You've been deleted from the system";

			// save to session
			$_SESSION['amst_userid'] = $user['id'];
			$_SESSION['amst_username'] = $user['username'];
			$_SESSION['amst_userhash'] = $user['password'];
			$_SESSION['amst_userRole'] = $user['role'];
			$_SESSION['amst_isLogin'] = true;
		}
		else if('api'==$type)
		{
			$_SESSION['amst_api_userid'] = $user['id'];
			$_SESSION['amst_api_username'] = $user['username'];
			$_SESSION['amst_api_userhash'] = $user['password'];
			$_SESSION['amst_api_userRole'] = $user['role'];
			$_SESSION['amst_api_isLogin'] = true;
		}

		if('server'==$type || 'api'==$type)
		{
			// update userlogin date
			$arr = array("#lastlogin" => 'NOW()');
			$result = DB::update(Info::$sysTable['user'], $arr, array('id'=>$user['id']));
			$error = DB::error();
			if($error[0] != '00000')
				Log::addActionLog("user","unable to update lastest login time to : ". $user['username'],DB::error());
		}

		return 'success';
	}

	static function login_server($username, $password)
	{
		if($username == Config::adminid && md5($password) == Config::adminpw)
			return User::login_initial(null,'admin');

		$arr = array(
			"username" => $username
			);
		$user = DB::get(Info::$sysTable['user'], '*', $arr);

		if (!$user)
			return "Invalid username or password"; 	// wrong username

		if ($user['password'] != md5($password))
			return "Invalid username or password";	// wrong password

		// login successful //
		return User::login_initial($user,'server');
	}

	static function login_facebook($facebookid)
	{
		$arr = array(
			"facebook_id" => $facebookid
			);
		$user = DB::get(Info::$sysTable['user'], '*', $arr);

		if (!$user)
			return "Invalid facebook id";

		// login successful //
		return User::login_initial($user,'server');
	}

	static function login_google($googleid)
	{
		$arr = array(
			"google_id" => $googleid
			);
		$user = DB::get(Info::$sysTable['user'], '*', $arr);

		if (!$user)
			return "Invalid google id";

		// login successful //
		return User::login_initial($user,'server');
	}

	static function login_twitter($twitterid)
	{
		$arr = array(
			"twitter_id" => $twitterid
			);
		$user = DB::get(Info::$sysTable['user'], '*', $arr);

		if (!$user)
			return "Invalid twitter id";

		// login successful //
		return User::login_initial($user,'server');
	}

	static function relogin_server($userid, $username, $role, $userhash)
	{
		if($username == Config::adminid && $userhash == Config::adminpw)
			return User::login_initial(null,'admin');

		if($userid == 0)
			return false;

		$arr = array(
			"username" => $username
			);
		$user = DB::get(Info::$sysTable['user'], '*', $arr);	

		if (!$user)
			return false; 	// wrong username
		if ($user['password'] != $userhash)
			return false;	// wrong password	

		// login successful //
		User::login_initial($user,'server');

		return true;
	}

	static function login_api($apikey)
	{
		$arr = array(
			"apikey" => $apikey
			);
		$user = DB::get(Info::$sysTable['user'],'*',$arr);

		if (!$user)
			return false; 	// wrong api key

		// login successful //
		User::login_initial($user,'api');

		return true;
	}

	static function logout()
	{
		if(isset($_SESSION['amst_userid']))
			unset($_SESSION['amst_userid']);
		if(isset($_SESSION['amst_username']))
			unset($_SESSION['amst_username']);
		if(isset($_SESSION['amst_userhash']))
			unset($_SESSION['amst_userhash']);
		if(isset($_SESSION['amst_userRole']))
			unset($_SESSION['amst_userRole']);
		if(isset($_SESSION['amst_isLogin']))
			unset($_SESSION['amst_isLogin']);

		if(isset($_SESSION['amst_api_userid']))
			unset($_SESSION['amst_api_userid']);
		if(isset($_SESSION['amst_api_username']))
			unset($_SESSION['amst_api_username']);
		if(isset($_SESSION['amst_api_userhash']))
			unset($_SESSION['amst_api_userhash']);
		if(isset($_SESSION['amst_api_userRole']))
			unset($_SESSION['amst_api_userRole']);
		if(isset($_SESSION['amst_api_isLogin']))
			unset($_SESSION['amst_api_isLogin']);

		if(isset($_COOKIE['amst_userid']))
		{
			setcookie("amst_userid", "", time()-360000,'/');
			unset($_COOKIE['amst_userid']);
		}
		if(isset($_COOKIE['amst_username']))
		{
			setcookie("amst_username", "", time()-360000,'/');
			unset($_COOKIE['amst_username']);
		}
		if(isset($_COOKIE['amst_userhash']))
		{	
			setcookie("amst_userhash", "", time()-360000,'/');
			unset($_COOKIE['amst_userhash']);
		}
		if(isset($_COOKIE['amst_userRole']))
		{	
			setcookie("amst_userRole", "", time()-360000,'/');
			unset($_COOKIE['amst_userRole']);
		}
		if(isset($_COOKIE['amst_isLogin']))
		{
			setcookie("amst_isLogin", "", time()-360000,'/');
			unset($_COOKIE['amst_isLogin']);
		}
	}

	static function logout_api()
	{
		if(isset($_SESSION['amst_api_userid']))
			unset($_SESSION['amst_api_userid']);
		if(isset($_SESSION['amst_api_username']))
			unset($_SESSION['amst_api_username']);
		if(isset($_SESSION['amst_api_userhash']))
			unset($_SESSION['amst_api_userhash']);
		if(isset($_SESSION['amst_api_userRole']))
			unset($_SESSION['amst_api_userRole']);
		if(isset($_SESSION['amst_api_isLogin']))
			unset($_SESSION['amst_api_isLogin']);
	}

	static function getCurrentUserid()
	{
		if(isset($_SESSION['amst_userid']))
			return $_SESSION['amst_userid'];
		else if(isset($_SESSION['amst_api_userid']))
			return $_SESSION['amst_api_userid'];
		else
			return -1;
	}

	static function getCurrentUsername()
	{
		if(isset($_SESSION['amst_username']))
			return $_SESSION['amst_username'];
		else if(isset($_SESSION['amst_api_username']))
			return $_SESSION['amst_api_username'];
		else
			return null;
	}

	static function getCurrentUserHash()
	{
		if(isset($_SESSION['amst_userhash']))
			return $_SESSION['amst_userhash'];
		else if(isset($_SESSION['amst_api_userhash']))
			return $_SESSION['amst_api_userhash'];
		else
			return null;
	}

	static function getCurrentUserRole()
	{
		if(isset($_SESSION['amst_userRole']))
			return $_SESSION['amst_userRole'];
		else if(isset($_SESSION['amst_api_userRole']))
			return $_SESSION['amst_api_userRole'];
		else
			return null;
	}

	static function getCurrentUserLogintype()
	{
		if(isset($_SESSION['amst_username']))
			return 'server';
		else if(isset($_SESSION['amst_api_username']))
			return 'api';
		else
			return 'unknown';
	}

	static function isLogin()
	{
		if(isset($_SESSION['amst_isLogin']))
			return $_SESSION['amst_isLogin'];
		else if(isset($_SESSION['amst_api_isLogin']))
			return $_SESSION['amst_api_isLogin'];
		else
			return null;
	}

	static function register($username, $password, $role)
	{
		if($username==Config::adminid)
			return false;

		$arr = array(
			'username' => $username,
			'password' => md5($password),
			'role' => $role,
			'apikey' => md5($username.'api'),
			'status' => 'Active'
			);
		$result = DB::insert(Info::$sysTable['user'], $arr);

		if(!$result) {
			Log::addActionLog("user","anonymous Name[".$username."] failed to register.",$arr);
			return $result;
		}

		if(self::getCurrentUsername()==Config::adminid)
			Log::addActionLog("user","user[". $username ."] summon to the system",$arr);
		else if(self::getCurrentUserid()!=null || self::getCurrentUserid()!="")
			Log::addActionLog("user","user[". self::getCurrentUsername() ."] add user[". $username ."] to the system",$arr);
		else
			Log::addActionLog("user","user[". $username ."] register to the system",$arr);

		return $result;
	}

	static function editUser($userid, $arr)
	{
		$result = self::getUserByID($userid);

		if (!$result)
			return false; // user not existed

		if(isset($arr['username']))
		{
			if($arr['username']==$result['username'])
				unset($arr['username']);
		}
		if(isset($arr['password']))
		{
			if($arr['password']==$result['password'] || $arr['password']=='')
				unset($arr['password']);
			else
				$arr['password'] = md5($arr['password']);
		}
		if(isset($arr['role']))
		{
			if($arr['role']=='')
				unset($arr['role']);
		}
		if(isset($arr['status']))
		{
			if($arr['status']=='')
				unset($arr['status']);
		}
		$arr['version[+]'] = 1;

		$result = DB::update(Info::$sysTable['user'], $arr, array('id'=>$userid));

		if(!$result)
			return false; // error

		if(self::getCurrentUsername()==Config::adminid)
			Log::addActionLog("user","system change user[$userid] detail to",$arr);
		else if($userid==self::getCurrentUserid())
			Log::addActionLog("user","user[$userid] change own detail to",$arr);
		else
			Log::addActionLog("user","user[". self::getCurrentUserid() ."] change user[$userid] detail to",$arr);

		return true;
	}

	static function getUser()
	{
		return DB::select(Info::$sysTable['user'] , '*');
	}

	static function getUserByList($where)
	{
		return DB::select(Info::$sysTable['user'] , '*', $where);
	}

	static function getUserByID($userid)
	{
		return DB::get(Info::$sysTable['user'], '*', array('id' => $userid));
	}

	static function getUserByUsername($username)
	{
		return DB::get(Info::$sysTable['user'], '*', array('username' => $username));
	}

	static function getUserByFacebookID($facebook_id)
	{
		return DB::get(Info::$sysTable['user'], '*', array('facebook_id' => $facebook_id));
	}

	static function getUserByGoogleID($google_id)
	{
		return DB::get(Info::$sysTable['user'], '*', array('google_id' => $google_id));
	}

	static function getUserByTwitterID($twitter_id)
	{
		return DB::get(Info::$sysTable['user'], '*', array('twitter_id' => $twitter_id));
	}

	static function getUserByAPIKey($apikey)
	{
		return DB::get(Info::$sysTable['user'], '*', array('apikey' => $apikey));
	}





	// user permission
	static function addUserPermission($userid,$functionid)
	{
		$arr = array(
			'userid' => $userid,
			'functionid' => $functionid
			);
		return DB::insert(Info::$sysTable['userpermission'], $arr);
	}

	static function removeUserPermission($id)
	{
		return DB::delete(Info::$sysTable['userpermission'],array('id'=>$id));
	}

	static function getUserPermission()
	{
		return DB::select(Info::$sysTable['userpermission'], '*');
	}

	static function getUserPermissionByList($where)
	{
		return DB::select(Info::$sysTable['userpermission'], '*', $where);
	}





	// tool
	static function isUserHavePermission($userid,$functionid)
	{
		$selectuser = User::getUserByID($userid);

		if('Mod'==$selectuser['role'])
		{
			$where = array(
				'AND' => array(
					'userid' => $userid,
					'functionid' => $functionid
					)
				);
			return DB::get(Info::$sysTable['userpermission'], '*', $where);
		}
		else if('Dev'==$selectuser['role'] || 'Guardian'==$selectuser['role'])
			return true;
	}
}
?>