<?php
$apiinfo[$modulename] = array(
	'PINONTOP' => array(
		'INSERT' => array(
			'description' => 'ใส่ข้อมูลลงฐานข้อมูล',
			'required' => array(
				'action' => 'insert',
				'table' => '[code]_[tablename]',
				'column_name1' => 'column_value1',
				'column_name2' => 'column_value2',
				'column_name3' => 'column_value3',
				'...' => '...',
				),
			'return' => 'text',
			'returndata' => 'GET BY ID',
			),
		'INSERT MULTIPLE' => array(
			'description' => 'ใส่ข้อมูลลงฐานข้อมูล หลายครั้งพร้อมกัน',
			'required' => array(
				'action' => 'insert_multiple',
				'insertlist' => 'array(table,column_name1,column2,column3,...)',
				),
			'return' => 'none',
			),
		'UPDATE' => array(
			'description' => 'อัพข้อมูลในฐานข้อมูล',
			'required' => array(
				'action' => 'update',
				'table' => '[code]_[tablename]',
				'id' => 'number',
				'column_name1' => 'column_value1',
				'column_name2' => 'column_value2',
				'column_name3' => 'column_value3',
				'...' => '...',
				),
			'return' => 'text',
			'returndata' => 'GET BY ID',
			),
		'UPDATE MULTIPLE' => array(
			'description' => 'อัพข้อมูลในฐานข้อมูล หลายครั้งพร้อมกัน',
			'required' => array(
				'action' => 'update',
				'updatelist' => 'array(table,id,column_name1,column2,column3,...)',
				),
			'return' => 'none',
			),
		'SWAP' => array(
			'description' => 'เปลี่ยนข้อมูล sortorderid',
			'required' => array(
				'action' => 'swap',
				'table' => '[code]_[tablename]',
				'id1' => 'number',
				'id2' => 'number',
				),
			'return' => 'none',
			),
		'DELETE' => array(
			'description' => 'DeActive ข้อมูลในฐานข้อมูล',
			'required' => array(
				'action' => 'delete',
				'table' => '[code]_[tablename]',
				'id' => 'number',
				),
			'return' => 'none',
			),
		'UNDO DELETE' => array(
			'description' => 'DeActive ข้อมูลในฐานข้อมูล',
			'required' => array(
				'action' => 'delete_undo',
				'table' => '[code]_[tablename]',
				'id' => 'number',
				),
			'return' => 'none',
			),
		'GET BY ID' => array(
			'description' => 'ดึงข้อมูล ตาม ID',
			'required' => array(
				'action' => 'getbyid',
				'table' => '[code]_[tablename]',
				'id' => 'number',
				),
			'return' => 'custom',
			'returndata' => array(
				'column_name1' => 'column_value1',
				'column_name2' => 'column_value2',
				'column_name3' => 'column_value3',
				'...' => '...',
				),
			),
		'GET LIST' => array(
			'description' => 'ดึงข้อมูล ตาม WHERE',
			'required' => array(
				'action' => 'getlist',
				'table' => '[code]_[tablename]',
				'where' => 'array',
				),
			'return' => 'custom',
			'returndata' => array(
				'column_name1' => 'column_value1',
				'column_name2' => 'column_value2',
				'column_name3' => 'column_value3',
				'...' => '...',
				),
			),
		'COUNT' => array(
			'description' => 'นับข้อมูล ตาม WHERE',
			'required' => array(
				'action' => 'count',
				'table' => '[code]_[tablename]',
				'where' => 'array',
				),
			'return' => 'custom',
			'returndata' => array(
				'total_row' => 'number',
				),
			),
		),
	'IMAGE' => array(
		'ADD IMAGE' => array(
			'description' => 'เพิ่มรูปด้วย base 64',
			'required' => array(
				'action' => 'image_add',
				'imagecode' => 'code',
				'imagedata' => 'base64',
				),
			'return' => 'text',
			'returndata' => 'GET IMAGE PATH',
			),
		'GET IMAGE PATH' => array(
			'description' => 'ดึงข้อมูลรูป ตาม ชื่อไฟล์',
			'required' => array(
				'action' => 'image_get',
				'imagecode' => 'text',
				),
			'return' => 'custom',
			'returndata' => array(
				'code' => 'ชื่อไฟล์',
				'url' => 'url',
				),
			),
		),
	'FILE' => array(
		'ADD FILE' => array(
			'description' => 'เพิ่มไฟล์ด้วย CURLFile object',
			'required' => array(
				'action' => 'file_add',
				'filecode' => 'code',
				'filedata' => 'CURLFile object',
				),
			'return' => 'text',
			'returndata' => 'GET FILE PATH',
			),
		'GET FILE PATH' => array(
			'description' => 'ดึงข้อมูลไฟล์ ตาม ชื่อไฟล์',
			'required' => array(
				'action' => 'file_get',
				'filecode' => 'text',
				),
			'return' => 'custom',
			'returndata' => array(
				'code' => 'ชื่อไฟล์',
				'url' => 'url',
				),
			),
		)
	);
?>