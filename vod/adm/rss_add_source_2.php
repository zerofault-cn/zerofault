<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from rss_source where rss_source_url='".$rss_source_url."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("��URL�Ѵ���,��������");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="insert into rss_source(rss_source_url,rss_source_name,prefetch) values('".$rss_source_url."','".$rss_source_name."','".$prefetch."')";
	if(mysql_query($sql2)) 
	{
		?>
			<script>
				if(confirm("�ѳɹ����,���������?"))
					window.location="index.php?content=rss_add_source_1";
				else
					window.location="index.php?content=rss_source";
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