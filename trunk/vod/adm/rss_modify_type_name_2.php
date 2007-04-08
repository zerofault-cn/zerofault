<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update rss_type set rss_type_name='".$rss_type_name."',rss_type_descr='".$rss_type_descr."' where rss_type_id='".$rss_type_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("更新成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
	alert("更新失败,请检查重试,或者报告管理员");
	window.history.go(-1);
	</script>
	<?
}
?>