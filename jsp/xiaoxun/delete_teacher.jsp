<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String grade=request.getParameter("grade");
String query1="delete from teacher where grade='"+grade+"'";
int r=user.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("删除成功");
		window.location="index.jsp?content=view_teacher";
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
