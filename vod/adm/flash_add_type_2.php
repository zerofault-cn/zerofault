<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from flash_type where type_name='".$type_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("�Ѵ�����ͬ������,��������");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="select max(id) from flash_type";
	$result2=mysql_query($sql2);
	$id=1;
	if($r=mysql_fetch_array($result2))
	{
		$tmp_id=$r[0];
		$id=$tmp_id+1;
	}
	$sql3="insert into flash_type values('".$id."','".$type_name."','".$descr."',1)";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=flash_add_type_1";
			else
				window.location="index.php?content=flash_add_type_1";
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

