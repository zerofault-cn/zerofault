<?
$file_ext=substr($mp3file_name,-4);
if($file_ext!=".mp3"&&$file_ext!=".MP3")
{
	?>
	<script>
		alert("这不是一个MP3文件，请重新选择文件!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	include_once "admin_limit.php";
	include_once "../include/mysql_connect.php";
	$sql1="select path from song_info where id=".$mp3_id;
	$sql2="update song_info set del_flag=1 where id=".$mp3_id;
	$result1=mysql_query($sql1);
	$path=mysql_result($result1,0,0);
	$upflag=copy($mp3file,'/dpfs/'.$path);
	if($upflag && mysql_query($sql2))
	{
		?>
		<script>
			alert("提示:文件更新成功!");
			window.opener.location.reload();
			window.close();
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("文件上传失败,请检查重试!");
			window.history.go(-1);
		</script>
		<?
	}
}
?>