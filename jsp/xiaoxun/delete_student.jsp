<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String sname=request.getParameter("sname");
String query1="delete from student where sname='"+sname+"'";
int r=user.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("�ѳɹ�ɾ��");
		window.location="index.jsp";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("ɾ����¼ʱ��������,������!");
		window.history.go(-1);
	</script>
	<%
}
%>
