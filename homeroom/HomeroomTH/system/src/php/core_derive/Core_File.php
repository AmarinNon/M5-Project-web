<?php
class File
{	
	/* 
	code convention

	code_id
	code_talble_id
	code_table_type_id
	*/
	static function addPDF_base64($code,$base64,$prefixrelative)
	{
		$arr = array(
			"code" => $code,
			"prefixrelative" => $prefixrelative,
			"base64_data" => $base64
			);
		if ( base64_encode(base64_decode($base64, true)) === $base64)
			$arr['base64'] = 'base64 valid';
		else
			$arr['base64'] = 'base64 invalid';

		$startwith = "data:application/pdf;base64,";
		$startwith_length = strlen($startwith);
		if(!(substr($base64,0,$startwith_length) === $startwith))
		{
			Log::addActionLog('file',"failed add base64 : base64 not start with pdf format",$arr);
			return false;
		}

		$base64 = str_replace("data:application/pdf;base64,", "", $base64);

		$savepath = $prefixrelative."conf/file/".$code.'.pdf';
		$arr['imagetype'] = 'pdf';
		$arr['savepath'] = $savepath;

		$decode64 = base64_decode($base64);
		$result = file_put_contents($savepath, $decode64);

		if(!$result)
		{
			Log::addActionLog('file',"failed add base64 : Unable to save pdf data",$arr);
			return false;
		}
		Log::addActionLog('file',"add pdf base64",$arr);
		return true;
	}

	static function addImage_base64($code,$base64,$prefixrelative)
	{
		$arr = array(
			"code" => $code,
			"prefixrelative" => $prefixrelative,
			"base64_data" => $base64,
			);
		if ( base64_encode(base64_decode($base64, true)) === $base64)
			$arr['base64'] = 'base64 valid';
		else
			$arr['base64'] = 'base64 invalid';

		if(!$base64)
		{
			Log::addActionLog('file',"failed add base64 : no base64 data",$arr);
			return false;
		}

		$image = new ImageManagement();
		if(!$image->load($base64))
		{
			Log::addActionLog('file',"failed add base64 : base64 invalid",$arr);
			return false;
		}

		$savepath = $prefixrelative."conf/file/".$code.'.'.$image->getFileType();
		$arr['imagetype'] = $image->getFileType();
		$arr['savepath'] = $savepath;

		self::delete($code,$prefixrelative);

		if($image->getWidth()>1280)
			$image->resizeToWidth(1280);

		if(!$image->save($savepath))
		{
			Log::addActionLog('file',"failed add base64 : Unable to save data",$arr);
			return false;
		}
		return true;
	}

	static function addFile($code,$file,$prefixrelative)
	{
		if($file["name"]!='' && !is_null($file["name"]) && !is_null($file))
		{
			self::delete($code,$prefixrelative);

			$allowedExts = array("PDF", "DOC", "DOCX", "pdf", "doc", "docx", "txt");
			$tmp = explode('.', $file["name"]);
			$extension = end($tmp);

			$arr = array(
				"code" => $code,
				"filename" => $file["name"],
				"filetmp_name" => $file["tmp_name"],
				"extension" => $extension,
				"size" => $file["size"],
			);

			if (($file["type"] == "application/pdf")
				|| ($file["type"] == "application/rtf")
				|| ($file["type"] == "text/plain"))
			{
				if(in_array($extension, $allowedExts))
				{
					if ($file["error"] > 0)
					{
						Log::addActionLog('file',"failed add file : file error",$arr);
						return false;
					}
					else
					{
						if (!is_uploaded_file($file['tmp_name']))
						{
							Log::addActionLog('file',"failed add file : file is not upload properly",$arr);
							return false;
						}

						$result = move_uploaded_file($file["tmp_name"], $prefixrelative."conf/file/".$code.".". $extension);

						if(!$result)
							Log::addActionLog('file',"failed add file : move_uploaded_file not done [error:".$file['error']."]",$arr);

						return $result;
					}
				}
				else
				{
					Log::addActionLog('file',"failed add file : extension not allowed (".$extension.")",$arr);
					return false;
				}
			}
			else
			{
				Log::addActionLog('file',"failed add file : file type not allowed (".$file["type"].")",$arr);
				return false;
			}
		}
	}

	static function addImage($code,$file,$prefixrelative)
	{
		if($file["name"]!='' && !is_null($file["name"]) && !is_null($file))
		{
			self::delete($code,$prefixrelative);

			$allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
			$extension = end((explode(".", $file["name"])));

			$arr = array(
				"code" => $code,
				"filename" => $file["name"],
				"filetmp_name" => $file["tmp_name"],
				"extension" => $extension,
				"size" => $file["size"],
				);

			if (($file["type"] == "image/gif")
				|| ($file["type"] == "image/png")
				|| ($file["type"] == "image/jpg")
				|| ($file["type"] == "image/jpeg"))
			{
				if(in_array($extension, $allowedExts))
				{
					if ($file["error"] > 0)
					{
						Log::addActionLog('file',"failed add file : file error",$arr);
						return false;
					}
					else
					{
						if (!is_uploaded_file($file['tmp_name']))
						{
							Log::addActionLog('file',"failed add file : file is not upload properly",$arr);
							return false;
						}

						$image = new ImageManagement($file["tmp_name"]);
						if($image->getWidth()>1500)
						{
							$image->resizeToWidth(1500);
							$image->save($file["tmp_name"]);
						}
						
						$result = move_uploaded_file($file["tmp_name"], $prefixrelative."conf/file/".$code.".". $extension);

						if(!$result)
							Log::addActionLog('file',"failed add image : move_uploaded_file not done [error:".$file['error']."]",$arr);

						return $result;
					}
				}
				else
				{
					Log::addActionLog('file',"failed add image : extension not allowed",$arr);
					return false;
				}
			}
			else
			{
				Log::addActionLog('file',"failed add image : file type allowed",$arr);
				return false;
			}
		}
	}

