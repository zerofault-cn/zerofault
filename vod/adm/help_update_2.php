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
$sql1="update help set info='".format($info)."' where type1='".$type1."' and type2='".$type2."'";
if(mysql_query($sql1))
{
	?>
	<script>
	alert("�޸ĳɹ�!");
	window.location="index.php?content=help_update_1";
	</script>
	<?
}
else
{
	?>
	<script>
	alert("�޸�ʧ��,��������,���߱������Ա");
	window.history.go(-1);
	</script>
	<?
}
?>