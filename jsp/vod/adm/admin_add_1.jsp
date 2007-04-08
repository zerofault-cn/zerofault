<!-- 添加管理员-1 -->
<%
if(session.getAttribute("goldsoft_admin")==null)
{
	%>
	<script>
		alert("您尚未登录,无权操作");	
		window.history.go(-1);
	</script>
	<%
}
else
{
%>
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
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>添加管理员</caption>
<form action="admin_add_2.jsp" method=post name=add onsubmit="return check()">
<tr><td align=right>管理员帐号:</td><td><input type=text name=admin_account></td></tr>
<tr><td align=right>真实姓名:</td><td><input type=text name=admin_name></td></tr>
<tr><td align=right>密码:</td><td><input type=password name=admin_pass></td></tr>
<tr><td align=right>密码确认:</td><td><input type=password name=admin_repass></td></tr>
<tr><td></td><td><input type=submit value="加入"></td></tr>
</form>
</table>
</center>
<%
}
%>
