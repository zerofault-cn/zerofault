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
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>