<?
ob_start();
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<LINK rel="stylesheet" href="../style.css" type="text/css">
<title>软件下载</title>
</head>
<body topMargin=0>
<center>
<?
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/top.php';
include_once $phpbbs_root_path.'/include/db_connect.php';
$newsearchtype=$_REQUEST['newsearchtype'];
?>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr><td height=12 align=center valign=bottom colspan=3 background='/phpbbs/image/table_back0.jpg'>
	<?
	include_once 'search_table.php';
	?>
	</td></tr>
<tr><td width=100 align=right valign=top bgcolor=#d0dce0>
	<?
	include_once 'left.php';
	?>
	</td>
	<td width=10 background='/phpbbs/image/jiao.gif'>&nbsp;</td>
	<td width=660 valign=top align=center>
	<?
	if($newsearchtype!='')
	{
		include_once 'search.php';
	}
	else
	{
		include_once 'main.php';
	}
	?>
	</td></tr>
</table>
<div align=center><font color=red>本来有很多软件,由于懒得整理,所以这里没有列出.<br>如果没有找到你需要的软件,可以留言通知我添加!<a href="/phpbbs/board/insert_1.php?username=downloader&title=我需要某个软件...">走这里</a></font></div>
<?php
include $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>