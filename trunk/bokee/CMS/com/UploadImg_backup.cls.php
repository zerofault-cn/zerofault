<?php
/**
* 图片处理部分
*
*
* @version  v 1.0
* @access   Upload
*/
require_once('com/FTP.cls.php');

class UploadImg
{
    /*实际使用中可以将属性设置为常量*/
    var $mimePhoto        = array();
    var $Path            = "";
    var $remote_path	= "";
    var $remote_small_path = "";
    var $smallPath        = "";
    var $MaxSize        = 5242880000;
    var $waterstring    = DOMAIN;    /*水印文字，英文或UTF-8字符*/
    var $waterImage        = "bokee.gif";    /*水印图片*/
    var $font_size        = 5;
    var $iWaterMark        = 2;    /*0.不加水印；1.加文字水印；2.图片水印*/
    var $width            = 120;    /*缩略图大小*/
    var $heigh            = 160;
    var $length				= 100;	//最短边长度
    var $DOC_ROOT        = PATH_IMAGES;

    function UploadImg()
    {
        $this->add_mime(array('image/gif'=>'.gif','image/pjpeg'=>'.jpg','image/jpeg'=>'.jpg','application/x-zip-compressed'=>'.zip','application/zip'=>'.zip'));
    }
   /**
    * 上传照片
    * @params Array;
    * @return Boolean;
    */
    function upload($file)
    {
        if($file["size"] > $this->MaxSize)
        {
        	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 所上传文件太大。");
            return -2;
        }
        if($this->mimePhoto[$file["type"]]=="")
        {
        	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 所上传文件类型错误 filetype: " . $file["type"] . "。");
            return null;
        }
        $upload_name=$this->make_rand(16).$this->mimePhoto[$file["type"]];
        /*如果该文件名存在,重新生成一个*/
        if(@file_exists($this->DOC_ROOT.$this->Path."/".$upload_name))
        {
            return $this->upload($file);
        }
        if(!@move_uploaded_file($file["tmp_name"],$this->DOC_ROOT.$this->Path."/".$upload_name))
        {
        	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传文件失败。" . $this->DOC_ROOT.$this->Path."/".$upload_name);
            return 0;
        }
        $pathInfo = explode("/", $this->Path);
        $channel_name = substr($pathInfo[1], 4);
        $ftp = new FTP($channel_name);
        $up_files = array();
        if($this->mimePhoto[$file["type"]]!=".zip")
        {
	        if(!@$ftp->Put($this->DOC_ROOT.$this->Path."/".$upload_name, str_replace('cms_', '', $this->remote_path)."/".$upload_name))
	        {
	        	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传图片 出错。");
	        	return 0;
	        }
	        $small_name = $this->make2smallA($upload_name, $ftp);
	        //Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传图片：" . $small_name);
	        $arr['ori_name'] = $file['name'];
	        $arr['new_name'] = $upload_name;
	        $arr['small_name'] = $small_name;
	        $upload_name = $arr;
        }
        else 
        {
        	//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传ZIP文件。");
			$zip=zip_open($this->DOC_ROOT.$this->Path."/".$upload_name);
			
			if ($zip) 
			{
				$dir = $this->DOC_ROOT.$this->Path."/".substr($upload_name,0,-4);
				$small_dir = $this->DOC_ROOT.$this->smallPath."/".substr($upload_name,0,-4);
				if(!is_dir($dir))
				{
					mkdir($dir);
				}
				if(!is_dir($small_dir))
				{
					mkdir($small_dir);
				}
				while ($zip_entry = zip_read($zip)) 
				{
//					echo "Name:              " . zip_entry_name($zip_entry) . "\n";
//					echo "<br/>";
//					echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
//					echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
//					echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";

					if (zip_entry_open($zip, $zip_entry, "r"))
					{
						$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						$handle = fopen($dir."/".zip_entry_name($zip_entry),"w");
						if($handle)
						{
							fwrite($handle,$buf);
							$remote_dir = str_replace('cms_', '',$this->remote_path)."/".substr($upload_name,0,-4);

							$ftp->FtpMkdir($remote_dir);
							if(!$name = $ftp->Put($this->DOC_ROOT.$this->Path."/".substr($upload_name,0,-4)."/".zip_entry_name($zip_entry),$remote_dir."/".zip_entry_name($zip_entry)))
							{
								Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 发布ZIP文件中的图片出错。");
							}
							else 
							{
								$arr['ori_name'] = zip_entry_name($zip_entry);
								$arr['new_name'] = substr($upload_name,0,-4) . "/" . zip_entry_name($zip_entry);
								$arr['small_name'] = $this->make2smallA($arr['new_name'], $ftp);
								$up_files[] = $arr;
							}
						}

						zip_entry_close($zip_entry);
					}

				}
				zip_close($zip);
				$upload_name = $up_files;
			}
        }
        return $upload_name;
    }

