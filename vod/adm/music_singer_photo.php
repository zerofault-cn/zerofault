<?
include "../include/mysql_connect.php";
$sql0="select photo from singer_info where singer_id=".$singer_id;
$result0=mysql_query($sql0);
$photo=mysql_result($result0,0,0);
//Header("Content-type:image/gif");
echo $photo;
?>
