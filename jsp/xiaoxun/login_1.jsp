<%@ page language="java"%>
<html>
<head>
<title>��¼</title>
</head>
<script language="javascript">
function check()
{
	if(window.document.login.teacher.value=="")
	{
		alert("�����������û���");
		document.login.teacher.focus();
		return false;
	}
	if(window.document.login.passwd.value=="")
	{
		alert("��������������");
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
<caption>������¼</caption>
<form action="login_2.jsp" name=login method=post>
<tr><td align=right>�û���:</td><td><input type=text name="teacher" value=""></td></tr>
<tr><td align=right>����:</td><td><input type="password" name="passwd" value=""></td></tr>
<tr><td></td><td><input type="submit" value=��¼ onclick="return check();"></td></tr>
</form>
</table>



</center>
</body>
</html>