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
$singer_name=$_POST['singer_name'];
$singer_name_fc=strtoupper($_POST['singer_name_fc']);
$singer_area_id=$_POST['singer_area_id'];
$singer_chorus_id=$_POST['singer_chorus_id'];
$singer_photo=$_FILES['singer_photo'];
$singer_intro=$_POST['singer_intro'];
$sql1="select * from singer_info where binary singer_name='".$singer_name."'";
$result1=$db->sql_query($sql1);
if($db->sql_fetchrow($result1))
{
	?>
	<script>
		alert("此歌手已被添加!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	if(isset($singer_photo)&&$singer_photo['size']!=0)
	{
		$fp=fopen($singer_photo['tmp_name'],"r");
		$photo_data=addslashes(fread($fp,$singer_photo['size']));
		fclose($fp);
	}
	else
	{
		$photo_data='../image/no_photo.jpg';
	}
	$sql2="insert into singer_info values('','".$singer_name."','".$singer_name_fc."','".$photo_data."','".format($singer_intro)."','".$type_area_id."','".$type_chorus_id."')";
	if($db->sql_query($sql2))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="singer_add_1.php";
		else
			window.location="singer_list.php";
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
