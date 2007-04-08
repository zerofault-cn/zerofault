<?
if($goldsoft_admin!="zerofault")
{
	?>
	<script>
		alert("您无权操作");
		window.history.go(-1);
	</script>
	<?
}
else
{
	include_once "admin_limit.php";
	include_once "../include/mysql_connect.php";
	$sql1="delete from admin_message where id=".$id." or pid=".$id;
	if(mysql_query($sql1))
	{
		?>
		<script>
			alert("删除成功");
			window.location="index.php?content=message_index";
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