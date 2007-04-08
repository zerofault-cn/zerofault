<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 修改prog_info表信息,电影和音乐公用 -->
<%
String goldsoft_admin=(String)session.getAttribute("goldsoft_admin");
Opendb opendb = new Opendb();
int prog_id=java.lang.Integer.parseInt(request.getParameter("prog_id"));
int depre_id=java.lang.Integer.parseInt(request.getParameter("depre_id"));
String prog_name=request.getParameter("prog_name");
int prog_stype=java.lang.Integer.parseInt(request.getParameter("prog_stype"));
int prog_format=java.lang.Integer.parseInt(request.getParameter("prog_format"));
int prog_kindfir=java.lang.Integer.parseInt(request.getParameter("prog_kindfir"));
int prog_kindsec=java.lang.Integer.parseInt(request.getParameter("prog_kindsec"));
int prog_kindthr=java.lang.Integer.parseInt(request.getParameter("prog_kindthr"));
int prog_kindfor=java.lang.Integer.parseInt(request.getParameter("prog_kindfor"));
String prog_path=request.getParameter("prog_path");
int prog_size=java.lang.Integer.parseInt(request.getParameter("prog_size"));
int prog_timespan=java.lang.Integer.parseInt(request.getParameter("prog_timespan"));
String publisher=request.getParameter("publisher");
String pubdate=request.getParameter("pubdate");
String director=request.getParameter("director");
String prog_acot=request.getParameter("prog_acot");
String prog_describe=request.getParameter("prog_describe");
int del_flag=java.lang.Integer.parseInt(request.getParameter("del_flag"));
int prog_limit=java.lang.Integer.parseInt(request.getParameter("prog_limit"));

String sql="update prog_info set depre_id="+depre_id+",prog_name='"+prog_name+"',prog_stype="+prog_stype+",prog_format="+prog_format+",prog_kindfir="+prog_kindfir+",prog_kindsec="+prog_kindsec+",prog_kindthr="+prog_kindthr+",prog_kindfor="+prog_kindfor+",prog_path='"+prog_path+"',prog_size="+prog_size+",prog_timespan="+prog_timespan+",publisher='"+publisher+"',pubdate='"+pubdate+"',director='"+director+"',prog_acot='"+prog_acot+"',prog_describe='"+prog_describe+"',del_flag="+del_flag+",operator='"+goldsoft_admin+"',operdate=CURDATE(),opertime=CURTIME(),prog_limit="+prog_limit+" where prog_id="+prog_id;
int r=opendb.executeUpdate(sql);
if(r!=0)
{
	%>
	<script>
		alert("修改成功!");
		window.close();
	</script>
	<%
}
else
{
	%>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>