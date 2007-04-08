<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_class.php';
$music=new Music();
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天音乐首页——所有单曲列表</title>
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
<?
	$offset=$_REQUEST['offset'];
	$offpage=$_POST['offpage'];
	$allpage=$_POST['allpage'];
	$music->singleSong('all',$offset,$offpage,$allpage);
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