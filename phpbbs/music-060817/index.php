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
<title>����������ҳ</title>
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
	newAlbum5();//�г����µ�5��ר��
	?>
	<hr size='0.6' noshade>
	<?
	singleSong('new10');//�г����µ�10�׵���
	?>
	<br>
	<table width="580" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td align=center>����ʹ��Winamp��Windows Media Player�������������������ź���ʾ���ء�play.php����������Ϊ���ϵͳ��δע��.m3u�ļ����ͣ������ز�����<a href='m3u.reg' style="color:#3399ff">m3u.reg</a>
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