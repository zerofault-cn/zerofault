<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>
<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="prog_delete.jsp?del_flag=record&page_from=music_prog&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	
	if(confirm("ȷ��Ҫɾ�����ļ���")&&confirm("ɾ�����޷��ָ�Ŷ�����ȷ�ϣ�"))
	{
		window.location="prog_delete.jsp?del_flag=file&page_from=music_prog&prog_id="+prog_id;
	}
	else
		return;
}
</script>
<%
Opendb opendb = new Opendb();
StringReplace sr=new StringReplace();
String conv32 = "" + (char)32;
GetServerIp getServerIp=new GetServerIp();
String strOffset=(String)session.getAttribute("offset");
session.removeAttribute("offset");
int offset=0;
if(strOffset==null)
	offset=0;
else 
	offset=java.lang.Integer.parseInt(strOffset);
int pageitem=20;//�趨ÿҳ��ʾ����

int wordcount=java.lang.Integer.parseInt((String)session.getAttribute("wordcount"));
String sql1="";
String sql2="";
ResultSet rs=null;

if(wordcount>=6)
{
	sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan>="+wordcount;
	sql2="select prog_id,singer_id,singer_name,prog_name,prog_path,prog_indate,del_flag from prog_info,singer_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher=singer_id and prog_timespan>="+wordcount+" order by prog_timespan,binary prog_name limit "+offset+","+pageitem;
}
else
{
	sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan="+wordcount;
	sql2="select prog_id,singer_id,singer_name,prog_name,prog_path,prog_indate,del_flag from prog_info,singer_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher=singer_id and prog_timespan="+wordcount+" order by binary prog_name limit "+offset+","+pageitem;
}
rs=opendb.executeQuery(sql1);
rs.next();
int rowCount = rs.getInt(1);
rs=null;
rs=opendb.executeQuery(sql2);
int prog_id=0;
String singer_name="";
int singer_id=0;
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
	singer_id=rs.getInt(2);
	singer_name=rs.getString(3).trim();
	prog_name=rs.getString(4).trim();
	prog_path=rs.getString(5).trim();
	prog_indate=rs.getString(6).trim();
	del_flag=rs.getInt(7);
	if(prog_name.length()>18)
		prog_name=prog_name.substring(0,18);
	realpath = "/dpfs/" + prog_path;
	f = new File(realpath);
	%>
<tr bgcolor=white>
	<td><%=i%></td>
	<td><a href="index.jsp?content=music_singer_song&var1=singer_id&value1=<%=singer_id%>" title="����鿴������ϸ��Ϣ"><%=singer_name%></a></td>
	<td><%=prog_name%></td>
	<td><a href="mms://<%=getServerIp.getIpByPath(prog_path)%>/<%=prog_path%>" title="<%=prog_path%>">play</a></td>
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
<tr bgcolor=white><td colspan=8 align=right>
<%
int preoffset=0;
int nextoffset=0;
int endpage=0;
if(offset!=0)
{
	preoffset=(offset-pageitem)>0?(offset-pageitem):0;
	%>
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=preoffset%>">��ǰһҳ��</a>&nbsp;&nbsp;
	<%
}

if((offset+pageitem)<rowCount)
{
	nextoffset=offset+pageitem;
	endpage=rowCount-pageitem;
	%>
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=nextoffset%>">����һҳ��</a>&nbsp;&nbsp;
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=endpage%>">�����</a>&nbsp;&nbsp;
	<%
}
%>
<%=(int)(Math.ceil((double)(rowCount-offset)/(double)pageitem))%>/<%=(int)(Math.ceil((double)rowCount/(double)pageitem))%>,��<%=rowCount%>��,ÿҳ<%=pageitem%>��
</td></tr>
<caption valign=top><span class=small>(��<span class=red><%=rowCount%></span>��)</span></caption>
</table>
