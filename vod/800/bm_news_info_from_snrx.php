<?
$url=$_REQUEST['url'];
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
include_once "color.inc.php";
if($fp=fopen($url,"r"))
{
	while ($buffer = fgets($fp, 4096))

	{
		$news_source.=$buffer;
	}
	fclose($fp);
}
//echo $news_source;
//exit;
$news_source=substr($news_source,indexOf($news_source,'<td width="572" valign="top">')+29);
$news_source=substr($news_source,0,indexOf($news_source,'</table>')+8);
$info=str_replace('width="572"','width="100%"',$news_source);
$info=str_replace('#3333cc','#ffffff',$info);
$info=str_replace('news_title','style32w',$info);
$info=str_replace('news_time','style30w',$info);
$info=str_replace('p10','style32w',$info);
$info=str_replace('size=3 ','',$info);
$info=str_replace('-----------------','',$info);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>便民信息</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
p
{
	line-height:1.8;
}
</style>
<script language="JavaScript" type="text/JavaScript">
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
	var key1 = keycode -48
　	var patern=/^[1-9]$/; 
	if(keycode==36)
	{
		history.go(-1);
	}
	if(keycode==40 || keycode==34)
	{
		if(navigator.platform=='Win32')
		{
			marquee1.start();
		}
		else
		{
			marquee1.start();
			marquee1.stop();
		}
		
	}
}
document.onkeydown=keyDown
//-->
</script>
</head>
<body leftMargin=0 topMargin=0 background="image/bm/bm2_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
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
		<td class=style30w>
		<marquee id="marquee1" name="marquee1" direction="up" loop=1 behavior="scroll" dataformatas="html" scrolldelay="0" scrollamount="2" border="0" height="400">
		<?=$info?>
		</marquee> 
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="300" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center></td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="javascript:window.history.go(-1);">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>