   /**
    * 增加上传文件类型
    * @params $mime:Array/String,$suffix:String:null;
    * @return Boolean;
    */
    function add_mime($mime,$suffix=null)
    {
        if(is_array($mime))
        {
            foreach($mime as $k => $v)
            {
                $this->mimePhoto[$k]=$v;
            }
        }else{
            $this->mimePhoto[$mime]=$suffix;
        }
    }

   /**
    * 给图片加水印
    * @params String;
    * @return Byte;
    * 只有jpg图片才可以加水印
    */
    function watermark($Image)
    {
        if($this->iWaterMark!=1 && $this->iWaterMark!=2)
        {
            return 0;
        }
        $info=$this->getInfo($Image);
        if(!$info)
        {
            return 0;
        }
        $file=$this->DOC_ROOT.$this->Path."/".$Image;

        $nimage=@imagecreatetruecolor($info["width"],$info["heigh"]);
        $white=@imagecolorallocate($nimage,255,255,255);
        $black=@imagecolorallocate($nimage,0,0,0);

        $simage =@imagecreatefromjpeg($file);
        if($simage)
        {
            @imagecopy($nimage,$simage,0,0,0,0,$info["width"],$info["heigh"]);
            if($this->iWaterMark==1)
            {
                @imagestring($nimage,$this->font_size,$info["width"]-159,$info["heigh"]-45,$this->waterstring,$black);
                @imagestring($nimage,$this->font_size,$info["width"]-160,$info["heigh"]-46,$this->waterstring,$white);
                /*如果图片过大再加一个水印*/
                if($info["width"]>800 && $info["heigh"]>600)
                {
                    @imagestring($nimage,$this->font_size,$info["width"]/2-159,$info["heigh"]/2-45,$this->waterstring,$black);
                    @imagestring($nimage,$this->font_size,$info["width"]/2-160,$info["heigh"]/2-46,$this->waterstring,$white);
                }
            }else{
                $wInfo = $this->getInfo($this->waterImage);
                $wimage =@imagecreatefromgif($this->DOC_ROOT.$this->Path."/".$this->waterImage);
                @imagecopy($nimage,$wimage,$info['width']-$wInfo['width']-10,$info['heigh']-$wInfo['heigh']-10,0,0,$wInfo["width"],$wInfo["heigh"]);
                /*如果图片过大再加一个水印*/
                if($info["width"]>800 && $info["heigh"]>600)
                {
                    @imagecopy($nimage,$wimage,$info['width']/2-$wInfo['width']-10,$info['heigh']/2-$wInfo['heigh']-10,0,0,$wInfo["width"],$wInfo["heigh"]);
                }
                @imagedestroy($wimage);
            }
            /*覆盖原上传文件*/
            $result=@imagejpeg($nimage,$file);
            @imagedestroy($nimage);
        }else{
            $result=0;
        }
        @imagedestroy($simage);
        return $result;
    }
   /**
    * 生成一个缩略图
    * @params $Image:String;
    * @return String;
    */
    function make2small($Image)
    {
        $info=$this->getInfo($Image);
        if(!$info)
        {
            return 0;
        }
		
        $file=$this->DOC_ROOT.$this->Path."/".$Image;
        /*随即生成一个文件名*/
        $small=$this->make_rand(16).$this->mimePhoto[$info["mime"]];
        if(@file_exists($this->DOC_ROOT.$this->Path."/".$small))
        {
            return $this->make2small($Image);
        }
        /*如果大图小于小缩略图，则直接拷贝一份*/
        if($this->width>=$info["width"] && $this->heigh>=$info["heigh"])
        {
            if(@copy($file,$this->DOC_ROOT.$this->smallPath."/".$small))
            {
                return $small;
            }else{
                return 0;
            }
        }
        /*按照比例得到缩略图的高、宽*/
        if(($info["width"] / $info["heigh"]) > ($this->width / $this->heigh))
        {
            $w=$this->width;
            $h=floor($info["heigh"]*$w / $info["width"]);
        }else{
            $h=$this->heigh;
            $w=floor($info["width"]*$h / $info["heigh"]);
        }
        /*创建缩略图*/
        switch($info["mime"])
        {
            case "image/gif":
                $im=@imagecreatefromgif($file);
                break;
            case "image/pjpeg":
            case "image/jpeg":
                $im=@imagecreatefromjpeg($file);
                break;
            case "image/png":
                $im=@imagecreatefrompng($file);
                break;
            default:
                return -1;
        }
        if($im)
        {
            $ni=@imagecreatetruecolor($w,$h);
            @imagecopyresampled($ni,$im,0,0,0,0,$w,$h,$info["width"],$info["heigh"]);
            $result=@imagejpeg($ni,$this->DOC_ROOT.$this->smallPath."/".$small);
            @imagedestroy($ni);
        }
        @imagedestroy($im);
        if($result)
        {
            return $small;
        }
        return "NoSmall.gif";
    }
	/**
    * 生成一个缩略图，短边长度为100，等比例压缩
    * @params $Image:String;
    * @return String;
    */
    function make2smallA($Image, $ftp)
    {
        $info=$this->getInfo($Image);
        if(!$info)
        {
            return 0;
        }
        $file=$this->DOC_ROOT.$this->Path."/".$Image;
        /*随即生成一个文件名*/
//        $small=$this->make_rand(16).$this->mimePhoto[$info["mime"]];
//        if(@file_exists($this->DOC_ROOT.$this->Path."/".$small))
//        {
//            return $this->make2smallA($Image);
//        }
		$small = $Image;
        /*如果大图小于小缩略图，则直接拷贝一份*/
        if($this->length>=$info["width"] || $this->length>=$info["heigh"])
        {
            if(@copy($file,$this->DOC_ROOT.$this->smallPath."/".$small))
            {
            	if(!$ftp->Put($this->DOC_ROOT.$this->smallPath."/".$small, str_replace('cms_', '', $this->remote_small_path)."/".$small))
            	{
            		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传图片 出错。");
            		return 0;
            	}
                return $small;
            }else{
                return 0;
            }
        }
        /*按照比例得到缩略图的高、宽*/
        if($info["width"] > $info["heigh"])
        {
        	$h = $this->length;
            $w=floor($info["width"]*$h / $info["heigh"]);
        }else{
        	$w = $this->length;
            $h=floor($info["heigh"]*$w / $info["width"]);
        }
        /*创建缩略图*/
        switch($info["mime"])
        {
            case "image/gif":
                $im=imagecreatefromgif($file);
                break;
            case "image/pjpeg":
            case "image/jpeg":
                $im=imagecreatefromjpeg($file);
                break;
            case "image/png":
                $im=imagecreatefrompng($file);
                break;
            default:
                return -1;
        }
        if($im)
        {
            $ni=@imagecreatetruecolor($w,$h);
            @imagecopyresampled($ni,$im,0,0,0,0,$w,$h,$info["width"],$info["heigh"]);
            $result=@imagejpeg($ni,$this->DOC_ROOT.$this->smallPath."/".$small);
            @imagedestroy($ni);
        }
            @imagedestroy($im);
        if($result)
        {
        	if(!$ftp->Put($this->DOC_ROOT.$this->smallPath."/".$small, str_replace('cms_', '', $this->remote_small_path)."/".$small))
            {
            	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传图片 出错。");
            	return "NoSmall.gif";
            }
            return $small;
        }
        return "NoSmall.gif";
    }

