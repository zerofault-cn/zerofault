<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update rss_channel set channel_name='".$channel_name."',channel_description='".$channel_description."',del_flag=".$del_flag." where id=".$id;
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