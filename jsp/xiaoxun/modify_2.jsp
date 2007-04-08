<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="modify" scope="page" class="MySQL.dbconnect"/>
<%
//out.println(request.getParameter("action"));
if(request.getParameter("action").equals("modify_student"))
{
	String id=request.getParameter("id");
	String ssn=request.getParameter("ssn");
	String sname=request.getParameter("sname");
	String grade=request.getParameter("grade");
	String haveLunch=request.getParameter("haveLunch");
	String mobile=request.getParameter("mobile");
	String query1="update student set ssn='"+ssn+"',sname='"+sname+"',grade='"+grade+"',elunch='"+haveLunch+"',mobile='"+mobile+"' where id='"+id+"'";
	int r=modify.executeUpdate(query1);
	if(r!=0)
	{
		%>
		<script>
			alert("修改成功");
			window.close();
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("修改失败,请检查输入");
			window.history.go(-1);
		</script>
		<%
	}
}
if(request.getParameter("action").equals("modify_passwd"))
{
//	String grade=(String)session.getAttribute("grade");
	String grade=request.getParameter("grade");
	String passwd=request.getParameter("passwd");
	String query1="update teacher set passwd='"+passwd+"' where grade='"+grade+"'";
	int r=modify.executeUpdate(query1);
	if(r!=0)
	{
		%>
		<script>
			alert("修改成功");
			window.close();
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("修改失败,请检查输入");
			window.close();
		</script>
		<%
	}
}
if(request.getParameter("action").equals("modify_phone"))
{
//	String grade=(String)session.getAttribute("grade");
	String grade=request.getParameter("grade");
	String phone=request.getParameter("phone");
	String query1="update teacher set phone='"+phone+"' where grade='"+grade+"'";
//	out.println(query1);
	int r=modify.executeUpdate(query1);
	if(r!=0)
	{
		%>
		<script>
			alert("修改成功");
			window.close();
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("修改失败,请检查输入");
			window.close();
		</script>
		<%
	}
}
if(request.getParameter("action").equals("modify_teacher"))
{
	String grade=request.getParameter("grade");
	String teacher=request.getParameter("teacher");
	String query1="update teacher set teacher='"+teacher+"' where grade='"+grade+"'";
	int r=modify.executeUpdate(query1);
	if(r!=0)
	{
		%>
		<script>
			alert("修改成功");
			window.close();
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("修改失败,请检查输入");
			window.close();
		</script>
		<%
	}
}
%>
