<!-- 添加用户-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql2="insert into user_info(utype_id,user_account,user_name,user_pass,user_limit,user_idcard,user_postno,user_tel,user_address,user_email,user_balance,user_opendate,operator,operdate,opertime,user_chargetype,user_status) values('".$user_type."','".$user_account."','".$user_name."','".$user_pass."','".$prog_limit."','".$user_idcard."','".$user_post."','".$user_tel."','".$user_addr."','".$user_email."','".$user_firstpay."',CURDATE(),'".$goldsoft_admin."',CURDATE(),CURTIME(),'".$fee_type."','61')";
if(mysql_query($sql2))
{
	?>
	<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=user_add_1";
		else
			window.location="index.php";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("添加用户失败,请检查重试！");
		window.history.go(-1);
	</script>
	<?
}
?>

