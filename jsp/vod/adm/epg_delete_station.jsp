<%@ page language="java" import="java.sql.*,goldsoft.*" %>

<%
Opendb opendb = new Opendb();
String num=request.getParameter("num");
String query1="delete from epg_station where num='"+num+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("�ѳɹ�ɾ��");
		window.location="index.jsp?content=epg_station";
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
