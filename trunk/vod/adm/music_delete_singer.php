<!-- 删除歌手 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from singer_info where singer_id='".$singer_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("已成功删除歌手");
		window.location="<?=$_COOKIE['last_uri']?>";
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
