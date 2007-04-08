<!-- 删除mp3记录 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "delete from song_info where id=".$mp3_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("记录已经删除！");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除记录时发生意外,请检查重试！");
		window.history.go(-1);
	</script>
	<?
}
?>