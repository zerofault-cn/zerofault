<!-- �޸�����-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="UPDATE admin_info SET admin_pass=md5('".$admin_pass."'),operdate=CURDATE(),opertime=CURTIME() WHERE admin_account='".$goldsoft_admin."'";
if(mysql_query($sql1))
{
	?>
	<script>
	alert("�����޸ĳɹ���")
	window.location="index.php";
	</script>
	<?
}
else
{
	?>
	<script>
	alert("�޸�����ʧ��,��������,���߱������Ա");
	window.history.go(-1);
	</script>
	<?
}
?>