<?php
class Query
{	
	static function add($table, $data) 
	{
		$sql = "INSERT INTO ". $table ."(";

		$isFirst = true; //
		foreach ($data as $key => $value) 
		{
			if($isFirst == true)
			{
				$sql .= $key;
				$isFirst = false;
			}
			else
				$sql .= ",".$key;
		}
		$sql .= ") VALUES (";

		$isFirst = true;
		foreach ($data as $key => $value) 
		{
			if($isFirst == true)
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= "$value";
				}
				else
					$sql .= "'$value'";
				$isFirst = false;
			}
			else
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= ",$value";
				}
				else
					$sql .= ",'$value'";
			}
		}
		$sql .= ")";

		if(ConNLog::executeQuery($sql)) //
			return mysql_insert_id(); //
		else //
			return 0; //
 	} //

 	static function edit($table, $id, $data) 
 	{
 		$sql = "SELECT * FROM ". $table ." WHERE id='". $id ."'";
 		$result = ConNLog::executeQuery($sql);

 		if (!$result || mysql_num_rows($result) == 0)
			return false; // not existed
		
		$sql = "UPDATE ". $table ." SET";

		$isFirst = true;
		foreach ($data as $key => $value) 
		{
			if($isFirst == true)
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= " $key=$value";
				}
				else if (strpos($value,'increase:') !== false)
				{
					$value = str_replace("increase:", "", $value);
					$sql .= " $key=$key+$value";
				}
				else if (strpos($value,'decrease:') !== false)
				{
					$value = str_replace("decrease:", "", $value);
					$sql .= " $key=$key-$value";
				}
				else
					$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= " ,$key=$value";
				}
				else if (strpos($value,'increase:') !== false)
				{
					$value = str_replace("increase:", "", $value);
					$sql .= " ,$key=$key+$value";
				}
				else if (strpos($value,'decrease:') !== false)
				{
					$value = str_replace("decrease:", "", $value);
					$sql .= " ,$key=$key-$value";
				}
				else
					$sql .= " ,$key='$value'";
			}
		}
		$tablepieces = explode("_", $table);
		if($tablepieces[0] == 'func')
			$sql .= ", version=version+1";
		$sql .= " WHERE id='". $id ."'";
		
		if(ConNLog::executeQuery($sql)) //
			return $id; //
		else //
			return 0; //
	} //

	static function removeByID($table, $id)
	{
		$sql = "DELETE FROM ". $table ." WHERE id='". $id ."'";
		
		return self::returnoperation(ConNLog::executeQuery($sql));
	}

	static function removeBy($table, $data)
	{
		$sql = "DELETE FROM ". $table ." WHERE ";
		$isFirst = true;
		foreach ($data as $key => $value) 
		{
			if($isFirst == true)
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= " $key=$value";
				}
				else
					$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
			{
				if (strpos($value,'value:') !== false)
				{
					$value = str_replace("value:", "", $value);
					$sql .= " ,$key=$value";
				}
				else
					$sql .= " ,$key='$value'";
			}
		}
		
		return self::returnoperation(ConNLog::executeQuery($sql));
	}

	static function getAll($table, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." ".self::returnsqldatetime($startdate,$enddate)." ORDER BY id ASC";
		
		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function getAllOrderBy($table, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." ".self::returnsqldatetime($startdate,$enddate)." ORDER BY ".$order." ASC";
		
		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function getAllLast($table, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." ".self::returnsqldatetime($startdate,$enddate)." ORDER BY id DESC";
		
		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function getAllLastOrderBy($table, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." ".self::returnsqldatetime($startdate,$enddate)." ORDER BY ".$order." DESC";
		
		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function getByID($table, $id)
	{
		$sql = "SELECT * FROM ". $table ." WHERE id='". $id ."' ORDER BY id ASC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function getByTargetValue($table, $target, $value, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE ".$target."='". $value ."' ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY id ASC";
		
		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function select($table, $data, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key='$value'";
		}
		$sql .= " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY id ASC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLast($table, $data, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key='$value'";
		}
		$sql .= " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY id DESC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectOrderBy($table, $data, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key='$value'";
		}
		$sql .=  " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY ".$order." ASC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLastOrderBy($table, $data, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key='$value'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key='$value'";
		}
		$sql .=  " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY ".$order." DESC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLike($table, $data, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key LIKE '%$value%'";
				$isFirst = false;
			}
			else
				$sql .= " ".self::returnsqldatetimenowhere($startdate,$enddate)." AND $key LIKE '%$value%'";
		}

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLastLike($table, $data, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key LIKE '%$value%'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key LIKE '%$value%'";
		}
		$sql .=  " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY id DESC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLikeOrderBy($table, $data, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key LIKE '%$value%'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key LIKE '%$value%'";
		}
		$sql .=  " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY ".$order." ASC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	static function selectLastLikeOrderBy($table, $data, $order, $startdate=null, $enddate=null)
	{
		$sql = "SELECT * FROM ". $table ." WHERE";

		$isFirst = true;
		foreach ($data as $key => $value) {
			if($isFirst == true)
			{
				$sql .= " $key LIKE '%$value%'";
				$isFirst = false;
			}
			else
				$sql .= " AND $key LIKE '%$value%'";
		}
		$sql .=  " ".self::returnsqldatetimenowhere($startdate,$enddate)." ORDER BY ".$order." DESC";

		return self::returnselect(ConNLog::executeQuery($sql));
	}

	// pure query
	static function executeQuery($sql)
	{
		return ConNLog::executeQuery($sql);
	}

	// private class
	static function returnoperation($result)
	{
		if(!$result)
			return false; // error

		return true;
	}

	static function returnselect($result)
	{
		if (!$result || mysql_num_rows($result) == 0)
			return null;	// no news in database

		return $result;
	}

	static function returnsqldatetime($startdate,$enddate)
	{
		if($startdate=='' || $enddate=='' || is_null($startdate) || is_null($enddate))
			return '';

		$date = new DateTime($enddate);
		$date->modify('+1 day');
		$enddate = $date->format('Y-m-d');

		return "WHERE datetime BETWEEN '".$startdate."' AND '".$enddate."'";
	}

	static function returnsqldatetimenowhere($startdate,$enddate)
	{
		if($startdate=='' || $enddate=='' || is_null($startdate) || is_null($enddate))
			return '';

		$date = new DateTime($enddate);
		$date->modify('+1 day');
		$enddate = $date->format('Y-m-d');

		return "AND datetime BETWEEN '".$startdate."' AND '".$enddate."'";
	}
}
?>