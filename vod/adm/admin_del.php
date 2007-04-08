<!-- 设置用户删除标志 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from admin_info where admin_id='".$admin_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("删除成功");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除失败,请检查重试,或者报告管理员!");
		window.history.go(-1);
	</script>
	<?
}
?>
