<p>
<?php
if($type=='')
	$type='message';
if($offset=='')
	$offset=0;
$pageitem=6;
mysql_connect('localhost','root','');
mysql_select_db('phpbbs');
$query1="select * from board where type='".$type."' order by id desc limit $offset,$pageitem";
$query2="select * from board where type='".$type."'";
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
		?>
		<a href='info.php?fid=<?=$fid?>&id=<?=$id?>'><?=$title?></a><br />
		<?
	}
}
echo '</p><p>';
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0'>【最前】</a><br />";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset'>【前一页】</a><br />";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset'>【后一页】</a><br />";
	echo "<a href='$PHP_SELF?offset=$endpage'>【最后】</a><br />";
}
echo '当前'.(ceil(($num2-$offset)/$pageitem)).'/'.ceil($num2/$pageitem).',共'.$num2.'条,每页'.$pageitem.'条';
echo '<p>';
?>