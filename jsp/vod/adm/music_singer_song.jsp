<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>
<!-- ������Ϣ�����ָ����б� -->
<script language="javascript">
function delrecord(prog_id)
{
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="prog_delete.jsp?del_flag=record&page_from=music_singer_song&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("ȷ��Ҫɾ�����ļ���")&&confirm("ɾ�����޷��ָ�Ŷ�����ȷ�ϣ�"))
	{
		window.location="prog_delete.jsp?del_flag=file&page_from=music_singer_song&prog_id="+prog_id;
	}
	else
		return;
}
function delsinger(singer_id)
{
	if(songcount>0)
	{
		alert("�ø��ֻ���"+songcount+"�׸���,����ɾ���ø���");
		return;
	}
	else
	{
		if(confirm("ȷ��Ҫɾ���ø�����?"))
		{
			window.location="music_delete_singer.jsp?singer_id="+singer_id;
		}
		else
			return;
	}
}
</script>
<%
String singer_id=(String)session.getAttribute("singer_id");
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
GetServerIp getServerIp=new GetServerIp();
String sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher ="+singer_id;
ResultSet rs = opendb.executeQuery(sql1);
int singer_song_count=0;
if(rs != null && rs.next()) {
	singer_song_count = rs.getInt(1);
}
String photo = "";
String introduce = "";
String singer_name="";
String sex="";
rs = null;
String sql2="select singer_name,ifnull(photo,''),introduce from singer_info where singer_id = '" + singer_id + "'";
rs = opendb.executeQuery(sql2);
if(rs != null && rs.next()) 
{
	singer_name=rs.getString(1).trim();
	photo = rs.getString(2).trim();
	if(photo.equals(""))
		photo="no.jpg";
	introduce = rs.getString(3).trim();
}
%>
<table width="100%" border=0 rules=rows cellspacing=0 cellpadding=0 bgcolor=black>
<caption>������Ϣ</caption>
<tr bgcolor=white>
	<td valign=top align=center width=120>
		<img src="/photo/<%=photo%>"><br>
		<%=singer_name%><br>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_name from singer_type,singer_info where type_label=1 and singer_info.singer_id='"+singer_id+"' and singer_info.type_area_id=type_id");
		rs.next();
		out.println("����һ:"+rs.getString(1).trim());
		rs=null;
		rs=opendb.executeQuery("select type_name from singer_type,singer_info where type_label=2 and singer_info.singer_id='"+singer_id+"' and singer_info.type_chorus_id=type_id");
		rs.next();
		out.println("<br>�����:"+rs.getString(1).trim());
		rs=null;
		rs=opendb.executeQuery("select type_name from singer_type,singer_info where type_label=3 and singer_info.singer_id='"+singer_id+"' and singer_info.type_other_id=type_id");
		rs.next();
		out.println("<br>������:"+rs.getString(1).trim());
		%><br>
		<input type=button onclick="window.open('music_modify_singer_1.jsp?singer_id=<%=singer_id%>','','width=450,height=425,toolbar=no,status=no,scrollbars=auto,resizeable=auto');" value="�޸�">
		<input type=button onclick='delsinger(<%=singer_id%>)' value="ɾ��">
		</td>
	<td align=right><textarea rows=15 cols=60 readonly><%=introduce%></textarea></td>
</tr>
</table>

<%
String sql3="select prog_id,prog_name,prog_path,prog_indate,del_flag from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher ="+singer_id+" order by prog_name,prog_id desc,prog_path";
rs=opendb.executeQuery(sql3);
int prog_id=0;
String prog_name="";
String prog_path ="";
String prog_indate="";
int del_flag=0;
String realpath ="";
File f;
int i = 0;
%>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>���</td>
	<td>����</td>
	<td>����</td>
	<td>¼��ʱ��</td>
	<td align=center>�ļ�</td>
	<td align=center>��Ч��</td>
	<td align=center>����</td>
</tr>
<%
while(rs!=null&&rs.next())
{
	i++;
	prog_id=rs.getInt(1);
	prog_name=rs.getString(2).trim();
	prog_path=rs.getString(3).trim();
	prog_indate=rs.getString(4).trim();
	del_flag=rs.getInt(5);
	if(prog_name.length()>18)
		prog_name=prog_name.substring(0,18);
	realpath = "/dpfs/" + prog_path;
	f = new File(realpath);
	%>
<tr bgcolor=white>
	<td><%=i%></td>
	<td><%=prog_name%></td>
	<td><a href="lrtsp://<%=prog_path%>" title="<%=prog_path%>">1</a>|<a href="mms://<%=getServerIp.getIpByPath(prog_path)%>/<%=prog_path%>" title="<%=prog_path%>">2</a></td>
	<td><%=prog_indate%></td>
	<td align=center>
	<%
	boolean f_exist=f.exists();
	if(f_exist) 
		out.print("<a style='color:blue' href=# title='�ļ�·��:"+realpath+"'>��</a>");
	else
		out.print("<a style='color:red' href=# title='�ļ�·��:"+realpath+"'>��</a>");
	%>
	</td>
	<td align=center>
	<%
	if(del_flag==1) 
		out.print("<span style=color:blue>��Ч</span>");
	else
		out.print("<span style=color:red>��Ч</span>");
	%>
	</td>
	<td align=center>
		<input type=button onclick="window.open('music_modify_prog_1.jsp?prog_id=<%=prog_id%>','','width=450,height=600,toolbar=no,status=no,scrollbars=auto,resizeable=auto');" value="�޸�"><input type=button onclick='delrecord(<%=prog_id%>)'
		<%
		if(f_exist)
			out.print(" disabled");
		%>
		value="ɾ����¼"><input type=button onclick='delfile(<%=prog_id%>)'
		<%
		if(!f_exist)
			out.print(" disabled");
		%>
		value="ɾ���ļ�"></td>
</tr>
<%
}
opendb.dbclose();
%>
<caption>�������и���<span class=small>(��<%=i%>��)</span></caption>
</table>
<center><a href="#top">�ص�����</a></center>
<script>
var songcount=<%=i%>;
</script>