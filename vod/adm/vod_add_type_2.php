<!-- ��ӵ�Ӱ���-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from dict_entry where dentry_name='".$dentry_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("���'<?=$dentry_name?>'�Ѿ�����,�����������!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$dtype_id=50;
//	$dentry_describe=addslashes($dentry_describe);
	$del_flag=1;
	$sql2="select max(dentry_id) from dict_entry";
	$result2=mysql_query($sql2);
	$dentry_id=mysql_result($result2,0,0);
	$dentry_id++;
	$sql3="insert into dict_entry values(".$dentry_id.",".$dtype_id.",'".$dentry_name."','".$dentry_describe."',".$del_flag.",'".$goldsoft_admin."',CURDATE(),CURTIME())";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=vod_add_type_1";
			else
				window.location="index.php";
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
