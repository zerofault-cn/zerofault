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
<title>海天音乐歌手列表</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body topMargin=0>
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 height=10><img height=1 src="../image/point1.gif" width="100%"></td>
	<td width=10><img height=10 src="../image/jiao1.gif" width=10></td>
	<td width=580><img height=1 src="../image/point1.gif" width="100%"></td>
</tr>
<tr>
	<td valign=top>
	<?
	include_once 'left.php';
	?>
	</td>
	<td height="100%" align="center"><img height="100%" src="../image/point1.gif" width=1></td>
	<td valign="top">
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td></td>
		<td height=30 colspan=2 align=left>
		您所在位置:<a href="index.php">音乐首页</a>-&gt;歌手列表:<br>
		<hr size="0.4" width="40%" style="color:#FFCC33">
		</td>
	</tr>
	</table>
	<img src="image/singer_list.gif">
	<?
	include_once "admin/singer_list.php";
	?>
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