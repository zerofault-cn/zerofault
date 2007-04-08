<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<script language=javascript>
function confirmdel(name)
{
	var sname="test";
	if(confirm("确实要删除 "+name+" 吗?"))
	{
		window.location="delete_student.jsp?sname="+name;
	}
	else
		return;
}
</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor=#ffffff rules=cols style="border-width:0.2">
<caption>已有用户列表</caption>
<tr bgcolor=#8888ff>
	<td>用户名(用户类型)</td>
	<td>用户权限</td>
	<td>用户状态</td>
	<td>缴费类型</td>
	<td>开户时间</td>
	<td>联系地址</td>
	<td>邮政编码</td>
	<td>详细信息</td>
	<td>删除</td>
</tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr>
	<%
	Opendb opendb = new Opendb();
	String query1="select user_id,user_name,user_limit,user_status,user_chargetype,user_opendate,user_address,user_postno from user_info group by utype_id,user_limit";
	ResultSet rs=user.executeQuery(query1); 
	//需要做复合查询（dict_type)，一次取出..........未完成
	while(rs.next())
	{
		String user_id=rs.getString(1).trim();
		String user_name=rs.getString(2).trim();
		String user_limit=rs.getString(3).trim();
		String user_status=rs.getString(4).trim();
		String user_chargetype=rs.getString(5).trim();
		
		%>
<tr><td><%=id%></td>
     <td><%=sname%></td>
     <td><%=grade%></td>
     <td><%=flag%></td>
     <td><input type=button onclick="window.open('send_1.jsp?sendtype=single&mobile=<%=mobile%>&sname=<%=sname%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=短信通知 <%if(mobile.length()!=11)out.print("disabled");%>></td>
	<td align=center><input type=button onclick="window.open('modify_1.jsp?action=modify_student&id=<%=id%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value="修改"></td>
	<td><input type=button onclick="confirmdel('<%=sname%>');" value="删除"></td>
	</tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr
     
</tr>
<%
	}
opendb.dbclose();
%>

