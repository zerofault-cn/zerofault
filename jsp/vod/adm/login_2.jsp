<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ����Ա��¼-2 -->
<%
Opendb opendb = new Opendb();
String admin_account=request.getParameter("admin_account");
String tmp_admin_pass=request.getParameter("admin_pass");
String query1="select admin_pass from admin_info where admin_account ='"+admin_account+"'";
ResultSet rs=opendb.executeQuery(query1);
if(!rs.next())
{
	session.setAttribute("login_msg","�û�������,����������");
	response.sendRedirect("index.jsp?content=login_1");
}
else
{
	String admin_pass=rs.getString(1).trim();
	if(!tmp_admin_pass.equals(admin_pass))
	{
		session.setAttribute("login_msg","�������,����������");
		out.println("tmp_admin_pass:"+tmp_admin_pass+"<br>");
		out.println("login_msg2:"+session.getAttribute("login_msg")+"<br>");
		out.println("tmp_admin_pass.equals(admin_pass):"+admin_pass.equals(tmp_admin_pass)+"<br>");
		response.sendRedirect("index.jsp?content=login_1");
	}
	else
	{
		session.setAttribute("goldsoft_admin",admin_account);
		session.setAttribute("login_msg","��¼�ɹ�");
		out.println("login_msg3:"+session.getAttribute("login_msg")+"<br>");
		response.sendRedirect("index.jsp");
	}
}
opendb.dbclose();
%>


