<?php
	if(unlink($filename))
	{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>数据库备份文件　".$filename."　已成功删除！请等待页面自动跳转</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>或者<a href=\"index.php\">点击返回</a></div>";
	}
	else
	{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>数据库备份文件　".$filename."　删除失败！请等待页面自动跳转</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>或者<a href=\"index.php\">点击返回</a></div>";
	}
?>