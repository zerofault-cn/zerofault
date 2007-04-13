<?
$id=$_REQUEST['id'];
include_once "../include/db_connect.php";
include_once "color.inc.php";
$sql1="select title,info from bianmin where id='".$id."'";
$result1=$db->sql_query($sql1);
$title=$db->sql_fetchfield(0,0,$result1);
$info=$db->sql_fetchfield(1,0,$result1);
$sql2="update bianmin set count=count+1 where id='".$id."'";
$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>便民信息</title>
<link rel="stylesheet" href="style.css" type="text/css">
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
	if(keycode==36)
	{
		location="bm_title.php?type=<?=$type?>";
	}
	if(keycode==40 || keycode==34)
	{
		marquee1.start();
		marquee1.stop();
	}
}
document.onkeydown=keyDown
//-->
</script>
</head>
<body leftMargin=0 topMargin=0 background="image/bm/bg_<?=$type?>.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
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
	<table width="760" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50" height="80">&nbsp;</td>
		<td width="475">&nbsp;</td>
		<td width="35">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="style30b" style="color:<?=$bm_text?>">
		<marquee id="marquee1" name="marquee1" direction="up" loop=-1 behavior="scroll" dataformatas="html" scrolldelay="0" scrollamount="2" border="0" height="390">
			<div align=center class=style32b style="color:<?=$bm_text_focus?>"><?=$title?></div>
			<p style="line-height:1.5em"><?=$info?></p>
		</marquee> 
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table height="180" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bm_title.php?type=<?=$type?>');">返<br>回</td>
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
