<!-- ɾ������ -->
<?
@session_start();
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_REQUEST['singer_id'];
$sql1="delete from singer_info where singer_id=".$singer_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�ѳɹ�ɾ������");
		window.location="<?=$_SESSION['uri']?>";
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
