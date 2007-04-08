<?
ob_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$id=$_REQUEST['id'];
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title><?=$ftitle?></title>
<link rel="stylesheet" href="<?=$phpbbs_root_path?>/style.css" type="text/css">
</head>

<body topmargin="0">
<center>
<?
include_once $phpbbs_root_path.'/top.php';
$sql1="select * from board where id='".$id."'";//取得该条留言全部信息
$result1=mysql_query($sql1);
$username=mysql_result($result1,0,"username");
$title=mysql_result($result1,0,"title");
$time=mysql_result($result1,0,"time");
$info=mysql_result($result1,0,"info");
$type=mysql_result($result1,0,"type");
$count=mysql_result($result1,0,"count");
$count++;
$sql2="update board set count='".$count."' where id='".$id."'";
mysql_query($sql2);
$sql3="select * from board where pid=".$id;
$result3=mysql_query($sql3);

/*if($ftype=="tech"||$ftype=="feeling"||$ftype=="joke")//从数据库中导出至文件
{
	$title=$ftitle;
	$username=$fauthor;
	$time=$ftime;
	$info=str_replace("<br>","\n",$finfo);
	$text="$title\n$time\n$info";
	$fp=fopen("/document/$ftype/$title.txt","w"); 
	fwrite($fp,$text); 
	fclose($fp);
}
*/
?>
<table width="760" border="1" cellspacing="0" cellpadding="0"  bordercolor="#d0dce0">
<tr>
	<td>
	<table width="100%" border="1" cellspacing="0" cellpadding="0"  bordercolor="#d0dce0" rules="cols">
	<caption class="big"><?=$title?></caption>
	<tr>
		<td align="right">留言人:</td>
		<td width=680><?=$username?></td>
	</tr>
	<tr>
		<td align="right">留言时间:</td>
		<td><?=$time?></td>
	</tr>
	<tr>
		<td align="right">阅读次数:</td>
		<td><?=$count?></td>
	</tr>
	<tr>
		<td colspan="2"><hr size="0.6" noshade></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="white" style="word-wrap:break-word"><?=$info?></td>
	</tr>
<?
while($r=mysql_fetch_array($result3))
{
	?>
	<tr bgcolor=white>
		<td colspan=2><hr width=70% align=left><br><span style="color:#3399cc"><?=$r["username"]?></span>于<?=$r["time"]?>回复:</td>
	</tr>
	<tr bgcolor=white>
		<td colspan=2><?=$r["info"]?></td>
	</tr>
	<?
}
?>
	<tr bgcolor="#d0dce0">
		<td>
		<button onclick="javascript:history.go(-1)">后退</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button onclick="window.location='reply_1.php?id=<?=$id?>'">回复</button></td>
		<td>
		<button onclick="javascript:window.location='?id=<?=$id-1?>&max_id=<?=$max_id?>'">上一篇</button>&nbsp;&nbsp;&nbsp;&nbsp;
		<button <?if($id==$max_id)echo 'disabled'?> onclick="javascript:window.location='?id=<?=$id+1?>&max_id=<?=$max_id?>'">下一篇</button></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</center>
</body>
</html>
<?
ob_end_flush();
?>