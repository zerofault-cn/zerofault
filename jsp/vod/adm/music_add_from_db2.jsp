<%@ page language="java" import="java.sql.*,goldsoft.*" %>

<%
Opendb opendb = new Opendb();
ResultSet rs=null;
int singer_id=0;
String singer_name="";
String sql1="";
String sql2="";
/************公共变量*************************/
int depre_id=1;
String prog_name="";//name
int prog_stype=1000;
int prog_format=1012;
int prog_kindfir=999;
int prog_kindsec=1006;
int prog_kindthr=0;
int prog_kindfor=0;
//curdate
String prog_path="";//path
int prog_size=0;
int prog_timespan=0;//wordcount
int publisher=0;//singer_id
String pubdate="0000-00-00";
String prog_acot="";//pinyin
String prog_describe="";
int del_flag=-1;
String goldsoft_admin="goldsoft";
//curdate
//curtime
String director="";
String picture="";
int prog_limit=600;
/******************************************/
String file_name="";//文件原名,临时的
String rel_path="";//相对路径,临时的
int i=0;
int r=0;
sql1="select * from movie order by id limit 200,100";
rs=opendb.executeQuery(sql1);
while(rs.next())
{
	i++;
	prog_name		=rs.getString("name").trim();
	prog_kindthr	=rs.getInt("type");
	prog_describe	=rs.getString("introduce").trim();
	prog_acot		=rs.getString("actor").trim();
	picture			=rs.getString("picture").trim();
	prog_path		=rs.getString("path").trim();
	director		=rs.getString("director").trim();
	prog_timespan	=rs.getInt("play_long");

	file_name=prog_path.substring(prog_path.lastIndexOf("/"));
	rel_path=prog_path.substring(0,prog_path.lastIndexOf("/"));
	rel_path=rel_path.substring(rel_path.lastIndexOf("/")+1);
	prog_path="bod/server16_2/movie/"+rel_path+file_name;
	sql2="insert into prog_info(depre_id,prog_name,prog_stype,prog_format,prog_kindfir,prog_kindsec,prog_kindthr,prog_kindfor,prog_indate,prog_path,prog_size,prog_timespan,publisher,pubdate,prog_acot,prog_describe,del_flag,operator,operdate,opertime,director,picture,prog_limit) values("+depre_id+",'"+prog_name+"',"+prog_stype+","+prog_format+","+prog_kindfir+","+prog_kindsec+","+prog_kindthr+","+prog_kindfor+",CURDATE(),'"+prog_path+"','"+prog_size+"','"+prog_timespan+"','"+publisher+"','"+pubdate+"','"+prog_acot+"','"+prog_describe+"',"+del_flag+",'"+goldsoft_admin+"',CURDATE(),CURTIME(),'"+director+"','"+picture+"',"+prog_limit+")";
	out.print(i+":"+sql2);
	//r=opendb.executeUpdate(sql2);
	if(r==1)
		out.println("<span style='color:red'>ok</span><br>");
}
%>
