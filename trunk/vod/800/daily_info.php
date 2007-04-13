<?
$type=$_REQUEST['type'];
$id=$_REQUEST['id'];
include "../include/db_connect.php";
include "color.inc.php";
$sql1="select * from daily_source where id=".$id;
$result1=$db->sql_query($sql1);
$title=$db->sql_fetchfield(1,0,$result1);
$source=$db->sql_fetchfield(2,0,$result1);
$descr=$db->sql_fetchfield(3,0,$result1);
$time=$db->sql_fetchfield(5,0,$result1);
$source_list='../daily_list/'.$source;
$fp=fopen($source_list,"r");
$source_url=fread($fp,filesize($source_list));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
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
		location="daily_title.php?type=<?=$type?>";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/daily/daily3_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">

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
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=20 height=118>&nbsp;</td>
		<td width=384>&nbsp;</td>
		<td width=28>&nbsp;</td>
		<td>&nbsp;</td>
		<td width=20>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
		<tr>
			<td align=center id=mplayer valign=top>
			<script>
			if(navigator.platform=='Win32')
			{
				document.write('<embed src="<?=$source_url?>" autostart="1" ShowControls=0 ShowStatusBar=0 prefetch=0 nolabels=1 controls=imagewindow width="383" height="292"></embed>');
			}
			else
			{
				document.write('<embed src="../daily_list/<?=$source?>" width=383 height=292 type="application/x-mplayer2"></embed>');
			}
			</script>
			</td>
		</tr>
		</table>
		</td>
		<td></td>
		<td valign=top>
			<table border=0 width="100%" height="100%" cellspacing=0 cellpadding=0>
			<tr>
				<td height=10></td>
			</tr>
			<tr>
				<td valign=top class=style30w style="line-height:1.2em;letter-spacing:0em">
				<!-- <marquee DATAFORMATAS="HTML" loop="-1" direction="up" width=250 height="330" 	scrolldelay="0" scrollamount="1" style="word-break:break-all;line-height:140%;text-indent:2em"> -->
				<p align=justify>
				<?=substr($descr,0,180).'...'?>
				</p>
				<!-- </marquee> -->
				</td>
			</tr>
			</table>
		</td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('daily_title.php?type=<?=$type?>');">返<br>回</td>
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
