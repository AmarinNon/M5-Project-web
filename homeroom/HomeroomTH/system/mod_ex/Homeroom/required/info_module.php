<?php
$sqlinfo[$modulename] = array(
	'_role' => '_role` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`target_user_id` BIGINT NOT NULL ,
		`position` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_student_parent' => '_student_parent` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`teacher_id` BIGINT NOT NULL ,
		`student_id` BIGINT NOT NULL ,
		`parent_id` BIGINT NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_homeroom' => '_homeroom` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`teacher_id` BIGINT NOT NULL ,
		`name` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_subject' => '_subject` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`teacher_id` BIGINT NOT NULL ,
		`homeroom_id` BIGINT NOT NULL ,

		`subject_code` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`name` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`color` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_homework' => '_homework` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`subject_id` BIGINT NOT NULL ,
		`teacher_id` BIGINT NOT NULL ,
		`homeroom_id` BIGINT NOT NULL ,

		`shortname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`name` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,

		`homework_type` TINYINT NOT NULL ,

		`assign_date` DATETIME NOT NULL ,
		`deadline_date` DATETIME NOT NULL ,

		`score` DECIMAL(12,4) NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_homework_score' => '_homework_score` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`student_id` BIGINT NOT NULL ,
		`homework_id` BIGINT NOT NULL ,
		`homeroom_id` BIGINT NOT NULL ,

		`score` DECIMAL(12,4) NOT NULL ,
		`late_send` TINYINT NOT NULL DEFAULT 0 ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_checkin' => '_checkin` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`homeroom_id` BIGINT NOT NULL ,
		`subject_id` BIGINT NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_checkin_detail' => '_checkin_detail` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`checkin_id` BIGINT NOT NULL ,
		`student_id` BIGINT NOT NULL ,
		`homeroom_id` BIGINT NOT NULL ,
		`subject_id` BIGINT NOT NULL ,

		`checkin_status` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',
		
	'_message' => '_message` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`send_user_id` BIGINT NOT NULL ,
		`receive_user_id` BIGINT NOT NULL ,

		`message` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`message_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',

	'_announcement' => '_announcement` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`teacher_id` BIGINT NOT NULL ,
		`subject_id` BIGINT NOT NULL ,
		`homeroom_id` BIGINT NOT NULL ,

		`message` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;');
?>