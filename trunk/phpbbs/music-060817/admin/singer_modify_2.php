<!-- 修改歌手信息 -->
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
$singer_name=$_POST['singer_name'];
$singer_name_fc=$_POST['singer_name_fc'];
$singer_area_id=$_POST['singer_area_id'];
$singer_chorus_id=$_POST['singer_chorus_id'];
$singer_intro=$_POST['singer_intro'];
$sql1="update singer_info set singer_name='".$singer_name."',singer_name_fc='".strtoupper($singer_name_fc)."',singer_area_id=".$singer_area_id.",singer_chorus_id=".$singer_chorus_id.",singer_intro='".format($singer_intro)."' where singer_id=".$singer_id;
if($db->sql_query($sql1))
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