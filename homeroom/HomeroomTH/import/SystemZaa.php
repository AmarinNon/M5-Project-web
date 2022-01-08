<?php
class System {

	// api config
  const API_URL = 'http://127.0.0.1/homeroom/system/api/json/main.php';
  const API_KEY = '5e5e2d70ba499acab8b31b3d2b0371aa';
  const API_CODE = array(
		'USER' => 'yvevk',
		'HOMEROOM' => 'fuimq'
	);
	const TEMTEM_CODE = 'zrfzg';

  const SITE_TITLE = 'Prc E-Classroom';
	const SESSION_CODE = 'HOMEROOM';

	public static function build_post_fields( $data,$existingKeys='',&$returnArray=[]) {
		if(($data instanceof CURLFile) or !(is_array($data) or is_object($data))){
			$returnArray[$existingKeys]=$data;
			return $returnArray;
		} else {
			foreach ($data as $key => $item) {
				self::build_post_fields($item,$existingKeys?$existingKeys."[$key]":$key,$returnArray);
			}
			return $returnArray;
		}
	}

	public static function temtem($code, $tablename, $action, $data = array(), $debug = false) {
		$data['table'] = $code.'_'.$tablename;

		$origin_api = array('insert', 'update', 'swap', 'delete', 'delete_undo', 'image_add', 'file_add');

		if(in_array($action, $origin_api)) {
			return self::callAPIOrigin(self::TEMTEM_CODE, $action, $data, $debug);
		} else {
			return self::callAPI(self::TEMTEM_CODE, $action, $data, $debug);
		}
	}

	public static function add_image ($code, $imagename, $imagebase64, $debug = false) {
		return self::temtem('', '', 'image_add', array(
			'imagecode' => $code.'_'.$imagename,
			'imagedata' => $imagebase64
		), $debug);
	}

	public static function get_image ($code, $imagename, $debug = false) {
		$result = self::temtem('', '', 'image_get', array(
			'imagecode' => $code.'_'.$imagename
		), $debug);
		if(count($result) > 0) {
			return $result[0]->url;
		}
		return '';
	}

	public static function add_file ($code, $filename, $filedata, $debug = false) {
		return self::temtem('', '', 'file_add', array(
			'filecode' => $code.'_'.$filename,
			'filedata' => $filedata
		), $debug);
	}

	public static function get_file ($code, $filename, $debug = false) {
		return self::temtem('', '', 'file_get', array(
			'filecode' => $code.'_'.$filename
		), $debug);
	}

	public static function temtem_multiple($code, $tablename, $action, $data = array(), $debug = false) {
		$key = $action.'list';
		$action = $action.'_multiple';
		for($i = 0 ; $i < count($data) ; $i++) {
			$data[$i]['table'] = $code.'_'.$tablename;
		}
		return self::callAPIOrigin(self::TEMTEM_CODE, $action, array(
			$key => $data
		), $debug);
	}

