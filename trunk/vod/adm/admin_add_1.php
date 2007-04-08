<!-- 添加管理员-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.admin_account.value=="")
	{
		alert("您忘了输入您的帐号");
		document.add.admin_account.focus();
		return false;
	}
	if(window.document.add.admin_name.value=="")
	{
		alert("您忘了输入姓名");
		document.add.admin_name.focus();
		return false;
	}
	if(window.document.add.admin_pass.value=="")
	{
		alert("您忘了输入密码");
		document.add.admin_pass.focus();
		return false;
	}
	if(window.document.add.admin_repass.value=="")
	{
		alert("您忘了输入确认密码");
		document.add.admin_repass.focus();
		return false;
	}
	if(window.document.add.admin_pass.value!=window.document.add.admin_repass.value)
	{
		alert("前后密码不一致!");
		document.add.admin_repass.focus();
		return false;
	}
	
	return true;
}
</script>
<center>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加管理员</caption>
<form action="admin_add_2.php" method=post name=add onsubmit="return check()">
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>管理员帐号:</td>
	<td><input type=text name=admin_account></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>真实姓名:</td>
	<td><input type=text name=admin_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>密码:</td>
	<td><input type=password name=admin_pass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>密码确认:</td>
	<td><input type=password name=admin_repass></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="&nbsp;添加&nbsp;"></td>
</tr>
</form>
</table>
</center>
