<!-- ɾ������ -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="delete from singer_info where singer_id='".$singer_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�ѳɹ�ɾ������");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("ɾ������ʱ��������,��������!");
		window.history.go(-1);
	</script>
	<?
}
?>
