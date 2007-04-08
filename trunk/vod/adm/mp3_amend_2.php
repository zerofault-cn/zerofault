<!-- 修改mp3记录-2 -->
<?
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
$pub_dir='bod/server14_4/mp3_2/';
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
include_once "toPinyin.php";
$sql1="select * from song_info where id=".$mp3_id;
$result1=mysql_query($sql1);
$old_path=mysql_result($result1,0,'path');
$old_singer_id=mysql_result($result1,0,'singer_id');
$old_album_name=mysql_result($result1,0,'album_name');
$old_song_name=mysql_result($result1,0,'song_name');
$old_file_path='/dpfs/'.$old_path;
$has_copy=1;
if($singer_id!=$old_singer_id || $album_name!=$old_album_name || $song_name!=$old_song_name)
{
	$sql2="select singer_name from singer_info where singer_id='".$singer_id."'";
	$result2=mysql_query($sql2);
	$singer_name=mysql_result($result2,0,0);
	$singer_name_py=words(str_replace(' ','_',$singer_name));//将歌手名转换为拼音
	$album_name_py=words(str_replace(' ','_',$album_name));//专辑名转换
	$mp3file_name_py=words(str_replace(' ','_',$song_name));//将歌曲名转换为拼音,只转换中文字符
	$singer_dir='/dpfs/'.$pub_dir.$singer_name_py;
	if(!file_exists($singer_dir))
	{
		umask(000);
		mkdir($singer_dir,0777);
	}	
	$new_file_path=$singer_dir.'/'.$album_name_py.'-'.$mp3file_name_py.'.mp3';
	$path=substr($new_file_path,6);
	if(file_exists($old_file_path))
	{
		if(!rename($old_file_path,$new_file_path))
		{
			$has_copy=0;
		}
	}
}
$sql2="update song_info set song_name='".$song_name."',singer_id='".$singer_id."',album_name='".$album_name."',path='".$path."',lyric='".format($lyric)."',del_flag='".$mp3_del."' where id='".$mp3_id."'";
if($has_copy && mysql_query($sql2))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>