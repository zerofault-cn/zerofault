<?php
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$song_id=$_REQUEST['song_id'];
$type=$_REQUEST['type'];
$value=$_REQUEST['value'];
if(!$type)
{
	$sql1="select * from song_info where song_id=".$song_id;
	$result1=$db->sql_query($sql1);
	$song_name=$db->sql_fetchfield('song_name',0,$result1);
	$song_path=$db->sql_fetchfield('song_path',0,$result1);
	if(!file_exists('F:/'.$song_path))
	{
		?>
		<script>
			alert('对不起，文件暂不存在!');
			history.go(-1);
		</script>
		<?
		exit;
	}
	$playpath='http://'.$_SERVER["SERVER_ADDR"].'/'.$song_path;
	$sql2="update song_info set song_count=song_count+1 where song_id=".$song_id;
	$db->sql_query($sql2);
	$content="#EXTINF:0,".$song_name."\n".$playpath;
}
else
{
	if($type=='singer_id')
	{
		$sql_ext=' album_id=0 and ';
	}
	$sql1="select * from song_info where ".$sql_ext.$type."=".$value;
	$result1=$db->sql_query($sql1);
	$sql2="update song_info set song_count=song_count+1 where ".$sql_ext.$type."=".$value;
	$db->sql_query($sql2);
	$i=0;
	while($r=$db->sql_fetchrow($result1))
	{
		$song_id=$r["song_id"];
		$song_name=$r["song_name"];
		$song_path=$r["song_path"];
	//	if(!file_exists('F:/'.$song_path))
		{
			?>
			<script>
	//			alert('对不起，文件暂不存在!');
	//			history.go(-1);
			</script>
			<?
	//		exit;
		}
		$playpath='http://'.$_SERVER["SERVER_ADDR"].'/'.$song_path;
		$content.="#EXTINF:".++$i.",".$i.' '.$song_name."\n".$playpath."\n";
	}
}
Header("Content-Type: audio/x-mpegurl");
$content="#EXTM3U\n".$content;
echo $content;
?>
