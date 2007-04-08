<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	function sImageResize($src, $dst, $dst_w, $quality) {
		
		if(extension_loaded('gd')) {
			$dst_w = intval($dst_w);
			$quality = intval($quality);
			
			// get image information
			$imgsize = getimagesize($src);
		
			// determine filetype	
			switch($imgsize['mime']) {
				case 'image/jpeg':
					$im_src = imagecreatefromjpeg($src);
					break;
				case 'image/png':
					$im_src = imagecreatefrompng($src);
					break;
				case 'image/gif':
					$im_src = imagecreatefromgif($src);
					break;
				default:
					$mime = '?';
					break;
			}
		
			// check image dimensions
			if($imgsize[0] > $dst_w) {
				if($imgsize[0] > $imgsize[1]) {
					$width = $imgsize[0];
					$height = ceil($imgsize[0] * ($imgsize[1] / $imgsize[0]));
				}
				else {
					$width = $imgsize[0];
					$height = $imgsize[1];
				}
				
				$dst_h = ceil($height * ($dst_w / $imgsize[0]));
				
				$im_dst = imagecreatetruecolor($dst_w, $dst_h);
				imagecopyresampled($im_dst, $im_src, 0, 0, 0, 0, $dst_w, $dst_h, $width, $height);
			}
			else {
				$width = $imgsize[0];
				$height = $imgsize[1];
				
				// create image
				$im_dst = imagecreatetruecolor($width, $height);
	
				// copy image as it is
				imagecopy($im_dst, $im_src, 0, 0, 0, 0, $width, $height);
			}
	
			
			// output image to browser or file
			imagejpeg($im_dst, $dst, $quality);
		
			// destroy images
			imagedestroy($im_src);
			imagedestroy($im_dst);
		}
		else {
			move_uploaded_file($src, $dst);
		}
	}

?>