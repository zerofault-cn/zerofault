<?
function indexOf($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中needle最先出现的位置 
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
function has_str($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中是否有needle字符串 
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
		return 1; //找到则返回1
	else 
		return 0;//没找到就返回0 
}
include_once "../include/toPinyin.php";
$today=date("md",time());
$weather_today='../800/html_cache/weather_cn_'.$today.'.txt';
$file_exist=file_exists($weather_today);
if($file_exist)
{
//	echo '啥都不用干';
}
else
{
	$url="http://weather.tq121.com.cn/index.php";
	$source=@file_get_contents($url);
	$title1='24小时国内城市天气预报';
	$title2=date("m月d日").'－'.date("m月d日",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
	$source=substr($source,indexOf($source,'<div'));
	$source=substr($source,0,indexOf($source,'<!--Popup-->')-2);
	$yesterday = date("md",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$weather_yesterday='../800/html_cache/weather_cn_'.$yesterday.'.txt';
	@unlink($weather_yesterday);
	$fwp=fopen($weather_today,"w"); 
	$fw=fwrite($fwp,$title1."\r\n".$title2."\r\n".$source);
	$fc=fclose($fwp);
}

$city=array('北京','哈尔滨','长春','沈阳','天津','呼和浩特','乌鲁木齐','银川','西宁','兰州','西安','拉萨','成都','重庆','贵阳','昆明','太原','石家庄','济南','郑州','合肥','南京','上海','武汉','长沙','南昌','杭州','福州','台北','南宁','海口','广州','香港','澳门');
$weather_arr=file($weather_today);
$title1=$weather_arr[0];
$title2=$weather_arr[1];
$j=0;
for($i=2;$i<sizeof($weather_arr);$i+=39)
{
	$tmp_city[$j]=substr($weather_arr[$i],8,strpos($weather_arr[$i],'s')-9);
	$tmp_city_info[$j]='城市：'.$tmp_city[$j].'<br>'.trim($weather_arr[$i+19]).trim($weather_arr[$i+20]).substr(trim($weather_arr[$i+21]),0,-5);
	$tmp_weather[$j]=substr(trim($weather_arr[$i+19]),0,-4);
	if(has_str($tmp_weather[$j],'转'))
	{
		$weather1=substr($tmp_weather[$j],0,indexOf($tmp_weather[$j],'转'));
		$weather2=substr($tmp_weather[$j],indexOf($tmp_weather[$j],'转')+2);
		$weather1_pic=words($weather1);
		$weather2_pic=words($weather2);
		$tmp_weather_pic[$j]='<img src=src_"+src_width+"/image/weather/'.$weather1_pic.'.gif height=50>~<img src=src_"+src_width+"/image/weather/'.$weather2_pic.'.gif height=50>';
	}
	else
	{
		$tmp_weather_pic[$j]='<img src=src_"+src_width+"/image/weather/'.words($tmp_weather[$j]).'.gif height=50>';
	}
	$j++;
}
for($i=0;$i<sizeof($city);$i++)
{
	for($j=0;$j<sizeof($tmp_city);$j++)
	{
		if($tmp_city[$j]==$city[$i])
		{
			$city_info[$i]=$tmp_city_info[$j];
			$weather[$i]=$tmp_weather[$j];
			$weather_pic[$i]=$tmp_weather_pic[$j];
		}
	}
}
$pageitem=8;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>天气预报</title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript">
if(screen.width==800)
{
	document.write('<link rel="stylesheet" href="src_800/weather_cn.css" type="text/css">');
}
else if(screen.width==640)
{
	document.write('<link rel="stylesheet" href="src_640/weather_cn.css" type="text/css">');
}
else
{
	document.write('<link rel="stylesheet" href="src_800/weather_cn.css" type="text/css">');
}
</script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

var city=new Array(<?=sizeof($city)?>);
var city_info=new Array(<?=sizeof($city)?>);
var weather=new Array(<?=sizeof($city)?>);
var weather_pic=new Array(<?=sizeof($city)?>);
<?
for($i=0;$i<sizeof($city);$i++)
{
?>
city[<?=$i?>]="<?=$city[$i]?>";
city_info[<?=$i?>]="<?=$city_info[$i]?>";
weather[<?=$i?>]="<?=$weather[$i]?>";
weather_pic[<?=$i?>]="<?=$weather_pic[$i]?>";
<?
}
?>


var i=0;
var pageitem=9;
function init()
{
	for(k = 0; k < pageitem; k++)
	{
		document.getElementById(k).innerHTML=city[k];
	}
	onfoc(i);
}
function onfoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="url(src_"+src_width+"/image/weather/bar1.gif)";
	document.getElementById(n%pageitem).style.color="#ffffff";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="";
	document.getElementById(n%pageitem).style.color="#b6dbf8";
	unshow(n);
}

function show(n) {
	document.getElementById('city_info').innerHTML=city_info[n];
	ta=document.getElementById(city[n]);
	ta.innerHTML='<table border=0 width=170 height=100 cellspacing=0 cellpadding=0 background="src_'+src_width+'/image/weather/weather_pop.gif"><tr><td height=2></td></tr><tr><td align=center valign=top class="popText">'+weather_pic[n]+'<br>'+weather[n]+'</td></tr></table>';
}

function unshow(n)
{
	document.getElementById(city[n]).innerHTML='';
}

function newPage(n) 
{
	if((n % pageitem)==(pageitem-1))
	{		
		for(k = 0; k < pageitem; k++) 
		{
			document.getElementById(k).innerHTML=city[n-pageitem+k+1];
		}
	}
	else 
	{
		for(k = 0; k < pageitem; k++) 
		{
			if((n + k) > (city.length - 1)) 
			{
				document.getElementById(k).innerHTML='';
			}
			else 
			{
				document.getElementById(k).innerHTML=city[n + k];
			}
		}
	}
	onfoc(n);
}
if(document.all)
{
	var ie=1;
	var ns=0;
}
else
{
	var ns=1;
	var ie=0;
}
function keyDown(e)
{
	if (ns)
	{ 
		var keycode=e.which
	} 
	if (ie)
	{ 
		var keycode=event.keyCode; 
	} 
	if((keycode==37 || keycode==38) && i>0)
	{
		losefoc(i);
		j=i%pageitem;
		i--;
		if(j == 0) 
		{
			newPage(i);
		}
		else 
		{
			onfoc(i);
		}
	}
	if((keycode==39 || keycode==40) && i < city.length - 1)
	{
		losefoc(i);
		j=i%pageitem;
		i++;
		if(j==pageitem-1)
		{
			newPage(i);
		}
		else
		{
			onfoc(i);
		}
	}
	if(keycode==33 && i-pageitem>=0)
	{
		losefoc(i);
		i=pageitem*Math.floor((i-pageitem)/pageitem);
		newPage(i);
	}
	if(keycode==34 && i+pageitem<city.length-1)
	{
		losefoc(i);
		i=pageitem*Math.floor((i+pageitem)/pageitem);
		newPage(i);
	}
	if(keycode==36)
	{
		location ="service_index.html";
	}
}
document.onkeydown=keyDown

//-->
</script>
</head>
<body id="weather" onload="init()">
<div id="北京"></div>
<div id="哈尔滨"></div>
<div id="长春"></div>
<div id="沈阳"></div>
<div id="天津"></div>
<div id="呼和浩特"></div>
<div id="乌鲁木齐"></div>
<div id="银川"></div>
<div id="西宁"></div>
<div id="兰州"></div>
<div id="西安"></div>
<div id="拉萨"></div>
<div id="成都"></div>
<div id="重庆"></div>
<div id="贵阳"></div>
<div id="昆明"></div>
<div id="太原"></div>
<div id="石家庄"></div>
<div id="济南"></div>
<div id="郑州"></div>
<div id="合肥"></div>
<div id="南京"></div>
<div id="上海"></div>
<div id="武汉"></div>
<div id="长沙"></div>
<div id="南昌"></div>
<div id="杭州"></div>
<div id="福州"></div>
<div id="台北"></div>
<div id="南宁"></div>
<div id="海口"></div>
<div id="广州"></div>
<div id="香港"></div>
<div id="澳门"></div>
<div id="topnavi">
<span class="weather_title"><?=$title1?><span style="margin-left:2em"><?=$title2?></span></span>
</div>
<div id="weather_city_info">
<table border=0 cellspacing=0 cellpadding=0>
<tr>
	<td width=7><img src="src_800/image/weather/left_top.gif"></td>
	<td background="src_800/image/weather/top.gif" style="background-repeat:repeat"></td>
	<td><img src="src_800/image/weather/right_top.gif"></td>
</tr>
<tr>
	<td background="src_800/image/weather/left.gif"></td>
	<td id="city_info" class="fullText" bgcolor="#feffed"></td>
	<td background="src_800/image/weather/right.gif"></td>
</tr>
<tr>
	<td><img src="src_800/image/weather/left_bottom.gif"></td>
	<td background="src_800/image/weather/bottom.gif" style="background-repeat:repeat"></td>
	<td><img src="src_800/image/weather/right_bottom.gif"></td>
</tr>
</table>
</div>
<div id="weather_city_item">
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<!--***********************************城市列表**************************-->
<tr>
	<td id="0" class="weather_city_item"></td>
</tr>
<tr>
	<td id="1" class="weather_city_item"></td>
</tr>
<tr>
	<td id="2" class="weather_city_item"></td>
</tr>
<tr>
	<td id="3" class="weather_city_item"></td>
</tr>
<tr>
	<td id="4" class="weather_city_item"></td>
</tr>
<tr>
	<td id="5" class="weather_city_item"></td>
</tr>
<tr>
	<td id="6" class="weather_city_item"></td>
</tr>
<tr>
	<td id="7" class="weather_city_item"></td>
</tr>
<tr>
	<td id="8" class="weather_city_item"></td>
</tr>
<!--*************************************************************-->
</table>
</div>
</body>
</html>
