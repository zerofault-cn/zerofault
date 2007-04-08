<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<%
String search_type=request.getParameter("search_type");
String keyword=request.getParameter("keyword");
String query1="select id,flag,sname,grade,mobile from student where "+search_type+" like '%"+keyword+"%'";
ResultSet rs1=user.executeQuery(query1);
%>
<table width=100% border="1" cellpadding="0" cellspacing="0" bordercolor=#ffffff rules=cols style="border-width:0.2">
<caption>学生详细信息</caption>
<tr bgcolor=#8888ff>
	<td>学生代号</td>
	<td>学生姓名</td>
	<td>班级</td>
	<td>是否到校</td>
	<td>通知家长</td>
	<td>修改学生资料</td>
	<td>删除</td></tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr>
<%
while(rs1.next())
{
	String id=rs1.getString("id").trim();
	String flag=rs1.getString("flag");
	String sname=rs1.getString("sname").trim();
	String grade=rs1.getString("grade").trim();
	String mobile=rs1.getString("mobile").trim();
        String atSchool="1";
	if(flag.equals(atSchool))
		flag="到校";
	else
		flag="未到校";
	%>
<tr><td><%=id%></td>
	<td><%=sname%></td>
	<td><%=grade%></td>
	<td><%=flag%></td>
	<td><input type=button onclick="window.open('send_1.jsp?sendtype=single&mobile=<%=mobile%>&sname=<%=sname%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=短信通知 <%if(mobile.length()!=11)out.print("disabled");%>></td>
	<td align=center><input type=button onclick="window.open('modify_1.jsp?action=modify_student&id=<%=id%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value="修改"></td>
	<td><input type=button onclick="confirmdel('<%=sname%>');" value="删除"></td>
	</tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr>
	<%
}
rs1.close();
%>
</table>