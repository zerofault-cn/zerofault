<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update rss_channel set channel_name='".$channel_name."',channel_description='".$channel_description."',del_flag=".$del_flag." where id=".$id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>