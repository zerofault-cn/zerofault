<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String id=request.getParameter("id");
String query1="delete from feedback where id='"+id+"'";
int r=user.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("已成功删除");
		window.location="index.jsp?content=view_feedback";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("删除记录时发生意外,请重试!");
		window.history.go(-1);
	</script>
	<%
}
%>
