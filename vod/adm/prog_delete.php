<!-- ɾ��prog_info���¼,ɾ����Ӧ�ļ�,��Ӱ�����ֹ��� -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
if($del_flag=="record")
{
	$sql1="delete from prog_info where prog_id='".$prog_id."'";
	if(mysql_query($sql1))
	{
		?>
		<script>
			alert("��¼�ѳɹ�ɾ��");
			window.location="<?=$_COOKIE['last_uri']?>";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("ɾ����¼ʱ��������,��������!");
			window.history.go(-1);
		</script>
		<?
	}
}
if($del_flag="file")
{
	$sql1="select prog_path from prog_info where prog_id='".$prog_id."'";
	$result1=mysql_query($sql1);
	$prog_path=mysql_result($result1,0,0);
	if(unlink("/dpfs/".$prog_path))
	{
		$sql2="update prog_info set del_flag='-1' where prog_id=".$prog_id;
		mysql_query($sql2);
		?>
		<script>
			alert("�ļ��ѳɹ�ɾ��");
			window.location="<?=$_COOKIE['last_uri']?>";
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert("ɾ���ļ�ʱ��������,��������!");
			window.history.go(-1);
		</script>
		<?
	}
}
?>
