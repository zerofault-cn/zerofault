<%@ page language="java" import="java.sql.*,goldsoft.*"%>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
String type_id=request.getParameter("rss_type_id");
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
int row=0;
int i=0;
String rss_source_url[]=new String [20];
String sql1="select count(*) from rss_source where rss_type_id='"+type_id+"'";
String sql2="select rss_source_url from rss_source where rss_type_id='"+type_id+"'";
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
		rss_source_url[i]=rs.getString(1).trim();
		i++;
	}
}
String str_url_i = request.getParameter("url_i");
int url_i=0;
if (str_url_i == null) {
  url_i = 0;
}
else 
{
	url_i = java.lang.Integer.parseInt(str_url_i);
	if (url_i < 0)
		url_i = 0;
	if(url_i>=row)
		url_i=row-1;
}
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="javascript" type="text/javascript" src="file:///usr/suit/newebox/feedparser.js"></script>

<cache:cache time="1800" refresh="true">
<script language="JavaScript" type="text/JavaScript">
feed=new FeedParser('<%=rss_source_url[url_i]%>');
</script>
</cache:cache>
<script language="JavaScript" type="text/JavaScript">
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<span style="color:blue">'+(n+1)+'.&nbsp;</span><a class=style24b style="color:blue" ' + dat;
	document.links[n].focus();
}
function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = (n+1)+'.&nbsp;<a class="style24b" style="color:black" ' + dat;
}
var key2=0;
function keyPress(e){
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48
　	var patern=/^[1-9]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		
		location = document.links[key1 - 1];
	}
	if(keycode==36)
	{
		location="news_index.jsp";
	}
	if(keycode==33)
	{
		location="?rss_type_id=<%=type_id%>&url_i=<%=url_i-1%>";
	}
	if(keycode==34)
	{
		location="?rss_type_id=<%=type_id%>&url_i=<%=url_i+1%>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=8;
			onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>8) key2=0;
			onfoc(key2)
	}
	
}    
document.onkeypress=keyPress

//-->
</script>

</head>
<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/news/news_bg2.jpg" bgcolor="#0a56d" style="background-Attachment:fixed;" onload="onfoc(0)">

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
	
	<table width=560 height=426 border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=30 height=37>&nbsp;</td>
		<td width=200></td>
		<td width=320>&nbsp;</td>
		<td width=13>&nbsp;</td>
	</tr>
	<tr>
		<td height=35>&nbsp;</td>
		<td class=style24b style="color:blue"><script>document.write(feed.channel.title);</script></td>
		<td align=right><img src="file:///usr/suit/newebox/image/news/ing.gif"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4 height=10></td>
	</tr>
	<tr>
		<td height=300>&nbsp;</td>
		<td valign=top colspan=2 class=style24b style="line-height:1.4em">
		<script language="javascript" type="text/javascript">
		<%
		for (i=0; i<9; i++) 
		{
			%>
			var itemtitle=feed.channel.item[<%=i%>].title;
			if(itemtitle.length>20)
			{
				itemtitle=itemtitle.substring(0,20);
			}
			document.write('<div id=<%=i%>><%=i+1%>.&nbsp;<a class=style24b style="color:black" href=news_info.jsp?url_i=<%=url_i%>&type_id=<%=type_id%>&rss_source_url=<%=rss_source_url[url_i]%>&y=<%=i%>>'+itemtitle+'</a></div>');
			<%
		}
		%>
		</script>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4 height=10></td>
	</tr>
	<tr>
		<td height=24></td>
		<td>
		<%
		if(row>1&&url_i>0)
		out.println("<span class=style22b>上页</span>");
		%></td>
		<td align=right>
		<%
		if(row>1 && url_i<row-1)
		out.println("<span class=style22b>下页</span>");
		%></td>
		<td></td>
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
