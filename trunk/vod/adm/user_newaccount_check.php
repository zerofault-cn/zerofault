<!--验证用户账号是否注册-->
<?php
echo "正在检测......";
include_once "../include/mysql_connect.php";
//$user_account=$_GET["useraccount"];
$sql1= "select * from user_info where user_account='".$user_account."'";
$result1= mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("这个帐号已经注册,请换一个!");
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("这个帐号还没有被注册，可以使用!");
		window.close();
	</script>
	<?
}
?>
