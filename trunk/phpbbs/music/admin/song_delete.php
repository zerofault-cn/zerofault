<!-- 删除歌曲 -->
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_GET['singer_id'];
$song_id=$_GET['song_id'];

$sql1="delete from song_info where song_id=".$song_id;
if($db->sql_query($sql1))
{
	?>
<script>
	alert("已成功删除歌曲!");
	window.location="singer_info.php?singer_id=<?=$singer_id?>";
</script>
<?
}
else
{
	?>
<script>
	alert("删除歌曲时发生意外,请联系管理员!");
	window.history.go(-1);
</script>
	<?
}

?>
