<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="loginBean" scope="page" class="MySQL.dbconnect"/>
<%
String tmp_teacher=request.getParameter("teacher");
String tmp_passwd=request.getParameter("passwd");
String query1="select * from teacher where teacher ='"+tmp_teacher+"'";
ResultSet rs=loginBean.executeQuery(query1);
if(tmp_teacher.equals("school")&&tmp_passwd.equals("school"))
{
	session.setAttribute("school","manage");
	session.setAttribute("login_msg","��¼�ɹ�");
	response.sendRedirect("index.jsp");
}
if(!rs.next())
{
	session.setAttribute("login_msg","�û�������,����������");
	response.sendRedirect("index.jsp?content=login_1");
}
else
{
	String passwd=rs.getString("passwd").trim();
	String grade=rs.getString("grade").trim();
	rs.close();
	
	if(!tmp_passwd.equals(passwd))
	{
		session.setAttribute("login_msg","�������,����������");
		out.println("tmp_passwd:"+tmp_passwd+"<br>");
		out.println("login_msg2:"+session.getAttribute("login_msg")+"<br>");
		out.println("tmp_passwd.equals(passwd):"+passwd.equals(tmp_passwd)+"<br>");
		response.sendRedirect("index.jsp?content=login_1");
	}
	else
	{
		session.setAttribute("grade",grade);
		session.setAttribute("login_msg","��¼�ɹ�");
		out.println("session.getattribute(grade):"+session.getAttribute("grade")+"<br>");
		out.println("login_msg3:"+session.getAttribute("login_msg")+"<br>");
		response.sendRedirect("index.jsp");
	}
}
%>


