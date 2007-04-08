<?
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$sql1="select id,path from song_info where path like '%server14_3%' order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$id=$r[0];
	$song_path=$r[1];
	$new_song_path=str_replace('server14_3','server14_4',$song_path);
	$sql2="update song_info set path='".$new_song_path."' where id=".$id;
	echo($i.":".$id.":".$song_path.":");
	if(mysql_query($sql2))
	{
		echo "<span style='color:blue'>ok</span><br>";
	}
	else
	{
		echo "<span style='color:red'>error</span><br>";
	}
}
?>