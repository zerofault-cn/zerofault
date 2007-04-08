<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select id,source from daily_source where type='".$type."' order by id desc limit 20,-1";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r[0];
	$source=$r[1];
	$list_path='../daily_list/'.$source;
	$source_path='../daily_source/'.str_replace('list__','',$source);
	echo $id.':';
	echo '删除文件:';
	echo $source_del=unlink($source_path);
	echo '删除列表:';
	echo $list_del=unlink($list_path);
	$sql2="delete from daily_source where id=".$id;
	echo '删除记录:';
	echo mysql_query($sql2);
	echo '<br>';
}
?>
