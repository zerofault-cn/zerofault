<!-- ɾ��prog_info���¼,ɾ����Ӧ�ļ�,��Ӱ�����ֹ��� -->
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
			alert("�ļ��ѳɹ�ɾ��");
			window.location="<?=$lastpage?>";
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
