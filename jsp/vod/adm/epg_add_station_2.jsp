<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��ӵ���/��̨Ƶ��-2 -->
<%
Opendb opendb = new Opendb();
String station = request.getParameter("station");
String path= request.getParameter("path");
String type= request.getParameter("type");
ResultSet rs;
rs=opendb.executeQuery("select * from epg_station where type='"+type+"' and path='"+path+"'");
if(rs!=null&&rs.next())
{
	%>
	<script>
		alert("���ݿ��Ѵ�����ͬ·��,������ѡ�����");
		location="index.jsp?content=epg_station";
	</script>
	<%
}
else
{
	rs=null;
	rs=opendb.executeQuery("select max(num) from epg_station");
	int num=0;
	if(rs!=null&&rs.next())
	{
		num=rs.getInt(1);
		num=num+1;
		String sql = "insert into epg_station values('"+num+"','" + station + "','" + path + "','" + type + "')";
		int r = opendb.executeUpdate(sql);
		if(r!=0)
		{
			%>
			<script>
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.jsp?content=epg_add_station_1";
			else
				window.location="index.jsp?content=epg_station";
			</script>
			<%
		}
		else
		{
			%>
			<script>
			alert("��Ӽ�¼ʧ��,��������,���߱������Ա");
			window.history.go(-1);
			</script>
			<%
		}
	}
}
opendb.dbclose();
%>
