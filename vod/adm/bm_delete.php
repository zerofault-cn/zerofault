<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from bianmin where id='".$id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�ѳɹ�ɾ��");
		window.location="index.php?content=bm_source";
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
