<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>

<wml>
<card>
<p>
<table>
<caption>�ҵĵ绰��--
<?php
$pageitem=5;
if($offset=='')
	echo '1';
else 
	echo ceil($offset/$pageitem)+1;
?>
</caption>
<tr><td>����</td><td>�绰/�ֻ�</td></tr>
<?php
if($offset=='')
	$offset=0;
$db_conn=mysql_connect("localhost","root","");
mysql_select_db("personal");
$query1="select * from friend order by id limit $offset,$pageitem";
$query2="select * from friend";
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=$pageitem;
$num2=mysql_num_rows($result2);
if($fid=='')
$fid=0;
while($r=mysql_fetch_array($result1))
{
	$fid++;
	$id=$r["id"];
	$name=$r["name"];
	$tele=$r["tele"];
	echo "<tr><td>".$name."</td><td>".$tele."</td><td><a href='moreinfo.php?id=".$id."'>��ϸ��Ϣ</a></td></tr>";
}
echo '</table></p><p>';
echo 'ÿҳ'.$pageitem.'��,��'.$num2.'��<br/>';
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0'>��ǰһҳ</a><br/>";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset'>��һҳ</a><br/>";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset'>��һҳ</a><br/>";
	echo "<a href='$PHP_SELF?offset=$endpage'>���һҳ</a><br/>";
}
?>
</p>
<p>
<a href='../index.php'>����</a>
</p>
</card>
</wml>
