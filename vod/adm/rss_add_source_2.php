<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from rss_source where rss_source_url='".$rss_source_url."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("此URL已存在,请检查重试");
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
				if(confirm("已成功添加,继续添加吗?"))
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
			alert("添加记录失败,请检查重试,或者报告管理员");
			window.history.go(-1);
		</script>
		<?
	}
}
?>