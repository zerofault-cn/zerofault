<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from bt_file_info where file_id='".$file_id."'";
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
