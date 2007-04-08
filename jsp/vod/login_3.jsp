<%@ page import="goldsoft.*,java.sql.*" %>
<%@ page errorPage="error.jsp" %>
<%
String account = request.getParameter("account");
String password = request.getParameter("password");
Opendb opendb = new Opendb();
ResultSet rs = opendb.executeQuery("select * from user_info where user_account='" + account + "' and user_pass='" + password + "'");
if(rs != null && rs.next()) {
	Cookie cookie1=new Cookie("password", password);
	cookie1.setMaxAge(-1);
	response.addCookie(cookie1);
	Cookie cookie2=new Cookie("account", account);
	cookie2.setMaxAge(-1);
	response.addCookie(cookie2);
	Cookie cookie3=new Cookie("goldsoft", "vod");
	cookie3.setMaxAge(-1);
	response.addCookie(cookie3);

	response.sendRedirect("menu_1.jsp");
}
else
	response.sendRedirect("error.jsp?wrong=password");
%>
