<?php
include 'medoo.php';

class DB
{
	protected static $database;
	
	public static function init()
	{
		self::$database = new medoo(array(
			'database_type' => Config::dbtype,
			'server' => Config::dbserver,
			'database_name' => Config::dbname,
			'username' => Config::dbusername,
			'password' => Config::dbpassword,
			'charset' => 'utf8',
			)
		);
		self::$database->query("SET time_zone='+07:00'");

		return self::$database;
	}

	public static function select($table, $columns = null, $where = null)
	{
		$result = self::$database->select($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function insert($table, $data)
	{
		$result = self::$database->insert($table, $data);
		self::checkerror();
		return $result;
	}

	public static function update($table, $data, $where)
	{
		$result = self::$database->update($table, $data, $where);
		self::checkerror();
		return $result;
	}

	public static function delete($table, $where = null)
	{
		$result = self::$database->delete($table, $where);
		self::checkerror();
		return $result;
	}

	public static function replace($table, $columns, $search, $replace, $where)
	{
		$result = self::$database->replace($table, $columns, $search, $replace, $where);
		self::checkerror();
		return $result;
	}

	public static function get($table, $columns, $where)
	{
		$result = self::$database->get($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function has($table, $where)
	{
		$result = self::$database->has($table, $where);
		self::checkerror();
		return $result;
	}

	public static function count($table, $where = null)
	{
		$result = self::$database->count($table, $where);
		self::checkerror();
		return $result;
	}

	public static function max($table, $columns, $where)
	{
		$result = self::$database->max($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function min($table, $columns, $where)
	{
		$result = self::$database->min($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function avg($table, $columns, $where)
	{
		$result = self::$database->avg($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function sum($table, $columns, $where)
	{
		$result = self::$database->sum($table, $columns, $where);
		self::checkerror();
		return $result;
	}

	public static function query($query)
	{
		$result = self::$database->query($query);
		self::checkerror();
		return $result;
	}

	public static function error()
	{
		return self::$database->error();
	}

	public static function last_query()
	{
		return self::$database->last_query();
	}

	public static function checkerror()
	{
		$error = self::error();
		if($error[0]!='00000')
		{
			$tracearr = debug_backtrace();
			$traceresult = '';
			foreach($tracearr as $trace)
			{
				$traceresult .= '<br />FILE : '.basename($trace['file']).' ['.$trace['line'].']<br />';
				$traceresult .= 'FUNCTION : '.$trace['function'].'<br />-------------------';
			}

			$arr = array(
				'userid' => User::getCurrentUserid(),
				'description' => $error[2].'<br /><br />LINK : http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'<br />'.$traceresult,
				'sqlquery' => self::$database->last_query(),
				'type' => User::getCurrentUserLogintype(),
				);
			Log::addSQLLog($arr);
		}
	}
}

DB::init();
?>