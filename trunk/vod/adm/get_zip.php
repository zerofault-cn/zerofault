<?
//从央视网站取得每周节目单zip文件,然后从此zip文件中读出有效信息,插入数据库,完成节目单更新
$url="http://www.cctv.com/download/showtime.zip";
$zipfile_name=basename($url);
//计算本周起始日期,即本周日日期,但央视提供的节目单是以周一为每周起点,故再做加一处理,为后面方便计算,此时使用unix时间戳
$monday_timestamp=mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"));
if(file_exists($zipfile_name)&&filemtime($zipfile_name)>=$monday_timestamp)
{
	echo $zipfile_name."<span class=blue>已经更新</span><br>";//不需下载新的zipfile
	$zipfile_name='';//同时阻止后面的zip解包过程
}
else
{
	if(!$fpr=@fopen($url,"r"))//; or die("不能连接到凤凰网");
	{
		unlink($zipfile_name);
		$dir='节目单/';
		$handle=opendir($dir);
		while($file=readdir($handle))
		{
			if(is_file($dir.'/'.$file))
			{
				unlink($dir.'/'.$file);
			}
		}
		echo '<span class=red>不能连接到cctv,取'.$zipfile_name.'文件失败!</span><br>';
	}
	else
	{
		$fpw=fopen("showtime.zip","w"); 
		fwrite($fpw,file_get_contents($url));//将读到的内容写入本地文件,相当于文件下载
		fclose($fpw);
		echo $zipfile_name."<span class=blue>已经更新到".date("Y年m月d日",$monday_timestamp)."</span><br>";
	}
}
//对zip文件解压处理
//linux下zip函数库有问题,暂时用unzip命令
$command="unzip ./showtime.zip";
if(`$command`)
{
	echo "ok";
}

//linux下转换zip函数库
/*
function zip_open($filename)
{
	return zzip_opendir($filename);
}
function zip_read($zzip_dp)
{
	return zzip_readdir($zzip_dp);
}
function zip_entry_name($zzip_entry)
{
	return zzip_entry_name($zzip_entry);
}
function zip_entry_open($zzip_dp,$zzip_entry,$mode)
{
	return zzip_open($zzip_dp,$zzip_entry,$mode);
}
function zip_entry_read($zzip_entry,$zzip_entry_fs)
{
	return zzip_read($zzip_entry,$zzip_entry_fs);
}
function zip_entry_filesize($zzip_entry)
{
	return zzip_entry_filesize($zzip_entry);
}
function zip_entry_close($zzip_entry)
{
	return zzip_close($zzip_entry);
}
function zip_close($zzip_dp)
{
	return zzip_closedir($zzip_dp);
}
*/
/*
if(is_file(realpath('./'.$zipfile_name)))
{
	$zip=zip_open(realpath('./'.$zipfile_name));
}
if($zip) 
{
	while ($zip_entry = zip_read($zip))
	{
	//	echo "Name:              " . zip_entry_name($zip_entry) . "\n";
	//	echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
	//	echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
	//	echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";
		if(substr(zip_entry_name($zip_entry),-1)=='/')
		{
			continue;
		}
		if (zip_entry_open($zip, $zip_entry, "r")) 
		{
	//		echo "File Contents:\n<br>";
			$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
		//echo $date=substr($buf,0,8);
			$fp=fopen(zip_entry_name($zip_entry),"w");
			fwrite($fp,$buf); 
			fclose($fp);
	//		echo "$buf\n<br>";
			zip_entry_close($zip_entry);
		}
	//	echo "\n<br>";
	}
	zip_close($zip);
	echo $zipfile_name."<span class=blue>解压缩完成!</span><br>";
}
*/

?>