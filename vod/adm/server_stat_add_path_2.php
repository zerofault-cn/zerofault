<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from server_stat_path where name='".$name."' or path='".$path."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("已存在相同项目名或路径,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="insert into server_stat_path(name,path,descr) values('".$name."','".$path."','".$descr."')";
	if(mysql_query($sql2))
	{
		?>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=server_stat_add_path_1";
			else
				window.location="index.php?content=server_stat";
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

