<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_functions.php';
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天音乐首页</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body topMargin=0>
<center>
<!-- TOP -->
<?
include_once $phpbbs_root_path.'/top.php';
?>
<!-- TOP over -->
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 height=10><img src="../image/point1.gif" width="100%" height=1></td>
	<td width=10><img src="../image/jiao1.gif" width=10 height=10></td>
	<td width=580><img src="../image/point1.gif" width="100%" height=1></td>
</tr>
<tr>
	<td valign=top>
	<!-- LEFT -->
	<?
	include_once 'left.php';
	?>
	<!-- LEFT over -->
	</td>
	<td height="100%" align="center"><img height="100%" src="../image/point1.gif" width=1></td>
	<td valign=top>
	<!-- main -->
	<?
	newAlbum5();//列出最新的5个专辑
	?>
	<hr size='0.6' noshade>
	<?
	singleSong('new10');//列出最新的10首单曲
	?>
	<br>
	<table width="580" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td align=center>建议使用Winamp或Windows Media Player在线收听，如果点击播放后提示下载“play.php”，则是因为你的系统还未注册.m3u文件类型，请下载并导入<a href='m3u.reg' style="color:#3399ff">m3u.reg</a>
		</td>
	</tr>
	</table>
	<!-- main over -->
	</td>
</tr>
</table>
<?
include_once $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>