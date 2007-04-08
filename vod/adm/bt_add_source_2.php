<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from bt_file_info where file_name='".$file_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库中已经有这个种子名了,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$file_url=time().'.torrent';
	$upflag=copy($torrent_file,"../torrent/".$file_url);
	$sql2="insert into bt_file_info(file_name,file_size,file_url,file_type_id,time) values('".$file_name."','".$file_size."','".$file_url."','".$file_type_id."',now())";
	if($upflag&&mysql_query($sql2))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=bt_add_source_1";
		else
			window.location="index.php";
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
