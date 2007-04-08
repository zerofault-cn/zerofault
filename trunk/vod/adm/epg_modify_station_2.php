<!-- 修改电视电台频道信息-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update epg_station set station_name='".$station_name."',station_path='".$station_path."',fps=".$fps.",zoom_flag=".$zoom_flag.",del_flag=".$del_flag.",force_flag=".$force_flag.",sort_id=".$sort_id.",pubtype=".$pubtype.",schedule_url='".$schedule_url."' where station_id='".$station_id."'";
if(mysql_query($sql1))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>
