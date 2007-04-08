<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>

<?php
$name=addslashes($name);
$size=filesize($filepath);
$filepath=str_replace("E:\\","",$filepath);
$filepath=str_replace("\\","/",$filepath);
$path=addslashes($filepath);

function format($text)
{
	$text=addslashes($text);
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
	return $text;
}
$info=format($info);
$time=date("Y/m/d");
$phpbbs_root_path="../";
include_once $phpbbs_root_path.'include/db_connect.php';
$sql1="select * from software where path='$path'";
$sql2="insert into software(name,path,size,info,time,type) values('$name','$path','$size','$info','$time','$type')";
$result1=mysql_query($sql1);
if(mysql_num_rows($result1))
{
	?>
	数据库中已经存在相同路径!
	<button onclick="javascript:history.go(-1)">后退</button>
	<?
}
else
{
	if(!mysql_query($sql2))
	{
		echo "error:$sql2";
	}
	else
	{
		?>
		插入信息操作成功!
		<script>
			window.history.go(-1);
		</script>
		<?
	}
}
?>

</body>
</html>