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
<title>����һɫ���Ա�</title>
</head>

<body topmargin="0">
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width="760" border="1" cellpadding="0" cellspacing="0" bordercolor="#d0dce0">
<caption class="big">
	<?php
	$caption=array('message'=>'����һɫ���԰�----������Ϣ',
	'tech'=>'����һɫ���԰�----���м�������',
	'feeling'=>'����һɫ���԰�----�����������',
	'joke'=>'����һɫ���԰�----����Ц��');
	if($infotype)
	{
		echo $caption[$infotype];
	}
	else
	{
		echo '����һɫ���԰�----��������';
	}
	?></caption>
<tr bgcolor="#3399CC">
	<td width="6%">���</td>
	<td width="7%">������</td>
	<td width="1%"></td>
	<td width="60%">���Ա���</td>
	<td width="46%">����ʱ��</td>
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
	<td align="center" colspan="5">���ݿ��ѱ����!</td>
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
	<td colspan="5" align="right"><a style="color:#ff0000" href="insert_1.php">���������ԡ�</a>&nbsp;&nbsp;
<?
if($offset!=0)
{
	echo "<a href='$PHP_SELF?offset=0&infotype=$infotype'>����ǰ��</a>&nbsp;&nbsp;";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='$PHP_SELF?offset=$preoffset&infotype=$infotype'>��ǰһҳ��</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='$PHP_SELF?offset=$newoffset&infotype=$infotype'>����һҳ��</a>&nbsp;&nbsp;";
	echo "<a href='$PHP_SELF?offset=$endpage&infotype=$infotype'>�����</a>&nbsp;&nbsp;";
}
echo '��ǰ'.(ceil(($num2-$offset)/$pageitem)).'/'.ceil($num2/$pageitem).',��'.$num2.'��,ÿҳ'.$pageitem.'��';
?>
	</td>
</tr>
<tr>
	<td colspan="5" align="center">
	<hr>
	<form action="search.php" method="post">
	����:<select name="title">
		<option value="title">����</option>
		<option value="info">����</option>
		</select>
	�ؼ���:<input type="text" name="keyword">
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