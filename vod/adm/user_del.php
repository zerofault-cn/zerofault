<!-- �����û�ɾ����־ -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="UPDATE user_info set del_flag=-1 where user_id='".$user_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("��־����Ϊɾ��");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("��־�޸�ʱ��������,��������!");
		window.history.go(-1);
	</script>
	<?
}
?>
