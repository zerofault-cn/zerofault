<?
include_once "../include/mysql_connect.php";
$sql1="select singer_id from singer_info order by singer_id";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$singer_id=$r[0];
	$sql2="select count(*) from song_info where singer_id=".$singer_id." and del_flag=1";
	$mp3_count=mysql_result(mysql_query($sql2),0,0);
//	$sql3="select count(*) from prog_info where publisher=".$singer_id." and prog_kindsec=1026 and del_flag=1";
//	$mtv_count=mysql_result(mysql_query($sql3),0,0);
	$sql4="update singer_info set mp3_count=".$mp3_count." where singer_id=".$singer_id;
	if(mysql_query($sql4))
	{
		echo $singer_id.':'.$mp3_count.'-> ok!<br>';
	}
	else
	{
		echo 'error<br>';
	}
}
?>