<!--更新-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$xml_file_name=substr($sdp_file_name,0,strpos($sdp_file_name,'.')).'.xml';
$upflag1=copy($sdp_file,"/jbproject/tomcat/goldsoft/php-vod/sdp/".$xml_file_name);
$upflag2=copy($sdp_file,"/jbproject/tomcat/goldsoft/php-vod/sdp/".$sdp_file_name);
$station_path="sdp://sntx.169ol.com:8088/sdp/".$xml_file_name;
$sql1="update epg_station set station_path='".$station_path."',del_flag=1,force_flag=1 where station_id=".$station_id;
if($upflag1&&$upflag2&&mysql_query($sql1))
{
	?>
	<script>
		alert("更新成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
	alert("更新失败,请检查重试,或者报告管理员");
	window.history.go(-1);
	</script>
	<?
}
?>
