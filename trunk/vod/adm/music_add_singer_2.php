<!-- 添加歌手信息-2, -->
<?
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="select *from singer_info where binary singer_name='".$singer_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库已存在相同记录");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="select max(singer_id) from singer_info";
	$result2=mysql_query($sql2);
	$singer_id=mysql_result($result2,0,0);
	$singer_id++;
	if(isset($photo)&&$photo!="")
	{
		$fp=fopen($photo,"r");
		$photo_data=addslashes(fread($fp,filesize($photo)));
		fclose($fp);
	}
	else
	{
		$photo_data="";
	}
	$sql3="insert into singer_info values(".$singer_id.",'".$singer_name."','".strtoupper($singer_name_fc)."','".$photo_data."','".format($introduce)."','".$type_area_id."','".$type_chorus_id."','".$type_other_id."',0,0)";
	if(mysql_query($sql3))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=music_add_singer_1";
		else
			window.location="index.php?content=music_singer_list";
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
