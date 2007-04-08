<?php
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$song_id=$_REQUEST['song_id'];
$sql1="select * from song_info where song_id=".$song_id;
$result1=$db->sql_query($sql1);
$song_path=$db->sql_fetchfield('song_path',0,$result1);
$downpath='http://'.$_SERVER["HTTP_HOST"].'/'.$song_path;
$sql2="update song_info set song_count=song_count+1 where song_id=".$song_id;
$db->sql_query($sql2);
Header("location:".$downpath);
exit;
?>
