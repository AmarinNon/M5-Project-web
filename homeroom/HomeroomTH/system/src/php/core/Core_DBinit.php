<?php
class DBInit
{	
	static function dropSQLTable()
	{
		// remove associate file from function
		File::deleteAllFile('../../');

		// delete database
		Amst::query("DROP DATABASE IF EXISTS ". Config::dbname .";");

		return true;
	}

	static function regenerateSQLTable()
	{
		//// create Database
		Amst::query("CREATE DATABASE IF NOT EXISTS ". Config::dbname .";");

		//// create System
		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['logaction'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`userid` BIGINT NOT NULL ,
			`code` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE = INNODB ;");
		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['logsql'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`userid` BIGINT NOT NULL ,
			`code` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`sqlquery` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE = INNODB ;");

		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['function'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`code` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`module` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`functionname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`vat_num` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`refer_code` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`address` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_line1` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_line2` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`address_no` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_moo` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_village` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_soi` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_road` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_tumbon` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_aumper` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_province` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_zipcode` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`tel` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`email` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`expireddate` DATETIME NOT NULL ,
			`money_totalpaid` DECIMAL(9,6) NOT NULL ,
			`money_debt` DECIMAL(9,6) NOT NULL ,

			`insertuserid` BIGINT NOT NULL ,
			`insertdatetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
			`updateuserid` BIGINT NOT NULL ,
			`updatedatetime` TIMESTAMP NOT NULL ,
			`sortorderid` BIGINT NOT NULL ,
			UNIQUE ( `code` )
			) ENGINE = INNODB ;");

		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['user'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`username` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`password` CHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`role` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`apikey` CHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,


			`barcode` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`ipaddress` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`facebook_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`facebook_link` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`google_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`google_link` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`firebase_registration_id` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`twitter_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`twitter_link` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`line_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`line_link` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`usertype` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`point` INT NOT NULL ,

			`organization_name` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`citizenid` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`title` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`name` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`group` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`surname` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`nickname` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`gender` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`birth_day` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`birth_month` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`birth_year` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_line1` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_line2` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`address_no` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_moo` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_village` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_soi` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_road` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_tumbon` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_aumper` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_province` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`address_zipcode` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`latitude` DOUBLE NOT NULL ,
			`longitude` DOUBLE NOT NULL ,

			`occupation` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`tel` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`tel_mobile` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`tel_home` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`website` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`email` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`bank` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`bank_number` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`secret_code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`howyouknowus` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`emergency_contact_name` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`emergency_contact_relation` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`emergency_contact_address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`emergency_contact_tel` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

			`log_value1` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`log_value2` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`log_value3` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`log_value4` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`log_value5` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`log_id1` BIGINT NOT NULL DEFAULT 0 ,
			`log_id2` BIGINT NOT NULL DEFAULT 0 ,
			`log_id3` BIGINT NOT NULL DEFAULT 0 ,
			`log_id4` BIGINT NOT NULL DEFAULT 0 ,
			`log_id5` BIGINT NOT NULL DEFAULT 0 ,

			`task` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL Default 'Active' ,

			`status` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL Default 'Active' ,
			`register` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
			`date_expired` TIMESTAMP NOT NULL ,
			`lastlogin` TIMESTAMP NOT NULL ,
			`lastlogin_api` TIMESTAMP NOT NULL ,
			`version` BIGINT NOT NULL DEFAULT 1 ,
			UNIQUE ( `username` )
			) ENGINE = INNODB ;");
		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['userlog'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`userid` BIGINT NOT NULL ,
			`topiccode` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`topicname` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
			`description` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			`insertdatetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
			) ENGINE = INNODB ;");
		Amst::query("CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::$sysTable['userpermission'] ."` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`userid` BIGINT NOT NULL ,
			`functionid` BIGINT NOT NULL
			) ENGINE = INNODB ;");

		//// create Function
		$functionlist = Func::getFunction(); //

		// initial 
		if($functionlist!=null)
		{
			foreach($functionlist as $function)
			{
				if('User' != $function['module'] && 'APITemTem' != $function['module'])
				{
					$prependdata = "CREATE TABLE IF NOT EXISTS `". Config::dbname ."`.`". Info::moduleTablePrefix.$function['code'];
					$appenddata = "
					`insertdatetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
					`insertusertype` VARCHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					`insertuserid` BIGINT NOT NULL ,

					`updatedatetime` TIMESTAMP NOT NULL ,
					`updateusertype` VARCHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
					`updateuserid` BIGINT NOT NULL ,

					`sortorderid` BIGINT NOT NULL ,
					`version` BIGINT NOT NULL DEFAULT 1 ,
					`status` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL Default 'Active'";
					$modulename = $function['module'];
					include_once '../../'.Info::$moduleFile[$function['module']].'/required/info_module.php';

					if($sqlinfo[$function['module']] != null)
					{
						foreach ($sqlinfo[$function['module']] as $value)
							Amst::query($prependdata.$value);
					}
				}
			}
		}
	}
}
?>