	static function addImageAndResize($code,$file,$prefixrelative,$width,$height)
	{
		if($file["name"]!='' && !is_null($file["name"]) && !is_null($file))
		{
			self::delete($code,$prefixrelative);
			
			$arr = array(
				"code" => $code,
				"filename" => $file["name"],
				"filetmp_name" => $file["tmp_name"],
				"extension" => $extension,
				"size" => $file["size"],
				);

			$allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
			$extension = end(explode(".", $file["name"]));

			if (($file["type"] == "image/gif")
				|| ($file["type"] == "image/png")
				|| ($file["type"] == "image/jpg")
				|| ($file["type"] == "image/jpeg"))
			{
				if(in_array($extension, $allowedExts))
				{
					if ($file["error"] > 0)
					{
						Log::addActionLog('file',"failed add file : file error",$arr);
						return false;
					}
					else
					{
						if (!is_uploaded_file($file['tmp_name']))
						{
							Log::addActionLog('file',"failed add file : file is not upload properly",$arr);
							return false;
						}

						$image = new ImageManagement($file["tmp_name"]);
						if($width==0 && $height>0)
							$image->resizeToHeight($height);
						else if($height==0 && $width>0)
							$image->resizeToWidth($width);
						else if($height>0 && $width>0)
							$image->resize($width,$height);
						$image->save($file["tmp_name"]);
						
						$result = move_uploaded_file($file["tmp_name"], $prefixrelative."conf/file/".$code.".". $extension);

						if(!$result)
							Log::addActionLog('file',"failed add file : move_uploaded_file not done [error:".$file['error']."]",$arr);

						return $result;
					}
				}
				else
				{
					Log::addActionLog('file',"failed add file : extension not allowed",$arr);
					return false;
				}
			}
			else
			{
				Log::addActionLog('file',"failed add file : file type allowed",$arr);
				return false;
			}
		}
	}

	static function copy($code1,$code2,$prefixrelative)
	{
		$oldfilepath = File::getPath($code1);
		$oldfileextension = end(explode(".", $oldfilepath));

		return copy($oldfilepath, $prefixrelative.'conf/file/'.$code2.'.'.$oldfileextension);
	}

	static function getPath($code,$prefixrelative,$getabsolute = true) // get file path
	{
		$file = glob($prefixrelative.'conf/file/'. $code .'.*');

		if(count($file)!=1)
			return null;

		$filedata = explode("/", $file[0]);
		$filename = end($filedata);

		if($filename=='')
			return null;

		if($getabsolute)
			return ROOT_URL.'/conf/file/'.$filename;
		else
			return ROOT_PHP.'/conf/file/'.$filename;
	}

	static function delete($code,$prefixrelative)
	{
		$files = glob($prefixrelative.'conf/file/'. $code .'.*');

		if($files)
		{
			foreach($files as $file)
			{
				if(is_file($file))
					unlink($file);
			}
		}

		return 1;
	}

	// recieve only $_GET['c']
	static function deleteAllFile($prefixrelative)
	{
		$files = glob($prefixrelative.'conf/file/*'); // get all file names
		foreach($files as $file)
		{
			if(is_file($file))
				unlink($file);
		}
		$files = glob($prefixrelative.'conf/tinymce/*'); // get all file names
		foreach($files as $file)
		{
			if(is_file($file))
				unlink($file);
		}
	}

	static function addTextToImage($input_filepath, $output_filename, $text_data)
	/**
	 * input_file: accept only png
	 * 
	 * text_data: array(
	 * 	array(text, 
	 * 		position_x: default = 0, 
	 * 		position_y: default = 0, 
	 * 		font_size: default = 20, 
	 * 		color: default = [0, 0, 0])
	 * )
	 * 
	 * color: array(R, G, B)
	 */
	{
		$img = self::convertImageToPng($input_filepath);
		$font = ROOT_PHP.'/src/fonts/JaromThai2-Regular.ttf';

		for($i = 0 ; $i < count($text_data) ; $i++) {
			$str = $text_data[$i][0];
			$x = isset($text_data[$i][1]) ? $text_data[$i][1] : '';
			$y = isset($text_data[$i][2]) ? $text_data[$i][2] : '';
			$size = isset($text_data[$i][3]) ? $text_data[$i][3] : 20;
			$color = ImageColorAllocate($img, 0, 0, 0);

			if(isset($text_data[$i][4]) && count($text_data[$i][4]) == 3) {
				$rgb = $text_data[$i][4];
				$color = ImageColorAllocate($img, $rgb[0], $rgb[1], $rgb[2]);
			}

			imagettftext($img, $size, 0, $x, $y, $color, $font, $str);
		}

		if(imagepng($img, ROOT_PHP.'/conf/file/'.$output_filename.'.png')) {
			$status = ROOT_PHP.'/conf/file/'.$output_filename.'.png';
		} else {
			$status = false;
		}
		imagedestroy($img);
		return $status;
	}

