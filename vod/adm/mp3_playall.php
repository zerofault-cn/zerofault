<?
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$pageitem=20;
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$sql2="select singer_info.singer_id,singer_info.singer_name,song_info.id,song_info.song_name,song_info.album_name,song_info.path,song_info.lyric,song_info.del_flag from singer_info,song_info where singer_info.singer_id=song_info.singer_id ";
if(isset($key_mp3_name)&&$key_mp3_name!="")
{
	$sql2.=" and song_info.song_name like '%".$key_mp3_name."%' ";
	$caption='query';//为标题显示内容做判断依据
	$newpage_url_ext='&key_mp3_name='.$key_mp3_name;//为翻页时提供变量
}
if(isset($singer_id)&&$singer_id!="")
{
	$sql2.=" and song_info.singer_id='".$singer_id."' ";
	$caption='singer';
	$newpage_url_ext='&singer_id='.$singer_id;
}
if(isset($album_name)&&$album_name!='')
{
	$sql2.=" and binary song_info.album_name='".$album_name."' ";
	$caption='album';
	$newpage_url_ext='&album_name='.$album_name;
}
if(isset($listtype)&&$listtype=='new')
{
	$sql2.=" order by song_info.id desc limit 0,20";
	$caption='new';
}
else
{
	$sql2.=" order by song_info.id desc limit ".$offset.",".$pageitem;
}
$result2=mysql_query($sql2);
while($r=mysql_fetch_array($result2))
{
	$singer_id=$r[0];
	$singer_name=$r[1];
	$id=$r[2];
	$song_name=$r[3];
	$album_name=$r[4];
	$path=$r[5];
	$prog_ip=getIpByPath($path);
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	if($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92)
	{
		$prog_ip=$server_ip;//服务器不是那6台时
	}
	$play_path='http://'.$prog_ip.':8088/'.$path;
	$content.="#EXTINF:".$id.",".$singer_name."-".$album_name."-".$song_name."\n".$play_path."\n";
}
Header ("Content-Type: audio/x-mpegurl");
$content="#EXTM3U\n".$content;
//echo str_replace(" ","%20",$content);
echo $content;
?>

