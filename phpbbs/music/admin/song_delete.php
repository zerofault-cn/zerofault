<!-- ɾ������ -->
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_GET['singer_id'];
$song_id=$_GET['song_id'];

$sql1="delete from song_info where song_id=".$song_id;
if($db->sql_query($sql1))
{
	?>
<script>
	alert("�ѳɹ�ɾ������!");
	window.location="singer_info.php?singer_id=<?=$singer_id?>";
</script>
<?
}
else
{
	?>
<script>
	alert("ɾ������ʱ��������,����ϵ����Ա!");
	window.history.go(-1);
</script>
	<?
}

?>
