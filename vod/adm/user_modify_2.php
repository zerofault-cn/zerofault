<!-- 修改用户资料-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$pass="";
if($user_pass!="")
{
	$pass=",user_pass='".$user_pass."'";
}   
$sql2= "update user_info set user_name='".$user_name."',utype_id='".$user_type."',user_chargetype='".$fee_type."',user_limit='".$prog_limit."',user_status='".$user_status."',del_flag='".$user_del."',user_idcard='".$user_idcard."',user_postno='".$user_post."',user_tel='".$user_tel."',user_address='".$user_addr."',user_email='".$user_email.$pass."' where user_id='".$user_id."'";
if(mysql_query($sql2))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>
