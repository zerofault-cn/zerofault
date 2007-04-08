<!-- 修改mp3记录-2 -->
<?
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
	$text=addslashes($text);
	return $text;
}
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$song_id=$_POST['song_id'];
$singer_id=$_POST['singer_id'];
$album_id=$_POST['album_id'];
$song_name=$_POST['song_name'];
$song_name=addslashes($song_name);
$song_path=$_POST['song_path'];
$song_path=addslashes($song_path);
$song_lyric=$_POST['song_lyric'];
$song_lyric=addslashes($song_lyric);
$sql1="update song_info set singer_id='".$singer_id."',album_id='".$album_id."',song_name='".$song_name."',song_path='".$song_path."',song_lyric='".$song_lyric."' where song_id='".$song_id."'";
if($db->sql_query($sql1))
{
	?>
	<script>
		alert("修改成功!");
	//	window.opener.location.reload();
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