<!-- �����û�ɾ����־ -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from admin_info where admin_id='".$admin_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("ɾ���ɹ�");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("ɾ��ʧ��,��������,���߱������Ա!");
		window.history.go(-1);
	</script>
	<?
}
?>
