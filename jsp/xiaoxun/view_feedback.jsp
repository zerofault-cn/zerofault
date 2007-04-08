<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<script language=javascript>
function confirmdel(id)
{
	if(confirm("确实要删除吗"))
	{
		window.location="delete_feedback.jsp?id="+id;
	}
	else
		return;
}
</script>
<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>查看家长反馈信息</caption>
	<tr><td>序号</td>
		<td>状态</td>
		<td>来自学生家长</td>
		<td>发送日期</td>
		<td>查看</td>
		<td>回复</td>
		<td>删除</td></tr>
	<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr>
		<%
		String grade=(String)session.getAttribute("grade");
		String query1="select id,readflag,sname,sendtime,mobile from feedback where grade='"+grade+"'";
		ResultSet rs=user.executeQuery(query1);
		int i=0;
		while(rs.next())
		{
			i++;
			String id=rs.getString("id").trim();
			String readflag=rs.getString("readflag").trim();
			String sname=rs.getString("sname").trim();
			String sendtime=rs.getString("sendtime").trim();
			String mobile=rs.getString("mobile").trim();
                        %>
	<tr><td><%=i%></td>
		<td><%
			if(readflag.equals("1"))
				out.println("已读");
			else
				out.println("未读");
			%></td>
		<td><%=sname%></td>
		<td><%=sendtime%></td>
		<td><input type=button onclick="window.open('view_message.jsp?sname=<%=sname%>&id=<%=id%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=查看></td>
		<td><input type=button onclick="window.open('send_1.jsp?sendtype=single&mobile=<%=mobile%>&sname=<%=sname%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=回复></td>
		<td><input type=button onclick="confirmdel('<%=id%>');" value=删除></td></tr>
	<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr>
		<%
		}
		rs.close();
		%>
	</table>