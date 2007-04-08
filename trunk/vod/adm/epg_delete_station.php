<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select SUBSTRING_INDEX(station_path,'/',-1) from epg_station where station_id='".$station_id."'";
$result1=mysql_query($sql1);
$xml_file_name=mysql_result($result1,0,0);
$xml_file_path="/jbproject/tomcat/goldsoft/php-vod/sdp/".$xml_file_name;
if(file_exists($xml_file_path))
{
	$sdp_del=unlink($xml_file_path);
}
else
{
	$sdp_del=1;
}
$sql2="delete from epg_station where station_id='".$station_id."'";
if($sdp_del&&mysql_query($sql2))
{
	?>
	<script>
		alert("已成功删除");
		window.location="index.php?content=epg_station";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除记录时发生意外,请重试!");
		window.history.go(-1);
	</script>
	<?
}
?>
