<?php
class Info
{
	//// system config
	const keepNormalActivityLog = false;
	const keepErrorActivityLog = true;
	// upfirst then down
	const keepServerActivityLog = true;
	const keepServerSQLLog = true;
	const keepAPIActivityLog = true;
	const keepAPISQLLog = true;
	//// when dev call api keep log
	const keepAPICallLog = false;

	const maximumActivityLog = 200;

	// system
	// map relative between [classname => file] *only class
	static $sysFile = array(
		// main Info
		"Info" => "Info",

		// config
		"Config-Server" => "conf/config-server",
		"Config-Localhost" => "conf/config-localhost",

		// core
		"DB" => "src/php/core/Core_DB",
		"DBInit" => "src/php/core/Core_DBinit",

		// core derive
		"Amst" => "src/php/core_derive/Core_Amst",
		"File" => "src/php/core_derive/Core_File",
		"Func" => "src/php/core_derive/Core_Function",
		"Log" => "src/php/core_derive/Core_Log",
		"User" => "src/php/core_derive/Core_User",
		"Minion" => "src/php/core_derive/Core_Minion",

		// lib
		"ImageManagement" => "src/php/core_other/Lib_image",

		// Nammon
		"Model" => "src/php/jesr/Model",
		"Firebase" => "src/php/jesr/Firebase/Firebase",
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
		"userlog" => "sys_user_log",
		"userpermission" => "sys_user_permission",
		"minion" => "sys_minion",
		"minionlog" => "sys_minion_log",
		);
	// end

	//// module
	// module prefix
	const moduleTablePrefix = "func_";

	// map relative between [modulename => file]
	static $moduleFile = array(
		"Content" => "mod/Content",
		"ImageCode" => "mod/ImageCode",
		"SlideShow" => "mod/SlideShow",
		"Product" => "mod/Product",

		// SYS module
		"User" => "mod_sys/User",
		"TestAPI" => "mod_sys/TestAPI",
		"APITemTem" => "mod_sys/APITemTem",
		"Function" => "mod_sys/Function",

		// EPIC module
		"Aomkem POS" => "mod_ex/AomkemPOS",
		"Aomkem Zada" => "mod_ex/AomkemZada",

		// EX module
		"AbleOrder" => "mod_ex/AbleOrder",
		"PerfectOrder" => "mod_ex/PerfectOrder",
		"Mari" => "mod_ex/Mari",
		"GMT" => "mod_ex/GMT",
		"CustomerBall" => "mod_ex/CustomerBall",
		
		"CMTrail" => "mod_ex/CMTrail",
		"CMUActivity" => "mod_ex/CMUActivity",
		"KohtaoMap" => "mod_ex/KohtaoMap",
		"APT" => "mod_ex/APT",
		"ALogistic" => "mod_ex/ALogistic",
		"OrderAble" => "mod_ex/OrderAble",
		"Webboard" => "mod_ex/Webboard",
		"Guestbook" => "mod_ex/Guestbook",
		"ChulaDocument" => "mod_ex/ChulaDocument",
		"POS" => "mod_ex/POS",

		// API
		"JoinTour" => "mod_ex/JoinTour",
		"MoneyTracking" => "mod_ex/MoneyTracking",
		"Uniktec" => "mod_ex/Uniktec",
		"MuakPOS" => "mod_ex/MuakPOS",
		"WisdomLocation" => "mod_ex/WisdomLocation",
		"ProudFront" => "mod_ex/ProudFront",
		"ProudMagazine" => "mod_ex/ProudMagazine",
		"R2C" => "mod_ex/R2C",
		"Buyback" => "mod_ex/Buyback",
		"HazefreeAPI" => "mod_ex/HazefreeAPI",
		"TCDCStock" => "mod_ex/TCDCStock",

		// SHOP !!!!!
		"DangBakery" => "mod_ex/DangBakery",
		"NathaPharmacy" => "mod_ex/NathaPharmacy",
		"Yimprasert" => "mod_ex/Yimprasert",
		"YimprasertExtra" => "mod_ex/YimprasertExtra",
		"Catwalk" => "mod_ex/Catwalk",
		"Kaipop" => "mod_ex/Kaipop",
		"Shista" => "mod_ex/Shista",
		"Restaurant" => "mod_ex/Restaurant",
		"RatthaClinic" => "mod_ex/RatthaClinic",
		"SC2LClinic" => "mod_ex/SC2LClinic",
		"Shop" => "mod_ex/Shop",
		"HOFStore" => "mod_ex/HOFStore",
		"PoliceShop" => "mod_ex/PoliceShop",
		"Banana" => "mod_ex/Banana",

		// UTILITY
		"Account" => "mod_ex/Account",

		"ADAGems" => "mod_ex/ADAGems",
		"GoGym" => "mod_ex/GoGym",
		"PowerUpGym" => "mod_ex/PowerUpGym",

		"PhotoShare" => "mod_ex/PhotoShare",

		"ExamM" => "mod_ex/ExamM",
		"Ordnance" => "mod_ex/Ordnance",
		"Cremation" => "mod_ex/Cremation",
		"Constech" => "mod_ex/Constech",

		"StockBill" => "mod_ex/StockBill",
		"StockPrisoner" => "mod_ex/StockPrisoner",
		"CDSupply" => "mod_ex/CDSupply",
		"Company" => "mod_ex/Company",
		"Gas" => "mod_ex/Gas",
		"Fanball555" => "mod_ex/Fanball555",
		"TISQuestionaire" => "mod_ex/TISQuestionaire",
		"Logistic" => "mod_ex/Logistic",
		"Pongyang" => "mod_ex/Pongyang",
		"Ronubb" => "mod_ex/Ronubb",
		"Panta" => "mod_ex/Panta",

		// Trailer
		"EnergyPlus168" => "mod_ex/EnergyPlus168",

		// ETC
		"LemonProperty" => "mod_ex/LemonProperty",
		"Company" => "mod_ex/Company",
		"SMSm" => "mod_ex/SMSm",
		"RWProduct" => "mod_ex/RWProduct",
		"ACFS" => "mod_ex/ACFS",
		"Homdang" => "mod_ex/Homdang",
		"Homeroom" => "mod_ex/Homeroom",

		"WorkerSchedule" => "mod_ex/WorkerSchedule",
		"RentalStore" => "mod_ex/RentalStore",
		"CardMoney" => "mod_ex/CardMoney",

		// NAMMON
		"Metro" => "mod_ex/Metro",
		"FarmPB" => "mod_ex/FarmPB",
		"FuelCard" => "mod_ex/FuelCard",
		"CrossModuleOrder" => "mod_ex/CrossModuleOrder",
		"7Guns" => "mod_ex/7Guns",
		"Yec" => "mod_ex/Yec",
		"CDSupplySale" => "mod_ex/CDSupplySale",

		"Youtube" => "mod/Youtube",
		);
	// end
}
?>