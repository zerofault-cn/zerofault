<%@ page language="java" import="java.sql.*,java.io.*,goldsoft.*" %>
<!-- ɾ��prog_info���¼,ɾ����Ӧ�ļ�,��Ӱ�����ֹ��� -->
<%
Opendb opendb = new Opendb();
String del_flag=request.getParameter("del_flag");
String page_from=request.getParameter("page_from");
String prog_id=request.getParameter("prog_id");
if(del_flag.equals("record"))
{
	String query1="delete from prog_info where prog_id='"+prog_id+"'";
	int r=opendb.executeUpdate(query1);
	if(r!=0)
	{
		%>
		<script>
			alert("��¼�ѳɹ�ɾ��");
			window.location="index.jsp?content=<%=page_from%>";
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("ɾ����¼ʱ��������,��������!");
			window.history.go(-1);
		</script>
		<%
	}
	opendb.dbclose();
}
if(del_flag.equals("file"))
{
	String query1="select prog_path from prog_info where prog_id='"+prog_id+"'";
	ResultSet rs=opendb.executeQuery(query1);
	rs.next();
	String prog_path=rs.getString(1).trim();
	String realpath="/dpfs/"+prog_path;
	File f=new File(realpath);
	if(f.delete())
	{
		%>
		<script>
			alert("�ļ��ѳɹ�ɾ��");
			window.location="index.jsp?content=<%=page_from%>";
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("ɾ���ļ�ʱ��������,��������!");
			window.history.go(-1);
		</script>
		<%
	}
	opendb.dbclose();
}
%>
