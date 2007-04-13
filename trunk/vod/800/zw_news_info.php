<?
$id=$_REQUEST['id'];
$type0=$_REQUEST['type0'];
$type=$_REQUEST['type'];
include "../include/db_connect.php";
$sql1="select title,info from zw_suining where id='".$id."'";
$result1=$db->sql_query($sql1);
$title=$db->sql_fetchfield(0,0,$result1);
$info=$db->sql_fetchfield(0,0,$result1);
$sql2="update zw_suining set count=count+1 where id='".$id."'";
$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
p
{
	line-height:1.8;
	text-indent:2em;
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
	if (patern.exec(key1)) 
	{
		document.links[key1-1].focus();
		location = document.links[key1 - 1];
	}
	if(keycode==36)
	{
		location="zw_news_title.php?type0=<?=$type0?>&type=<?=$type?>";
	}			
}    
document.onkeydown=keyDown
//-->
</script>
</head>
<body leftMargin=0 topMargin=0 background="image/zw/zw3_bg_<?=$type?>.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20 >&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="60" height="25">&nbsp;</td>
		<td width="660">&nbsp;</td>
		<td width=40>&nbsp;</td>
	</tr>
	<tr>
		<td height=105>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class=style30w>
		<marquee direction="up" loop=-1 behavior="scroll" dataformatas="html" scrolldelay="0" scrollamount="2" border="0" height="370">
		<div align=center class=style30w><?=$title?></div>
		<p><?=str_replace("\n","<br>",$info)?></p>
		</marquee> 
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('zw_news_title.php?type0=<?=$type0?>&type=<?=$type?>');">返<br>回</td>
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
