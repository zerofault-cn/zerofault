<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select source from daily_source where id='".$id."'";
$result1=mysql_query($sql1);
$source=mysql_result($result1,0,0);
$list_path='../daily_list/'.$source;
$source_path='../daily_source/'.str_replace('list__','',$source);
if(file_exists($source_path))
{
	$source_del=unlink($source_path);
}
else
{
	$source_del=1;
}
if(file_exists($list_path))
{
	$list_del=unlink($list_path);
}
else
{
	$list_del=1;
}
$sql2="delete from daily_source where id=".$id;
if($source_del&&$list_del&&mysql_query($sql2))
{
	$sql3="update daily_source set del_flag='-1' where id=".$id;
	mysql_query($sql3);
	?>
	<script>
		alert("删除成功");
		window.location="<?=$_COOKIE['last_uri']?>";
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
