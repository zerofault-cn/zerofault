<%@ page language="java"%>
<%@ page contentType="text/html;charset=gb2312" %>
<html>
<head>
<title>��ѯ</title>
</head>

<body>
<center>

<table>
<caption>�������ѯ����</caption>
<form action="index.jsp?manage_content=view_tkaoqin" name=login method=post>
<tr><td align=right>�༶:</td><td><input type=text name=grade value=""></td></tr>
<tr><td align=right>��ʦ����:</td><td><input type=text name=sname value=""></td></tr>
<tr><td align=right>��ʼʱ��:</td><td>
<select name=from_year>
	<%
	int i=0;
	for(i=2000;i<=2010;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==2004)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select>
	<select name=from_month>
	<%
	for(i=1;i<=12;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==6)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select>
	<select name=from_day>
	<%
	for(i=1;i<=31;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==15)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select></td></tr>
	<tr><td align=right>����ʱ��:</td><td>
<select name=end_year>
	<%
	
	for(i=2000;i<=2010;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==2004)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select>
	<select name=end_month>
	<%
	for(i=1;i<=12;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==6)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select>
	<select name=end_day>
	<%
	for(i=1;i<=31;i++)
	{
		%>
		<option value=<%=i%>
		<%if(i==15)out.print("selected");%>><%=i%></option>
		<%
	}
	%>
	</select></td></tr>
<tr><td></td><td align=left><input type="submit" value="�ύ��ѯ"></td></tr>
</form>
</table>



</center>
</body>
</html>