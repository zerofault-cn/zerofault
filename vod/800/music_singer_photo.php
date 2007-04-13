<?
$singer_id=$_REQUEST['singer_id'];
$img_file='singer_photo/'.$singer_id.'.jpg';
if(file_exists($img_file))
{
	echo file_get_contents($img_file);
}
else
{
	ob_start();
	include_once "../include/db_connect.php";
	$sql1="select photo from singer_info where singer_id=".$singer_id;
	$result1=$db->sql_query($sql1);
	$photo=$db->sql_fetchfield(0,0,$result1);
	echo $photo;
	$fwp=fopen($img_file,"w"); 
	fwrite($fwp,ob_get_contents());
	fclose($fwp);
	ob_end_flush();
}
?>