<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>
<!-- ��������Դ -->
<%
Opendb opendb = new Opendb();
//��ѯ��ʾϵͳ������Դ��Ŀ
String sql1="select count(*) from epg_station group by type";//����̨�͵�̨
String sql2="select count(*) from prog_info where prog_kindsec=1006";//���е�Ӱ
String sql3="select count(*) from prog_info where prog_kindsec=1006 and del_flag=1";//��Ч��
String sql4="select count(*) from singer_info";//������
String sql5="select count(*) from prog_info where prog_kindsec=1026";//MTV
String sql6="select count(*) from prog_info where prog_kindsec=1026 and del_flag=1";//��Ч��

ResultSet rs =null;
int radio_count=0;
int tv_count=0;
rs=opendb.executeQuery(sql1);
if(rs!=null&&rs.next())
	radio_count=rs.getInt(1);
if(rs!=null&&rs.next())
	tv_count=rs.getInt(1);

rs=null;
rs=opendb.executeQuery(sql2);
rs.next();
int movie_count=rs.getInt(1);

rs=null;
rs=opendb.executeQuery(sql3);
rs.next();
int right_movie_count=rs.getInt(1);

rs=null;
rs=opendb.executeQuery(sql4);
rs.next();
int singer_count=rs.getInt(1);

rs=null;
rs=opendb.executeQuery(sql5);
rs.next();
int music_count=rs.getInt(1);

rs=null;
rs=opendb.executeQuery(sql6);
rs.next();
int right_music_count=rs.getInt(1);

opendb.dbclose();
%>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
	<td background="image/top_white.gif" colspan=4 height=20 valign=top align=center><img height=16 src="image/message.gif" width=16>ϵͳ��Ϣ</td>
</tr>
<tr>
	<td align=right height=100% rowspan=5 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td align=right width="40%">����̨:</td><td><span style="color:#ee0000"><%=tv_count%></span></td>
	<td align=left height=100% rowspan=5 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
</tr>
<tr>
	<td align=right>��̨:</td><td><span style="color:#ee0000"><%=radio_count%></span></td>
</tr>
<tr>
	<td align=right>��Ӱ:</td><td><span style="color:#ee0000"><%=movie_count%></span><span class=small style="color:blue">[<%=right_movie_count%>]</span></td>
</tr>
<tr>
	<td align=right>������:</td><td><span style="color:#ee0000"><%=singer_count%></span></td>
</tr>
<tr>
	<td align=right>������:</td><td><span style="color:#ee0000"><%=music_count%></span><span class=small style="color:blue">[<%=right_music_count%>]</span></td>
</tr>
<tr>
	<td background="image/bottom_white.gif" colspan=3 height=20></td>
</tr>
</table>