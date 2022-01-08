<?php
$apiinfo[$modulename] = array(
	'PINONTOP' => array(
		'GET USER BY ID' => array(
			'description' => 'ดึงข้อมูล user ผ่าน user id',
			'required' => array(
				'action' => 'getuserbyid',
				'user_id' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'user_id_encrypt' => 'id with encrypt',
				'...' => 'all the field that we have',
				),
			),
		'GET ALL' => array(
			'description' => 'ดึงข้อมูล user ทั้งหมดที่ Active',
			'required' => array(
				'action' => 'usergetall',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'...' => 'all the field that we have',
				),
			),
		'GET ALL STATE' => array(
			'description' => 'ดึงข้อมูล user ทั้งหมดทุกสถานะ',
			'required' => array(
				'action' => 'usergetallstate',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'...' => 'all the field that we have',
				),
			),
		'GET ALL BAN' => array(
			'description' => 'ดึงข้อมูล user ที่ถูก BAN (สถานะเป็น DeActive)',
			'required' => array(
				'action' => 'usergetallban',
				),
			'return' => 'custom',
			'returndata' => array(
				'user_id' => 'id',
				'...' => 'all the field that we have',
				),
			),
		),
	'REGISTER' => array( //
		'REGISTER ธรรมดา' => array(
			'description' => 'ลงทะเบียน user',
			'required' => array(
				'action' => 'register',
				'username' => 'REQUIRED',
				'password' => 'REQUIRED',
				'role' => 'REQUIRED (Mod)',
				'...' => 'any other field that we want to add',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'REGISTER ด้วย Facebook' => array(
			'description' => 'ลงทะเบียน user ด้วย facebook_id',
			'required' => array(
				'action' => 'register_facebook',
				'facebook_id' => 'REQUIRED',
				'role' => 'REQUIRED (Mod)',
				'...' => 'any other field that we want to add',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'REGISTER ด้วย Google' => array(
			'description' => 'ลงทะเบียน user ด้วย google_id',
			'required' => array(
				'action' => 'register_google',
				'role' => 'REQUIRED (Mod)',
				'...' => 'any other field that we want to add',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'REGISTER ด้วย Twitter' => array(
			'description' => 'ลงทะเบียน user ด้วย twitter_id',
			'required' => array(
				'action' => 'register_twitter',
				'role' => 'REQUIRED (Mod)',
				'...' => 'any other field that we want to add',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		),
	'LOGIN' => array( //
		'LOGIN ธรรมดา' => array(
			'description' => 'login เข้าสู่ระบบ',
			'required' => array(
				'action' => 'login',
				'username' => 'REQUIRED',
				'password' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LOGIN ด้วย Facebook' => array(
			'description' => 'login เข้าสู่ระบบ ด้วย facebook_id',
			'required' => array(
				'action' => 'login_facebook',
				'facebook_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LOGIN ด้วย Google' => array(
			'description' => 'login เข้าสู่ระบบ ด้วย google_id',
			'required' => array(
				'action' => 'login_google',
				'google_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LOGIN ด้วย Twitter' => array(
			'description' => 'login เข้าสู่ระบบ ด้วย twitter_id',
			'required' => array(
				'action' => 'login_twitter',
				'twitter_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'RECHECK LOGIN' => array(
			'description' => 'เช็ค login หลัง login ไปแล้ว ',
			'required' => array(
				'action' => 'login_recheck',
				'user_id_encrypt' => 'REQUIRED',
				'username' => 'REQUIRED',
				'password' => 'REQUIRED (from getuserbyid)',
				),
			'return' => 'none',
			),
		),
	'EDIT' => array( //
		'LINK FACEBOOK' => array(
			'description' => 'เชื่อม user กับ account facebook',
			'required' => array(
				'action' => 'link_facebook',
				'user_id' => 'REQUIRED',
				'facebook_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'UNLINK FACEBOOK' => array(
			'description' => 'ยกเลิกการเชื่อม user กับ account facebook',
			'required' => array(
				'action' => 'unlink_facebook',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LINK GOOGLE' => array(
			'description' => 'เชื่อม user กับ account google',
			'required' => array(
				'action' => 'link_google',
				'user_id' => 'REQUIRED',
				'google_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'UNLINK GOOGLE' => array(
			'description' => 'ยกเลิกการเชื่อม user กับ account google',
			'required' => array(
				'action' => 'unlink_google',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'LINK TWITTER' => array(
			'description' => 'เชื่อม user กับ account twitter',
			'required' => array(
				'action' => 'link_twitter',
				'user_id' => 'REQUIRED',
				'google_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'UNLINK TWITTER' => array(
			'description' => 'ยกเลิกการเชื่อม user กับ account twitter',
			'required' => array(
				'action' => 'unlink_twitter',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'EDIT (EXCEPT PASSWORD, PROFILE IMAGE)' => array(
			'description' => 'แก้ไข user data ทั่วไป',
			'required' => array(
				'action' => 'edit',
				'user_id' => 'REQUIRED',
				'...' => 'any other field that we want to edit',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'EDIT PASSWORD' => array(
			'description' => 'แก้ไข password',
			'required' => array(
				'action' => 'editpassword',
				'user_id' => 'REQUIRED',
				'oldpassword' => 'REQUIRED',
				'newpassword' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'EDIT PROFILE IMAGE' => array(
			'description' => 'แก้ไข profile image',
			'required' => array(
				'action' => 'editprofileimage',
				'user_id' => 'REQUIRED',
				'profile_image' => 'base64',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		'BAN' => array(
			'description' => 'ban user',
			'required' => array(
				'action' => 'userban',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET ALL',
			),
		'UNBAN' => array(
			'description' => 'unban user',
			'required' => array(
				'action' => 'userban',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET ALL BAN',
			),
		),
	'DELETE' => array( //
		'PERMANENT DELETE USER' => array(
			'description' => 'เป็นการลบ user ออกไปเลยจากระบบ (!warning)',
			'required' => array(
				'action' => 'permanentdelete',
				'user_id' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET ALL',
			),
		),
	'RESET PASSWORD' => array( //
		'SEND MAIL' => array(
			'description' => 'ส่ง link reset password',
			'required' => array(
				'action' => 'resetpassword_sendmail',
				'email' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'status' => 'boolean',
				),
			),
		'EDIT PASSWORD' => array(
			'description' => 'เปลี่ยนรหัสผ่าน',
			'required' => array(
				'action' => 'resetpassword_editpassword',
				'user_id' => 'REQUIRED',
				'newpassword' => 'REQUIRED',
				),
			'return' => 'text',
			'returndata' => 'GET USER BY ID',
			),
		),
	'VERIFICATION' => array( //
		'GET CODE' => array(
			'description' => 'เจนรหัส 4 ตัวส่ง sms',
			'required' => array(
				'action' => 'verify_getcode',
				'user_id' => 'REQUIRED',
				'tel' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'status' => 'boolean'
				// 'tel' => 'text',
				// 'code' => 'number',
				// 'exp_datetime' => 'datetime',
				),
			),
		'VERIFY CODE' => array(
			'description' => 'verify code',
			'required' => array(
				'action' => 'verify_code',
				'user_id' => 'REQUIRED',
				'verification_code' => 'REQUIRED',
				),
			'return' => 'custom',
			'returndata' => array(
				'status' => 'boolean'
				),
			),
		),
	);
?>