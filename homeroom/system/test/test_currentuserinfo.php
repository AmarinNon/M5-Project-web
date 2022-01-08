<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../def/defImport.php';

if(isset($_POST['logout']))
	User::logout();
else if(isset($_POST['loginadmin']))
	echo User::login_server(Config::adminid,'taurustale');

startShow();
show('CURRENT userid'	  ,   ': '.User::getCurrentUserid());
show('CURRENT username'	  ,   ': '.User::getCurrentUsername());
show('CURRENT userhash'	  ,   ': '.User::getCurrentUserHash());
show('CURRENT role'		  ,   ': '.User::getCurrentUserRole());
show('CURRENT login type' ,   ': '.User::getCurrentUserLogintype());
show('CURRENT isLogin'	  ,   ': '.User::isLogin());
endShow();

startShow();
show('SAVED userid'		, ': '.$_COOKIE['userid']);
show('SAVED username'	, ': '.$_COOKIE['username']);
show('SAVED role'		, ': '.$_COOKIE['userRole']);
endShow();

function startShow()
{	echo '<table>';	}
function show($topic, $data)
{	echo '<tr><td>'.$topic.'</td><td>'.$data.'</td></tr>';	}
function endShow()
{	echo '</table>';	}

?>

<form action="" method="post">
	<input type="submit" name="logout" value="logout" />
</form>

<form action="" method="post">
	<input type="submit" name="loginadmin" value="login admin" />
</form>