<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<html>
<head>
<title>�޸ĵ�Ӱ�����Ϣ-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<%
Opendb opendb = new Opendb();
String dentry_id=request.getParameter("dentry_id");
String query1="select * from dict_entry where dentry_id='"+dentry_id+"'";
ResultSet rs=opendb.executeQuery(query1);
rs.next();
int dtype_id=rs.getInt("dtype_id");
String dentry_name=rs.getString("dentry_name").trim();
String dentry_describe=rs.getString("dentry_describe").trim();
int del_flag=rs.getInt("del_flag");
opendb.dbclose();
%>
<form action="vod_modify_type_2.jsp" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�޸ķ�����Ϣ</caption>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input name=dentry_id value="<%=dentry_id%>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ͱ��:</td>
	<td><input name=dtype_id value="<%=dtype_id%>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=dentry_name value="<%=dentry_name%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ч��־:</td>
	<td><select name=del_flag>
		<option value="1" 
		<%
		if(del_flag==1)
			out.print(" selected");
		%>
		>��Ч</option>
		<option value="-1" 
		<%
		if(del_flag==-1)
			out.print(" selected");
		%>
		>��Ч</option></select><span class=small>(������Ϊ��Ч���������������ӰƬ)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=dentry_describe cols=30 rows=4><%=dentry_describe%></textarea></td>
</tr>

<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>