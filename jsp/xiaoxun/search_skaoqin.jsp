<%@ page language="java" %>
<html>
<head>
<title>登录</title>
</head>

<body>
<center>

<table>
<caption>请输入查询条件</caption>
<form action="index.jsp?content=view_skaoqin" name=login method=post>
<tr><td align=right>学生姓名:</td><td><input type=text name=sname value=""><span class=red>(为空是查询所有)</span></td></tr>
<tr><td align=right>开始时间:</td><td>
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
	<tr><td align=right>结束时间:</td><td>
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
<tr><td></td><td align=left><input type="submit" value="提交查询"></td></tr>
</form>
</table>



</center>
</body>
</html>