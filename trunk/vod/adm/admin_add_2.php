<!-- 添加管理员-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$admin_account=$_REQUEST['admin_account'];
$admin_name=$_REQUEST['admin_name'];
$sql1="select admin_id from admin_info where admin_account='".$admin_account."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("帐号 <?=$admin_account?> 已存在,请确认重新添加");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$admin_id=1;
	$sql2="select max(admin_id) from admin_info";
	$result2=mysql_query($sql2);
	$admin_id=mysql_result($result2,0,0);
	$admin_id++;
	$sql3="insert into admin_info values('".$admin_id."','".$admin_account."','".$admin_name."',md5('".$admin_pass."'),'','','1','".$_COOKIE['goldsoft_admin']."',CURDATE(),CURTIME())";
	if(mysql_query($sql3))
	{
		?>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=admin_add_1";
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
