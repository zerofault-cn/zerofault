<!-- 删除prog_info表记录,删除对应文件,电影和音乐公用 -->
<?
include_once "../include/mysql_connect.php";
if($del_flag="file")
{
	$sql1="select prog_path from prog_info where prog_id='".$prog_id."'";
	$result1=mysql_query($sql1);
	$prog_path=mysql_result($result1,0,0);
	if(unlink("/dpfs/".$prog_path))
	{
		?>
		<script>
			alert("文件已成功删除");
			window.location="<?=$lastpage?>";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("删除文件时发生意外,请检查重试!");
			window.history.go(-1);
		</script>
		<?
	}
}
?>
