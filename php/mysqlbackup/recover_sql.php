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
		$result=mysql_query($query) or die ("�������ݿ�ʱ��������");
	}
	for($i=0;$i<$count;$i++)
	{
		$query=$sql_array[$i];
		$result=mysql_query($query) or die ("�ָ����ݿ�ʱ��������");
	}
	
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>���ݿ��Ѿ��ɹ��ָ����ȴ�3����Զ�ת����ҳ��</div>";
	echo "<meta http-equiv=REFRESH content=\"3;URL=index.php\">";
	echo "<br><div align=center>���ߵ��<a href=\"index.php\">����</a>����</div>";
	
?>