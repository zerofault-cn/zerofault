<?
/*********RSS内容预取程序*********************/
//利用系统crontab自动执行,目前仅用于mysql支持下
/*********************************************/
$base_dir='/jbproject/tomcat/goldsoft/php-vod/';
$rss_tmp_dir=$base_dir.'rss_tmp/';
$dbhost='localhost';
$dbuser='dba';
$dbpasswd='sql';
$dbname='BOD_WIN';
mysql_connect($dbhost,$dbuser,$dbpasswd);
mysql_select_db($dbname);
$lock_file='lock.txt';
$list_file='rss.txt';
if(file_exists($rss_tmp_dir.$lock_file))
{
	exit;
}
if(!isset($offset)||$offset=='')
{
	$offset=10;
}
$sql1="select rss_source_url from rss_source where del_flag=1 and prefetch=1 order by id";// limit ".$offset.",1";
$result1=mysql_query($sql1);
$i=0;
$rss_list='';
while($row=mysql_fetch_array($result1))
{
	$url=$row[0];//http://61.152.104.35/rss/newsrss11.xml
	$xml_file_name=eregi_replace("([?=&]+)","",basename($url));
	$fwp=fopen($rss_tmp_dir.$xml_file_name.'.tmp',"w"); 
	if(!$frp=@fopen($url,"r"))
	{
	//	echo '不能连接网站';
		$i=1;
		continue;
	}
	while ($line = fgets($frp, 4096))
	{
		if(eregi("((img src=){1})",$line))
		{
			$ereg_str="((http://)[a-zA-Z0-9@:%_.~#-/\?&]+(.jpg|.png|.gif|.bmp){1})";
			eregi($ereg_str,$line,$eregs);
			$pic_url=$eregs[0];
//			$pic_name=time().substr(microtime(),0,10).$eregs[3];//重命名图片文件
			$pic_name=basename($pic_url);//不重命名
			if(!file_exists($rss_tmp_dir.$pic_name))
			{
				$rss_list.='img|'.$pic_url.'|'.$rss_tmp_dir.$pic_name."\r\n";
			}		
		//	$pic_wp=fopen('../rss_tmp/'.$pic_name,"w"); 
		//	$fw=fwrite($pic_wp,@file_get_contents($pic_url));//由php来获取图片文件
		//	if($fw)
			{
				$line=eregi_replace($ereg_str,"../rss_tmp/".$pic_name,$line);
			}
		}
		fwrite($fwp,$line);
	}
	$rss_list.='xml|'.$rss_tmp_dir.$xml_file_name.'.tmp|'.$rss_tmp_dir.$xml_file_name."\r\n";
	@fclose($frp);
	$fc=fclose($fwp);
	$i=1;
}
if(!file_exists($rss_tmp_dir.$lock_file))
{
	fopen($rss_tmp_dir.$lock_file,"w");
	$flp=fopen($rss_tmp_dir.$list_file,'w');
	fwrite($flp,$rss_list);
	fclose($flp);
	system($rss_tmp_dir."parse");
}

?>
