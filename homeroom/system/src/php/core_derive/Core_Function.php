<?php
class Func
{	
	static function addFunction($data, $userid = 'notset')
	{
		if('notset' == $userid)
			$userid = User::getCurrentUserID();

		$data['insertuserid'] = $userid;
		$data['#insertdatetime'] = "NOW()";
		$insertid = DB::insert(Info::$sysTable['function'], $data);

		if(!$insertid) {
			Log::addActionLog("system","FAILED to ADD function Name[".$data['name']."].<br />ERROR : [".var_export(DB::error(), true)."]<br />RETURN : [".var_export($insertid, true)."]<br />insertid : [".$insertid."]",$data);
			return false;
		}
		Log::addActionLog("system","ADD function #[".$data['name']."] to the system.",$data);

		while(true)
		{
			$characters = 'abcdefghijklmnopqrstuvwxyz';
			$randomstring = '';
			for ($i=1; $i<=5; $i++)
				$randomstring .= $characters[rand(0, strlen($characters) - 1)];
			$where = array('code' => $randomstring);

			if(!DB::has(Info::$sysTable['function'],array('code'=>$randomstring)))
				break;
		}

		$data = array(
			'code' => $randomstring,
			'sortorderid' => $insertid
			);
		DB::update(Info::$sysTable['function'], $data, array('id'=>$insertid));

		return $insertid;
	}

	static function editFunction($functionid, $data) 
	{
		unset($data['code']);
		$data['#updatedatetime'] = 'NOW()';
		$updatenum = DB::update(Info::$sysTable['function'], $data, array('id'=>$functionid));

		if(!$updatenum)
			return false; // function not existed

		Log::addActionLog("system","EDIT function #$functionid",$arr);

		return true;
	}

	static function removeFunction($functionid, $module, $code, $name)
	{
		$removenum = DB::delete(Info::$sysTable["function"], array('id'=>$functionid));

		if(!$removenum)
			return false; // error

		File::delete($code,'../../');

		$modulename = $module;
		include_once '../../'.Info::$moduleFile[$module].'/required/info_module.php';
		foreach ($sqlinfo[$module] as $key => $value)
			Amst::query('DROP TABLE IF EXISTS '.Info::moduleTablePrefix.$code.$key.';');

		Log::addActionLog("system","REMOVE function #[$name] system and data.",null);

		return true;
	}

	static function swapFunction($currentid, $movetoid)
	{
		$arr = array(
			'currentid' => $currentid,
			'movetoid' => $movetoid
			);

		$currententity = DB::get(Info::$sysTable["function"], "sortorderid", array("id" => $currentid));
		$movetoentity = DB::get(Info::$sysTable["function"], "sortorderid", array("id" => $movetoid));

		$currentarr = array( 'sortorderid' => $currententity['sortorderid'] );
		$movetoarr = array( 'sortorderid' => $movetoentity['sortorderid'] );

		if(!DB::update(Info::$sysTable["function"], $movetoarr, array('id'=>$currentid)))
		{
			Log::addActionLog("system","FAILED to SWAP function id [".$currentid."],[".$movetoid."] in the system.",null);
			return false;
		}
		DB::update(Info::$sysTable["function"], $currentarr, array('id'=>$movetoid));

		Log::addActionLog("system","SWAP function id [".$currentid."],[".$movetoid."] in the system.",null);
		return true;
	}

	static function getFunction()
	{
		$where = array('ORDER' => array('sortorderid' => 'ASC'));
		return DB::select(Info::$sysTable['function'], '*', $where);
	}

	static function getFunctionByID($id)
	{
		return DB::get(Info::$sysTable['function'], '*', array('id'=>$id));
	}

	static function getFunctionByCode($code)
	{
		return DB::get(Info::$sysTable['function'], '*', array('code'=>$code));
	}


	static function getFunctionByModule($module)
	{
		return DB::get(Info::$sysTable['function'], '*', array('module'=>$module));
	}

	static function getFunctionBy($where)
	{
		return DB::select(Info::$sysTable['function'], '*', $where);
	}

	static function countFunctionBy($where)
	{
		return DB::count(Info::$sysTable['function'], $where);
	}
}
?>