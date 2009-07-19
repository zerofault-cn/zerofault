<?php
class AttachAction extends Action{
	public function upload(){
		/*
		["attach"] => array(5) {
			["name"] => string(12) "IMG_2263.jpg"
			["type"] => string(11) "image/pjpeg"
			["tmp_name"] => string(26) "C:\WINDOWS\TEMP\php245.tmp"
			["error"] => int(0)
			["size"] => int(1288268)
		}
		*/
		$type = $_REQUEST['t'];
		$site_id = $_REQUEST['id'];
		$file = $_FILES['attach'];

		$file_path = 'Html/Attach/'.$type.'/';
		$file_name = $site_id .($type=='logo'?'.gif':'.jpg');
		if (move_uploaded_file($file['tmp_name'], $file_path.$file_name)) {
			die('1');
		}
		else
		{
			die('0');
		}
	}
}
?>