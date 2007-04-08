<!-- 修改密码-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.amendpassword.admin_pass.value=="")
	{
		alert("您忘了输入新密码");
		document.amendpassword.admin_pass.focus();
		return false;
	}
	if(window.document.amendpassword.admin_repass.value=="")
	{
		alert("您忘了输入确认密码");
		document.amendpassword.admin_repass.focus();
		return false;
	}
	if(window.document.amendpassword.admin_pass.value!=window.document.amendpassword.admin_repass.value)
	{
		alert("新密码前后不一致!");
		document.amendpassword.admin_repass.focus();
		return false;
	}
	return true;
}
</script>
<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>修改密码</caption>
<form action="admin_modify_password_2.php" method=post name=amendpassword onsubmit="return check()">
<tr><td align=right>新密码:</td><td><input type=password name=admin_pass></td></tr>
<tr><td align=right>新密码确认:</td><td><input type=password name=admin_repass></td></tr>
<tr><td></td><td><input type=submit value="修改"></td></tr>
</form>
</table>
</center>
