<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String id=request.getParameter("id");
String query1="select * from student where id='"+id+"'";
ResultSet rs1=user.executeQuery(query1);
if(rs1.next())
{
	%>
	<script>
		alert("����Ϊ<%=id%>��ѧ���Ѵ���,��ȷ���������");
		window.history.go(-1);
	</script>
	<%
}
else
{
	String sname=request.getParameter("sname");
	String grade=(String)session.getAttribute("grade");
	String mobile=request.getParameter("mobile");
	String ssn=request.getParameter("ssn");
	String haveLunch=request.getParameter("haveLunch");
	String query2="insert into student (id,sname,grade,mobile,flag,sendnum,recnum,elunch,ssn)values('"+id+"','"+sname+"','"+grade+"','"+mobile+"','0','0','0','"+haveLunch+"','"+ssn+"')";
	int r=user.executeUpdate(query2);
	if(r!=0)
	{
		%>
		<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.jsp?content=add_student_1";
			else
				window.location="index.jsp";
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("��Ӽ�¼ʧ��,��������,�������");
			window.history.go(-1);
		</script>
		<%
	}
}
%>