	static function addRingToImage($input_filepath, $output_filename, $ring_data)
	{
		/**
	 * input_file: accept only png
	 * 
	 * ring_data: array(
	 * 	array( 
	 * 		width,
	 * 		height,
	 * 		thick: default = 0,
	 * 		position_x: default = 0, 
	 * 		position_y: default = 0, 
	 * 		color: default = [0, 0, 0])
	 * )
	 * 
	 * color: array(R, G, B)
	 */
		$img = self::convertImageToPng($input_filepath);

		for($i = 0 ; $i < count($ring_data) ; $i++) {
			$width = $ring_data[$i][0];
			$height = $ring_data[$i][1];
			$thick = isset($ring_data[$i][2]) ? $ring_data[$i][2] : 0;
			$x = isset($ring_data[$i][3]) ? $ring_data[$i][3] : '';
			$y = isset($ring_data[$i][4]) ? $ring_data[$i][4] : '';
			$color = ImageColorAllocate($img, 0, 0, 0);

			if(isset($ring_data[$i][5]) && count($ring_data[$i][5]) == 3) {
				$rgb = $ring_data[$i][5];
				$color = ImageColorAllocate($img, $rgb[0], $rgb[1], $rgb[2]);
			}

			imageellipse($img, $x, $y, $width, $height, $color);
			if($thick > 0) {
				imageellipse($img, $x, $y, $width - $thick, $height - $thick, $color);
				imagefilltoborder($img, $x - ($width / 2) + 1, $y, $color, $color);
			}
		}

		if(imagepng($img, ROOT_PHP.'/conf/file/'.$output_filename.'.png')) {
			$status = ROOT_PHP.'/conf/file/'.$output_filename.'.png';
		} else {
			$status = false;
		}
		imagedestroy($img);
		return $status;
	}

	static function addCircleWatermark($target_filepath, $overlay_filepath, $output_filename, $x, $y, $width, $opacity = 100) {
		$img = self::convertImageToPng($target_filepath);
		$green_screen = ImageColorAllocate($img, 0, 255, 0);
		$white_screen = ImageColorAllocate($img, 255, 255, 255);

		$tmp_img = imagecreatetruecolor($width, $width);
		imagefill($tmp_img, 0, 0, $white_screen);

		$overlay_img = self::convertImageToPng($overlay_filepath);
		$src_size = getimagesize($overlay_filepath);

		if($src_size[0] >= $src_size[1]) {
			$ratio = $src_size[0] / $width;
			$newWidth = $width;
			$newHeight = $src_size[1] / $ratio;
		} else {
			$ratio = $src_size[1] / $width;
			$newWidth = $src_size[0] / $ratio;
			$newHeight = $width;
		}

		imagecopyresized($tmp_img, $overlay_img, ($width / 2) - ($newWidth / 2), ($width / 2) - ($newHeight / 2), 0, 0, $newWidth, $newHeight, $src_size[0], $src_size[1]);

		imageellipse($tmp_img, ($width / 2), ($width / 2), $width, $width, $green_screen);
		imagefilltoborder($tmp_img, 0, 0, $green_screen, $green_screen);
		imagefilltoborder($tmp_img, 0, $width, $green_screen, $green_screen);
		imagefilltoborder($tmp_img, $width, 0, $green_screen, $green_screen);
		imagefilltoborder($tmp_img, $width, $width, $green_screen, $green_screen);
		imagecolortransparent($tmp_img, $green_screen);

		imagecopymerge($img, $tmp_img, $x, $y, 0, 0, $width, $width, $opacity);
		if(imagepng($img, ROOT_PHP.'/conf/file/'.$output_filename.'.png')) {
			$status = ROOT_PHP.'/conf/file/'.$output_filename.'.png';
		} else {
			$status = false;
		}
		imagedestroy($tmp_img);
		imagedestroy($img);
		return $status;
	}

	static function convertImageToPng($input_filepath) {
		$img = null;
		$extension = pathinfo($input_filepath, PATHINFO_EXTENSION); 
		switch ($extension) {
			case 'jpg':
			case 'jpeg':
				$img = imagecreatefromjpeg($input_filepath);
			break;
			case 'gif':
				$img = imagecreatefromgif($input_filepath);
			break;
			case 'png':
				$img = imagecreatefrompng($input_filepath);
				break;
			case 'bmp':
				$img = imagecreatefrombmp($input_filepath);
				break;
		}
		return $img;
	}
}
?>