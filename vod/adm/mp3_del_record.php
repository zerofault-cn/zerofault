<!-- ɾ��mp3��¼ -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "delete from song_info where id=".$mp3_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("��¼�Ѿ�ɾ����");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("ɾ����¼ʱ��������,�������ԣ�");
		window.history.go(-1);
	</script>
	<?
}
?>