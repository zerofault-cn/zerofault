<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
if(''==$prefetch)
{
	$prefetch=0;
}
$sql1="update rss_source set rss_source_name='".$rss_source_name."',rss_source_url='".$rss_source_url."',del_flag='".$del_flag."',prefetch='".$prefetch."' where id=".$id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>