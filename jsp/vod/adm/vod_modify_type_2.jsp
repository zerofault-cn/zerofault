<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- �޸ĵ�Ӱ�����Ϣ-2 -->
<%
String goldsoft_admin=(String)session.getAttribute("goldsoft_admin");
Opendb opendb = new Opendb();
int dentry_id=java.lang.Integer.parseInt(request.getParameter("dentry_id"));
String dentry_name=request.getParameter("dentry_name");
String dentry_describe=request.getParameter("dentry_describe");
int del_flag=java.lang.Integer.parseInt(request.getParameter("del_flag"));

String sql="update dict_entry set dentry_name='"+dentry_name+"',dentry_describe='"+dentry_describe+"',del_flag="+del_flag+",operator='"+goldsoft_admin+"',operdate=CURDATE(),opertime=CURTIME() where dentry_id="+dentry_id;
int r=opendb.executeUpdate(sql);
if(r!=0)
{
	%>
	<script>
		alert("�޸ĳɹ�!");
		window.close();
	</script>
	<%
}
else
{
	%>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>