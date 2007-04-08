<!-- 删除mp3文件 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "select path from song_info where id=".$mp3_id;
$sql2="update song_info set del_flag=-1 where id=".$mp3_id;
$result1=mysql_query($sql1);
$path=mysql_result($result1,0,0);
if(unlink("/dpfs/".$path) && mysql_query($sql2))
{
	?>
	<script>
		alert("文件已成功删除!");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除文件时发生意外,请检查重试!");
		window.history.go(-1);
	</script>
	<?
}
?>