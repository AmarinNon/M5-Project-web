<?php
class Homeroom {
	private static $__homeroom = null;
	private static $__subject = null;

	const COLORS = array(
		'#f44336',
		'#e91e63',
		'#9c27b0',
		'#673ab7',
		'#3f51b5',
		'#2196f3',
		'#03a9f4',
		'#00bcd4',
		'#009688',
		'#4caf50',
		'#8bc34a',
		'#cddc39',
		'#ffeb3b',
		'#ffc107',
		'#ff9800',
		'#ff5722',
		'#795548',
		'#9e9e9e',
		'#607d8b'
	);
	const FONT_COLORS = array(
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#000000',
		'#000000',
		'#000000',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff',
		'#ffffff'
	);

	public static function color_index($color_code) {
		for($i = 0 ; $i < count(self::COLORS) ; $i++) {
			if($color_code == self::COLORS[$i]) {
				return $i;
			}
		}
		return -1;
	}

	public static function init () {
		if(System::session('mode') === null) {
			System::session('mode', 'Homeroom');
		}
	}

	public static function save_success () {
		System::notification('บันทึกข้อมูลสำเร็จ', 'success');
	}

	public static function save_error () {
		System::notification('เกิดข้อผิดพลาด ไม่สามารถบนทึกข้อมูลได้', 'error');
	}

	public static function check_permission ($allowed , $redirect_url = '') {
		$user = System::get_current_user();
		if($user) {
			if(! in_array($user->role, $allowed)) {
				System::redirect($redirect_url);
			}
		} else {
			System::redirect($redirect_url);
		}
	}

	//---------- user
	public static function user_getbyid($user_id) {
		$query_result = System::callAPI(System::API_CODE['USER'], 'getuserbyid', array(
			'user_id' => $user_id
		), false);
		if(count($query_result) > 0) {
			return $query_result[0];
		} else {
			return array();
		}
	}

  //---------- homeroom
	public static function homeroom_getlist ($and = array(), $cache = false) {
		$and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => 'name'
		);

