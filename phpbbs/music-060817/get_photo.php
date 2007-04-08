<?
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$photo_id=$_REQUEST['photo_id'];
$photo_type=$_REQUEST['photo_type'];
$sql1="select ".$photo_type."_photo from ".$photo_type."_info where ".$photo_type."_id=".$photo_id;
$photo_data=$db->sql_fetchfield(0,0,$db->sql_query($sql1));
if(strlen($photo_data)>1024)
{
	echo $photo_data;
}
else
{
	echo readfile($phpbbs_root_path.'/music/image/no_photo.jpg');
}
?>
