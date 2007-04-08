<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$album_id=$_REQUEST['album_id'];
$sql1="select * from album_info where album_id=".$album_id;
$photo=$db->sql_fetchfield('album_photo',0,$db->sql_query($sql1));
echo $photo;
?>
