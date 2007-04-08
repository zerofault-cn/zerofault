<!-- 添加歌手信息-2,涉及文件上传 -->
<?
include_once "../include/mysql_connect.php";
$sql1="select singer_id,photo from singer_info where photo!=''";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$singer_id=$r[0];
	$photo=$r[1];
	$photo_file='../photo/'.$photo;
	if(file_exists($photo_file))
	{
		$fp=fopen($photo_file,"r");
		$photo_data=addslashes(fread($fp,filesize($photo_file)));
		fclose($fp);
	}
	else
	{
		$photo_data='';
	}
	$sql2="update singer_info set photo2='".$photo_data."' where singer_id='".$singer_id."'";
	if(mysql_query($sql2))
	{
		echo 'ok<br>';
	}
	else
	{
		echo 'error<br>';
	}
}
?>
