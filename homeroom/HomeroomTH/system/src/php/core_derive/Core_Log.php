<?php
class Log
{	
	// ACTION LOG
	static function addActionLog($code,$log,$logarr)
	{
		$type = '';
		if(User::getCurrentUserLogintype()=='server' && Info::keepServerActivityLog)
			$type = 'server';
		else if(User::getCurrentUserLogintype()=='api' && Info::keepAPIActivityLog)
			$type = 'api';
		else
			$type = 'unknown';

		$description = $log;
		if($logarr != null)
		{
			$description .= '<br />';
			foreach($logarr as $key => $val)
			{
				if($val=='' || $val==' ')
					$val = '-';
				$description .= '<b>'.$key.'</b> : <span class="text-muted">'.$val.'</span><br />';
			}
		}
		$description .= '<br /><br />LINK : http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'<br />';

		$tracearr = debug_backtrace();
		foreach($tracearr as $trace)
		{
			$description .= '<br />FILE : '.basename($trace['file']).' ['.$trace['line'].']<br />';
			$description .= 'FUNCTION : '.$trace['function'].'<br />-------------------';
		}

		$userid = User::getCurrentUserID();

		$arr = array(
			'userid' => $userid,
			'code' => $code,
			'description' => $description,
			'type' => $type,
			);

		return DB::insert(Info::$sysTable['logaction'], $arr);
	}

	static function getActionLog()
	{
		return DB::select(Info::$sysTable['logaction'] , '*');
	}

	static function getActionLogByType($type)
	{
		return DB::select(Info::$sysTable['logaction'] , '*', array('type'=>$type));
	}

	static function countActionLog()
	{
		return DB::count(Info::$sysTable['logaction']);
	}

	static function clearActionLog()
	{
		return DB::delete(Info::$sysTable['logaction']);
	}

	static function clearActionLogByType($type)
	{
		return DB::delete(Info::$sysTable['logaction'], array('type'=>$type));
	}

	// SQL LOG
	static function addSQLLog($arr)
	{
		return DB::insert(Info::$sysTable['logsql'], $arr);
	}

	static function getSQLLog()
	{
		return DB::select(Info::$sysTable['logsql'] , '*');
	}

	static function getSQLLogByType($type)
	{
		return DB::select(Info::$sysTable['logsql'] , '*', array('type'=>$type));
	}

	static function countSQLLog()
	{
		return DB::count(Info::$sysTable['logsql']);
	}

	static function clearSQLLog()
	{
		return DB::delete(Info::$sysTable['logsql']);
	}

	static function clearSQLLogByType($type)
	{
		return DB::delete(Info::$sysTable['logsql'], array('type'=>$type));
	}
}
?>