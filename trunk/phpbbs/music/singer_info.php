<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_class.php';
$music=new Music();

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
<span id="topNavi">您所在位置:<a href="index.php">音乐首页</a>-&gt;<a href="singer_list.php?list_id=<?=$singer_area_id.$singer_chorus_id?>"><?=$singer_area?><?=$singer_chorus?></a>-&gt;<?=$singer_name?>:</span>
<br /><br />
<img src="image/singer_info.gif">
<div>
<div id="singerInfo">
<div id="singerInfoPhoto"><img src="get_photo.php?photo_type=singer&photo_id=<?=$singer_id?>"></div>
<div id="text"><?=$singer_name?></div>
<div id="text"><?=$singer_area?><?=$singer_chorus?></div>
</div>
<div id="singerIntro"><textarea rows="14" cols="58" readonly><?=$music->unformat($singer_intro)?></textarea></div>
</div>
<br /><br />
<img src="image/singer_album.gif">
<?
for($i=0;$i<sizeof($album_info);$i++)
{
	?>
<div id="albumList">
<div id="photo"><a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><img src="get_photo.php?photo_type=album&photo_id=<?=$album_info[$i][0]?>" width="120" border="0"></a></div>
<div>专辑名:<a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><?=$album_info[$i][1]?></a></div>
<div>发布日期:<?=$album_info[$i][2]?></div>
<div>关注指数:<?=$album_info[$i][4]?></div>
简介:<div id="textIntro"><?=substr($album_info[$i][3],0,180)?> </div>
</div>
	<?
}
if(sizeof($album_info)==0)
{
	?>
<div style="border:1px dotted #a0a0a0;margin-bottom:5px;padding:20px 0;font-size:16px;text-align:center;background-color:#eee">暂时没有专辑</div>
	<?
}
if($db->sql_numrows($result5)>0)
{
	?>
<img src="image/single_song.gif">
	<?
	$music->setLabel(Array(1,1,0,0,1,1,1,1,1));
	$music->songListLabel();
	$music->songList($result5);
	?>
<div id="more"><a href="play.php?type=singer_id&value=<?=$singer_id?>">|&gt;单曲连续播放&lt;|</a></div>
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