<?php
include_once "../include/mysql_connect.php";
$sql1="select max(id) from admin_message";
$result1=mysql_query($sql1);
$maxId=mysql_result($result1,0,0);
$oldId=$_COOKIE['cookie_id'];
setcookie('cookie_id',$maxId,time()+30*24*3600);
//echo $maxId.'.'.$oldId;
if($maxId>$oldId)
{
	?>
	<script>
		alert("���԰����µ�����,��ע��鿴!");
	</script>
	<?
}
?>