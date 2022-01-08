<?php
class Info
{
	//// system config
	const debug_sql_select = false;
	const debug_sql_insert = false;
	const debug_sql_update = false;
	const debug_sql_delete = false;

	const keepServerActivityLog = true;
	const keepServerSQLLog = true;

	const keepAPIActivityLog = true;
	const keepAPISQLLog = true;

	const maximumActivityLog = 200;

	//// system
	// map relative between [classname => file] *only class
	static $sysFile = array(
		// main Info
		"Info" => "src/php/Info",

		// config
		"Config" => "conf/config",

		// core
		"ConNLog" => "src/php/core/Core_ConNLog",
		"DB" => "src/php/core/Core_DB",
		"Query" => "src/php/core/Core_Query",

		// core derive
		"Amst" => "src/php/core_derive/Core_Amst",
		"File" => "src/php/core_derive/Core_File",
		"Func" => "src/php/core_derive/Core_Function",
		"Log" => "src/php/core_derive/Core_Log",
		"User" => "src/php/core_derive/Core_User",
		"UserAPI" => "src/php/core_derive/Core_Userapi",

		// lib
		"ImageManagement" => "src/php/lib/Lib_image",

		// front
		"ChartManagement" => "src/php/front/Front_Chart",
		);

	// map relative between [name => file] *only non-class
	static $sysOtherFile = array(
		// main Info
		"json-get-getbyid" => "api/json-get/getbyid",
		);
	
	// map relative between [functiontable => tablename]
	static $sysTable = array(
		"logaction" => "sys_log_action",
		"logsql" => "sys_log_sql",
		"function" => "sys_function",
		"user" => "sys_user",
		"userapi" => "sys_user_api",
		"userpermission" => "sys_user_permission",
		"usermemo" => "sys_user_memo"
		);
	// end

	//// module
	// module prefix
	const moduleTablePrefix = "func_";

	// map relative between [modulename => file]
	static $moduleFile = array(
		// small module
		"content" => "mod/content",
		"contenthtml" => "mod/contenthtml",
		"gallery" => "mod/gallery",
		"gallerycategory" => "mod/gallerycategory",
		"youtube" => "mod/youtube",
		"file" => "mod/file",
		"score" => "mod/score",
		"counter" => "mod/counter",
		"switch" => "mod/switch",
		"jobs" => "mod/jobs",

		// big module
		"700trail" => "mod_ex/700trail",
		"examenergy" => "mod_ex/examenergy",
		"account" => "mod_ex/account",
		"banana" => "mod_ex/banana",
		"employee" => "mod_ex/employee",
		"factory" => "mod_ex/factory",
		"factorymini" => "mod_ex/factorymini",
		"callcenter" => "mod_ex/callcenter",
		"mailing" => "mod_ex/mailing",

		// special module
		"company_electronic" => "mod_lm/company_electronic",

		"pos_chamook" => "mod_lm/pos_chamook",
		"pos_restaurant" => "mod_lm/pos_restaurant",
		"pos_tws" => "mod_lm/pos_tws",
		"pos_gym" => "mod_lm/pos_gym",

		"stock_yamfactory" => "mod_lm/stock_yamfactory",
		"stock_paradise" => "mod_lm/stock_paradise",
		"stock_export" => "mod_lm/stock_export",
		);
	// end
}
?>