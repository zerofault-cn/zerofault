<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- �޸ĵ��ӵ�̨Ƶ����Ϣ-2 -->
<%
Opendb opendb = new Opendb();
String num=request.getParameter("num");
String station = request.getParameter("station");
String path= request.getParameter("path");
String type= request.getParameter("type");
String sql = "update epg_station set station='"+station+"',path='"+path+"',type='"+type+"' where num='"+num+"'";
int r = opendb.executeUpdate(sql);
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
