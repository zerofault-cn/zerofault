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

$sql1="insert into bianmin(city,type,title,info,time) values('".$city."','".$type."','".$title."','".format($info)."',now())";

if(mysql_query($sql1))
{
	?>
	<script>
		if(confirm("�ѳɹ����,���������?"))
			window.location="index.php?content=bm_add_1";
		else
			window.location="index.php?content=bm_source";
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
