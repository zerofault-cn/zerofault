<!-- ��ӻ���½�Ŀ��-2, -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$weekday=date("w",$date);
$date=date("Ymd",$date);
//$program=addslashes($program);
$program=htmlspecialchars($program);
$program=str_replace(" ","&nbsp;",$program);
$program=nl2br($program);

$sql1="insert into epg_schedule(station_id,date,weekday,program) values('".$station_id."','".$date."','".$weekday."','".$program."')";

if(mysql_query($sql1))
{
	?>
	<script>
		if(confirm("�ѳɹ����,���������?"))
			window.location="index.php?content=epg_modify_schedule_1&station_id=<?=$station_id?>";
		else
			window.location="index.php?content=epg_station";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("��Ӽ�¼ʧ��,��������,���߱������Ա");
		window.history.go(-1);
	</script>
	<?
}
?>
