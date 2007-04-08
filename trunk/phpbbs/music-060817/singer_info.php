<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_functions.php';

$singer_id=$_REQUEST['singer_id'];
$sql1="select * from singer_info where singer_id=".$singer_id;
$result1=$db->sql_query($sql1);
$singer_name=$db->sql_fetchfield('singer_name',0,$result1);
$singer_intro=$db->sql_fetchfield('singer_intro',0,$result1);
$singer_area_id=$db->sql_fetchfield('singer_area_id',0,$result1);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result1);

$sql2="select * from singer_type where type_id=".$singer_area_id." and type_label=1";
$singer_area=$db->sql_fetchfield('type_name',0,$db->sql_query($sql2));
$sql3="select * from singer_type where type_id=".$singer_chorus_id." and type_label=2";
$singer_chorus=$db->sql_fetchfield('type_name',0,$db->sql_query($sql3));

$sql4="select * from album_info where singer_id=".$singer_id;
$result4=$db->sql_query($sql4);
$i=0;
while($r4=$db->sql_fetchrow($result4))
{
	$album_info[$i][0]=$r4['album_id'];
	$album_info[$i][1]=$r4['album_name'];
	$album_info[$i][2]=$r4['album_pubdate'];
	$album_info[$i][3]=$r4['album_intro'];
	$album_info[$i][4]=$r4['album_count'];
	$i++;
}
$sql5="select * from song_info where singer_id=".$singer_id." and album_id=0";
$result5=$db->sql_query($sql5);
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天音乐歌手——<?=$singer_name?></title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body topMargin=0>
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width="760" border=0 cellpadding=0 cellspacing=0>
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
		<td>&nbsp;</td>
		<td height=30 colspan=2>
		您所在位置:<a href="index.php">音乐首页</a>-&gt;<a href="singer_list.php?list_id=<?=$singer_area_id.$singer_chorus_id?>"><?=$singer_area?><?=$singer_chorus?></a>-&gt;<?=$singer_name?>:
		</td>
	</tr>
	<tr>
		<td height=28 colspan=3><img src="image/singer_info.gif"></td>
	</tr>
	<tr>
		<td width=10></td>
		<td align=center valign=top width=120>
			<img src="get_photo.php?photo_type=singer&photo_id=<?=$singer_id?>"><br>
			<br>
			<?=$singer_name?><br>
			<?=$singer_area?><?=$singer_chorus?><br>
			</td>
		<td align=right valign=top>
		<textarea rows=14 cols=58 readonly><?=unformat($singer_intro)?></textarea>
		</td>
	</tr>
	</table>
	<br>
	<img src="image/singer_album.gif">
	<table width="100%" border=0 cellPadding=3 cellSpacing=1 bgcolor="#a0a0a0">
	<?
	for($i=0;$i<sizeof($album_info);$i++)
	{
		?>
	<tr bgcolor="#ffffff">
		<td width=140 align=center><a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><img src="get_photo.php?photo_type=album&photo_id=<?=$album_info[$i][0]?>" width=120 border=0></a></td>
		<td valign=top>
		专辑名:<a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><?=$album_info[$i][1]?></a><br>
		发布日期:<?=$album_info[$i][2]?><br>
		关注指数:<?=$album_info[$i][4]?><br>
		简介:<div style="text-indent:2em;line-height:130%;word-wrap:break-word"><?=substr($album_info[$i][3],0,180)?> </div>
		</td>
	</tr>
		<?
	}
	if(sizeof($album_info)==0)
	{
		?>
	<tr bgcolor="#ffffff">
		<td height=50 align=center><span style="color:#a0a0a0;font-size:16px">暂时没有专辑</span></td>
	</tr>
		<?
	}
	?>
	</table>
	<?
	if($db->sql_numrows($result5)>0)
	{
		?>
	<br>
	<img src="image/single_song.gif">
	<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor="#ffffff">
	<tr bgcolor="#3399CC">
		<td height="20">序号</td>
		<td>歌曲名</td>
		<td>加入时间</td>
		<td align=center>人气</td>
		<td align=center>播放</td>
		<td align=center>下载</td>
		<td align=center>歌词</td>
	</tr>
	<?
	listTable2($result5);
	?>
	<tr>
		<td colspan=7 align=right><a href="play.php?type=singer_id&value=<?=$singer_id?>">|&gt;单曲连续播放&lt;|</a></td>
	</tr>
	</table>
	<br />
		<?
	}
	comment('music',$singer_id,$album_id);
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