<%@ page language="java"%>
<html>
<head>
<title>登录</title>
</head>
<script language="javascript">
function check()
{
	if(window.document.login.teacher.value=="")
	{
		alert("您忘了输入用户名");
		document.login.teacher.focus();
		return false;
	}
	if(window.document.login.passwd.value=="")
	{
		alert("您忘了输入密码");
		document.login.passwd.focus();
		return false;
	}
	return true;
}
</script>

<body>
<center>
<%
String login_msg=(String)session.getAttribute("login_msg");
if(login_msg!=null)
{
	%>
	<script>
		alert("<%=login_msg%>");
	</script>
	<%
}
%>
<table>
<caption>请您登录</caption>
<form action="login_2.jsp" name=login method=post>
<tr><td align=right>用户名:</td><td><input type=text name="teacher" value=""></td></tr>
<tr><td align=right>密码:</td><td><input type="password" name="passwd" value=""></td></tr>
<tr><td></td><td><input type="submit" value=登录 onclick="return check();"></td></tr>
</form>
</table>



</center>
</body>
</html>