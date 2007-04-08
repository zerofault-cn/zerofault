<!-- ÏÔÊ¾mp3¸è´Ê -->
<?
include_once "../include/mysql_connect.php";

$sql1= "select lyric from song_info where id=".$mp3_id;
$result1= mysql_query($sql1);
$lyric= mysql_result($result1,0,0);

echo $lyric;
?>