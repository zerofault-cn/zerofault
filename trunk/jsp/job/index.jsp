<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="test" scope="page" class="MySQL.dbconnect" />
<html>
<head>
<title>Flash Test</title>

<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<center>
<table width="720" cellpadding="0" cellspacing="0" border="1" bordercolor="#d0dce0">
<caption>用户已上传FLASH列表</caption>
<tr>
	<td>序号</td>
	<td>标题</td>
	<td>查看次数</td>
	<td>上传者</td>
	<td>上传时间</td>
	<td>描述</td>
</tr>
<%
String sql1="select * from flash";
ResultSet rs1=test.executeQuery(sql1);
int i=1;
while(rs1.next())
{
	out.println("<tr>");
	out.println("\t<td>"+i+"</td>");
	out.println("\t<td><a href=\"view.jsp?id="+rs1.getInt("id")+"\">"+rs1.getString("title")+"</a></td>");
	out.println("\t<td>"+rs1.getInt("count")+"</td>");
	out.println("\t<td>"+rs1.getString("user")+"</td>");
	out.println("\t<td>"+rs1.getString("uptime")+"</td>");
	out.println("\t<td>"+rs1.getString("descr")+"</td>");
	out.println("</tr>");
	i++;
}
rs1.close();
%>
<tr>
	<td colspan="6" align="right"><a href="upload.jsp">上传FLASH</a></td>
</tr>
</table>

</center>
</body>
</html>