<%@ page language="java" import="java.sql.*" %>
<html>
<head>
<title>�鿴��Ϣ</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
</head>

<body>
<center>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String id=request.getParameter("id");
String sname=request.getParameter("sname");
String query1="select readflag,mobile,sendtime,message from feedback where id='"+id+"'";
ResultSet rs=user.executeQuery(query1);
rs.next();
String readflag=rs.getString("readflag").trim();
String mobile=rs.getString("mobile").trim();
String sendtime=rs.getString("sendtime").trim();
String message=rs.getString("message").trim();
rs.close();
//out.println("readflag="+readflag);
//out.println("id="+id);

if(readflag.equals("0"))
{
	String query2="update feedback set readflag='1' where id='"+id+"'";
	int r=user.executeUpdate(query2);
	if(r==0)
	{
		out.println("Update readflag error");
	}
}
%>
<table width=300 border="1" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa>
<caption>�鿴�ҳ�����</caption>
<tr><td width=80 align=right>ѧ������:</td><td><%=sname%></td></tr>
<tr><td align=right>����ʱ��:</td><td><%=sendtime%></td></tr>
<tr><td align=right valign=center>����:</td><td><%=message%></td></tr>

</table>
<br>
<input type=button value="�رմ���" onclick="javascript:window.close();">
</center>
</body>
</html>