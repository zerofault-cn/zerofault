<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update dict_entry set dentry_name='".$dentry_name."',dentry_describe='".$dentry_describe."',del_flag=".$del_flag.",operator='".$goldsoft_admin."',operdate=CURDATE(),opertime=CURTIME() where dentry_id=".$dentry_id;
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