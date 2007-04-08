<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_functions.php';
$sort_field=$_REQUEST["sort_field"];
if(!isset($sort_field)||$sort_field=='')
{
	$sort_field=$_SESSION['session_sort_field'];
	if(!isset($sort_field)||$sort_field=='')
	{
		$sort_field='album_id';
	}
}
$_SESSION['session_sort_field']=$sort_field;
$offset=$_REQUEST["offset"];
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$pageitem=5;
$sql1="select * from album_info order by ".$sort_field." desc limit ".$offset.",".$pageitem;
$sql2="select count(*) from album_info";
$result1=$db->sql_query($sql1);
$i=0;
while($r1=$db->sql_fetchrow($result1))
{
	$album_info[$i][0]=$r1['album_id'];
	$album_info[$i][1]=$r1['album_name'];
	$album_info[$i][2]=$r1['album_pubdate'];
	$album_info[$i][3]=$r1['album_intro'];
	$album_info[$i][4]=$r1['album_count'];
	$album_info[$i][5]=$r1['singer_id'];
	$album_info[$i][6]=getSingerName($album_info[$i][5]);
	$i++;
}
$result2=$db->sql_query($sql2);
$rowCount=$db->sql_fetchfield(0,0,$result2);
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天专辑列表</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body topMargin=0>
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 height=10><img height=1 src="../image/point1.gif" width="100%"></td>
	<td width=10><img height=10 src="../image/jiao1.gif" width=10></td>
	<td width=580><img height=1 src="../image/point1.gif" width="100%"></td>
</tr>
<tr>
	<td valign=top>
	<?
	include_once 'left.php';
	?>
	</td>
	<td height="100%" align="center"><img height="100%" src="../image/point1.gif" width=1></td>
	<td valign="top">
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td></td>
		<td height=30 colspan=2 align=left>
		您所在位置:<a href="index.php">音乐首页</a>-&gt;专辑列表:<br>
		<hr size="0.4" width="40%" style="color:#FFCC33">
		</td>
	</tr>
	</table>
	<img src="image/newalbum.gif">
	<table width="100%" border=0 cellPadding=3 cellSpacing=1 bgcolor="#a0a0a0">
	<?
	for($i=0;$i<sizeof($album_info);$i++)
	{
		?>
	<tr bgcolor="#ffffff">
		<td width=140 align=center><a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><img src="get_photo.php?photo_type=album&photo_id=<?=$album_info[$i][0]?>" width=120 border=0></a></td>
		<td valign=top>
		专辑名:<a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><?=$album_info[$i][1]?></a><br>
		歌手名:<a href="singer_info.php?singer_id=<?=$album_info[$i][5]?>"><?=$album_info[$i][6]?></a><br />
		发布日期:<?=$album_info[$i][2]?><br>
		关注指数:<?=$album_info[$i][4]?><br>
		简介:<div style="text-indent:2em;line-height:130%;word-wrap:break-word"><?=substr($album_info[$i][3],0,180)?></div>
		</td>
	</tr>
		<?
	}
	if(sizeof($album_info)==0)
	{
		?>
	<tr bgcolor="#ffffff">
		<td height=50 align=center><span style="color:#a0a0a0;font-size:16px">暂时没有</span></td>
	</tr>
		<?
	}
	else
	{
		?>
	<tr bgcolor="#ffffff">
		<td align=right colspan=2>
		<table border=0 cellpadding=0 cellspacing=0>
		<form action='<?=$_SERVER['PHP_SELF']?>' method=post>
		<tr>
			<td valign=top>
		<?
		if($offset!=0)
		{
			echo "<a href='?offset=0&songlist=all'>首页</a>&nbsp;&nbsp;";
			$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
			echo "<a href='?offset=$preoffset&songlist=all'>上一页</a>&nbsp;&nbsp;";
		}
		if(($offset+$pageitem)<$rowCount)
		{
			$newoffset=$offset+$pageitem;
			$endpage=$rowCount-$pageitem;
			echo "<a href='?offset=$newoffset&songlist=all'>下一页</a>&nbsp;&nbsp;";
			echo "<a href='?offset=$endpage&songlist=all'>尾页</a>&nbsp;&nbsp;";
		}
		?>
			</td>
			<td>页码:<input onmouseover="this.select()" onmouseout="this.blur()" type=text name=offpage value='<?=ceil(($offset+1)/$pageitem)?>' size=2 style="height:18px;font-size:13px;color:red">
			/<span class=red><?=ceil($rowCount/$pageitem)?></span>,每页<span class=red><?=$pageitem?></span>个,共<span class=red><?=$rowCount?></span>个</td>
		</tr>
		<input type="hidden" name="allpage" value='<?=$allpage?>'>
		<input type="hidden" name="song_ltype" value="all">
		</form>
		</table>
		</td>
	</tr>
		<?
	}
	?>
	</table>
	</td>
</tr>
</table>
<?
include_once $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>