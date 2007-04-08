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

$sql1="insert into bianmin(city,type,title,info,time) values('".$city."','".$type."','".$title."','".format($info)."',now())";

if(mysql_query($sql1))
{
	?>
	<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=bm_add_1";
		else
			window.location="index.php?content=bm_source";
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
