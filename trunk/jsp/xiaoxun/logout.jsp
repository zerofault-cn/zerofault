<%

if(request.getParameter("type").equals("manage_out")&&session.getAttribute("school")!=null)
{
	session.removeAttribute("school");
	session.removeAttribute("grade");
	session.removeAttribute("login_msg");
//	response.sendRedirect("index.jsp");
}

if(request.getParameter("type").equals("teacher_out")&&session.getAttribute("grade")!=null)
{
	session.removeAttribute("grade");
	session.removeAttribute("login_msg");
	session.removeAttribute("has_noticed");
//	response.sendRedirect("index.jsp");
}

if(session.getAttribute("grade")==null&&session.getAttribute("school")==null)
{
	session.removeAttribute("school");
	session.removeAttribute("grade");
	session.removeAttribute("login_msg");
	response.sendRedirect("index.jsp");
}
else
{
	%>
	<script>
		window.history.go(-1);
	</script>
	<%
}
%>