<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ���и��ְ����б� -->
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
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=1&var2=type_field&value2=type_area_id">�������ֶӷ�ʽ����</a></td>
	<td width="33%" align=center
	<%
	if(type_label.equals("2"))
		out.print("bgcolor=#b3b7e6");
	%>
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=2&var2=type_field&value2=type_chorus_id">���ݳ���ʽ����</a></td>
	<td width="33%" align=center
	<%
	if(type_label.equals("3"))
		out.print("bgcolor=#b3b7e6");
	%>
	><a href="index.jsp?content=music_singer_list&var1=type_label&value1=3&var2=type_field&value2=type_other_id">�������</a></td>
</tr>	
<tr bgcolor=white>
	<td colspan=3>
	<%
	String[] type_name_arr=new String[500];//�������������������
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
		<a href="index.jsp?content=music_singer_song&var1=singer_id&value1=<%=singer_id%>" title="����鿴������ϸ��Ϣ"><%=singer_name%></a>&nbsp;&nbsp;
		<%
	}
	opendb.dbclose();
	%>
	</td>
</tr>
<caption valign=top>���и����б�(<span style="color:red"><%=i%></span>��)</caption>
</table>
<center><a href="#top">�ص�����</a></center>