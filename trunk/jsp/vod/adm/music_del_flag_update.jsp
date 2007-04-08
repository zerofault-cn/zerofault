<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>

<%
Opendb opendb = new Opendb();
String sql1="";
String sql2="";
int i=0;
int prog_id=0;
String prog_path="";
String realpath="";
File f;
boolean f_exist=false;
int del_flag=-1;
int r=0;
sql1="select prog_id,prog_path from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_path like '%.wmv' order by prog_id";
ResultSet rs=opendb.executeQuery(sql1);
while(rs!=null&&rs.next())
{
	i++;
	prog_id=rs.getInt(1);
	prog_path=rs.getString(2).trim();
	realpath = "/dpfs/" + prog_path;
	f = new File(realpath);
	f_exist=f.exists();
	if(f_exist) 
		del_flag=1;
	else
		del_flag=-1;
	sql2="update prog_info set del_flag="+del_flag+" where prog_id="+prog_id;
	out.println(i+":"+sql2);
	//r=opendb.executeUpdate(sql2);
	if(r==1)
		out.println("<span style='color:red'>ok</span><br>");
}
%>