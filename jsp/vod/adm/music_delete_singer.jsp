<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ɾ������ -->
<%
Opendb opendb = new Opendb();
String singer_id=request.getParameter("singer_id");
String query1="delete from singer_info where singer_id='"+singer_id+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("�ѳɹ�ɾ������");
		window.location="index.jsp?content=music_singer_list";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("ɾ������ʱ��������,��������!");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
