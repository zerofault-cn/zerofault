<!-- �޸��û�����-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "update admin_info set admin_name='".$admin_name."',del_flag='".$del_flag."' where admin_id='".$admin_id."'";
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
