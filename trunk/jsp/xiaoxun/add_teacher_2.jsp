<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="add" scope="page" class="MySQL.dbconnect"/>
<%
String grade=request.getParameter("grade");
String query1="select * from teacher where grade='"+grade+"'";
ResultSet rs1=add.executeQuery(query1);
if(rs1.next())
{
	%>
	<script>
		alert("班级<%=grade%>已存在,请确认重新添加");
		window.history.go(-1);
	</script>
	<%
}
else
{
	String teacher=request.getParameter("teacher");
	String passwd=request.getParameter("passwd");
	String phone=request.getParameter("phone");
	String query2="insert into teacher values('"+teacher+"','"+passwd+"','"+grade+"','"+phone+"')";
	int r=add.executeUpdate(query2);
	if(r!=0)
	{
		%>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.jsp?manage_content=add_teacher_1";
			else
				window.location="index.jsp";
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("添加记录失败,请检查输入,重新添加");
			window.history.go(-1);
		</script>
		<%
	}
}
%>
