<%@ page language="java" import="java.sql.*" %>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>校园关爱网</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body>
<center>
<jsp:include page="top.jsp"/>

<table width="760" border="0" cellpadding="0" cellspacing="0">
<tr><td width=170 align=center valign=top>
	<table width=170 border="0" cellpadding="0" cellspacing="0">
	<tr><td width=100% align=center>
		<script language=javascript>
			today=new Date();
			function initarray()
			{
				this.length=initarray.arguments.length
				for(var i=0;i<this.length;i++)
				this[i+1]=initarray.arguments[i]  
			}
			var d=new initarray(" 星期日"," 星期一"," 星期二"," 星期三"," 星期四"," 星期五"," 星期六");
			document.write("<font color=#ff0000 style='font-size:10pt;font-family: 宋体'> ",today.getYear(),"年",today.getMonth()+1,"月",today.getDate(),"日",d[today.getDay()+1],"</font>" ); 
		</script></td></tr>
	<tr><td width=100%><img src='image/linepoint.gif' height=1 width=100%></td></tr>
	<tr><td width=100%  align=center>
		<%
		if(session.getAttribute("grade")==null)
		{
			if(session.getAttribute("school")!=null)
			{
				out.println("您只有<span class=purple>校方管理</span>权限");
			}
			else
			{
				out.println("您尚未登录");
			}
		}
		
		else
		{
			%>
			<jsp:include page="grade_info.jsp"/>
			<%
		}
		%></td></tr>
	<tr><td width=100%><img src='image/linepoint.gif' height=1 width=100%></td></tr>

	<tr><td width=100%>
		<jsp:include page="function.jsp"/></td></tr>
	</table></td>
	
	<td width=10 align=middle height=100%><img height="100%" src="image/linepoint.gif" width=1></td>
	
	<td width=580 align=left valign=top>
	<%
	if(session.getAttribute("grade")==null)
	{
		if(session.getAttribute("school")==null)
		{
			%>
			<jsp:include page="login_1.jsp"/>
			<%
		}
		else
		{
			if(request.getParameter("manage_content")==null)
			{
				%>
				<jsp:include page="view_teacher.jsp"/>
				<%
			}
			else
			{
				String mainfile=request.getParameter("manage_content")+".jsp";
				%>
				<jsp:include page="<%=mainfile%>"/>
				<%
			}
		}
	}
	else
	{
		if(request.getParameter("content")==null)
		{
			%>
			<jsp:include page="view_student.jsp"/>
			<%
		}
		else
		{
			String mainfile=request.getParameter("content")+".jsp";
			%>
			<jsp:include page="<%=mainfile%>"/>
			<%
		}
	}
	%>
	</td></tr>
</table>

<jsp:include page="footer.jsp"/>
</center>
</body>
</html>
