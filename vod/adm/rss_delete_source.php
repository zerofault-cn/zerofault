<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from rss_source where id='".$id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�ѳɹ�ɾ��");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("ɾ����¼ʱ��������,������!");
		window.history.go(-1);
	</script>
	<?
}
?>
