<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<script language=javascript>
function confirmdel(name)
{
	var sname="test";
	if(confirm("ȷʵҪɾ�� "+name+" ��?"))
	{
		window.location="delete_student.jsp?sname="+name;
	}
	else
		return;
}
</script>
<table width=100% border="1" cellpadding="0" cellspacing="0" bordercolor="#ffffff" rules="cols" style="border-width:0.2">
<caption>ѧ����ϸ��Ϣ</caption>
<tr bgcolor="#8888ff">
	<td>ѧ������</td>
	<td>ѧ������</td>
	<td>�༶</td>
	<td>�Ƿ�У</td>
	<td>֪ͨ�ҳ�</td>
	<td>�޸�ѧ������</td>
	<td>ɾ��</td></tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width="100%"></td></tr>
	<%
	String grade=(String)session.getAttribute("grade");
	String query1="select id,flag,sname,mobile from student where grade='"+grade+"'";
	String query2="select readflag from feedback where grade='"+grade+"' and readflag='0'";//readflagΪ0��ʾδ��
	ResultSet rs1=user.executeQuery(query1); 
	while(rs1.next())
	{
		String id=rs1.getString("id").trim();
		String flag=rs1.getString("flag");
		String sname=rs1.getString("sname").trim();
                String mobile=rs1.getString("mobile").trim();
		String atSchool="1";
		if(flag.equals(atSchool))
			flag="��У";
		else
			flag="δ��У";
		%>
<tr><td><%=id%></td>
     <td><%=sname%></td>
     <td><%=grade%></td>
     <td><%=flag%></td>
     <td><input type=button onclick="window.open('send_1.jsp?sendtype=single&mobile=<%=mobile%>&sname=<%=sname%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=����֪ͨ <%if(mobile.length()!=11)out.print("disabled");%>></td>
	<td align=center><input type=button onclick="window.open('modify_1.jsp?action=modify_student&id=<%=id%>','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value="�޸�"></td>
	<td><input type=button onclick="confirmdel('<%=sname%>');" value="ɾ��"></td>
	</tr>
<tr><td height=1 colspan=7><img src='image/linepoint.gif' height=1 width=100%></td></tr
     
</tr>
<%
	}
%>
<tr><td colspan=7 align=center><input type=button onclick="window.open('send_1.jsp?sendtype=class','','width=400,height=300,toolbar=no,status=no,resizeable=yes');" value=��ȫ��ѧ���ҳ�������Ϣ></td></tr>
</table>
<%
ResultSet rs2=user.executeQuery(query2);
if(rs2.next())
{
	if(session.getAttribute("has_noticed")==null)
	{
		%>
		<script>
			alert("�����µķ�����Ϣ");
		</script>
		<%
		session.setAttribute("has_noticed","1");
	}
}
rs1.close();
rs2.close();
%>
