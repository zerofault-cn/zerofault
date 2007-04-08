<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_class.php';
$music=new Music();

$album_id=$_REQUEST['album_id'];
$sql0="update album_info set album_count=album_count+1 where album_id=".$album_id;
$db->sql_query($sql0);
$sql1="select * from album_info where album_id=".$album_id;
$result1=$db->sql_query($sql1);
$singer_id=$db->sql_fetchfield('singer_id',0,$result1);
$album_name=$db->sql_fetchfield('album_name',0,$result1);
$album_pubdate=$db->sql_fetchfield('album_pubdate',0,$result1);
$album_intro=$db->sql_fetchfield('album_intro',0,$result1);
$album_count=$db->sql_fetchfield('album_count',0,$result1);

$sql2="select * from singer_info where singer_id=".$singer_id;
$result2=$db->sql_query($sql2);
$singer_name=$db->sql_fetchfield('singer_name',0,$result2);
$singer_area_id=$db->sql_fetchfield('singer_area_id',0,$result2);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result2);

$sql3="select * from singer_type where type_id=".$singer_area_id." and type_label=1";
$singer_area=$db->sql_fetchfield('type_name',0,$db->sql_query($sql3));
$sql4="select * from singer_type where type_id=".$singer_chorus_id." and type_label=2";
$singer_chorus=$db->sql_fetchfield('type_name',0,$db->sql_query($sql4));

$sql5="select * from song_info where album_id=".$album_id." order by song_id";
$result5=$db->sql_query($sql5);
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天音乐歌手专辑——<?=$singer_name?>_<?=$album_name?></title>
<link rel="stylesheet" href="../style.css" type="text/css">
<link rel="StyleSheet" href="music.css" type="text/css">
<script type="text/JavaScript" language="javascript" src="music.js"></script>
</head>
<body>
<div id="all">
<?
include_once $phpbbs_root_path.'/top.php';
?>

<div id="left">
<?
$music->musicSearchTable();
$music->menuTable();
$music->hotAlbum5();
$music->hotSong5();
$music->downloadTools();
?>
</div>
<div id="main">
<span id="topNavi">您所在位置:<a href="index.php">音乐首页</a>-&gt;<a href="singer_list.php?list_id=<?=$singer_area_id.$singer_chorus_id?>"><?=$singer_area?><?=$singer_chorus?></a>-&gt;<a href="singer_info.php?singer_id=<?=$singer_id?>"><?=$singer_name?></a>-&gt;<?=$album_name?>:</span>
<br /><br />
<img src="image/album_info.gif">

<div id="albumInfo" style="height:160px;">
<img src="get_photo.php?photo_type=album&photo_id=<?=$album_id?>" width="120" style="margin:8px;float:left">
<div>歌手名:<a href="singer_info.php?singer_id=<?=$singer_id?>"><?=$singer_name?></a></div>
<div>专辑名:<a href="album_info.php?album_id=<?=$album_id?>"><?=$album_name?></a></div>
<div>发布日期:<?=$album_pubdate?></div>
<div>关注指数:<?=$album_count?></div>
简介:<div id="textIntro"><?=$album_intro?></div>
</div>
<br />
<img src="image/album_song.gif">
<?
$music->setLabel(Array(1,1,0,0,1,1,1,1,1));
$music->songListLabel();
if($db->sql_numrows($result5)==0)
{
	?>
	<div id="songList" style="text-align:center">暂时没有歌曲</div>
	<?
}
else
{
	$music->songList($result5);
	?>
<div id="more"><a href="play.php?type=album_id&value=<?=$album_id?>">|&gt;播放整张专辑&lt;|</a></div>
	<?
}
$music->comment('music',$singer_id,$album_id);
?>
</div>
<?
include_once $phpbbs_root_path.'/footer.php';
?>
</div><!-- all end -->
</body>
</html>
<?
ob_end_flush();
?>