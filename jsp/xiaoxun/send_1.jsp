<%@ page language="java" import="java.sql.*" %>
<html>
<head>
<title>������Ϣ��ѧ���ҳ�</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	
	if(window.document.send_msg.content.value=="")
	{
		alert("��������������");
		document.send_msg.content.focus();
		return false;
	}
	
	return true;
}
</script>
<body>
<center>
<table width=100% border="0" cellpadding="0" cellspacing="0">
<caption>������Ϣ��<span class=red>
<%
String grade=(String)session.getAttribute("grade");
String sname=request.getParameter("sname");
String mobile=request.getParameter("mobile");
String sendtype=request.getParameter("sendtype");
if(sendtype.equals("single"))
	out.println(sname);
else
	out.println(grade+"������ѧ��");

%></span>�ļҳ�</caption>
<form name=send_msg action="send_2.jsp" method=post onsubmit="return check();">
<tr><td align=right>����:</td><td><textarea name=content rows=4 cols=30></textarea></td></tr>
<tr><td></td>
	<td>
	<input type=hidden name=mobile value=<%=mobile%>>
	<input type=hidden name=sendtype value=<%=sendtype%>>
	<input type=submit value=����></td></tr>
</form>
</table>




</center>
</body>
</html>