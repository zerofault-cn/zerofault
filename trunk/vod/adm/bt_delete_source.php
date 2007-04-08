<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from bt_file_info where file_id='".$file_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("已成功删除");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除记录时发生意外,请重试!");
		window.history.go(-1);
	</script>
	<?
}
?>
