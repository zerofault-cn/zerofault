<!-- 添加电视频道-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$xml_file_name=substr($sdp_file_name,0,strpos($sdp_file_name,'.')).'.xml';
$sql1="select * from epg_station where type='".$type."' and SUBSTRING_INDEX(station_path,'/',-1)='".$xml_file_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库已存在相同路径,请确认重试");
		window.history.go(-1);
	</script>
	<?
}
else
{
//	$tmp_sdp_name=substr($sdp_file_name,0,strpos($sdp_file_name,'.'));
	$upflag=copy($sdp_file,"/jbproject/tomcat/goldsoft/php-vod/sdp/".$xml_file_name);
	$sql2="select max(station_id),max(sort_id) from epg_station";
	$result2=mysql_query($sql2);
	$station_id=mysql_result($result2,0,0);
	$sort_id=mysql_result($result2,0,1);
	$station_id++;
	$sort_id++;
	$station_path="sdp://sntx.169ol.com:8088/sdp/".$xml_file_name;
	$sql3="insert into epg_station(station_id,station_name,station_path,fps,type,schedule_url,del_flag,zoom_flag,force_flag,sort_id,pubtype) values('".$station_id."','".$station_name."','".$station_path."',".$fps.",'".$type."','".$schedule_url."',".$del_flag.",".$zoom_flag.",".$force_flag.",".$sort_id.",".$pubtype.")";
	if($upflag&&mysql_query($sql3))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=epg_add_tv_1";
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
