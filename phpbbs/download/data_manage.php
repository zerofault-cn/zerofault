<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>������</title>
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
		echo $id.': '.$filepath.':<font color=blue>�ļ�·����ȷ!</font><br>';
	}
	else
	{
		$query3="DELETE FROM software WHERE id=$id";
		if(mysql_query($query3))
			echo $id.': '.$filepath.'<font color=red>������,�Ѿ������ݿ���ɾ��</font><br>';
	}
}
echo '�������<font color=red>'.$i.'</font>����¼,��ʣ<font color=red>'.$j.'</font>����Ч��¼';
?>

</body>
</html>