<!-- �޸ĵ�Ӱ�����Ϣ-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update flash_type set type_name='".$type_name."',descr='".$type_descr."',del_flag=".$del_flag." where id=".$id;
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