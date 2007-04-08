<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select flash_path from flash_source where id='".$id."'";
$result1=mysql_query($sql1);
$flash_path=mysql_result($result1,0,0);
$flashfile_path='/jbproject/tomcat/goldsoft/php-vod/flash/'.$flash_path;
if(file_exists($flashfile_path))
{
	$file_del=unlink($flashfile_path);
}
else
{
	$file_del=1;
}
$sql2="delete from flash_source where id=".$id;
if($file_del&&mysql_query($sql2))
{
	?>
	<script>
		alert("删除成功");
		window.location="index.php?content=flash_source";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("删除文件时发生意外,请检查重试!");
		window.history.go(-1);
	</script>
	<?
}
?>
