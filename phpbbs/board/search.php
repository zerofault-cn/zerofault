<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<nobr>
<center>

<table width=78% border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 ><!--208,220,224  -->
<caption>�������</caption>
<tr bgcolor=#3399CC><td width=7%>���</td><td width=7%>������</td><td width=60%>���Ա���</td><td width=46%>����ʱ��</td></tr>
<?php
if($offset=="")
	$offset=0;
$pageitem=25;
$db_conn=mysql_connect("localhost","root","");
mysql_select_db("phpbbs");
if($titletype=='all')
{
	if($type=='all')
	{
		$query1="select * from board where info like '%".$keyword."%' or title like '".$keyword."' order by id desc limit $offset,$pageitem";
		$query2="select * from board where info like '%".$keyword."%' or title like '".$keyword."'";
	}
	else
	{
		$query1="select * from board where (info like '%".$keyword."%' or title like '".$keyword."') and type='".$type."' order by id desc limit $offset,$pageitem";
		$query2="select * from board where (info like '%".$keyword."%' or title like '".$keyword."') and type='".$type."'";
	}
}
else
{
	if($type=='all')
	{
		$query1="select * from board where ".$titletype." like '%".$keyword."%' order by id desc limit $offset,$pageitem";
		$query2="select * from board where ".$titletype." like '%".$keyword."%'";
	}
	else
	{
		$query1="select * from board where ".$titletype." like '%".$keyword."%' and type='".$type."' order by id desc limit $offset,$pageitem";
		$query2="select * from board where ".$titletype." like '%".$keyword."%' and type='".$type."'";
	}
}
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=mysql_num_rows($result1);
$num2=mysql_num_rows($result2);
if($num1==0)
{
	echo"<tr><td align=center colspan=4>�Բ���,û�ҵ��κ������Ϣ!</td></tr>";
}
else
{
	$temp=$num2-$offset;
	while($r=mysql_fetch_array($result1))
	{
		$fid=$temp--;
		$id=$r["id"];
		$username=$r["username"];
		$title=$r["title"];
		$time=$r["time"];
		echo "<tr><td>".$fid."</td><td>".$username."</td><td><a href='info.php?fid=".$fid."&id=".$id."'>".$title."</a></td><td>".$time."</td></tr>";
	}
}
?>
<tr><td colspan=4 align=right><a href="javascript:history.go(-1);">����</a>&nbsp;<a href='insert_1.php'><font color=red>���������ԡ�</font></a>&nbsp;
<?php
if($offset!=0)
{
	echo "<a href='?offset=0&titletype=$titletype&type=$type&keyword=$keyword'>����ǰ��</a>&nbsp;&nbsp;";
	$preoffset=$offset-$pageitem;
	echo "<a href='?offset=$preoffset&titletype=$titletype&type=$type&keyword=$keyword'>��ǰһҳ��</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='?offset=$newoffset&titletype=$titletype&type=$type&keyword=$keyword'>����һҳ��</a>&nbsp;&nbsp;";
	echo "<a href='?offset=$endpage&titletype=$titletype&type=$type&keyword=$keyword'>�����</a>&nbsp;&nbsp;";
}
echo (ceil(($num2-$offset)/$pageitem))."/".ceil($num2/$pageitem)." ÿҳ".$pageitem."��";
echo "</td></tr>";
?>
<tr><td colspan=4 align=center><hr>
<form action='search.php' method=get>
����:<select name=titletype>
	<option value=title>����</option>
	<option value=info>����</option>
	</select>&nbsp;�ؼ���:
	<input type="text" name="keyword">
	<input type="hidden" name=type value=all>
	<input type=submit value='GO!'></form></td></tr>
</table>

</center>
</body>
</html>