<!-- ɾ��ר�� -->
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_GET['singer_id'];
$album_id=$_GET['album_id'];
$flag=$_GET['flag'];
$sql1="delete from album_info where album_id=".$album_id;
$sql2="delete from song_info where album_id=".$album_id;
$sql3="update song_info set album_id=0 where album_id=".$album_id;
if($flag=='delall')
{
	if($db->sql_query($sql1) && $db->sql_query($sql2))
	{
		?>
	<script>
		alert("�ѳɹ�ɾ��ר��!");
		window.location="singer_info.php?singer_id=<?=$singer_id?>";
	</script>
	<?
	}
	else
	{
		?>
	<script>
		alert("ɾ��ר��ʱ��������,����ϵ����Ա!");
		window.history.go(-1);
	</script>
		<?
	}
}
if($flag=='delalbum')
{
	if($db->sql_query($sql1) && $db->sql_query($sql3))
	{
		?>
	<script>
		alert("�ѳɹ�ɾ��ר��!��������תΪ����");
		window.location="singer_info.php?singer_id=<?=$singer_id?>";
	</script>
	<?
	}
	else
	{
		?>
	<script>
		alert("ɾ��ר��ʱ��������,����ϵ����Ա!");
		window.history.go(-1);
	</script>
		<?
	}
}
?>
