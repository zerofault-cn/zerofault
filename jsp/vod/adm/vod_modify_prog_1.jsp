<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<html>
<head>
<title>�޸ĵ�Ӱ��Ŀ</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<%
Opendb opendb = new Opendb();
String prog_id=request.getParameter("prog_id");
String sql1="select * from prog_info where prog_id='"+prog_id+"'";
ResultSet rs=opendb.executeQuery(sql1);
rs.next();
//ȡ�ø�������
int depre_id=rs.getInt("depre_id");//�۾ɱ��,(��Ƭ,��Ƭ)��Ӧdepreciate��depre_id
String prog_name=rs.getString("prog_name").trim();
int prog_stype=rs.getInt("prog_stype");//��������(bod),��Ӧdict_entry��dtype_id=20
int prog_format=rs.getInt("prog_format");//�ļ���ʽ(mp4,mp3),��Ӧdict_entry��dtype_id=10
int prog_kindfir=rs.getInt("prog_kindfir");//���ŷ�ʽ,(�㲥,�ಥ,����),��Ӧdict_entry��dtype_id=30
int prog_kindsec=rs.getInt("prog_kindsec");//��Ŀ����,��Ӧdict_entry��dtype_id=40,��dentry_id>1000
int prog_kindthr=rs.getInt("prog_kindthr");//���ݷ���,��Ӧdict_entry��dtype_id=50
int prog_kindfor=rs.getInt("prog_kindfor");//��Ŀ���,��Ӧdict_entry��dtype_id=60
String prog_path=rs.getString("prog_path").trim();
int prog_size=rs.getInt("prog_size");
int prog_timespan=rs.getInt("prog_timespan");
String publisher=rs.getString("publisher").trim();
String pubdate=rs.getString("pubdate").trim();
String director=rs.getString("director").trim();
String prog_acot=rs.getString("prog_acot").trim();
String prog_describe=rs.getString("prog_describe").trim();
int del_flag=rs.getInt("del_flag");//ɾ����־
int prog_limit=rs.getInt("prog_limit");//ӰƬ����,��Ӧdict_entry��dtype_id=90,���û�����(user_limit)
%>
<form action="prog_modify.jsp" method=post name=modify><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�޸Ľ�Ŀ��Ϣ<%=prog_id%><span class=small>(<span style="color:red">*</span>�Ҫ�����޸�)</span></caption>
<tr bgcolor=white>
	<td align=right>��Ŀ�¾�:</td>
	<td><select name=depre_id>
		<%
		rs=null;
		rs=opendb.executeQuery("select depre_id,depre_name from depreciate where del_flag=1 order by depre_id");
		int tmp_depre_id=0;
		String tmp_depre_name="";
		while(rs.next())
		{
			tmp_depre_id=rs.getInt(1);
			tmp_depre_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_depre_id%>" 
			<%
			if(depre_id==tmp_depre_id)
				out.print(" selected");
			%>
			><%=tmp_depre_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ŀ����:</td>
	<td><input type=text name=prog_name value="<%=prog_name%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
	<td><select name=prog_stype>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=20 and del_flag=1 order by dentry_id");
		int tmp_dentry_id=0;
		String tmp_dentry_name="";
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_stype==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>�ļ���ʽ:</td>
	<td><select name=prog_format>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=10 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_format==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>���ŷ�ʽ:</td>
	<td><select name=prog_kindfir>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=30 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_kindfir==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��Ŀ����:</td>
	<td><select name=prog_kindsec>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=40 and dentry_id>1000 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_kindsec==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>���ݷ���:</td>
	<td><select name=prog_kindthr>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_kindthr==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��Ŀ���:</td>
	<td><select name=prog_kindfor>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=60 and del_flag=1 order by dentry_id");
		if(rs!=null&&rs.next())
		{
			do
			{
				tmp_dentry_id=rs.getInt(1);
				tmp_dentry_name=rs.getString(2).trim();
				%>
				<option value="<%=tmp_dentry_id%>" 
				<%
				if(prog_kindfor==tmp_dentry_id)
					out.print(" selected");
				%>
				><%=tmp_dentry_name%></option>
				<%
			}while(rs.next());
		}
		else
		{
			%>
			<option value="<%=prog_kindfor%>">��δ����</option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>����·��</td>
	<td><input type=text name=prog_path size=40 value="<%=prog_path%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input type=text name=prog_size value=<%=prog_size%> size=5>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>����ʱ��:</td>
	<td><input type=text name=prog_timespan value=<%=prog_timespan%>></td>
</tr>
<tr bgcolor=white>
	<td align=right>������:</td>
	<td><input type=text name=publisher value=<%=publisher%>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input type=text name=pubdate value=<%=pubdate%>></td>
</tr>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input type=text name=director value=<%=director%>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ҫ��Ա:</td>
	<td><input type=text name=prog_acot value=<%=prog_acot%>></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ݼ��:</td>
	<td><textarea name=prog_describe rows=6 cols=40><%=prog_describe%></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ч��־:</td>
	<td><select name=del_flag>
		<option value="1" 
		<%
		if(del_flag==1)
			out.print(" selected");
		%>
		>��Ч</option>
		<option value="-1" 
		<%
		if(del_flag==-1)
			out.print(" selected");
		%>
		>��Ч</option></select><span class=small>(ֻ������Ϊ��Ч�û����ܿ���)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>ӰƬ����:</td>
	<td><select name=prog_limit>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_limit==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>


<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
<input type=hidden name=prog_id value="<%=prog_id%>">
</form>
</body>
</html>
<%
opendb.dbclose();
%>