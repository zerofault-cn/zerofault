<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from daily_type where type_name='".$type_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("已存在相同分类名,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="insert into daily_type(type_name,type_descr) values('".$type_name."','".$type_descr."')";
	if(mysql_query($sql2))
	{
		?>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=daily_add_type_1";
			else
				window.location="index.php?content=daily_type";
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

