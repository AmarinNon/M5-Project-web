<?php
$apiinfo[$modulename] = array(
	'PINONTOP' => array(
		'GET SAMPLE JSON' => array(
			'description' => 'ดึงข้อมูลตัวอย่าง แบบข้อมูลเดียว',
			'required' => array(
				'action' => 'sample_testjsonsingle',
				),
			'return' => 'custom',
			'returndata' => array(
				'sampleid' => 'id',
				'sampletext' => 'text',
				'samplenumber' => 'number',
				),
			),
		'GET SAMPLE JSON LIST' => array(
			'description' => 'ดึงข้อมูลตัวอย่าง แบบ list',
			'required' => array(
				'action' => 'sample_testjsonlist',
				),
			'return' => 'custom',
			'returndata' => array(
				'sampleid' => 'id',
				'sampletext' => 'text',
				'samplenumber' => 'number',
				),
			),
		'GET PINGPONG MESSAGE' => array(
			'description' => 'ส่งค่ามา จะส่งค่ากลับไม่โกง',
			'required' => array(
				'action' => 'sample_pingpong',
				'message' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'message' => 'text',
				),
			),
		),
	'USER TEST' => array( //
		'REGISTER' => array(
			'description' => 'ลงทะเบียน user',
			'required' => array(
				'action' => 'user_register',
				'username' => 'REQUIRED',
				'password' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LOGIN' => array(
			'description' => 'login เข้าสู่ระบบ',
			'required' => array(
				'action' => 'user_login',
				'username' => 'REQUIRED',
				'password' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'PERMANENT DELETE USER' => array(
			'description' => 'เป็นการลบ user ออกไปเลยจากระบบ (!warning)',
			'required' => array(
				'action' => 'user_permanentdelete',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET ALL',
			),
		'GET USER BY ID' => array(
			'description' => 'ดึงข้อมูล user ผ่าน user id',
			'required' => array(
				'action' => 'user_getbyid',
				'user_id' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'username' => 'text',
				'password' => 'text',
				),
			),
		'GET USER LIST' => array(
			'description' => 'ดึงข้อมูล user ทั้งหมด',
			'required' => array(
				'action' => 'user_getlist',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'username' => 'text',
				'password' => 'text',
				),
			),
		),
);
?>