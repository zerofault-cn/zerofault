<?
if($goldsoft_admin!="zerofault")
{
	?>
	<script>
		alert("����Ȩ����");
		window.history.go(-1);
	</script>
	<?
}
else
{
	include_once "admin_limit.php";
	include_once "../include/mysql_connect.php";
	$sql1="delete from admin_message where id=".$id." or pid=".$id;
	if(mysql_query($sql1))
	{
		?>
		<script>
			alert("ɾ���ɹ�");
			window.location="index.php?content=message_index";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("ɾ���ļ�ʱ��������,��������!");
			window.history.go(-1);
		</script>
		<?
	}
}
?>