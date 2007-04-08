<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from server_stat_path where id=".$id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("删除成功");
		window.location="index.php?content=server_stat_add_path_1";
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
