<?
$mp3_id=$_REQUEST['mp3_id'];
include "../include/db_connect.php";
include "../include/getplaypath.php";
include "color.inc.php";
$sql1="select singer_name,album_name,song_name,lyric from song_info,singer_info where song_info.id=".$mp3_id." and singer_info.singer_id=song_info.singer_id";
$result1=$db->sql_query($sql1);
$singer_name=$db->sql_fetchfield(0,0,$result1);
$album_name=$db->sql_fetchfield(1,0,$result1);
$song_name=$db->sql_fetchfield(2,0,$result1);
$lyric=$db->sql_fetchfield(3,0,$result1);
$lyric=str_replace("\r\n",'',$lyric);
$lyric=str_replace("\t",'',$lyric);
$lyric=str_replace("  ",'',$lyric);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>mp3歌词</title>
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
	if(keycode==36)//返回
	{
		window.history.go(-1);
	}
}    
document.onkeydown=keyDown
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/music/music9_bg.jpg" bgcolor="#495772">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760>&nbsp;</td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--*********************************** *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	    <td width="40" height="50">&nbsp;</td>
		<td><span class=style32w style="color:#bafd76"><?=$singer_name?>_<?=$album_name?>_<?=$song_name?></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<marquee height=500 width="100%" direction="up" loop=-1 behavior="scroll" dataformatas="html"  scrolldelay="0" scrollamount="1" border="0">
		<div class="style30w" style="line-height:1.2em"><?=$lyric?></div>
		</td>
	</tr>
	</table>
	<!--*******************************************************************************************-->
	</td>
	<td></td>
</tr>
</table>
</body>
</html>
