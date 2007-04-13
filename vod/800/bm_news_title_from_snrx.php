<?
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
function has_str($haystack,$needle,$offset=0)
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
		return 1; //找到则返回1
	else 
		return 0;//没找到就返回0 
}
include_once "color.inc.php";
$url= "http://news.snrx.com/";

$source_item=array();
$pageitem=9;
$offset=0;
$intRowCount=9;
$i=0;
if($fp=fopen($url,"r"))
{
	while ($buffer = fgets($fp, 4096))

	{
		if(has_str($buffer,'<li>'))
		{
			if($i>=$pageitem)
			{
				break;
			}
			$source_item[$i++]=$buffer;
		}
		elseif(has_str($buffer,'<BR><BR>'))
		{
			break;
		}
		else
		{
			continue;
		}
		
	}
	fclose($fp);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>遂宁新闻——标题</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bm2_bg.jpg" onload="onfoc(0)" style="background-Attachment:fixed;background-repeat:no-repeat;">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20></td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="60" height="80">&nbsp;</td>
		<td width="650">&nbsp;</td>
		<td width="50">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		for($i=0;$i<$pageitem;$i++)
		{
			$news_url='bm_news_info_from_snrx.php?url=http://news.snrx.com/'.substr($source_item[$i],indexOf($source_item[$i],'shownews'),indexOf($source_item[$i],'" >')-indexOf($source_item[$i],'shownews'));
			if(indexOf($source_item[$i],'<font color="#FF0000">[附图]</font>'))
			{
				$has_pic=1;
				$source_item[$i]=substr($source_item[$i],indexOf($source_item[$i],'</font>')+7);
			}
			else
			{
				$has_pic=0;
			}
			$news_title=substr($source_item[$i],indexOf($source_item[$i],'<font class="p10">')+18,indexOf($source_item[$i],'</font>')-indexOf($source_item[$i],'<font class="p10">')-18);
			if($has_pic)
			{
				$news_title='[附图]'.$news_title;
			}
			if(strlen($news_title)>40)
			{
				$news_title=substr($news_title,0,38).'..';
			}
			?>
		<tr>
			<td id=<?=$i?> height="45" class="style30b" onMouseOver='this.style.backgroundColor="<?=$bm_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style='color:<?=$bm_text?>' href="<?=$news_url?>" onMouseOver='this.style.color="<?=$bm_text_focus?>"' onMouseOut='this.style.color="<?=$bm_text?>"'><?=$i+1?>.<?=$news_title?></a></td>
		</tr>
			<?
		}
		?>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="300" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bm_index.php');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>

</table>
</body>
<script language="JavaScript" type="text/JavaScript">
var key2=0;
function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$bm_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$bm_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$bm_text?>" ' + dat;
}

function begin()
{
	td= document.getElementById(key2);
	dat = td.innerHTML;
	dat +='<img src=image/ing.gif height=22>';
	td.innerHTML = dat; 
	window.setTimeout('end()',5000);
}
function end()
{
	td = document.getElementById(key2);
	dat = td.innerHTML;
	dat = dat.substring(0,dat.lastIndexOf("<"));
	td.innerHTML = dat; 
}
if(document.all)
{
	var ie=1;
}
else
{
	var ie=0;
}
function keyDown(e)
{
	if (ie)
	{
		var keycode=event.keyCode; 
	}
	else
	{
		var keycode=e.which;
	}
	var key1 = keycode -48;
	var patern=/^[1-<?=$i?>]$/; 
	if (patern.exec(key1)) {
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location=document.links[key2];
	}
	if(keycode==13)
	{
		begin();
		location=document.links[key2];
	}
	if(keycode==36)
	{
		location='bm_index.php';
	}
	if(keycode==33 && <?=$offset?>!=0)//表示不是第一页
	{
		location="?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?type=<?=$type?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$i-1?>;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$i-1?>) 
			key2=0;
		onfoc(key2)
	}
}    
document.onkeydown=keyDown
//-->
</script>
</html>
