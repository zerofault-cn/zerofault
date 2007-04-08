<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>

<wml>
<card>
<p>
<table>
<caption>我的电话薄--
<?php
$pageitem=5;
if($offset=='')
	echo '1';
else 
	echo ceil($offset/$pageitem)+1;
?>
</caption>
<tr><td>姓名</td><td>电话/手机</td></tr>
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
	echo "<tr><td>".$name."</td><td>".$tele."</td><td><a href='moreinfo.php?id=".$id."'>详细信息</a></td></tr>";
}
echo '</table></p><p>';
echo '每页'.$pageitem.'条,共'.$num2.'条<br/>';
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0'>最前一页</a><br/>";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset'>上一页</a><br/>";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset'>下一页</a><br/>";
	echo "<a href='$PHP_SELF?offset=$endpage'>最后一页</a><br/>";
}
?>
</p>
<p>
<a href='../index.php'>返回</a>
</p>
</card>
</wml>