   /**
    * 得到图片信息
    * @params Array;
    * @return Boolean;
    */
    function getInfo($Image)
    {
        $info=@getimagesize($this->DOC_ROOT.$this->Path."/".$Image);
        if($info)
        {
            $return["width"]=$info[0];
            $return["heigh"]=$info[1];
            $return["mime"]=$info["mime"];
            $return["channels"]=$info["channels"];
            $return["bits"]=$info["bits"];
            return $return;
        }
        Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 获取图片信息 出错。" . $this->DOC_ROOT.$this->Path."/".$Image);
        return;
    }

   /**
    * 设置文件大图(上传图片)路径
    * @params String
    * @return void;
    */
    function setPath($Path)
    {
        $this->Path=$Path;

		$dir = trim($Path, '/');
		$dir_array = split('/', $dir);
		$dir_array_depth = count($dir_array);
		$dir = $this->DOC_ROOT;
		for($i=0;$i<$dir_array_depth;$i++)
		{
			$dir .= "/" . $dir_array[$i];
			if(!is_dir($dir))
			{
				if(!mkdir($dir))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 创建目录 出错。");
				}
			}
		}
		
        $this->remote_path = "/images".$Path;
    }

   /**
    * 设置文件缩率图路径
    * @params String
    * @return void;
    */
    function setSmallPath($smallPath)
    {
        $this->smallPath=$smallPath;
        $dir = trim($smallPath, '/');
		$dir_array = split('/', $dir);
		$dir_array_depth = count($dir_array);
		$dir = $this->DOC_ROOT;
		for($i=0;$i<$dir_array_depth;$i++)
		{
			$dir .= "/" . $dir_array[$i];
			if(!is_dir($dir))
			{
				if(!mkdir($dir))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 创建目录 出错。");
				}
			}
		}
		
        $this->remote_small_path = "/images".$smallPath;
    }

   /**
    * 设置文件缩率图大小
    * @params $width:Int,$height:Int
    * @return void;
    */
    function setWH($width,$height)
    {
        $this->width=$width;
        $this->height=$height;
    }

   /**
    * 设置加图片水印还是文字水印
    * @params $width:Int,$height:Int
    * @return void;
    */
    function setWaterMark($iWaterMark=2)
    {
        $this->iWaterMark=$iWaterMark;
    }

   /**
    * 设置水印字符(只能为英文或者UTF-8)
    * @params String
    * @return void;
    */
    function setWaterString($waterstring)
    {
        $this->waterstring=$waterstring;
    }

   /**
    * 设置水印图片路径
    * @params String
    * @return void;
    */
    function setWaterImage($waterImage)
    {
        $this->waterImage=$waterImage;
    }

   /**
    * 设置上传文件的大小
    * @params $width:Int,$height:Int
    * @return void;
    */
    function setMaxSize($MaxSize)
    {
        $this->MaxSize=$MaxSize;
    }

   /**
    * 设置水印字符大小
    * @params String
    * @return void;
    */
    function setFontSize($font_size)
    {
        $this->font_size=$font_size;
    }

   /**
    * 删除大图
    * @params $Image:String;
    * @return Boolean;
    */
    function delete_big($Image)
    {
        if(@file_exists($this->DOC_ROOT.$this->Path."/".basename($Image)))
        {
            return @unlink($this->DOC_ROOT.$this->Path."/".basename($Image));
        }
        return false;
    }

   /**
    * 删除缩略图
    * @params $Image:String;
    * @return Boolean;
    */
    function delete_small($Image)
    {
        if(@file_exists($this->DOC_ROOT.$this->smallPath."/".basename($Image)))
        {
            return @unlink($this->DOC_ROOT.$this->smallPath."/".basename($Image));
        }
        return false;
    }

   /**
    * 生成随即数
    * @params $Image:String;
    * @return Boolean;
    */
    function make_rand($strLength=10)
    {
        $str="012345678901234567890123456789abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($i=0;$i<$strLength;$i++)
        {
            list($usec, $sec) = explode(' ', microtime());
            $srand = (float) $sec + ((float) $usec * 100000);
            srand($srand);
            $rand.=$str[rand(0,82)];
        }
        return $rand;
    }
}
?>

