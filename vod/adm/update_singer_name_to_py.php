<?
include_once "../include/mysql_connect.php";
include_once "../include/toPinyin.php";
$sql1="select singer_id,singer_name from singer_info order by binary singer_name";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$singer_id=$r[0];
	$singer_name=$r[1];
	$sql2="update singer_info set singer_name_fc='".strtoupper(substr(words(substr($singer_name,0,2)),0,1))."' where singer_id=".$singer_id;
	if(mysql_query($sql2))
	{
		echo "ok<br>";
	}
}
?>
