<!-- ��Ӹ�����Ϣ-2,�漰�ļ��ϴ� -->
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$type=$_REQUEST['type'];
$value=$_REQUEST['value'];
$pic=$_FILES['pic'];
if($pic['size']!=0)
{
	$fp=fopen($pic['tmp_name'],"r");
	$pic_data=addslashes(fread($fp,$pic['size']));
	fclose($fp);
}
$sql1="update ".$type."_info set ".$type."_photo='".$pic_data."' where ".$type."_id=".$value;
if($db->sql_query($sql1))
{
	?>
	<script>
		alert("�ϴ��ɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("��Ӽ�¼ʧ��,��������,���߱������Ա");
		window.history.go(-1);
	</script>
	<?
}
?>
