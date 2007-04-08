<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="test" scope="page" class="MySQL.dbconnect" />
<%
String sid=request.getParameter("id");
int id=Integer.parseInt(sid);
String sql1="select * from flash where id="+id;
ResultSet rs1=test.executeQuery(sql1);
rs1.next();
String sql2="update flash set count=count+1 where id="+id;
test.executeUpdate(sql2);
%>
<html>
<head>
<title>Flash view</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<center>
<table width="720" cellpadding="0" cellspacing="0" border="1" bordercolor="#d0dce0">
<caption>FLASH预览</caption>
<tr>
	<td>标题</td>
	<td><%=rs1.getString("title")%></td>
	<td>访问次数</td>
	<td><%=rs1.getInt("count")+1%></td>
</tr>
<tr>
	<td>上传者</td>
	<td><%=rs1.getString("user")%></td>
	<td>上传时间</td>
	<td><%=rs1.getString("uptime")%></td>
</tr>
<tr>
	<td>描述</td>
	<td colspan="3"><%=rs1.getString("descr")%></td>
</tr>
<tr>
	<td colspan=4>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="600" height="450"><param name="src" value="<%=rs1.getString("path")%>"><embed pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash" type="application/x-shockwave-flash" width="600" height="450" src="<%=rs1.getString("path")%>"></embed></object>
	</td>
</tr>
</table>
<button onclick="javascript:history.go(-1)">返回</button>
</center>
</body>
</html>
<%
rs1.close();
%>