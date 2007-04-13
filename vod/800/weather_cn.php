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
$weather_today='html_cache/weather_cn_'.$today.'.txt';
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
	$weather_yesterday='html_cache/weather_cn_'.$yesterday.'.txt';
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
		$tmp_weather_pic[$j]='<img src=image/bm/weather/'.$weather1_pic.'.gif height=50><img src=image/blank.gif width=20 height=1><img src=image/bm/weather/'.$weather2_pic.'.gif height=50>';
	}
	else
	{
		$tmp_weather_pic[$j]='<img src=image/bm/weather/'.words($tmp_weather[$j]).'.gif height=50>';
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
<link rel="stylesheet" href="style.css" type="text/css">
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
var pageitem=<?=$pageitem?>;
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
	document.getElementById(n%pageitem).style.backgroundColor="#2b4971";
	document.getElementById(n%pageitem).style.color="#20e3f4";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundColor="";
	document.getElementById(n%pageitem).style.color="#ffffff";
	unshow(n);
}

function show(n) {
	document.getElementById('city_info').innerHTML=city_info[n];
	ta=document.getElementById(city[n]);
	ta.innerHTML='<table border=0 width=170 height=100 cellspacing=0 cellpadding=0 background="image/bm/weather/weather_pop.gif"><tr><td height=2></td></tr><tr><td height=80 align=center valign=top class=style24b>'+weather_pic[n]+'<br>'+weather[n]+'</td></tr></table>';
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
	if(keycode==38 && i>0)
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
	if(keycode==40 && i < city.length - 1)
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
		location ="bm_index.php";
	}
}
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/bm/weather/weather_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="init()">

<div id="北京" style="position:absolute; left:275px; top:119px;width:170px;height:100px"></div>

<div id="哈尔滨" style="position:absolute; left:357px; top:38px;width:170px;height:100px"></div>

<div id="长春" style="position:absolute; left:346px; top:63px;width:170px;height:100px"></div>

<div id="沈阳" style="position:absolute; left:339px; top:91px;width:170px;height:100px"></div>

<div id="天津" style="position:absolute; left:286px; top:130px;width:170px;height:100px"></div>

<div id="呼和浩特" style="position:absolute; left:234px; top:111px;width:170px;height:100px"></div>

<div id="乌鲁木齐" style="position:absolute; left:34px; top:39px;width:170px;height:100px"></div>

<div id="银川" style="position:absolute; left:183px; top:137px;width:170px;height:100px"></div>

<div id="西宁" style="position:absolute; left:136px; top:155px;width:170px;height:100px"></div>

<div id="兰州" style="position:absolute; left:164px; top:170px;width:170px;height:100px"></div>

<div id="西安" style="position:absolute; left:209px; top:192px;width:170px;height:100px"></div>

<div id="拉萨" style="position:absolute; left:24px; top:220px;width:170px;height:100px"></div>

<div id="成都" style="position:absolute; left:155px; top:235px;width:170px;height:100px"></div>

<div id="重庆" style="position:absolute; left:180px; top:248px;width:170px;height:100px"></div>

<div id="贵阳" style="position:absolute; left:179px; top:291px;width:170px;height:100px"></div>

<div id="昆明" style="position:absolute; left:132px; top:306px;width:170px;height:100px"></div>

<div id="太原" style="position:absolute; left:244px; top:149px;width:170px;height:100px"></div>

<div id="石家庄" style="position:absolute; left:260px; top:147px;width:170px;height:100px"></div>

<div id="济南" style="position:absolute; left:293px; top:164px;width:170px;height:100px"></div>

<div id="郑州" style="position:absolute; left:257px; top:190px;width:170px;height:100px"></div>

<div id="合肥" style="position:absolute; left:298px; top:221px;width:170px;height:100px"></div>

<div id="南京" style="position:absolute; left:314px; top:219px;width:170px;height:100px"></div>

<div id="上海" style="position:absolute; left:338px; top:226px;width:170px;height:100px"></div>

<div id="武汉" style="position:absolute; left:260px; top:237px;width:170px;height:100px"></div>

<div id="长沙" style="position:absolute; left:254px; top:268px;width:170px;height:100px"></div>

<div id="南昌" style="position:absolute; left:285px; top:262px;width:170px;height:100px"></div>

<div id="杭州" style="position:absolute; left:326px; top:239px;width:170px;height:100px"></div>

<div id="福州" style="position:absolute; left:322px; top:294px;width:170px;height:100px"></div>

<div id="台北" style="position:absolute; left:349px; top:305px;width:170px;height:100px"></div>

<div id="南宁" style="position:absolute; left:201px; top:339px;width:170px;height:100px"></div>

<div id="海口" style="position:absolute; left:221px; top:379px;width:170px;height:100px"></div>

<div id="广州" style="position:absolute; left:256px; top:335px;width:170px;height:100px"></div>

<div id="香港" style="position:absolute; left:267px; top:344px;width:170px;height:100px"></div>

<div id="澳门" style="position:absolute; left:252px; top:347px;width:170px;height:100px"></div>

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=30 height=10>&nbsp;</td>
	<td width=750><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=540></td>
		<td width=188></td>
		<td width=22></td>
	</tr>
	<tr>
		<td height=80 id=title><span class=style32w style="margin-left:1em;color:fbb123"><?=$title1?></span><br><span class=style30w style="margin-left:2em;color:fbb123"><?=$title2?></span></td>
	</tr>
	<tr>
		<td height=420 valign=bottom>
		<table border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td width=7><img src="image/bm/weather/left_top.gif"></td>
			<td background="image/bm/weather/top.gif"></td>
			<td><img src="image/bm/weather/right_top.gif"></td>
		</tr>
		<tr>
			<td background="image/bm/weather/left.gif"></td>
			<td id="city_info" class=style24b bgcolor=white></td>
			<td background="image/bm/weather/right.gif"></td>
		</tr>
		<tr>
			<td><img src="image/bm/weather/left_bottom.gif"></td>
			<td background="image/bm/weather/bottom.gif"></td>
			<td><img src="image/bm/weather/right_bottom.gif"></td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
		<tr>
			<td height=52></td>
		</tr>
		<!--***********************************城市列表**************************-->
		<?
		for($i=0;$i<$pageitem;$i++)
		{
			?>
		<tr align=center>
			<td id="<?=$i?>" height=40 class=style30w></td>
		</tr>
			<?
		}
		?>
		<!--*************************************************************-->
		</table>
		</td>
	<td></td>
</tr>
</table>
	<!--********************************************* 可视面积 ***********************************************-->
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>
