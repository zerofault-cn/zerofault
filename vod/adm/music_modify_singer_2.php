<!-- 修改歌手信息 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update singer_info set singer_name='".$singer_name."',singer_name_fc='".strtoupper($singer_name_fc)."',type_area_id=".$type_area_id.",type_chorus_id=".$type_chorus_id.",type_other_id=".$type_other_id.",introduce='".$introduce."' where singer_id=".$singer_id;
if(mysql_query($sql1))
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