<%@ page language="java" import="java.sql.*" %>
<%
if(session.getAttribute("school")==null)
{
	%>
	<script>
		alert("��û��У������Ȩ��");	
		window.history.go(-1);
	</script>
	<%
}
else
{
%>
<script language=javascript>
function confirmdel(grade)
{
	if(confirm("ȷʵҪɾ���༶ "+grade+" ��?"))
	{
		window.location="delete_teacher.jsp?grade="+grade;
	}
	else
		return;
}
</script>
<jsp:useBean id="view" scope="page" class="MySQL.dbconnect"/>
<table width=100% border="1" cellpadding="0" cellspacing="0" bordercolor=#ffffff rules=cols style="border-width:0.2">
<caption>ѧУ���а༶�б�</caption>
<tr bgcolor=#8888ff>
	<td>�༶����</td>
	<td>��ʦ����</td>
	<td>��ʦ��ϵ��ʽ</td>
	<td>����ȫ��֪ͨ</td>
	<td>�޸Ĺ�����ʦ</td>
	<td>ɾ��</td></tr>
<tr><td height=1 colspan=6><img src='image/linepoint.gif' height=1 width=100%></td></tr>
	<%
	String query1="select grade,teacher,phone from teacher";
	ResultSet rs=view.executeQuery(query1);
	while(rs.next())
	{
		String grade=rs.getString("grade").trim();
		String teacher=rs.getString("teacher").trim();
		String phone=rs.getString("phone").trim();
		%>
<tr><td><%=grade%></td>
	<td><%=teacher%></td>
	<td><%=phone%></td>
	<td><input type=button onclick="window.open('schoolsend_1.jsp?sendtype=class&grade=<%=grade%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=����></td>
	<td align=center><input type=button onclick="window.open('modify_1.jsp?action=modify_teacher&grade=<%=grade%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value="�޸�"></td>
	<td><input type=button onclick="confirmdel('<%=grade%>');" value="ɾ��"></td></tr>
<tr><td height=1 colspan=6><img src='image/linepoint.gif' height=1 width=100%></td></tr>
	<%
	}
	rs.close();
	%>
<tr><td colspan=5 align=center><input type=button onclick="window.open('schoolsend_1.jsp?sendtype=school','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=��ȫУѧ���ҳ�������Ϣ></td></tr>
</table>
<%
}
%>