		if($cache === false) {
			self::$__homeroom = System::temtem(System::API_CODE['HOMEROOM'], 'homeroom', 'getlist', array(
				'where' => $where
			), false);
		} else {
			if(self::$__homeroom === null) {
				self::homeroom_getlist($and, false);
			}
		}
		return self::$__homeroom;
	}

	public static function homeroom_getbyid ($homeroom_id) {
		$homeroom = self::homeroom_getlist(array(), true);
		for($i = 0 ; $i < count($homeroom) ; $i++) {
			if($homeroom_id == $homeroom[$i]->id) {
				return $homeroom[$i];
			}
		}
		return false;
	}

	public static function homeroom_add ($data) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homeroom', 'insert', $data, false);
		return $query_result;
	}

	public static function homeroom_edit ($homeroom_id, $name) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homeroom', 'update', array(
			'id' => $homeroom_id,
			'name' => $name
		), false);
		return $query_result;
	}

	public static function homeroom_delete ($homeroom_id) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homeroom', 'delete', array(
			'id' => $homeroom_id
		), false);

		$where = array(
			'homeroom_id' => $homeroom_id,
			'subject_id' => 0
		);

		if($query_result) {
			self::checkin_delete($where);
			self::checkin_detail_delete($where);
		}

		return $query_result;
	}

	public static function homeroom_removable ($homeroom_id) {
		$removable = false;
		$homework = self::subject_getlist(array('homeroom_id' => $homeroom_id));
		$student = self::student_getbyhomeroomid($homeroom_id);
		if(count($homework) == 0 && count($student) == 0) {
			$removable = true;
		}
		return $removable;
	}

  //---------- subject
	public static function subject_getlist ($and = array(), $cache = false) {
		$and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => 'name'
		);

		if($cache === false) {
			self::$__subject = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'getlist', array(
				'where' => $where
			), false);
		} else {
			if(self::$__subject === null) {
				self::subject_getlist($and, false);
			}
		}
		return self::$__subject;
	}

	public static function subject_add ($data) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'insert', $data, false);
	}

	public static function subject_edit ($data) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'update', $data, false);
    return $query_result;
	}

	public static function subject_delete ($subject_id) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'delete', array(
			'id' => $subject_id
		), false);

		$where = array(
			'subject_id' => $subject_id
		);

		if($query_result) {
			self::checkin_delete($where);
			self::checkin_detail_delete($where);
			self::homework_delete($where);
			self::prakard_delete($where);
			self::message_delete(array('ref_id' => $subject_id));
		}
		
		return $query_result;
  }
	
  public static function subject_getbyid ($subject_id) {
		$subject = self::subject_getlist(array(), true);
		for($i = 0 ; $i < count($subject) ; $i++) {
			if($subject_id == $subject[$i]->id) {
				return $subject[$i];
			}
		}
		return false;
	}

	public static function subject_removable ($subject_id) {
		$removable = false;
		$homework = self::homework_getlist(array('subject_id' => $subject_id));
		if(count($homework) == 0) {
			$removable = true;
		}
		return $removable;
	}

  //---------- student
	public static function delete_student ($student_id, $parent_id = false) {
		System::callAPI(System::API_CODE['USER'], 'permanentdelete', array(
			'user_id' => $student_id
		));
		if($parent_id !== false) {
			System::callAPI(System::API_CODE['USER'], 'permanentdelete', array(
				'user_id' => $parent_id
			), false);

			$student_parent = System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'getlist', array(
					'where' => array(
						'student_id' => $student_id
					)
			), false);

			if(count($student_parent) > 0) {
				System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'delete', array(
					'id' => $student_parent[0]->id
				), false);
			}
		}
  }

	public static function student_parent ($student_id) {
		$where = array(
			'AND' => array(
				'student_id' => $student_id,
				'status' => 'Active'
			)
		);

		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'getlist', array(
				'where' => $where
		), false);
		if(count($query_result) > 0) {
			$parents = System::callAPI(System::API_CODE['USER'], 'getuserbyid', array(
				'user_id' => $query_result[0]->parent_id
			));
			if(count($parents) > 0) {
				return $parents[0];
			}
		}
		return false;
  }

	public static function parent_student ($parent_id) {
		$where = array(
			'AND' => array(
				'parent_id' => $parent_id,
				'status' => 'Active'
			)
		);

		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'getlist', array(
				'where' => $where
		), false);
		if(count($query_result) > 0) {
			$student = System::callAPI(System::API_CODE['USER'], 'getuserbyid', array(
				'user_id' => $query_result[0]->student_id
			));
			if(count($student) > 0) {
				return $student[0];
			}
		}
		return false;
  }
  
  public static function student_getbyhomeroomid($homeroom_id) {
    $all_student = System::callAPI(System::API_CODE['USER'], 'usergetall', null, false);
    $student = array();
    for($i = 0; $i < count($all_student) ; $i++){
      if($all_student[$i]->role == 'Student' && $all_student[$i]->log_id1 == $homeroom_id) {
        array_push($student, $all_student[$i]);
      }
    }
    return $student;
	}

  //---------- homework
  public static function homework_getlist($and = array(), $order = array()) {
    $and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => 'shortname'
    );
    if(count($order) > 0) {
      $where['ORDER'] = $order;
    }
    $homework = System::temtem(System::API_CODE['HOMEROOM'], 'homework', 'getlist', array(
				'where' => $where
    ), false);
    return $homework;  
	}
	
  public static function homework_getbyid($homework_id) {  
    $homework = System::temtem(System::API_CODE['HOMEROOM'], 'homework', 'getbyid', array(
				'id' => $homework_id
    ), false);
    return $homework;
  }

  public static function homework_add($data) {
    $query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homework', 'insert', $data, false);
    return $query_result;
	}
	
  public static function homework_edit($data) {
    $query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homework', 'update', $data, false);
    return $query_result;
  }

  public static function homework_delete($homework_id) {
    $query_result = System::temtem(System::API_CODE['HOMEROOM'], 'homework', 'delete', array(
      'id' => $homework_id
		), false);

		if($query_result) {
			self::score_delete(array('homework_id' => $homework_id));
		}
    return $query_result;
	}

	public static function homework_groupbydate($and = array(), $order = array()) {
		$homework = self::homework_getlist($and, $order);
		$group_data = array();
		for($i = 0 ; $i < count($homework) ; $i++) {
			$date = date('Y-m-d', strtotime($homework[$i]->deadline_date));
			if(isset($group_data[$date])) {
				array_push($group_data[$date], $homework[$i]);
			} else {
				$group_data[$date] = array();
				array_push($group_data[$date], $homework[$i]);
			}
		}
		return $group_data;
	}

	public static function homework_add_file($filename, $fileobj) {
		$tmp_name = $fileobj['tmp_name'];
		$type = $fileobj['type'];
		$name = basename($fileobj['name']);

		$curl_file = curl_file_create($tmp_name, $type, $name);

		$api_result = System::add_file(System::API_CODE['HOMEROOM'], $filename, $curl_file, false);
		return $api_result;
	}

	public static function homework_get_file($filename) {
		$api_result = System::get_file(System::API_CODE['HOMEROOM'], $filename, false);
		return $api_result;
	}
	
	//---------- score
	public static function score_getlist($and = array()) {
    $and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and
    );
    
    $homework = System::temtem(System::API_CODE['HOMEROOM'], 'homework_score', 'getlist', array(
				'where' => $where
    ), false);
    return $homework;  
	}

	public static function score_add($data) {
		$api_result = System::temtem_multiple(System::API_CODE['HOMEROOM'], 'homework_score', 'insert', $data, false);
		return $api_result;
	}

	public static function score_update($data) {
		$api_result = System::temtem_multiple(System::API_CODE['HOMEROOM'], 'homework_score', 'update', $data, false);
		return $api_result;
	}

	public static function score_delete ($and = array()) {
		$list = self::score_getlist($and);
		$id = array();
		for($i = 0 ; $i < count($list) ; $i++) {
			array_push($list, $list[$i]->id);
		}
		if(count($id) > 0) {
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'score', 'delete', array(
				'id' => $id
			), false);
		} else {
			$query_result = false;
		}
		
		return $query_result;
	}

	public static function score_getlistwithstudent($subject_id) {
		$subject = self::subject_getbyid($subject_id);
		$student = self::student_getbyhomeroomid($subject->homeroom_id);
		$homework = self::homework_getlist(array(
			'subject_id' => $subject_id
		));
		$homework_id = array();
		for($i = 0 ; $i < count($homework) ; $i++) {
			array_push($homework_id, $homework[$i]->id);
		}

		$score = self::score_getlist(array(
			'homework_id' => $homework_id
		));
		// transform score array
		$tmp_score = array();
		for($i = 0 ; $i < count($score) ; $i++) {
			$h_id = $score[$i]->homework_id;
			$s_id = $score[$i]->student_id;
			$tmp_score[$s_id][$h_id] = $score[$i];
		}
		$score = $tmp_score;
		
		// merge score to student
		for($i = 0 ; $i < count($student) ; $i++) {
			$student[$i]->score = array();
			for($j = 0 ; $j < count($homework_id) ; $j++) {
				if(isset($score[$student[$i]->user_id][$homework_id[$j]])) {
					$student[$i]->score[$homework_id[$j]]['id'] = $score[$student[$i]->user_id][$homework_id[$j]]->id;
					$student[$i]->score[$homework_id[$j]]['score'] = number_format($score[$student[$i]->user_id][$homework_id[$j]]->score, 2);
					$student[$i]->score[$homework_id[$j]]['late_send'] = $score[$student[$i]->user_id][$homework_id[$j]]->late_send;
				} else {
					$student[$i]->score[$homework_id[$j]]['id'] = -1;
					$student[$i]->score[$homework_id[$j]]['score'] = number_format(0, 2);
					$student[$i]->score[$homework_id[$j]]['late_send'] = 0;
				}
			}
		}
		return $student;
	}

	public static function score_getbystudentid($subject_id, $student_id) {
		$homework = self::homework_getlist(array(
			'subject_id' => $subject_id
		));
		$homework_id = array();
		for($i = 0 ; $i < count($homework) ; $i++) {
			array_push($homework_id, $homework[$i]->id);
		}
		
		if(count($homework_id) == 0) {
			return array();
		}

		$score = self::score_getlist(array(
			'student_id' => $student_id,
			'homework_id' => $homework_id
		));

		// transform score array
		$tmp_score = array();
		for($i = 0 ; $i < count($score) ; $i++) {
			$h_id = $score[$i]->homework_id;
			$tmp_score[$h_id] = $score[$i];
		}
		$score = $tmp_score;
		
		for($i = 0 ; $i < count($homework_id) ; $i++) {
			if(isset($score[$homework_id[$i]])) {
				$score[$homework_id[$i]]->score = number_format($score[$homework_id[$i]]->score, 2);
			} else {
				$score[$homework_id[$i]] = null;
				// $score[$homework_id[$i]]->score = number_format(0, 2);
			}
		}

		return $score;
	}

	//---------- checkin
	public static function checkin_getlist($and = array(), $order = array()) {
    $and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => array('insertdatetime' => 'ASC')
		);
		if(count($order) > 0) {
      $where['ORDER'] = $order;
    }
    
    $checkin = System::temtem(System::API_CODE['HOMEROOM'], 'checkin', 'getlist', array(
				'where' => $where
    ), false);
    return $checkin;
	}

	public static function checkin_detail_getlist($and = array()) {
    $and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and
    );
    
    $checkin_detail = System::temtem(System::API_CODE['HOMEROOM'], 'checkin_detail', 'getlist', array(
				'where' => $where
    ), false);
    return $checkin_detail;
	}

	public static function checkin_detail_teacher ($homeroom_id, $subject_id) {
		$subject = self::subject_getbyid($subject_id);
		$checkin = self::checkin_getlist(array(
			'homeroom_id' => $homeroom_id,
			'subject_id' => $subject_id
		));
		$checkin_detail = self::checkin_detail_getlist(array(
			'homeroom_id' => $homeroom_id,
			'subject_id' => $subject_id,
			'checkin_status' => 'No'
		));
		// fetch checkin detail by date
		$group_data = array();
		for($i = 0 ; $i < count($checkin) ; $i++) {
			$date = date('Y-m-d', strtotime($checkin[$i]->insertdatetime));
			$group_data[$date] = array();
		}
		for($i = 0 ; $i < count($checkin_detail) ; $i++) {
			$date = date('Y-m-d', strtotime($checkin_detail[$i]->insertdatetime));
			if(isset($group_data[$date])) {
				$group_data[$date][$checkin_detail[$i]->student_id] = $checkin_detail[$i];
			}
		}
		return $group_data;
	}

	public static function checkin_detail_homeroom ($homeroom_id, $subject_id) {
		$subject = self::subject_getbyid($subject_id);
		$checkin = self::checkin_getlist(array(
			'homeroom_id' => $homeroom_id,
			'subject_id' => $subject_id
		));
		$checkin_detail = self::checkin_detail_getlist(array(
			'homeroom_id' => $homeroom_id,
			'subject_id' => $subject_id,
			'checkin_status' => 'No'
		));
		// fetch checkin detail by date
		$group_data = array();
		for($i = 0 ; $i < count($checkin) ; $i++) {
			$date = date('Y-m-d', strtotime($checkin[$i]->insertdatetime));
			$group_data[$date] = array();
		}
		for($i = 0 ; $i < count($checkin_detail) ; $i++) {
			$date = date('Y-m-d', strtotime($checkin_detail[$i]->insertdatetime));
			if(isset($group_data[$date])) {
				$student = self::user_getbyid($checkin_detail[$i]->student_id);
				$student->checkin_detail = $checkin_detail[$i];
				array_push($group_data[$date], $student);
			}
		}
		return $group_data;
	}

	public static function checkin_add ($data) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'checkin', 'insert', $data, false);
		return $query_result;
	}

	public static function checkin_detail_add($data) {
		$query_result = System::temtem_multiple(System::API_CODE['HOMEROOM'], 'checkin_detail', 'insert', $data, false);
		return $query_result;
	}

	public static function checkin_delete ($and = array()) {
		$list = self::checkin_getlist($and);
		$id = array();
		for($i = 0 ; $i < count($list) ; $i++) {
			array_push($id, $list[$i]->id);
		}
		if(count($id) > 0) {
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'checkin', 'delete', array(
				'and' => $id
			), false);
		} else {
			$query_result = false;
		}
		
		return $query_result;
	}

	public static function checkin_detail_delete ($and = array()) {
		$list = self::checkin_detail_getlist($and);
		$id = array();
		for($i = 0 ; $i < count($id) ; $i++) {
			array_push($id, $list[$i]->id);
		}
		if(count($id) > 0) {
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'checkin_detail', 'delete', array(
				'id' => $id
			), false);
		} else {
			$query_result = false;
		}
		
		return $query_result;
	}

	// ---------- prakard -- announcement
	public static function prakard_getlist ($and = array(), $order = array()) {
		$and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => array('updatedatetime' => 'DESC')
    );
    if(count($order) > 0) {
      $where['ORDER'] = $order;
    }
    $prakard = System::temtem(System::API_CODE['HOMEROOM'], 'announcement', 'getlist', array(
				'where' => $where
		), false);
		
		for($i = 0 ; $i < count($prakard) ; $i++) {
			if(trim($prakard[$i]->message) == '') {
				array_splice($prakard, $i, 1);
			}
		}
    return $prakard;
	}

	public static function prakard_add ($teacher_id, $subject_id, $homeroom_id, $message) {
		$data = array(
			'teacher_id' => $teacher_id,
			'subject_id' => $subject_id,
			'homeroom_id' => $homeroom_id
		);
		$prakard = self::prakard_getlist($data);
		if(count($prakard) > 0) {
			$prakard_id = $prakard[0]->id;
			$query_result = self::prakard_update($prakard_id, $message);
		} else {
			$data['message'] = $message;
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'announcement', 'insert', $data, false);
		}
		return $query_result;
	}
  
	public static function prakard_update($prakard_id, $message) {
		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'announcement', 'update', array(
			'id' => $prakard_id,
			'message' => $message
		), false);
		return $query_result;
	}

	public static function prakard_delete ($and = array()) {
		$list = self::prakard_getlist($and);
		$id = array();
		for($i = 0 ; $i < count($list) ; $i++) {
			array_push($id, $list[$i]->id);
		}
		if(count($id) > 0) {
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'announcement', 'delete', array(
				'id' => $id
			), false);
		} else {
			$query_result = false;
		}
		
		return $query_result;
	}

	// ------------ message
	/* message_type
		h_t = 0
		t_h = 1
		h_p = 2
		p_h = 3
		h_s = 4
		s_h = 5
		t_s = 6
		s_t = 7

		ref_id = subject_id using by '0, 1, 6, 7'
		homeroom_id -> of sent user if sent user is homeroom teacher
								-> of receiver user if sent user is teacher
	*/
	public static function message_getlist ($and = array(), $order = array()) {
		$and = array_merge($and, array(
			'status' => 'Active'
		));
		$where = array(
			'AND' => $and,
			'ORDER' => array('insertdatetime' => 'DESC')
    );
    if(count($order) > 0) {
      $where['ORDER'] = $order;
    }
    $message = System::temtem(System::API_CODE['HOMEROOM'], 'message', 'getlist', array(
				'where' => $where
    ), false);
    return $message;
	}

	public static function message_add ($send_user_id, $receive_user_id, $message, $message_type, $ref_id, $homeroom_id) {
		$data = array(
			'send_user_id' => $send_user_id,
			'receive_user_id' => $receive_user_id,
			'message' => $message,
			'message_type' => $message_type,
			'ref_id' => $ref_id,
			'homeroom_id' => $homeroom_id
		);

		$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'message', 'insert', $data, false);
		return $query_result;
	}

	public static function message_delete ($and) {
		$list = self::message_getlist($and);
		$id = array();
		for($i = 0 ; $i <count($list) ; $i++) {
			array_push($id, $list[$i]->id);
		}
		if(count($id) > 0) {
			$query_result = System::temtem(System::API_CODE['HOMEROOM'], 'message', 'delete', array(
				'id' => $id
			), false);
		} else {
			$query_result = false;
		}
		return $query_result;
	}

	public static function message_getbyid ($message_id) {
		$message = System::temtem(System::API_CODE['HOMEROOM'], 'message', 'getbyid', array(
			'id' => $message_id
		), false);
		return $message;
	}


}

Homeroom::init();
?>