<!-- 添加歌手信息-2,涉及文件上传 -->
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$type=$_REQUEST['type'];
$value=$_REQUEST['value'];
$pic=$_FILES['pic'];
if($pic['size']!=0)
{
	$fp=fopen($pic['tmp_name'],"r");
	$pic_data=addslashes(fread($fp,$pic['size']));
	fclose($fp);
}
$sql1="update ".$type."_info set ".$type."_photo='".$pic_data."' where ".$type."_id=".$value;
if($db->sql_query($sql1))
{
	?>
	<script>
		alert("上传成功!");
		window.opener.location.reload();
		window.close();
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
?>
