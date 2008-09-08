<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_class.php';
$music=new Music();

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
$music->setOffset($offset);
$music->setPageitem($pageitem);
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
<title>����ר���б�</title>
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
<span id="topNavi">������λ��:<a href="index.php">������ҳ</a>-&gt;ר���б�:</span>
<br /><br />
<img src="images/newalbum.gif">
<?
for($i=0;$i<sizeof($album_info);$i++)
{
	?>
<div id="albumList">
<div id="photo"><a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><img src="albums/<?=$album_info[$i][0]?>.jpg" onerror="this.src='images/no_photo.jpg';" width="120" border="0"></a></div>
<div>������:<a href="singer_info.php?singer_id=<?=$album_info[$i][5]?>"><?=$album_info[$i][6]?></a></div>
<div>ר����:<a href="album_info.php?album_id=<?=$album_info[$i][0]?>"><?=$album_info[$i][1]?></a></div>
<div>��������:<?=$album_info[$i][2]?></div>
<div>��עָ��:<?=$album_info[$i][4]?></div>
���:<div id="textIntro"><?=substr($album_info[$i][3],0,180)?> </div>
</div>
	<?
}
if(sizeof($album_info)==0)
{
	?>
<div style="border:1px dotted #a0a0a0;margin-bottom:5px;padding:20px 0;font-size:16px;text-align:center;background-color:#eee">��ʱû��ר��</div>
	<?
}
else
{
	$music->pageNavi($rowCount);
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