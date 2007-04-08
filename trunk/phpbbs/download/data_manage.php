<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>软件检查</title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>

<nobr>
<?php
$db_conn=mysql_connect("localhost","root","");
mysql_select_db("download");
$query1="select id,path from software";
$result1=mysql_query($query1);
while($r=mysql_fetch_array($result1))
{
	$i++;
	$id=$r["id"];
	$path=$r["path"];
	$filepath=str_replace("%20"," ",str_replace("http://211.83.118.100","",$path));
	if(file_exists($filepath))
	{
		$j++;
		echo $id.': '.$filepath.':<font color=blue>文件路径正确!</font><br>';
	}
	else
	{
		$query3="DELETE FROM software WHERE id=$id";
		if(mysql_query($query3))
			echo $id.': '.$filepath.'<font color=red>不存在,已经从数据库中删除</font><br>';
	}
}
echo '共检查了<font color=red>'.$i.'</font>个记录,还剩<font color=red>'.$j.'</font>个有效记录';
?>

</body>
</html>