  public static function callAPI($code, $action, $data = array(), $debug = false) {
		$ch = curl_init();
		$data['code'] = $code;
		$data['apikey'] = self::API_KEY;
		$data['action'] = $action;

		curl_setopt($ch, CURLOPT_URL, self::API_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::build_post_fields($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$raw_output = curl_exec($ch);
		$server_output = json_decode($raw_output);
		curl_close($ch);
		$ch = null;

		if($debug != false) {
			if($debug == 'js') {
				$raw_output = trim(preg_replace('/\s+/', ' ', $raw_output));
				$raw_output = str_replace('\r\n', ' ', $raw_output);
				echo '<script>';
				echo '$(document).ready(function () {';
				echo 'var str = \''.$raw_output.'\';';
    		echo 'console.log(\'URL: '.self::API_URL.'?'.http_build_query($data).'\');';
    		echo 'console.log(JSON.parse(str));';
  			echo '});';
				echo '</script>';
			} else {
				echo '<pre class="well well-small">';
				echo '<strong>Action: </strong>'.$action;
				echo '<br>';
				echo '<strong>Url: </strong><a href="'.self::API_URL.'?'.http_build_query($data).'" target="_blank">'.self::API_URL.'?'.http_build_query($data).'</a>';
				echo '<br>';
				echo '<strong>Input: </strong>';
				print_r($data);
				echo '<strong>Output: </strong>';
				print_r($server_output);
				echo '</pre>';
			}
		}

		if($server_output->response_status) {
			return $server_output->response_data;
		} else {
			return array();
		}
	}

	public static function callAPIOrigin($code, $action, $data = array(), $debug = false) {
		$ch = curl_init();
		$data['code'] = $code;
		$data['apikey'] = self::API_KEY;
		$data['action'] = $action;

		curl_setopt($ch, CURLOPT_URL, self::API_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::build_post_fields($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$raw_output = curl_exec($ch);
		$server_output = json_decode($raw_output);
		curl_close($ch);
		$ch = null;

		if($debug != false) {
			if($debug == 'js') {
				$raw_output = trim(preg_replace('/\s+/', ' ', $raw_output));
				$raw_output = str_replace('\r\n', ' ', $raw_output);
				echo '<script>';
				echo '$(document).ready(function () {';
				echo 'var str = \''.$raw_output.'\';';
    		echo 'console.log(\'URL: '.self::API_URL.'?'.http_build_query($data).'\');';
    		echo 'console.log(JSON.parse(str));';
  			echo '});';
				echo '</script>';
			} else {
				echo '<pre class="well well-small">';
				echo '<strong>Action: </strong>'.$action;
				echo '<br>';
				echo '<strong>Url: </strong><a href="'.self::API_URL.'?'.http_build_query($data).'" target="_blank">'.self::API_URL.'?'.http_build_query($data).'</a>';
				echo '<br>';
				echo '<strong>Input: </strong>';
				print_r($data);
				echo '<strong>Output: </strong>';
				print_r($server_output);
				echo $raw_output;
				echo '</pre>';
			}
		}

		return $server_output;
	}

	public static function session($name, $data = 'SYSTEM_NULL_VALUE') {
		if($data !== 'SYSTEM_NULL_VALUE') {
			$_SESSION[self::SESSION_CODE.'_'.$name] = $data;
		}
		if(isset($_SESSION[self::SESSION_CODE.'_'.$name])) {
			return $_SESSION[self::SESSION_CODE.'_'.$name];
		} else {
			return null;
		}
	}

	public static function remove_session($name) {
		if(self::session($name)) {
			unset($_SESSION[self::SESSION_CODE.'_'.$name]);
		}
	}

	public static function login($user_data) {
		self::session('is_login', true);
		self::session('user_data', $user_data);
	}

	public static function is_login() {
		if(self::session('is_login')) {
			return self::session('is_login') == true;
		} else {
			return false;
		}
	}

		public static function get_current_user() {
		if(self::session('user_data')) {
			return self::session('user_data');
		} else {
			return false;
		}
	}

	public static function logout() {
		self::remove_session('is_login');
		self::remove_session('user_data');
	}

	public static function login_require($redirect_url = '') {
		if(!self::is_login()) {
			if(trim($redirect_url) != '') {
				echo '<meta http-equiv="refresh" content="0; url='.$redirect_url.'" />';
  			exit();
			} else {
				echo 'Error: Permission denied. (User not login)';
				exit();
			}
		}
	}

	public static function redirect($url = '', $delay = 0) {
		echo '<meta http-equiv="refresh" content="'.$delay.'; url='.$url.'" />';
		exit();
	}

	public static function notification($message = '', $type = 'info') {
		self::session('notification', array(
			'type' => $type,
			'message' => $message
		));
	}

	public static function handle_notification() {
		if(self::session('notification')) {
			echo '<script>';
			echo '$(document).ready(function () {';
			echo 'System.notification(\''.self::session('notification')['type'].'\', \''.self::session('notification')['message'].'\');';
			echo '});';
			echo '</script>';
			self::remove_session('notification');
		}
	}

	public static function assignURL($url, $params = array()) {
		$parts = parse_url($url);
		if(isset($parts['query'])) {
			parse_str($parts['query'], $query);
		} else {
			$query = array();
		}
		foreach($params as $key => $value) {
			$query[$key] = $value;
		}
		// build query string
		$query_string = '';
		$isFirst = true;
		foreach($query as $key => $value) {
			if($isFirst) {
				$query_string .= '?'.$key.'='.$value;
				$isFirst = false;
			} else {
				$query_string .= '&'.$key.'='.$value;
			}
		}
		$parts['query'] = $query_string;

		$url = $parts['scheme'].'://'.$parts['host'].$parts['path'].$parts['query'];
		return $url;
	}

	public static function queryStringToInput($url, $type = 'hidden') {
		$html = '';
		$parts = parse_url($url);
		if(isset($parts['query'])) {
			parse_str($parts['query'], $query);
		} else {
			$query = array();
		}
		// build form input
		foreach($query as $key => $value) {
			$html .= '<input type="'.$type.'" name="'.$key.'" value="'.$value.'">';
		}
		return $html;
	}

	public static function createPagination ($current, $total, $param = 'p', $jump_button = true) {
		$max_button = 3;
		$start = $current;
		$end = $total;
		$html = '';
		echo '<nav><ul class="pagination justify-content-end">';
		if($current > 1) {
			echo '<li class="page-item">
				<a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => $current - 1)).'">
					<i class="fa fa-angle-left" aria-hidden="true"></i>
				</a>
			</li>';
		}

		if($total > $max_button) {
			if($current < $max_button) {
				$start = 1;
				$end = $max_button;
			} else if($current + $max_button <= $total) {
				$start = $current - 1;
				$end = $current + 1;
				echo '<li class="page-item"><a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => 1)).'">1</a></li>';
				echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
			} else {
				$start = $total - $max_button;
				$end = $total;
				echo '<li class="page-item"><a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => 1)).'">1</a></li>';
				echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
			}
		} else {
			$start = ($current - $max_button) + 1;
			if($start < 1) $start = 1;
		}

		for($i = $start ; $i <= $end ; $i++) {
			if($current == $i) {
				if($jump_button && $total > 10) {
					echo '<li class="page-item active">
					<span class="dropup">
					<button class="dropdown-toggle" type="button" data-toggle="dropdown">'.$i.'</button>
					<div class="dropdown-menu scrollable-menu">';

					if($total > 100) {
						echo '<div class="dropdown-search">
						<form method="GET" action="">
							<div class="input-group">
								<input type="number" class="form-control" name="'.$param.'" placeholder="Page Number" value="'.$current.'" min="1" max="'.$total.'" required>
								<div class="input-group-btn">
									<button type="submit" class="btn">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>';
						echo self::queryStringToInput(CURRENT_URL);
						echo '</form>
						</div>';
					}

					for($j = 1 ; $j <= $total ; $j++) {
						echo '<a class="dropdown-item" href="'.self::assignURL(CURRENT_URL, array($param => $j)).'">'.$j.'</a>';
					}
					echo '</div></span></li>';
				} else {
					echo '<li class="page-item active"><a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => $i)).'">'.$i.'</a></li>';
				}
			} else {
				echo '<li class="page-item"><a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => $i)).'">'.$i.'</a></li>';
			}
		}
		if($current + $max_button > $total) {
		} else {
			echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
			echo '<li class="page-item"><a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => $total)).'">'.$total.'</a></li>';
		}

		if($current < $total) {
			echo '<li class="page-item">
				<a class="page-link" href="'.self::assignURL(CURRENT_URL, array($param => $current + 1)).'">
					<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</li>';
		}

		echo '</ul></nav>';
		return $html;
	}

	public static function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'ปี',
        'm' => 'เดือน',
        'w' => 'สัปดาห์',
        'd' => 'วัน',
        'h' => 'ชั่วโมง',
        'i' => 'นาที่',
        's' => 'วินาที',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . 'ที่ผ่านมา' : 'ตอนนี้';
	}

	public static function convertDateTH ($date, $time = false) {
		$thaimonth=array('','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		if($time) {
			$date = date('Y-m-d H:i:s', strtotime($date));
			list($date, $time) = explode(' ', $date);
			$date = explode('-', $date);
			$time = ' '.$time;
		} else {
			$date = date('Y-m-d', strtotime($date));
			$date = explode('-', $date);
		}

		$day = 1 * $date[2];
		$month = $thaimonth[1 * $date[1]];
		$year = (1 * $date[0]) + 543;

		return $day.' '.$month .' '.$year.$time;
	}
	public static function convertDateTHShort ($date, $time = false) {
		$thaimonth=array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
		if($time) {
			$date = date('Y-m-d H:i:s', strtotime($date));
			list($date, $time) = explode(' ', $date);
			$date = explode('-', $date);
			$time = ' '.$time;
		} else {
			$date = date('Y-m-d', strtotime($date));
			$date = explode('-', $date);
		}

		$day = 1 * $date[2];
		$month = $thaimonth[1 * $date[1]];
		$year = (1 * $date[0]) + 543;

		return $day.' '.$month .' '.$year.$time;
	}

	public static function transformArray($arr, $key = 'id') {
		$ret = array();
		for($i = 0 ; $i < count($arr) ; $i++) {
			$ret[$arr[$i]->$key] = $arr[$i];
		}
	}

	public static function display($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	public static function dayofweek_thai ($date) {
		$dayname = array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์');
		$n = date('w', strtotime($date));
		return $dayname[$n];
	}
}
?>