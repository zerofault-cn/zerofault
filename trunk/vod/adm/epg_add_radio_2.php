<!-- 添加电视/电台频道-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select * from epg_station where type='".$type."' and station_path='".$station_path."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库已存在相同路径,您可以选择改名");
		location="index.php?content=epg_station";
	</script>
	<?
}
else
{
	$sql2="select max(station_id) from epg_station";
	$result2=mysql_query($sql2);
	$station_id=mysql_result($result2,0,0);
	$station_id=$station_id+1;
	$sql2="insert into epg_station(station_id,station_name,station_path,fps,type,schedule_url,del_flag,zoom_flag,force_flag,sort_id) values('".$station_id."','".$station_name."','".$station_path."','','".$type."','".$schedule_url."',1,0,0,0)";
	if(mysql_query($sql2))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=epg_add_radio_1";
		else
			window.location="index.php?content=epg_station";
		</script>
		<?
	}
	else
	{
		?>
		<script>
		alert("添加记录失败,请检查重试,或者报告管理员");
		window.history.go(-1);
		</script>
		<?
	}
}
?>
