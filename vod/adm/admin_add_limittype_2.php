<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$dentry_name=$_REQUEST['dentry_name'];
$sql1="select * from dict_entry where dentry_name='".$dentry_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("�Ѵ�����ͬȨ����,��������");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="select max(dentry_id) from dict_entry";
	$result2=mysql_query($sql2);
	$dentry_id=mysql_result($result2,0,0)+1;
	$sql3="insert into dict_entry values('".$dentry_id."','".$dtype_id."','".$dentry_name."','".$dentry_describe."','1','".$goldsoft_admin."','curdate()','curtime()')";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=admin_add_limittype_1";
			else
				window.location="index.php?content=admin_add_limittype_1";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("��Ӽ�¼ʧ��,��������,���߱������Ա");
			window.history.go(-1);
		</script>
		<?
	}
}
?>

