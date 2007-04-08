<!-- 修改用户资料-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "update admin_info set admin_name='".$admin_name."',del_flag='".$del_flag."' where admin_id='".$admin_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>
