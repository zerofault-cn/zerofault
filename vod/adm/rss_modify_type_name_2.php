<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update rss_type set rss_type_name='".$rss_type_name."',rss_type_descr='".$rss_type_descr."' where rss_type_id='".$rss_type_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("���³ɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
	alert("����ʧ��,��������,���߱������Ա");
	window.history.go(-1);
	</script>
	<?
}
?>