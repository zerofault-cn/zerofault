<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<table width=100% border="1" cellpadding="0" cellspacing="0" bordercolor=#ffffff rules=cols style="border-width:0.2">
<caption>��ʦ������Ϣ</caption>
<%
	String sname=request.getParameter("sname");
	String grade=request.getParameter("grade");
	String from_year=request.getParameter("from_year");
	String from_month=request.getParameter("from_month");
	if(from_month.length()<2)
	{
		from_month="0"+from_month;
	}
	String from_day=request.getParameter("from_day");
	String end_year=request.getParameter("end_year");
	String end_month=request.getParameter("end_month");
	if(end_month.length()<2)
	{
		end_month="0"+end_month;
	}
	String end_day=request.getParameter("end_day");
	String from_time=from_year+from_month+from_day;
	String end_time=end_year+end_month+end_day;

	if(sname.length()!=0)
		if(grade.length()!=0)
		{
			String query1="select stime,content from kq where sname='"+sname+"' grade='"+grade+"'  and 	stime<='"+end_time+"' and stime>='"+from_time+"'";
			ResultSet rs1=user.executeQuery(query1); 
			%>
			<tr bgcolor=#8888ff>
			<td>����</td>
			<td>�������</td></tr>
			<%
			while(rs1.next())
			{
			%>
			<td><%=rs1.getString("stime")%></td>
			<td><%=rs1.getString("content")%></td></tr>
			<tr><td height=1 colspan=4><img src='image/linepoint.gif' height=1 width=100%></td></tr>
			<%}
		}
		else{
		String query1="select grade,stime,content from kq where sname='"+sname+"'  stime<='"+end_time+"' and stime>='"+from_time+"'";
		ResultSet rs1=user.executeQuery(query1); 
		%>
		<tr bgcolor=#8888ff>
		<td>�༶</td>
		<td>����</td>
		<td>�������</td></tr>
		<%
		while(rs1.next())
		{%>
			<td><%=rs1.getString("grade")%></td>
			<td><%=rs1.getString("stime")%></td>
			<td><%=rs1.getString("content")%></td></tr>
			<tr><td height=1 colspan=4><img src='image/linepoint.gif' height=1 width=100%></td></tr>

		<%
		}
	}
	else
	{
		String query1="select sname,grade,stime,content from kq where stime<='"+end_time+"' and stime>='"+from_time+"'";
		ResultSet rs1=user.executeQuery(query1); 
		%>
		<tr bgcolor=#8888ff>
		<td>����</td>
		<td>�༶</td>
		<td>����</td>
		<td>�������</td></tr>
		<%
		while(rs1.next())
		{
		%>
			<td><%=rs1.getString("sname")%></td>
			<td><%=rs1.getString("grade")%></td>
			<td><%=rs1.getString("stime")%></td>
			<td><%=rs1.getString("content")%></td></tr>
			<tr><td height=1 colspan=4><img src='image/linepoint.gif' height=1 width=100%></td></tr>

		<%
		}
	}%>

</table>