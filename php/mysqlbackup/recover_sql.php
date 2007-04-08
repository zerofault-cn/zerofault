<?php
	require("connect.php");
	
	$sql=file_get_contents($filename);
	$sql_array=explode(";",$sql);
	$count=count($sql_array);
	
	$dbname_array=explode(" ",$sql_array[0]);
	$dbname=$dbname_array[1];
	
	if(!mysql_select_db($dbname))
	{
		$query="create database $dbname";
		$result=mysql_query($query) or die ("创建数据库时发生错误！");
	}
	for($i=0;$i<$count;$i++)
	{
		$query=$sql_array[$i];
		$result=mysql_query($query) or die ("恢复数据库时发生错误！");
	}
	
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>数据库已经成功恢复，等待3秒后将自动转自首页。</div>";
	echo "<meta http-equiv=REFRESH content=\"3;URL=index.php\">";
	echo "<br><div align=center>或者点击<a href=\"index.php\">这里</a>返回</div>";
	
?>