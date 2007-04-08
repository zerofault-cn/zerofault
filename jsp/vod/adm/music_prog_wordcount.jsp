<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>
<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="prog_delete.jsp?del_flag=record&page_from=music_prog&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	
	if(confirm("确定要删除该文件吗？")&&confirm("删除将无法恢复哦！真的确认？"))
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
int pageitem=20;//设定每页显示行数

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
	<td>序号</td>
	<td>歌手</td>
	<td>名称</td>
	<td>播放</td>
	<td>录入时间</td>
	<td align=center>文件</td>
	<td align=center>有效否</td>
	<td align=center>操作</td>
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
	<td><a href="index.jsp?content=music_singer_song&var1=singer_id&value1=<%=singer_id%>" title="点击查看歌手详细信息"><%=singer_name%></a></td>
	<td><%=prog_name%></td>
	<td><a href="mms://<%=getServerIp.getIpByPath(prog_path)%>/<%=prog_path%>" title="<%=prog_path%>">play</a></td>
	<td><%=prog_indate%></td>
	<td align=center>
	<%
	boolean f_exist=f.exists();
	if(f_exist) 
		out.print("<a style='color:blue' href=# title='文件路径:"+realpath+"'>有</a>");
	else
		out.print("<a style='color:red' href=# title='文件路径:"+realpath+"'>无</a>");
	%>
	</td>
	<td align=center>
	<%
	if(del_flag==1) 
		out.print("<span style=color:blue>有效</span>");
	else
		out.print("<span style=color:red>无效</span>");
	%>
	</td>
	<td align=center>
		<input type=button onclick="window.open('music_modify_prog_1.jsp?prog_id=<%=prog_id%>','','width=450,height=600,toolbar=no,status=no,scrollbars=auto,resizeable=auto');" value="修改"><input type=button onclick='delrecord(<%=prog_id%>)'
		<%
		if(f_exist)
			out.print(" disabled");
		%>
		value="删除记录"><input type=button onclick='delfile(<%=prog_id%>)'
		<%
		if(!f_exist)
			out.print(" disabled");
		%>
		value="删除文件"></td>
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
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=0">【最前】</a>&nbsp;&nbsp;
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=preoffset%>">【前一页】</a>&nbsp;&nbsp;
	<%
}

if((offset+pageitem)<rowCount)
{
	nextoffset=offset+pageitem;
	endpage=rowCount-pageitem;
	%>
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=nextoffset%>">【后一页】</a>&nbsp;&nbsp;
	<a href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=<%=wordcount%>&var2=offset&value2=<%=endpage%>">【最后】</a>&nbsp;&nbsp;
	<%
}
%>
<%=(int)(Math.ceil((double)(rowCount-offset)/(double)pageitem))%>/<%=(int)(Math.ceil((double)rowCount/(double)pageitem))%>,共<%=rowCount%>条,每页<%=pageitem%>条
</td></tr>
<caption valign=top><span class=small>(共<span class=red><%=rowCount%></span>首)</span></caption>
</table>
