<?php
class Amst
{	
	// add
	static function insert($code, $data, $insertusertype = 's', $defaulttable = true) 
	{
		if($defaulttable)
		{
			if(isset($data['insertuserid']))
			{
				if($data['insertuserid']==null)
					$data['insertuserid'] = User::getCurrentUserid();
			}
			else
				$data['insertuserid'] = User::getCurrentUserid();
			$data['insertusertype'] = $insertusertype;
		}

		foreach($data as $datacode => $datavalue)
		{
			if(is_null($datavalue))
				unset($data[$datacode]);
		}

		$insertid = DB::insert(Info::moduleTablePrefix.$code, $data);

		$data['id'] = $insertid;

		if(!$insertid)
		{
			Log::addActionLog($code,"FAILED to insert data<br />ERROR : [".var_export(DB::error(), true)."]<br />RETURN : [".var_export($insertid, true)."]<br />insertid : [".$insertid."]<br /><br />".DB::last_query()."<br />", $data);
			return $insertid;
		}

		if(Info::keepNormalActivityLog)
			Log::addActionLog($code,"add data",$data);

		// update sortorderid
		if($defaulttable)
		{
			$default_status = 'Active';
			if(isset($data['status']))
				$default_status = $data['status'];
			
			$default_sortorderid = $insertid;
			if(isset($data['sortorderid']))
				$default_sortorderid = $data['sortorderid'];

			$data = array(
				'status' => $default_status,
				'sortorderid' => $default_sortorderid,
				'#updatedatetime' => 'NOW()',
				'updateuserid' => -1
				);

			DB::update(Info::moduleTablePrefix.$code, $data, array('id'=>$insertid));
		}

		return $insertid;
	}

	// edit
	static function update($code, $data, $where, $updateusertype = 's', $defaulttable = true) 
	{
		if($defaulttable)
		{
			if(isset($data['updateuserid']))
			{
				if($data['updateuserid']==null)
					$data['updateuserid'] = User::getCurrentUserid();
			}
			else
				$data['updateuserid'] = User::getCurrentUserid();
			$data['updateusertype'] = $updateusertype;

			if(!isset($data['updatedatetime']))
				$data['#updatedatetime'] = 'NOW()';
			$data['version[+]'] = 1;
		}

		foreach($data as $datacode => $datavalue)
		{
			if(is_null($datavalue))
				unset($data[$datacode]);
		}

		$updatenum = DB::update(Info::moduleTablePrefix.$code, $data, $where);
		if(!$updatenum)
		{
			if(Info::keepErrorActivityLog)
				Log::addActionLog($code,"FAILED to edit data<br />ERROR : [".var_export(DB::error(), true)."]<br />RETURN : [".var_export($updatenum, true)."]", $data);
			return false;
		}
		if(Info::keepNormalActivityLog)
			Log::addActionLog($code,"edit data", $data);
		return true;
	}

	// remove
	static function delete($code, $where, $defaulttable = true)
	{
		$removenum = DB::delete(Info::moduleTablePrefix.$code, $where);
		$error = DB::error();

		if($error[0] != '00000')
		{
			if(Info::keepErrorActivityLog)
				Log::addActionLog($code,"FAILED to remove data<br />ERROR : [".var_export(DB::error(), true)."]<br />RETURN : [".var_export($removenum, true)."]", $data);
			return false;
		}
		if(Info::keepNormalActivityLog)
			Log::addActionLog($code,"remove data", $where);
		return true;
	}

	// swap orderid
	static function swap($code, $currentid, $movetoid)
	{
		$arr = array(
			'currentid' => $currentid,
			'movetoid' => $movetoid
			);

		$currententity = DB::get(Info::moduleTablePrefix.$code, "*", array("id" => $currentid));
		$movetoentity = DB::get(Info::moduleTablePrefix.$code, "*", array("id" => $movetoid));

		if($currententity['sortorderid'] == $movetoentity['sortorderid'])
		{
			if(Info::keepErrorActivityLog)
				Log::addActionLog($code,"FAILED to swap [sortorderid is equal]", $arr);
			return false;
		}

		$currentarr = array( 'sortorderid' => $currententity['sortorderid'] );
		$movetoarr = array( 'sortorderid' => $movetoentity['sortorderid'] );


		if(!DB::update(Info::moduleTablePrefix.$code, $movetoarr, array('id'=>$currentid)))
		{
			$error = DB::error();
			if(Info::keepErrorActivityLog)
				Log::addActionLog($code,"FAILED to swap sortorderid [".$error[2]."]", $arr);
			return false;
		}
		DB::update(Info::moduleTablePrefix.$code, $currentarr, array('id'=>$movetoid));

		if(Info::keepNormalActivityLog)
		{
			$arr['currentsortorderid'] = $currententity['sortorderid'];
			$arr['tosortorderid'] = $movetoentity['sortorderid'];
			Log::addActionLog($code,"swap orderid", $arr);
		}
		return true;
	}

