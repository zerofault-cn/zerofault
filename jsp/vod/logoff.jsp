<%@ page errorPage="error.jsp" %>
<%
Cookie cookies[]=request.getCookies();
Cookie sCookie=null;
String sname=null;
String svalue=null;
for(int i=0;i<cookies.length;i++)
{
	sCookie=cookies[i];
	sname=sCookie.getName();
	svalue=sCookie.getValue();
	if(sname!=null&&sname.equals("goldsoft"))
	{
		sCookie.setValue("");
		sCookie.setMaxAge(0);
		break;
	}
}
response.sendRedirect("login_1.jsp");
%>
