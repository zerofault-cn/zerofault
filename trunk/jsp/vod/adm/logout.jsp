<!-- ¹ÜÀí×¢Ïú -->
<%
if(session.getAttribute("goldsoft_admin")!=null)
	session.removeAttribute("goldsoft_admin");
session.removeAttribute("login_msg");
response.sendRedirect("index.jsp");
%>