	// fetch data
	static function select($code, $columns='*', $where='')
	{
		return DB::select(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function get($code, $columns='*', $where='')
	{
		return DB::get(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function count($code, $where='')
	{
		return DB::count(Info::moduleTablePrefix.$code, $where);
	}

	static function max($code, $columns='*', $where='')
	{
		return DB::max(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function min($code, $columns='*', $where='')
	{
		return DB::min(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function avg($code, $columns='*', $where='')
	{
		return DB::avg(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function sum($code, $columns='*', $where='')
	{
		return DB::sum(Info::moduleTablePrefix.$code ,$columns, $where);
	}

	static function has($code, $where='')
	{
		return DB::has(Info::moduleTablePrefix.$code, $where);
	}

	// manual
	static function query($sql)
	{
		$result =  DB::query($sql);

		if(!$result)
		{
			Log::addActionLog($code,"FAILED to insert data<br />ERROR : [".var_export(DB::error(), true)."]<br />RETURN : [".var_export($result, true)."]<br />result : [".$result."]<br /><br />".DB::last_query()."<br />", $data);
		}

		return $result;

	}

	// getter
	static function getUserName($data)
	{
		$userdata = User::getUserByID($data['insertuserid']);

		if(!$userdata)
			return 'Removed';

		$name = $userdata['username'];

		return $name;
	}

	// format user
	static function formatUser($userid, $isUser = 's', $codeUser = '')
	{
		if('s' == $isUser)
		{
			if($userid==-1)
				return "<span>Unknown</span>";
			else if($userid==0)
				return "<span class='text-success'>System</span>";
			else
			{
				$user = User::getUserByID($userid);
				if($user!=null)
				{
					if($user['role']=='Dev')
						return "<span class='text-warning'>".$user['username']."</span>";
					else if($user['role']=='Mod')
						return "<span class='text-primary'>".$user['username']."</span>";	
					else 
						return $user['username'];
				}
				return "Unknown";
			}
		}
		else if('m' == $isUser)
		{
			if($userid==-1)
				return "<span>Unknown</span>";
			else
			{
				$user = Amst::get($codeUser.'_user_system','*',array('id' => $userid));
				if($user!=null)
					return "<span>".$user['username']."</span>";

				return "<span>Not Found</span>";
			}
		}
		else
		{
			if($userid==-1)
				return "<span>Unknown</span>";
			else
				return "<span>Not Found</span>";
		}
	}
	static function formatUserAPI($userid)
	{
		if($userid==-1)
			return "<span>Unknown</span>";
		else if($userid==0)
			return "<span class='text-success'>System</span>";
		else
		{
			$user = UserAPI::getUserByID($userid);
			if($user!=null)
				return "<span class='text-warning'>".$user['fullname']."</span>";

			return "Unknown";
		}
	}
	static function formatUserRole($role)
	{
		if($role=='guardian')
			return "<span class='label label-success'>System</span>";
		else if($role=='Dev')
			return "<span class='label label-warning'>".$role."</span>";
		else if($role=='Mod')
			return "<span class='label label-primary'>".$role."</span>";	
		else 
			return $role;
	}
	static function formatUserStatus($status)
	{
		if($status=='Active')
			return "<span class='label label-success'>".$status."</span>";
		else if($status=='Banned')
			return "<span class='label label-danger'>".$status."</span>";
		else
			return $status;
	}

	// GENERAL METHOD
	static function formatStatus($status)
	{
		if($status=='Active')
			return "<span class='label label-success'>".$status."</span>";
		else if($status=='InActive')
			return "<span class='label label-danger'>".$status."</span>";
		else
			return $status;
	}

	static function formatDate($date)
	{
		if($date == "0000-00-00 00:00:00")
			return 'Never';

		$timestamp = strtotime($date);

		return "<small data-toggle='tooltip' data-placement='top' title='".date("d/m/Y H:i:s", $timestamp)."' data-livestamp='$timestamp'></small>";
	}
}
?>