<!-- 添加歌手信息-2, -->
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
$singer_id=$_POST['singer_id'];
$album_name=$_POST['album_name'];
$album_pubdate=$_POST['album_pubdate'];
$album_photo=$_FILES['album_photo'];
$album_intro=$_POST['album_intro'];
$sql1="select * from album_info where binary singer_id=".$singer_id." album_name='".$album_name."'";
$result1=$db->sql_query($sql1);
if($db->sql_fetchrow($result1))
{
	?>
	<script>
		alert("此专辑已被添加!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	if(isset($album_photo)&&$album_photo['size']!=0)
	{
		$fp=fopen($album_photo['tmp_name'],"r");
		$photo_data=addslashes(fread($fp,$album_photo['size']));
		fclose($fp);
	}
	else
	{
		$photo_data='../image/no_photo.jpg';
	}
	$sql2="insert into album_info values('','".$singer_id."','".$album_name."','".$album_pubdate."','".format($album_intro)."','".$photo_data."','')";
	if($db->sql_query($sql2))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="album_add_1.php?singer_id=<?=$singer_id?>";
		else
			window.location="singer_info.php?singer_id=<?=$singer_id?>";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("添加记录失败,请检查重试,或者报告管理员");
			window.history.go(-1);
		</script>
		<?
	}
}
?>
