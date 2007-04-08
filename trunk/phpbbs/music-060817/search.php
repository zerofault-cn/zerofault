<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_functions.php';
$keyword=$_REQUEST['keyword'];
$searchtype=$_REQUEST['searchtype'];
if($searchtype=='multi')
{
	$sql1="select distinct song_info.* from song_info,album_info,singer_info where binary song_info.song_name like '%".$keyword."%' or (singer_info.singer_id=song_info.singer_id and binary singer_info.singer_name like '%".$keyword."%') or (album_info.album_id=song_info.album_id and binary album_info.album_name like '%".$keyword."%') order by song_info.singer_id,song_info.album_id,song_info.song_id";
}
elseif($searchtype=='song')
{
	$sql1="select * from song_info where binary song_name like '%".$keyword."%' order by singer_id,album_id,song_id";
}
else
{
	$sql1="select song_info.* from song_info inner join ".$searchtype."_info on song_info.".$searchtype."_id=".$searchtype."_info.".$searchtype."_id where binary ".$searchtype."_info.".$searchtype."_name like '%".$keyword."%' order by song_info.singer_id,song_info.album_id,song_info.song_id";
}
$result1=$db->sql_query($sql1);
$num1=$db->sql_numrows($result1);
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天音乐——搜索结果</title>
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
	<td valign=top>
	<img src="image/searchresult.gif">
	<?
	if($num1==0)
	{
		?>
		<table width="100%" border=0 cellPadding=3 cellSpacing=1 bgcolor="#a0a0a0">
		<tr bgcolor="#ffffff">
			<td height=50 align=center><span style="color:#a0a0a0;font-size:16px">对不起,没有找到您查询的信息</span></td>
		</tr>
		</table>
		<?
	}
	else
	{
		?>
	<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor="#ffffff">
	<tr bgcolor="#3399CC">
		<td>序号</td>
		<td>歌曲名</td>
		<td>专辑</td>
		<td>歌手</td>
		<td>加入时间</td>
		<td>人气</td>
		<td>播放</td>
		<td>下载</td>
		<td>歌词</td>
	</tr>
	<?
	listTable3($result1);
	?>
	</table>
	<?
}
?>
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