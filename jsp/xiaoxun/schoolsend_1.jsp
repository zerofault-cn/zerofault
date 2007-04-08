<%@ page language="java" import="java.sql.*" %>
<html>
<head>
<title>发送信息给学生家长</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	
	if(window.document.send_msg.content.value=="")
	{
		alert("您忘了输入内容");
		document.send_msg.content.focus();
		return false;
	}
	
	return true;
}
</script>
<body>
<center>
<table width=100% border="0" cellpadding="0" cellspacing="0">
<caption>发送消息给<span class=red>
<%
String grade=request.getParameter("grade");
String sname=request.getParameter("sname");
String mobile=request.getParameter("mobile");
String sendtype=request.getParameter("sendtype");
if(sendtype.equals("class"))
{
	out.println(grade+"班所有学生");
}
else
{
	out.println("全校学生");
}
%></span>的家长</caption>
<form name=send_msg action="schoolsend_2.jsp" method=post onsubmit="return check();">
<tr><td align=right>内容:</td><td><textarea name=content rows=4 cols=30></textarea></td></tr>
<tr><td></td>
	<td>
	<input type=hidden name=grade value=<%=grade%>>
	<input type=hidden name=mobile value=<%=mobile%>>
	<input type=hidden name=sendtype value=<%=sendtype%>>
	<input type=submit value=发送></td></tr>
</form>
</table>
</center>
</body>
</html>