<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update bt_file_type set file_type_name='".$file_type_name."',file_type_descr='".$file_type_descr."' where file_type_id='".$file_type_id."'";
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