<!-- 修改密码-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="UPDATE admin_info SET admin_pass=md5('".$admin_pass."'),operdate=CURDATE(),opertime=CURTIME() WHERE admin_account='".$goldsoft_admin."'";
if(mysql_query($sql1))
{
	?>
	<script>
	alert("密码修改成功！")
	window.location="index.php";
	</script>
	<?
}
else
{
	?>
	<script>
	alert("修改密码失败,请检查重试,或者报告管理员");
	window.history.go(-1);
	</script>
	<?
}
?>