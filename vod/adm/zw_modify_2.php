<?php
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
$sql1="update zw_suining set title='".$title."',info='".format($info)."' where id=".$id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>