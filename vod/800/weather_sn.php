<?

$today=date("md",time());
$weather_today='html_cache/weather_sn_'.$today.'.jpg';
if(file_exists($weather_today))
{
	echo '<img src="'.$weather_today.'" width=310 height=220>';
}
else
{
	$url="http://extern.t7online.com/cgi-bin/fcgi/homecity.fcgi?KENNUNG=ssdp000636&WMO=57405&LANG=cn";
	$yesterday = date("md",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$weather_yesterday='html_cache/weather_sn_'.$yesterday.'.jpg';
	@unlink($weather_yesterday);
	$fwp=fopen($weather_today,"w"); 
	$fw=fwrite($fwp,@file_get_contents($url));
	$fc=fclose($fwp);
	if($fw&&$fc)
	{
		echo '<img src="'.$weather_today.'" width=310 height=220>';
	}
	else
	{
		echo '<span class=style24b>网络错误!</span>';
	}
}

//文字模式

function indexOf($haystack,$needle,$offset=0)
{
	//寻找字符串haystack中needle最先出现的位置 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//找到退出循环 
			break; 
		} 
	}
	if($find)
		return $i; //找到则返回第几个位置 ,0为计数起点
	else 
		return 0;//没找到就返回0 
}
function hasStr($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中needle最先出现的位置 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//找到退出循环 
			break; 
		} 
	}
	return $find; //找到则返回1,没找到就返回0 
}
function weather_table()
{
	?>
<table border=0 width="100%" cellpadding=0 cellspacing=0>
<tr>
	<td>
	</td>
</tr>
</table>
	<?
}
/*
$today=date("md",time());
$weather_today='weather_sn_'.$today.'.txt';
if(file_exists($weather_today))
{
	$frp=fopen($weather_today,"r");
	$time_span=fgets($frp,4096);
	$weather_str=fgets($frp,4096);
	$weather_img_url=fgets($frp,4096);
	$hi_temp=fgets($frp,4096);
	$lo_temp=fgets($frp,4096);
	$wind=fgets($frp,4096);
	weather_table();
}
else
{
	$url='http://cgi.news.sina.com.cn/cgi-bin/figureWeather/search.cgi?city=遂宁';
	if(!$fp=@fopen($url,"r"))
	{
		echo '网络连接失败！';
		exit;
	}
	while ($buffer = fgets($fp, 4096))
	{
		$source.=$buffer;
	}
	@fclose($fp);

	$source=substr($source,indexOf($source,'#FEFEFF')+58);
	$source=substr($source,0,indexOf($source,'end'));
	$time_span=substr($source,0,6);
	$time_span=trim($time_span);

	$source=substr($source,indexOf($source,'center')+7);
	$weather=substr($source,0,indexOf($source,'</td>'));
//	小雨<img src="http://image2.sina.com.cn/dy/weather/images/figure/xiaoyu_small.gif"  hspace=3 align=absmiddle vspace=0> － 阵雨<img src="http://image2.sina.com.cn/dy/weather/images/figure/zhenyu_small.gif"  hspace=3 align=absmiddle vspace=0>
	$weather_str=substr($weather,0,strpos($weather,'<'));
	$weather=substr($weather,strpos($weather,'"')+1);
	$weather_img_url=substr($weather,0,strpos($weather,'"'));
	if(hasStr($weather,'－'))
	{
		$weather=substr($weather,indexOf($weather,'－')+3);
		$weather_str.=' － '.substr($weather,0,strpos($weather,'<'));
		$weather=substr($weather,strpos($weather,'"')+1);
		$weather_img_url.=' － '.substr($weather,0,strpos($weather,'"'));
	}
	$source=substr($source,indexOf($source,'center')+7);
	$hi_temp=substr($source,0,strpos($source,'<'));
	$hi_temp=trim($hi_temp);
	
	$source=substr($source,indexOf($source,'center')+7);
	$lo_temp=substr($source,0,strpos($source,'<'));
	$lo_temp=trim($lo_temp);
	
	$source=substr($source,indexOf($source,'center')+7);
	$wind=substr($source,0,strpos($source,'<'));
	$wind=trim($wind);

	$yesterday=date("md",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$weather_yesterday='weather_sn_'.$yesterday.'.txt';
	@unlink($weather_yesterday);
	$fwp=fopen($weather_today,"w"); 
	$fw=fwrite($fwp,$time_span."\r\n".$weather_str."\r\n".$weather_img_url."\r\n".$hi_temp."\r\n".$lo_temp."\r\n".$wind);
	$fc=fclose($fwp);
	if($fw&&$fc)
	{
	//	weather_table();
	}
	else
	{
		echo '网络错误!';
	}
}
*/
?>
