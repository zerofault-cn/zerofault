<?
include_once "../include/mysql_connect.php";
$sql1="select id,path from song_info order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$id=$r[0];
	$song_path=$r[1];
	for($i=0;$i<strlen($song_path);$i++)
	{
		if(!ereg("[./()?!,&+a-zA-Z0-9_-]{1}",substr($song_path,$i,1)))
		{
			echo $id.':'.$song_path.'<br>';
		}
	}
}
?>