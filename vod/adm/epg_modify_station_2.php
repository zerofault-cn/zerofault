<!-- �޸ĵ��ӵ�̨Ƶ����Ϣ-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update epg_station set station_name='".$station_name."',station_path='".$station_path."',fps=".$fps.",zoom_flag=".$zoom_flag.",del_flag=".$del_flag.",force_flag=".$force_flag.",sort_id=".$sort_id.",pubtype=".$pubtype.",schedule_url='".$schedule_url."' where station_id='".$station_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>
