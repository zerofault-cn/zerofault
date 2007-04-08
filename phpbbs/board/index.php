<?
ob_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$infotype=$_REQUEST["infotype"];
$offset=$_REQUEST["offset"];
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<link rel="stylesheet" href="<?=$phpbbs_root_path?>/style.css" type="text/css">
<title>海天一色留言本</title>
</head>

<body topmargin="0">
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width="760" border="1" cellpadding="0" cellspacing="0" bordercolor="#d0dce0">
<caption class="big">
	<?php
	$caption=array('message'=>'海天一色留言板----所有信息',
	'tech'=>'海天一色留言板----所有技术文章',
	'feeling'=>'海天一色留言板----所有心情故事',
	'joke'=>'海天一色留言板----所有笑话');
	if($infotype)
	{
		echo $caption[$infotype];
	}
	else
	{
		echo '海天一色留言板----所有留言';
	}
	?></caption>
<tr bgcolor="#3399CC">
	<td width="6%">序号</td>
	<td width="7%">留言人</td>
	<td width="1%"></td>
	<td width="60%">留言标题</td>
	<td width="46%">留言时间</td>
</tr>
<?php
if($offset=="")
{
	$offset=0;
}
$pageitem=25;
if($infotype)
{
	$searchtype="where type='".$infotype."'";
}
$query1="select * from board ".$searchtype." order by id desc limit $offset,$pageitem";
$query2="select max(id),count(*) from board ".$searchtype;
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=mysql_num_rows($result1);
$num2=mysql_result($result2,0,'count(*)');
$max_id=mysql_result($result2,0,'max(id)');
if($num1==0)
{
	?>
<tr>
	<td align="center" colspan="5">数据库已被清空!</td>
</tr>
	<?
}
else
{
	$temp=$num2-$offset;
	while($r=mysql_fetch_array($result1))
	{
		$fid=$temp--;
		$id=$r['id'];
		$username=$r['username'];
		$type=$r['type'];
		$title=$r['title'];
		$time=$r['time'];
		?>
		<tr><td><?=$fid?></td><td><?=$username?></td><td><a href='?infotype=<?=$type?>'><font color=white><?=substr($type,0,1)?></font></a></td><td><a href='info.php?id=<?=$id?>&max_id=<?=$max_id?>'><?=$title?></a></td><td><?=$time?></td></tr>
		<?
	}
}
?>
<tr>
	<td colspan="5" align="right"><a style="color:#ff0000" href="insert_1.php">【发表留言】</a>&nbsp;&nbsp;
<?
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0&infotype=$infotype'>【最前】</a>&nbsp;&nbsp;";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset&infotype=$infotype'>【前一页】</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset&infotype=$infotype'>【后一页】</a>&nbsp;&nbsp;";
	echo "<a href='$PHP_SELF?offset=$endpage&infotype=$infotype'>【最后】</a>&nbsp;&nbsp;";
}
echo '当前'.(ceil(($num2-$offset)/$pageitem)).'/'.ceil($num2/$pageitem).',共'.$num2.'条,每页'.$pageitem.'条';
?>
	</td>
</tr>
<tr>
	<td colspan="5" align="center">
	<hr>
	<form action="search.php" method="post">
	搜索:<select name="title">
		<option value="title">标题</option>
		<option value="info">内容</option>
		</select>
	关键字:<input type="text" name="keyword">
		<input type="hidden" name="type" value="all">
		<input type="submit" value='GO!'>
	</form>
	</td>
</tr>
</table>
</center>
</body>
</html>
<?
ob_end_flush();
?>