<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from bt_file_type where file_type_name='".$file_type_name."'";
$result1=mysql_query($sql1);
if($r=mysql_fetch_array($result1))
{
	?>
	<script>
		alert("�Ѵ�����ͬ������,��������");
		location=window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="insert into bt_file_type values('".$file_type_id."','".$file_type_name."','".$file_type_descr."')";
	if(mysql_query($sql2))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=bt_add_type_1";
			else
				window.location="index.php?content=bt_add_type_1";
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
