<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ɾ����Ӱ���� -->
<%
Opendb opendb = new Opendb();
String dentry_id=request.getParameter("dentry_id");
String query1="delete from dict_entry where dentry_id='"+dentry_id+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("�ѳɹ�ɾ��");
		window.location="index.jsp?content=vod_add_type_1";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("ɾ����¼ʱ��������,������!");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
