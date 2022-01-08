<?php
$sqlinfo[$modulename] = array(
	'_user' => '_user` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,

		`username` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
		`password` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'.
		$appenddata.') ENGINE = INNODB ;',);
?>