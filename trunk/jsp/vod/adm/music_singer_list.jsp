<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 所有歌手按类列表 -->
<%
Opendb opendb = new Opendb();
String type_label=(String)session.getAttribute("type_label");
String type_field=(String)session.getAttribute("type_field");
if(type_label==null||type_field==null)
{
	type_label="1";
	type_field="type_area_id";
}
String sql1="select singer_id,singer_name,type_name from singer_info,singer_type where singer_type.type_id="+type_field+" and singer_type.type_label='"+type_label+"' order by singer_type.type_id,singer_id";
//out.println(sql1);
ResultSet rs=opendb.executeQuery(sql1);
%>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<tr bgcolor=white>
	<td width="33%" align=center
	<%
	if(type_label.equals("1"))
		out.print("bgcolor=#b3b7e6");
	%>
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=1&var2=type_field&value2=type_area_id">按歌手乐队方式排列</a></td>
	<td width="33%" align=center
	<%
	if(type_label.equals("2"))
		out.print("bgcolor=#b3b7e6");
	%>
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=2&var2=type_field&value2=type_chorus_id">按演唱方式排列</a></td>
	<td width="33%" align=center
	<%
	if(type_label.equals("3"))
		out.print("bgcolor=#b3b7e6");
	%>
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=3&var2=type_field&value2=type_other_id">其他类别</a></td>
</tr>	
<tr bgcolor=white>
	<td colspan=3>
	<%
	String[] type_name_arr=new String[500];//用来保存歌手所属分类
	type_name_arr[0]="";
	int i=0;
	int j=0;
	int singer_id=0;
	String singer_name="";
	String type_name="";
	while(rs!=null&&rs.next())
	{
		
		i++;
		singer_id=rs.getInt(1);
		singer_name=rs.getString(2).trim();
		type_name =rs.getString(3).trim();
		type_name_arr[i]=type_name;
		if(!type_name_arr[i].equals(type_name_arr[i-1]))
		{
			%>
			<p><span style="color:red"><%=type_name%></span>&nbsp;&nbsp;&nbsp;&nbsp;<br>
			<%
		}
		%>
		<a href="index.jsp?content=music_singer_song&var1=singer_id&value1=<%=singer_id%>" title="点击查看歌手详细信息"><%=singer_name%></a>&nbsp;&nbsp;
		<%
	}
	opendb.dbclose();
	%>
	</td>
</tr>
<caption valign=top>已有歌手列表(<span style="color:red"><%=i%></span>个)</caption>
</table>
<center><a href="#top">回到顶部</a></center>