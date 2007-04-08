<%@ page language="java" import="java.sql.*,goldsoft.*"%>
<%@ page errorPage="error.jsp" %>
<%
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
int row=0;
int i=0;
String rss_type_id[]=new String [30];
String rss_type_name[]=new String [30];
String sql1="select count(distinct rss_type.rss_type_id) from rss_type,rss_source where rss_type.rss_type_id=rss_source.rss_type_id";
String sql2="select distinct rss_type.rss_type_id,rss_type.rss_type_name from rss_type,rss_source where rss_type.rss_type_id=rss_source.rss_type_id order by rss_type.rss_type_id";
ResultSet rs=opendb.executeQuery(sql1);

if(rs!=null&&rs.next())
{
	row=rs.getInt(1);
}

rs=null;
rs=opendb.executeQuery(sql2);
if(row>0)
{
	while(rs.next())
	{
		rss_type_id[i]=rs.getString(1).trim();
		rss_type_name[i]=rs.getString(2).trim();
		i++;
	}
}
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>RSS News</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td width=16 height=28><img src="file:///usr/suit/newebox/image/selectright.gif"></td><td class=style24b bgcolor="#3366ff"><a style="color:white" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td width=16 height=28></td><td class=style24b><a style="color:black" ' + dat;
}

function keyPress(e)
{
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48;
	

	if(keycode==36)//HOME键
	{
		location="menu_1.jsp";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<%=row-1%>;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=row-1%>) key2=0;
		onfoc(key2)
	}
	if(keycode==37||keycode==39)
	{
		losefoc(key2);
		if(key2 < <%=row/2%>)
			key2=key2+<%=row/2%>
		else 
			key2=key2 - <%=row/2%>;
		onfoc(key2);
	}
	
}    
document.onkeypress=keyPress

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/news/news_bg.jpg" bgcolor="#0a56d" onload="onfoc(0);">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>金</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width=560 height=430 border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=60 height=90>&nbsp;</td>
		<td width=200>&nbsp;</td>
		<td width=40>&nbsp;</td>
		<td width=200>&nbsp;</td>
		<td width=60>&nbsp;</td>
	</tr>
	<tr>
		<td height=350>&nbsp;</td>
		<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0>
		<%
		
		for(i=0;i<row/2;i++)
		{
			if(rss_type_id[i]==null)
				break;
			%>
			<tr id=<%=i%>><td height=28 width=16></td><td class=style24b><a style="color:black" href="news_submenu.jsp?rss_type_id=<%=rss_type_id[i]%>"><%=rss_type_name[i]%></a></td></tr>
			<%
		}
		%>
		</table>
		</td>
		<td></td>
		<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0>
		<%
		for(i=row/2;i<row;i++)
		{
			if(rss_type_id[i]==null)
				break;
			%>
			<tr id=<%=i%>><td height=28 width=16></td><td class=style24b><a style="color:black" href="news_submenu.jsp?rss_type_id=<%=rss_type_id[i]%>"><%=rss_type_name[i]%></a></td></tr>
			<%
		}
		%>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td height=15>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

</body>
</html>
