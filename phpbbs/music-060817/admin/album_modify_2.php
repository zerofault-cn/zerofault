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
$album_id=$_POST['album_id'];
$singer_id=$_POST['singer_id'];
$album_name=$_POST['album_name'];
$album_pubdate=$_POST['album_pubdate'];
$album_intro=$_POST['album_intro'];
$sql1="update album_info set singer_id=".$singer_id.",album_name='".$album_name."',album_pubdate='".$album_pubdate."',album_intro='".format($album_intro)."' where album_id=".$album_id;
if($db->sql_query($sql1))
{
	?>
	<script>
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>