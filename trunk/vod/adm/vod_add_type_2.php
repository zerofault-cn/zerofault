<!-- 添加电影类别-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from dict_entry where dentry_name='".$dentry_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("类别'<?=$dentry_name?>'已经有了,添加其他类别吧!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$dtype_id=50;
//	$dentry_describe=addslashes($dentry_describe);
	$del_flag=1;
	$sql2="select max(dentry_id) from dict_entry";
	$result2=mysql_query($sql2);
	$dentry_id=mysql_result($result2,0,0);
	$dentry_id++;
	$sql3="insert into dict_entry values(".$dentry_id.",".$dtype_id.",'".$dentry_name."','".$dentry_describe."',".$del_flag.",'".$goldsoft_admin."',CURDATE(),CURTIME())";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=vod_add_type_1";
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
