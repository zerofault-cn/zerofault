<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_class.php';
$music=new Music();

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
<img src="image/searchresult.gif">
<?
if($num1==0)
{
	?>
	<div style="border:1px dotted #a0a0a0;margin-bottom:5px;padding:20px 0;font-size:16px;text-align:center;background-color:#eee">对不起,没有找到您查询的信息</div>
	<?
}
else
{
	$music->setLabel(Array(1,1,1,1,1,1,1,1,1));
	$music->songListLabel();
	$music->songList($result1);
}
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