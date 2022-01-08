<?php
$apiinfo[$modulename] = array(
	'PINONTOP' => array(
		'CREATE FUNCTION' => array(
			'description' => 'สร้าง function ขึ้นมา กรอกชื่อ function ให้ถูกต้อง',
			'required' => array(
				'action' => 'create',
				'fullname' => 'text',
				'function' => 'text [ask developer]',
				'user_id' => 'user_id',
				'img_logo' => 'base64 encode image (optional)',
				'...' => 'any other field that we want to add',
				),
			'return' => 'text',
			'returndata' => 'GET FUNCTION BY ID',
			),
		'EDIT FUNCTION NAME' => array(
			'description' => 'แก้ไข function',
			'required' => array(
				'action' => 'edit',
				'function_id' => 'number',
				'img_logo' => 'base64 encode image (optional)',
				'...' => 'any other field that we want to edit',
				),
			'return' => 'text',
			'returndata' => 'GET FUNCTION BY ID',
			),
		'REMOVE FUNCTION' => array(
			'description' => 'ลบ function',
			'required' => array(
				'action' => 'remove',
				'function_id' => 'number',
				),
			'return' => 'none',
			),
		'GET FUNCTION BY ID' => array(
			'description' => 'ดึง list function จาก user_id',
			'required' => array(
				'action' => 'getfunctionbyid',
				'function_id' => 'number',
				),
			'return' => 'custom',
			'returndata' => array(
				'function_id' => 'id',
				'name' => 'text',
				'function' => 'text',
				'img_logo' => 'link',
				'...' => 'all the field that we have',
				),
			),
		'GET FUNCTION BY USERID' => array(
			'description' => 'ดึง list function จาก user_id',
			'required' => array(
				'action' => 'getfunctionbyuserid',
				'user_id' => 'number',
				),
			'return' => 'custom',
			'returndata' => array(
				'function_id' => 'id',
				'name' => 'text',
				'function' => 'text',
				'img_logo' => 'link',
				'...' => 'all the field that we have',
				),
			),
		),
	);
?>