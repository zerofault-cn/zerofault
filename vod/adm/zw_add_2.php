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
$sql1="insert into zw_suining(title,type0,type,info,time) values('".$title."','".$type0."','".$type."','".format($info)."',now())";
if(mysql_query($sql1)) 
{
	?>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=zw_add_1";
			else
				window.location="index.php?content=zw_add_1";
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
