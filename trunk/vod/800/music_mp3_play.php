<?php
include_once "../include/db_connect.php";
include_once "../include/getplaypath.php";
$song_id=$_REQUEST['song_id'];
if(!strpos($song_id,'|'))//µ¥Çú
{
	$sql1="select id,album_name,song_name,path,count from song_info where id=".$song_id;
	$result1=$db->sql_query($sql1);
	$r=$db->sql_fetchrow($result1);
	$id=$r["id"];
	$album_name=$r["album_name"];
	$song_name=$r["song_name"];
	$count=$r["count"];
	$path=$r["path"];
	$sql2="update song_info set count=count+1 where id=".$id;
	$db->sql_query($sql2);
	$locate=getLocate($path);
	if($locate=='local')
	{
		$server_ip=getServerIp();
	}
	else
	{
		$server_ip=getIpByPath($path);
	}
	$play_path='http://'.$server_ip.':8088/'.$path;
	$content="#EXTINF:0,".$album_name."-".$song_name."\n".$play_path;
}
else//¶àÊ×
{
	$song_id_str=str_replace('|',',',$song_id);
	$sql1="select id,album_name,song_name,path,count from song_info where id in(".$song_id_str.")";
	$result1=$db->sql_query($sql1);
	while($r=$db->sql_fetchrow($result1))
	{
		$id=$r["id"];
		$album_name=$r["album_name"];
		$song_name=$r["song_name"];
		$count=$r["count"];
		$path=$r["path"];
		$sql2="update song_info set count=count+1 where id=".$id;
		$db->sql_query($sql2);
		$locate=getLocate($path);
		if($locate=='local')
		{
			$server_ip=getServerIp();
		}
		else
		{
			$server_ip=getIpByPath($path);
		}
		$play_path='http://'.$server_ip.':8088/'.$path;
		$content.="#EXTINF:0,".$album_name."-".$song_name."\n".$play_path."\n";
	}
}
Header ("Content-Type: audio/x-mpegurl");
$content="#EXTM3U\n".$content;
echo $content;
?>
