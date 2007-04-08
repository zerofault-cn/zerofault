<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="insert into vote_subject(title,begin_date,end_date,mode) values('".$title."','".$begin_date."','".$end_date."','".$mode."')";
if(mysql_query($sql1))
{
	$subject_id=mysql_insert_id();
	$item=explode("\r\n",$item_text);
	for($i=0;$i<count($item),$item[$i]!='';$i++)
	{
		echo $sql2="insert into vote_item(subject_id,item) values('".$subject_id."','".$item[$i]."')";
		echo '<br>';
		$result2=mysql_query($sql2);
	}
	if($result2)
	{
		?>
		<script>
		alert("添加成功");
		window.location="index.php?content=vote_subject";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("添加失败,请检查重试,或者报告管理员");
			window.history.go(-1);
		</script>
		<?
	}
}
else
{
	?>
	<script>
		alert("添加失败,请检查重试,或者报告管理员");
		window.history.go(-1);
	</script>
	<?
}
?>
