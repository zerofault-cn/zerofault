<?
include_once "../include/mysql_connect.php";
$sql1="select singer_id from singer_info order by singer_id";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$singer_id=$r[0];
	$sql2="update song_info set del_flag=3 where singer_id=".$singer_id;
	mysql_query($sql2);
}


?>