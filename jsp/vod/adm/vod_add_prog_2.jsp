<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��ӵ�Ӱ��Ŀ-1 -->
<%
String goldsoft_admin=(String)session.getAttribute("goldsoft_admin");
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs=null;
//ȡ�ô��ļ����ٵķ�����
String sql="select count(*),SUBSTRING_INDEX(prog_path, '/', 2) from prog_info where prog_kindsec=1006 group by SUBSTRING_INDEX(prog_path, '/', 2)";
rs=opendb.executeQuery(sql);
int min=0;
int tmp=0;
String min_path="";
String tmp_path="";
if(rs!=null&&rs.next())
{
	min=rs.getInt(1);
	min_path=rs.getString(2).trim();
}
while(rs!=null&&rs.next())
{
	tmp=rs.getInt(1);
	tmp_path=rs.getString(2).trim();
	if(tmp<min)
	{
		min=tmp;
		min_path=tmp_path;
	}
}
//**************************************
String str_prog_kindthr=request.getParameter("prog_kindthr");
String prog_name=request.getParameter("prog_name");
String prog_path=request.getParameter("prog_path");
prog_path=min_path+"/"+prog_path.substring(prog_path.lastIndexOf("\\")+1);
//�������ݿ���Ϊ��
String prog_size=request.getParameter("prog_size");
String prog_timespan=request.getParameter("prog_timespan");
String publisher=request.getParameter("publisher");
String pubdate=request.getParameter("pubdate");
String director=request.getParameter("director");
String prog_acot=request.getParameter("prog_acot");
String prog_describe=request.getParameter("prog_describe");
prog_describe=sr.newline(prog_describe);
prog_describe=sr.transIso(prog_describe);
rs=null;
String sql1="select * from prog_info where prog_name='"+prog_name+"'";
rs=opendb.executeQuery(sql1);
if(rs!=null&&rs.next())
{
	%>
	<script>
		alert("���ݿ��Ѵ���ͬ����¼");
		window.history.go(-1);
	</script>
	<%
}
else
{
	rs=null;
	String sql2="select max(prog_id) from prog_info";
	rs=opendb.executeQuery(sql2);
	int prog_id=0;
	if(rs!=null&&rs.next())
	{
		prog_id=rs.getInt(1);
		prog_id=prog_id+1;
	}
	int depre_id=1;
	int prog_stype=1000;
	int prog_format=1012;
	int prog_kindfir=999;
	int prog_kindsec=1006;
	int prog_kindthr=java.lang.Integer.parseInt(str_prog_kindthr);
	int prog_kindfor=0;
	int del_flag=-1;//Ĭ��Ϊ��Ч,�ļ��ϴ��ɹ��������ֶ�������Ч
	int prog_limit=600;
	String sql3="insert into prog_info values("+prog_id+","+depre_id+",'"+prog_name+"',"+prog_stype+","+prog_format+","+prog_kindfir+","+prog_kindsec+","+prog_kindthr+","+prog_kindfor+",CURDATE(),'"+prog_path+"','"+prog_size+"','"+prog_timespan+"','"+publisher+"','"+pubdate+"','"+prog_acot+"','"+prog_describe+"',"+del_flag+",'"+goldsoft_admin+"',CURDATE(),CURTIME(),'"+director+"',"+prog_limit+")";
	int r=opendb.executeUpdate(sql3);
	if(r!=0)
	{
		%>
		<script>
			alert("��ʾ:����Ҫ�ý��ļ��ϴ���<%=min_path.substring(4)%>Ŀ¼");
			if(confirm("�ѳɹ����,���������?"))
				window.location="index.jsp?content=vod_add_prog_1";
			else
				window.location="index.jsp?content=vod_prog";
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
	opendb.dbclose();
}
%>
