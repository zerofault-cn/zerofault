<!-- ��ӹ���Ա-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$admin_account=$_REQUEST['admin_account'];
$admin_name=$_REQUEST['admin_name'];
$sql1="select admin_id from admin_info where admin_account='".$admin_account."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("�ʺ� <?=$admin_account?> �Ѵ���,��ȷ���������");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$admin_id=1;
	$sql2="select max(admin_id) from admin_info";
	$result2=mysql_query($sql2);
	$admin_id=mysql_result($result2,0,0);
	$admin_id++;
	$sql3="insert into admin_info values('".$admin_id."','".$admin_account."','".$admin_name."',md5('".$admin_pass."'),'','','1','".$_COOKIE['goldsoft_admin']."',CURDATE(),CURTIME())";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=admin_add_1";
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
