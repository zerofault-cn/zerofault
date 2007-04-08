<!-- 设置用户删除标志 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="UPDATE user_info set del_flag=-1 where user_id='".$user_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("标志已设为删除");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("标志修改时发生意外,请检查重试!");
		window.history.go(-1);
	</script>
	<?
}
?>
