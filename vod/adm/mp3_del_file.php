<!-- ɾ��mp3�ļ� -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1= "select path from song_info where id=".$mp3_id;
$sql2="update song_info set del_flag=-1 where id=".$mp3_id;
$result1=mysql_query($sql1);
$path=mysql_result($result1,0,0);
if(unlink("/dpfs/".$path) && mysql_query($sql2))
{
	?>
	<script>
		alert("�ļ��ѳɹ�ɾ��!");
		window.location="<?=$_COOKIE['last_uri']?>";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("ɾ���ļ�ʱ��������,��������!");
		window.history.go(-1);
	</script>
	<?
}
?>