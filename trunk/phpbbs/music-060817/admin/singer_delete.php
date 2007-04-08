<!-- 删除歌手 -->
<?
@session_start();
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_REQUEST['singer_id'];
$sql1="delete from singer_info where singer_id=".$singer_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("已成功删除歌手");
		window.location="<?=$_SESSION['uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除歌手时发生意外,请检查重试!");
		window.history.go(-1);
	</script>
	<?
}
?>
