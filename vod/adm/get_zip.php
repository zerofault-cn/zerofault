<?
//��������վȡ��ÿ�ܽ�Ŀ��zip�ļ�,Ȼ��Ӵ�zip�ļ��ж�����Ч��Ϣ,�������ݿ�,��ɽ�Ŀ������
$url="http://www.cctv.com/download/showtime.zip";
$zipfile_name=basename($url);
//���㱾����ʼ����,������������,�������ṩ�Ľ�Ŀ��������һΪÿ�����,��������һ����,Ϊ���淽�����,��ʱʹ��unixʱ���
$monday_timestamp=mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"));
if(file_exists($zipfile_name)&&filemtime($zipfile_name)>=$monday_timestamp)
{
	echo $zipfile_name."<span class=blue>�Ѿ�����</span><br>";//���������µ�zipfile
	$zipfile_name='';//ͬʱ��ֹ�����zip�������
}
else
{
	if(!$fpr=@fopen($url,"r"))//; or die("�������ӵ������");
	{
		unlink($zipfile_name);
		$dir='��Ŀ��/';
		$handle=opendir($dir);
		while($file=readdir($handle))
		{
			if(is_file($dir.'/'.$file))
			{
				unlink($dir.'/'.$file);
			}
		}
		echo '<span class=red>�������ӵ�cctv,ȡ'.$zipfile_name.'�ļ�ʧ��!</span><br>';
	}
	else
	{
		$fpw=fopen("showtime.zip","w"); 
		fwrite($fpw,file_get_contents($url));//������������д�뱾���ļ�,�൱���ļ�����
		fclose($fpw);
		echo $zipfile_name."<span class=blue>�Ѿ����µ�".date("Y��m��d��",$monday_timestamp)."</span><br>";
	}
}
//��zip�ļ���ѹ����
//linux��zip������������,��ʱ��unzip����
$command="unzip ./showtime.zip";
if(`$command`)
{
	echo "ok";
}

//linux��ת��zip������
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
	echo $zipfile_name."<span class=blue>��ѹ�����!</span><br>";
}
*/

?>