<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from rss_channel where channel_name='".$channel_name."'";
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
	$sql2="insert into rss_channel(channel_name,channel_description) values('".$channel_name."','".$channel_description."')";
	if(mysql_query($sql2))
	{
		?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=rss_add_channel_1";
			else
				window.location="index.php?content=rss_add_channel_1";
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

