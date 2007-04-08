<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_REQUEST['singer_id'];
$sql1="select * from singer_info where singer_id=".$singer_id;
$singer_photo=$db->sql_fetchfield('singer_photo',0,$db->sql_query($sql1));
echo $singer_photo;
?>
