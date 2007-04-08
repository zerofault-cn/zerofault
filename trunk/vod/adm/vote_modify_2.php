<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update vote_subject set title='".$title."',begin_date='".$begin_date."',end_date='".$end_date."',mode='".$mode."' where id='".$subject_id."'";
if(mysql_query($sql1))
{
	$item_tmp=explode("\r\n",$item_text);
	$item_id_tmp=explode('|',$item_id);
	for($i=0;$i<count($item_id_tmp);$i++)
	{
		$item_id=$item_id_tmp[$i];
		$item_title=$item_tmp[$i];
		if($item_title=='')
		{
			echo $sql2="delete from vote_item where id='".$item_id."'";
			echo '<br>';
		}
		else
		{
			echo $sql2="update vote_item set item='".$item_title."' where id='".$item_id."'";
			echo '<br>';
		}
		$result2=mysql_query($sql2);
	}
	for($i=count($item_id_tmp);$i<count($item_tmp),$item_tmp[$i]!='';$i++)
	{
		echo $sql2="insert into vote_item(subject_id,item) values('".$subject_id."','".$item_tmp[$i]."')";
		echo '<br>';
		$result2=mysql_query($sql2);
	}
	if($result2)
	{
		?>
		<script>
			alert("修改成功");
			window.opener.location.reload();
			window.close();
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("修改2失败,请检查重试,或者报告管理员");
			window.history.go(-1);
		</script>
		<?
	}
}
else
{
	?>
	<script>
		alert("修改1失败,请检查重试,或者报告管理员");
		window.history.go(-1);
	</script>
	<?
}
?>
