<?php
define('CALLFROMMAIN', TRUE);

include '../../def/defImport.php';
include '../def/output_json.php';

// POST to REQUEST
$jsondataarr = json_decode(file_get_contents('php://input'),true);
foreach($jsondataarr as $key => $value)
{
	if(isset($_REQUEST))
		$_REQUEST[$key] = $value;
}

// LOG DATA
function outputLogging($data)
{
	if(is_string($data))
	{
		if (strlen($data) > 500)
		{
			$string = strip_tags($data);
			$stringCut = substr($string, 0, 500).'...';
			return '('.gettype($data).') '.$stringCut;
		}
		else
			return '('.gettype($data).') '.$data;
	}

	return '('.gettype($data).') '.$data;
}

function LogginAPICall($message)
{
	$code = (isset($_REQUEST['code']) ? $_REQUEST['code'] : '');

	$data = array();
	foreach ($_REQUEST as $key => $value)  
	{
		if(is_array($value) || is_object($value))
		{
			$data[$key] = gettype($value).' : array data<br />';
			foreach($value as $valuekey1 => $valuedata1)
			{
				$data[$key] = '&nbsp;&nbsp; => '.outputLogging($valuedata1);

				if(is_array($valuedata1) || is_object($valuedata1))
				{
					foreach($valuedata1 as $valuekey2 => $valuedata2)
					{
						$data[$key] = '&nbsp;&nbsp;&nbsp;&nbsp; => '.outputLogging($valuedata2);

						if(is_array($valuedata2) || is_object($valuedata2))
						{
							foreach($valuedata2 as $valuekey3 => $valuedata3)
							{
								$data[$key] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; => '.outputLogging($valuedata3);

								if(is_array($valuedata3) || is_object($valuedata3))
								{
									foreach($valuedata3 as $valuekey4 => $valuedata4)
									{
										$data[$key] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; => '.outputLogging($valuedata4);
									}
								}
							}
						}
					}
				}
			}
		}
		else
			$data[$key] = '&nbsp;&nbsp;'.outputLogging($value);
	}
	$result = Log::addActionLog($code,$message, $data);
}

// GET PARAMETER
$apikey = $_REQUEST['apikey'];
$code = $_REQUEST['code'];
$action = $_REQUEST['action'];

// REQUIRED
$callarr = array(
	$apikey,
	$code,
	$action,
	);
if(array_search("", $callarr) !== false)
	repError('Invalid Ajax Call');

// CHECK USER
if(!User::login_api($apikey))
	repError('Verification Failed');

// CHECK FUNCTION
$selectfunc = Func::getFunctionByCode($code);
if(!$selectfunc)
	repError('Function Not Found');

if(Info::keepAPICallLog)
	LogginAPICall('LOG from INFO setting');

// CHECK OPERATION FILE
if(!file_exists('../../'.Info::$moduleFile[$selectfunc['module']].'/api/json/'.$action.'.php'))
	repError('Action Not Found'.'../../'.Info::$moduleFile[$selectfunc['module']].'/api/json/'.$action.'.php');

include '../../'.Info::$moduleFile[$selectfunc['module']].'/api/json/'.$action.'.php';

User::logout_api();
?>