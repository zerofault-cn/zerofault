<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">

<title>��վ������ͳ��</title>

</head>
<body>
<nobr>
<center>

<table width=78% border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 >
<tr><td colspan=6 align=center>��վ������ͳ��</td></tr>
<tr bgcolor=#3399CC>
<td width=5%align=center>���</td>
<td width=12% align=center>ip</td>
<td align=center>address</td>
<td width=15% align=center>os</td>
<td width=18% align=center>browse</td>
<td width=23% align=center>time</td></tr>
<?php
if($offset=="")
	$offset=0;
$pageitem=20;
$phpbbs_root_path=".";
include_once $phpbbs_root_path.'/include/db_connect.php';
$query1="select * from count1 order by id desc limit $offset,$pageitem";
$query2="select * from count1";
$query3="select count(*) from count1 where ip='211.83.118.100' or ip='127.0.0.1'";
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$result3=mysql_query($query3);
$num1=mysql_num_rows($result1);
$num2=mysql_num_rows($result2);
if($num1==0)
{
	echo"û���κ�����";
}
else
{
	while($r=mysql_fetch_array($result1))
	{
		$fid=$r["id"];
		$fip=$r["ip"];
		$faddress=$r["address"];
		$fos=$r["os"];
		$fbrowse=$r["browse"];
		$ftime=$r["time"];
		echo "<tr><td>".$fid."</td><td>".$fip."</td><td>".$faddress."</td><td>".$fos."</td><td>".$fbrowse."</td><td>".$ftime."</td></tr>";
	}
}
echo "<tr><td colspan=6 align=right>&nbsp;&nbsp;";

if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0'>����ǰ��</a>&nbsp;&nbsp;";
	$preoffset=$offset-$pageitem;
	echo "<a href='$PHP_SELF?offset=$preoffset'>��ǰһҳ��</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset'>����һҳ��</a>&nbsp;&nbsp;";
	echo "<a href='$PHP_SELF?offset=$endpage'>�����</a>&nbsp;&nbsp;";
}
echo (ceil(($num2-$offset)/$pageitem))."/".ceil($num2/$pageitem)." ÿҳ".$pageitem."��";
echo "</td></tr>";
?>
</table>
���ط���<span class=red><?=mysql_result($result3,0);?></span>��!
</center>
</body>
</html>
