<?
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$sql="select album_id,album_photo from album_info";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$fp=fopen('albums/'.$row['album_id'].'.jpg',"w");
	if(fwrite($fp,$row['album_photo']))
	{
		echo $i.':'.$row['album_id'];
		echo '<br />';
	}
}
?>
