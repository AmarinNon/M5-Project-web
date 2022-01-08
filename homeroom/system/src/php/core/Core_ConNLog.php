<?php
class ConNLog
{	
	static function initialConnection() 
	{
		// Make connection
		$con = mysql_connect(Config::dbserver,Config::dbusername,Config::dbpassword);
		if (!$con)
			self::addSQLLog('getDefaultConnection() -> Could not connect : '. mysql_error(),'-');

		// encode
		mysql_query("SET NAMES UTF8");

		// choose DB
		mysql_select_db(Config::dbname,$con);
	}

	static function executeQuery($sql)
	{
		self::initialConnection();

		$result = mysql_query($sql);
		
		if(!$result)
			self::addSQLLog(mysql_error(),$sql);

		if (strpos($sql, 'sys_') === false)
		{
			if(Info::debug_sql_select)
				{if (strpos($sql, 'SELECT') !== false) self::addSQLLog(mysql_error(),$sql);}
			if(Info::debug_sql_insert)
				{if (strpos($sql, 'INSERT INTO') !== false) self::addSQLLog(mysql_error(),$sql);}
			if(Info::debug_sql_update)
				{if (strpos($sql, 'UPDATE') !== false) self::addSQLLog(mysql_error(),$sql);}
			if(Info::debug_sql_delete)
				{if (strpos($sql, 'DELETE') !== false) self::addSQLLog(mysql_error(),$sql);}
		}

		return $result;
	}

	// log
	static function addActionLog($code, $log)
	{
		$savedata = false;
		if($_SESSION['logintype']=='server' && Info::keepServerActivityLog)
			$savedata = true;
		else if($_SESSION['logintype']=='api' && Info::keepAPIActivityLog)
			$savedata = true;

		if($savedata)
		{
			$sql = "INSERT INTO ". Info::$sysTable['logaction'] ."(userid,code,description,type) VALUES ('".$_SESSION['userid']."','".$code."','".mysql_real_escape_string($log)."','".$_SESSION['logintype']."')";
			self::executeQuery($sql);

			$log = self::executeQuery("SELECT COUNT(id) AS num FROM ".Info::$sysTable['logaction']);

			if($log!=null)
			{
				$log = mysql_fetch_assoc($log);
				if($log['num'] >= Info::maximumActivityLog)
				{
					$sql = "DELETE FROM ".Info::$sysTable['logaction'];
					self::executeQuery($sql);
				}
			}
		}
	}

	static function getActionLog()
	{
		$sql = "SELECT * FROM ". Info::$sysTable['logaction'] ." ORDER BY id DESC";
		$result = self::executeQuery($sql);
		
		if (!$result || mysql_num_rows($result) == 0)
			return null;	// no data in database

		return $result;
	}

	static function getActionLogByType($type)
	{
		$sql = "SELECT * FROM ". Info::$sysTable['logaction'] ." WHERE type='".$type."' ORDER BY id DESC";
		$result = self::executeQuery($sql);

		if (!$result || mysql_num_rows($result) == 0)
			return null;	// no data in database

		return $result;
	}

	static function clearActionLog()
	{
		$sql = "DELETE FROM ". Info::$sysTable["logaction"];
		self::executeQuery($sql);

		if(mysql_errno())
			return false; // error

		self::addActionLog("system","clear activity log");

		return true;
	}

	static function clearActionLogByType($type)
	{
		$sql = "DELETE FROM ". Info::$sysTable["logaction"] ." WHERE type='".$type."'";
		self::executeQuery($sql);

		if(mysql_errno())
			return false; // error

		self::addActionLog("system","clear activity log type '".$type."'");

		return true;
	}

	static function addSQLLog($log,$sqlquery)
	{
		$savedata = false;
		if($_SESSION['logintype']=='server' && Info::keepServerSQLLog)
			$savedata = true;
		else if($_SESSION['logintype']=='api' && Info::keepAPISQLLog)
			$savedata = true;

		if($savedata)
		{
			self::initialConnection();

			$sql = "INSERT INTO ". Info::$sysTable['logsql'] ."(userid,description,sqlquery,type) VALUES ('".$_SESSION['userid']."','".mysql_real_escape_string($log)."','".mysql_real_escape_string($sqlquery)."','".$_SESSION['logintype']."')";
			mysql_query($sql);
		}
	}

	static function getSQLLog()
	{
		$sql = "SELECT * FROM ". Info::$sysTable['logsql'] ." ORDER BY id DESC";
		$result = self::executeQuery($sql);

		if (!$result || mysql_num_rows($result) == 0)
			return null;	// no data in database

		return $result;
	}

	static function getSQLLogByType($type)
	{
		$sql = "SELECT * FROM ". Info::$sysTable['logsql'] ." WHERE type='".$type."' ORDER BY id DESC";
		$result = self::executeQuery($sql);

		if (!$result || mysql_num_rows($result) == 0)
			return null;	// no data in database

		return $result;
	}

	static function clearSQLLog()
	{
		$sql = "DELETE FROM ". Info::$sysTable["logsql"];
		self::executeQuery($sql);

		if(mysql_errno())
			return false; // error

		self::addActionLog("system","clear sql log");

		return true;
	}

	static function clearSQLLogByType($type)
	{
		$sql = "DELETE FROM ". Info::$sysTable["logsql"] ." WHERE type='".$type."'";
		self::executeQuery($sql);

		if(mysql_errno())
			return false; // error

		self::addActionLog("system","clear sql log type '".$type."'");

		return true;
	}
}
?>