<!--��֤�û��˺��Ƿ�ע��-->
<?php
echo "���ڼ��......";
include_once "../include/mysql_connect.php";
//$user_account=$_GET["useraccount"];
$sql1= "select * from user_info where user_account='".$user_account."'";
$result1= mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("����ʺ��Ѿ�ע��,�뻻һ��!");
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("����ʺŻ�û�б�ע�ᣬ����ʹ��!");
		window.close();
	</script>
	<?
}
?>
