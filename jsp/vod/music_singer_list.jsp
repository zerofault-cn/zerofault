<%@ page import="goldsoft.*,java.sql.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
int type_label =java.lang.Integer.parseInt(request.getParameter("type_label"));
int type_id =java.lang.Integer.parseInt(request.getParameter("type_id"));
if(type_label==2&&(type_id!=2&&type_id!=3))
{
	response.sendRedirect("music_other_song.jsp?type_label="+type_label+"&type_id="+type_id);
}
String sql1="";
String sql2="";
if(type_label==1)
{
	sql1="select count(distinct singer_id) from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and type_area_id="+type_id;
	sql2="select distinct singer_id,singer_name,photo from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and type_area_id="+type_id+" order by binary singer_name";
}
if(type_label==2)
{
	sql1="select count(distinct singer_id) from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and type_chorus_id="+type_id;
	sql2="select distinct singer_id,singer_name,photo from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and type_chorus_id="+type_id+" order by binary singer_name";
}
int intPageSize;
int intRowCount;
int intPageCount;
int intPage;
String strPage;
intPageSize = 6;
strPage = request.getParameter("page");
if (strPage == null) 
{
	intPage = 1;
}
else
{
	intPage = java.lang.Integer.parseInt(strPage);
	if (intPage < 1)
		intPage = 1;
}
Opendb opendb = new Opendb();
ResultSet rs = opendb.executeQuery(sql1);
rs.next();
intRowCount = rs.getInt(1);
rs = null;
rs = opendb.executeQuery(sql2);
intPageCount = (intRowCount + intPageSize - 1) / intPageSize;
if(intPage > intPageCount && intPageCount > 0)	
	intPage = intPageCount;
if (intPage > 1) {
	for(int i = 0; i < (intPage - 1) * intPageSize; i++)
		rs.next();
}
String[] singer_id = new String[intPageSize];
String[] singer_name=new String[intPageSize];
String[] photo = new String[intPageSize];
String[] link=new String[intPageSize];
int a=0;
int n=0;

//StringReplace sr = new StringReplace();
for(int i = 0; i < intPageSize; i++) 
{
	if(rs != null && rs.next()) 
	{
		singer_id[i] = rs.getString("singer_id");
		singer_name[i]=rs.getString("singer_name").trim();
		photo[i]=rs.getString("photo");
		link[i]="music_singer_song.jsp?type_label="+type_label+"&type_id="+type_id+"&fpage="+intPage+"&singer_id="+singer_id[i];
		if(singer_name[i].length()>8)
		{
			singer_name[i]=singer_name[i].substring(0,8);
		}
		n++;
		if(photo[i].equals(""))
		{
			photo[i] = "no.jpg";
		}
	}
	else 
	{
		singer_id[i]="";
		singer_name[i] = "";
		photo[i]="no.jpg";
	}
}
opendb.dbclose();
%>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<table bgcolor=#3366ff border=0 cellpadding=0 cellspacing=0><tr><td><a class=style22b style="color:white" ' + dat + '</td></tr></table>';
	document.links[n].focus();
}
function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<a class="style22w" style="color:white" ' + dat;
}

function loc(url) {
 location=url;
}
function keyDown(e){
	var keycode=e.which
	var key1 = keycode - 48
	
	<%
	for(int i = 0; i < intPageSize; i++) {
		if(!singer_id[i].equals(""))
			out.println("if(keycode==" + (49 + i) + ")location='"+link[i]+"'");
	}
	%>
	if(keycode==36) 
		location="music_typelist.jsp?type_label=<%=type_label%>";
	if(keycode==33) 
		location="?type_label=<%=type_label%>&type_id=<%=type_id%>&page=<%=intPage - 1%>";
  	if(keycode==34) 
		location="?type_label=<%=type_label%>&type_id=<%=type_id%>&page=<%=intPage + 1%>";
	if(keycode==37)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<%=n-1%>;
				onfoc(key2)
	}
	if(keycode==39)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=n-1%>) key2=0;
				onfoc(key2)
	}
	if(keycode==38||keycode==40)
	{
		losefoc(key2);
		if(key2<3)
			key2+=3;
		else
			key2-=3;
		onfoc(key2);
	}
}
   
document.onkeydown=keyDown
//document.captureEvents(Event.KEYDOWN)
//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_singerlist.jpg" bgcolor="#0a56d" onload="onfoc(0)">

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
	<table width="560" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height=26 colspan=7></td>
	</tr>
	<tr>
		<td height="37">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="3" align=right valign="bottom" class="style22w">第<%=intPage%>页&nbsp;共<%=intPageCount%>页</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=17 colspan=7></td>
	</tr>
	<tr>
		<td width="73" height="122"></td>
		<td width="103" align=center><img src="/photo/<%=photo[0]%>"></td>
		<td width="53"></td>
		<td width="103" align=center><img src="/photo/<%=photo[1]%>"></td>
		<td width="53"></td>
		<td width="103" align=center><img src="/photo/<%=photo[2]%>"></td>
		<td width="72"></td>
	</tr>
	<tr>
	    <td height=6 colspan=7></td>
    </tr>
	<tr>
	    <td height="28"></td>
	    <td align=center id=0><a class=style22w style="color:white" href="<%=link[0]%>"><%=singer_name[0]%></a></td>
	    <td></td>
        <td align=center id=1><a class=style22w style="color:white" href="<%=link[1]%>"><%=singer_name[1]%></a></td>
	    <td></td>
	    <td align=center id=2><a class=style22w style="color:white" href="<%=link[2]%>"><%=singer_name[2]%></a></td>
	    <td></td>
    </tr>
	<tr>
	    <td height=8 colspan=7></td>
    </tr>
	<tr valign=top>
	    <td height="122"></td>
	    <td align=center><img src="/photo/<%=photo[3]%>"></td>
	    <td></td>
	    <td align=center><img src="/photo/<%=photo[4]%>"></td>
	    <td></td>
	    <td align=center><img src="/photo/<%=photo[5]%>"></td>
	    <td></td>
    </tr>
	<tr>
	    <td height=6 colspan=7></td>
    </tr>
	<tr>
	    <td height="28"></td>
	    <td align=center id=3><a class=style22w style="color:white" href="<%=link[3]%>"><%=singer_name[3]%></a></td>
	    <td></td>
		<td align=center id=4><a class=style22w style="color:white" href="<%=link[4]%>"><%=singer_name[4]%></a></td>
	    <td></td>
	    <td align=center id=5><a class=style22w style="color:white" href="<%=link[5]%>"><%=singer_name[5]%></a></td>
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
<%
opendb.dbclose();
%>
