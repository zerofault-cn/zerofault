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
$sql1="insert into zw_suining(title,type0,type,info,time) values('".$title."','".$type0."','".$type."','".format($info)."',now())";
if(mysql_query($sql1)) 
{
	?>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.php?content=zw_add_1";
			else
				window.location="index.php?content=zw_add_1";
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
