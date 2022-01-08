<?php
// logout from API in case there is external request from front page
User::logout_api();

// apply cookie to session if saved cookie exist
if(isset($_COOKIE['amst_userhash']) && !User::getCurrentUserRole())
{
	User::relogin_server($_COOKIE['amst_userid'],$_COOKIE['amst_username'],$_COOKIE['amst_userRole'],$_COOKIE['amst_userhash']);
}

// redirect to frontpage
if(!User::getCurrentUserRole())
{
	header('Location: ../../sys/login/index.php?timeout=1');
	exit();
}

function checkUser($priority)
{
	if($priority=='high')
	{
		$permission = array("Guardian");
		if (!in_array(User::getCurrentUserRole(), $permission))
		{
			header('Location: ../../sys/login/index.php?nopermission=1');
			exit();
		}
	}
	else if($priority=='medium')
	{
		$permission = array("Guardian", "Dev");
		if (!in_array(User::getCurrentUserRole(), $permission))
		{
			header('Location: ../../sys/login/index.php?nopermission=1');
			exit();
		}
	}
	else if($priority=='low')
	{
		$permission = array("Guardian", "Dev", "Mod");
		if (!in_array(User::getCurrentUserRole(), $permission))
		{
			header('Location: ../../sys/login/index.php?nopermission=1');
			exit();
		}
	}
}

if(User::getCurrentUserID() != -1)
{
	if('server'==User::getCurrentUserLogintype())
	{
		// 3600 = 1 hour (current set for ten year)
		setcookie("amst_userid", User::getCurrentUserID(), time() + (10 * 365 * 24 * 60 * 60), '/');
		setcookie("amst_username", User::getCurrentUsername(), time() + (10 * 365 * 24 * 60 * 60), '/');
		setcookie("amst_userhash", User::getCurrentUserHash(), time() + (10 * 365 * 24 * 60 * 60), '/');
		setcookie("amst_userRole", User::getCurrentUserRole(), time() + (10 * 365 * 24 * 60 * 60), '/');
		setcookie("amst_userlogintype", User::getCurrentUserLogintype(), time() + (10 * 365 * 24 * 60 * 60), '/');
		setcookie("amst_isLogin", User::isLogin(), time() + (10 * 365 * 24 * 60 * 60), '/');
	}
}
?>