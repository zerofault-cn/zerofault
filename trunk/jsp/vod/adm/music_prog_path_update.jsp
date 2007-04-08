<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<%
Opendb opendb = new Opendb();
ResultSet rs=null;
int prog_id=0;
String prog_path="";
String file_name="";//文件原名,临时的
String rel_path="";//相对路径,临时的
int i=0;
int r=0;
String sql2="";
String sql1="select prog_id,prog_path from prog_info where prog_path like '%server16_2%' and prog_path like '%.wmv'";
rs=opendb.executeQuery(sql1);
while(rs.next())
{
	i++;
	prog_id=rs.getInt(1);
	prog_path=rs.getString(2).trim();//mms://ebox.ltl.cn/music1/99tuhonggang1/baba.wmv
	file_name=prog_path.substring(prog_path.lastIndexOf("/"));
	rel_path=prog_path.substring(0,prog_path.lastIndexOf("/"));
	rel_path=rel_path.substring(rel_path.lastIndexOf("/")+1);
	prog_path="bod/server16_1/music/"+rel_path+file_name;
	sql2="update prog_info set prog_path='"+prog_path+"' where prog_id="+prog_id;
	out.print(i+":"+sql2);
	r=opendb.executeUpdate(sql2);
	if(r==1)
		out.println("<span style='color:red'>ok</span><br>");

}
%>
