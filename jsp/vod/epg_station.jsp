<%@ page import="goldsoft.*,java.sql.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
String type = request.getParameter("type");
int intPageSize;
int intRowCount;
int intPageCount;
int intPage;
String strPage;
intPageSize = 6;//初始化每页行数
strPage = request.getParameter("page");//初始化当前页数
if (strPage == null) {
	intPage = 1;
}
else {
	intPage = java.lang.Integer.parseInt(strPage);
	if (intPage < 1)
		intPage = 1;
}
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs = opendb.executeQuery("select count(*) from epg_station where type='" + type + "'");
rs.next();
intRowCount = rs.getInt(1);//查数据库取总条目数
rs = null;
rs = opendb.executeQuery("select distinct * from epg_station where type='" + type + "' order by num");
intPageCount = (intRowCount + intPageSize - 1) / intPageSize;//计算总页数
if(intPage > intPageCount && intPageCount > 0)	
	intPage = intPageCount;//对超过范围页数的修正
String[][] sts = new String[intPageSize][3];//数组用来存储电台号,电台名,电台地址
if (intPage > 1) {//翻页处理
		for(int i = 0; i < (intPage - 1) * intPageSize; i++)	
			rs.next();
}
String trd = "";//临时变量,存电台名
for (int i = 0; i < intPageSize; i++) {
	if (rs != null && rs.next()) {
	  	sts[i][0] = rs.getString(1);//num
	  	trd = rs.getString(2);//station
	  	if(trd.length()>26)
			trd = trd.substring(0,26);
	  	sts[i][1] = trd;
	  	sts[i][2] = rs.getString(3);//path
	}
	else {
		sts[i][0] = "";
		sts[i][1] = "";
		sts[i][2] = "";
	}
}
String vfocus = "";
String num = request.getParameter("num");//电台号,确定焦点行号
if(num == null) {
	num = sts[0][0];
	vfocus = "0";
}
else {
	for (int i = 0; i < intPageSize; i++) {
		if(sts[i][0].equals(num)) {
			vfocus = i + "";//int转String
			break;
		}
	}
}

%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

var vfocus = <%=vfocus%>;
var page = <%=intPage%>;
var num = <%=num%>;

function array(size) {
	for(var X = 0; X < size; X++) {
		this[X]=0;
	}
	this.length = size;
	return this;
}

nums = new array(<%=intPageSize%>);
<%
for(int i = 0; i < intPageSize; i++) {
	out.print("nums[" + i + "] = ");
	if(sts[i][0].equals("")) 
		out.println("0;");
	else 
		out.println(sts[i][0] + ";");
}
%>

paths = new array(<%=intPageSize%>);
<%
for(int i = 0; i < intPageSize; i++) {
	out.println("paths[" + i + "] = '" + sts[i][2] + "';");
}
%>
function mm() {
	t1 = document.getElementById(vfocus);
	dat = t1.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat.substring(dat.lastIndexOf(">") + 1);//dat=sts[i][1]
	t1.innerHTML = '<td height=48 class=style24b bgcolor=green>' + dat + '</td>'; 
}
function onfoc(vfocus)
{
	t2 = document.getElementById(vfocus);
	dat = t2.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat.substring(dat.lastIndexOf(">") + 1);
	t2.innerHTML = '<td height=48 class=style24b bgcolor=green>' + dat + '</td>'; 
}
function losfoc(vfocus)
{
	t1 = document.getElementById(vfocus);
	dat = t1.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat.substring(dat.lastIndexOf(">") + 1);
	t1.innerHTML = '<td height=48 class=style24w>' + dat + '</td>'; 
}
function keyDown(e){
　var keycode=e.which
　var realkey=String.fromCharCode(e.which)
	switch(keycode) {
		
		case 70://播放键
			if(paths[vfocus] != null && paths[vfocus] != '') 
				location = paths[vfocus];
			else 
				location = "?type=<%=type%>&page=" + page + "&num=" + nums[vfocus];
			break;
		case 13://回车键
			location ="epg_schedule.jsp?type=<%=type%>&spage="+page+"&num="+nums[vfocus];
			break;
		case 33:
			location =  "?type=<%=type%>&page=" + (page - 1);
			break;
		case 34:
			location =  "?type=<%=type%>&page=" + (page + 1);
			break;
		case 38:
			losfoc(vfocus);
			vfocus = vfocus - 1;
			if(vfocus < 0)
			{
				location =  "?type=<%=type%>&page=" + (page - 1);
			}
			else 
			{
				onfoc(vfocus);
			}
			break;
		case 40:
			losfoc(vfocus);
			vfocus = vfocus + 1;
			if(vfocus > <%=intPageSize - 1%>)
			{
				location =  "?type=<%=type%>&page=" + (page + 1);
				
			}
			else
			{
				onfoc(vfocus);
			}
			break;
		case 36:
			location =  "menu_1.jsp";
			break;
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 onload="mm()" background="file:///usr/suit/newebox/image/bg/<%=type%>1.jpg" bgcolor="#0a56d">
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
	<table width=560 border=0 cellpadding="0" cellspacing="0">
<tr>
    <td width="75" height="36">&nbsp;</td>
    <td width="324">&nbsp;</td>
    <td width=34>&nbsp;</td>
	<td width=32></td>
	<td width=95></td>
</tr>
<tr>
	<td height=39></td>
	
	<td colspan=3  valign="bottom" align=right class=style22w>第 <%=intPage%>页&nbsp;&nbsp;共 <%=intPageCount%>页</td>
	<td></td>
</tr>
<tr>
	<td colspan=5 height=32></td>
</tr>
<tr><td rowspan=2>&nbsp;</td>
    <td rowspan=2 align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <%
        for(int i = 0; i < intPageSize; i++) {
        %>
        	<tr id=<%=i%>>
          	<td height=48 class=style24w><%=sts[i][1]%></td>
        	</tr>
        <%
        }
        %>
    </table></td>
	<td rowspan=2>&nbsp;</td>
	<td valign=top align=center><img src="file:///usr/suit/newebox/image/uparray.png"></td>
	<td rowspan=2></td>
</tr>
<tr>
<td valign=bottom align=center><img src="file:///usr/suit/newebox/image/downarray.png"></td>
</tr>
<tr>
    <td height="35">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
	   <td>&nbsp;</td>
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

<%
opendb.dbclose();
%>
