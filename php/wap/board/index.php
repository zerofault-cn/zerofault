<?php  
header("Content-type:text/vnd.wap.wml; charset=gb2312"); 
?>
<wml>
<card>

<p>
<?php
$offset=$_REQUEST['offset'];
$infotype=$_REQUEST['infotype'];
if($offset=="")
	$offset=0;
$pageitem=5;
mysql_connect("localhost","root","");
mysql_select_db("phpbbs");
$query1="select * from board where type='".$infotype."' order by id desc limit $offset,$pageitem";
$query2="select * from board where type='".$infotype."'";
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=mysql_num_rows($result1);
$num2=mysql_num_rows($result2);
if($num1==0)
{
	echo"无数据,数据库故障或已被清空!";
}
else
{
	$temp=$num2-$offset;
	while($r=mysql_fetch_array($result1))
	{
		$fid=$temp--;
		$id=$r["id"];
		$title=$r["title"];
		echo $fid;
		echo ":<a href='info.php?id=".$id."&amp;infotype=".$infotype."'>".htmlspecialchars($title)."</a><br/>";
	}
}
echo '</p><p>';
echo '共'.ceil($num2/$pageitem).'页,共'.$num2.'条<br/>';
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0&amp;infotype=$infotype'>最前一页</a><br/>";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset&amp;infotype=$infotype'>上一页</a><br/>";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset&amp;infotype=$infotype'>下一页</a><br/>";
	echo "<a href='$PHP_SELF?offset=$endpage&amp;infotype=$infotype'>最后一页</a><br/>";
}

?>
</p>
<p>
<a href='../index.php'>返回</a>
</p>
</card>
</wml>