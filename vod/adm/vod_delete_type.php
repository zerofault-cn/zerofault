<!-- 删除电影分类 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from dict_entry where dentry_id='".$dentry_id."'";
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
