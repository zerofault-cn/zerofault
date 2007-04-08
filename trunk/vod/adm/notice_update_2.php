<?
include_once "admin_limit.php";

$notice_file="../notice.txt";
$fp=fopen($notice_file,"w"); 
if(!isset($notice)||$notice==''||strlen($notice)==0)
{
	$notice=' ';
}
if(fwrite($fp,$notice)&&fclose($fp))
{
	?>
	<script>
		alert("修改成功！")
		window.location="index.php?content=notice_update_1";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试,或者报告管理员");
		window.history.go(-1);
	</script>
	<?
}
?>