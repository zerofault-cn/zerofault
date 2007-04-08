<%@ page import="goldsoft.*,java.sql.*,java.net.*" %>
<%@ page errorPage="error.jsp" %>
<%
//Cookie cookies[]=request.getCookies();
String account="1";
String password="1";
//if(cookies==null)
//	response.sendRedirect("login_1.jsp");
//
//用户已有登录
//	account=cookies[1].getValue();
//	password=cookies[2].getValue();

Opendb opendb = new Opendb();
GetServerIp getServerIp=new GetServerIp();
String namepage = request.getParameter("namepage");
String typepage = request.getParameter("typepage");
String prog_id=request.getParameter("prog_id");
String dentry_id=request.getParameter("dentry_id");
String dentry_name=request.getParameter("dentry_name");

int i=0;
String prog_name="";
String prog_path="";
String prog_ip="";
String director="";
int prog_timespan=0;
String prog_acot="";
String prog_describe="";
String picture="";//用publisher列存储
String pic1="";
String play_path="";
ResultSet rs = opendb.executeQuery("select prog_path,prog_name,ifnull(director,'Unknow'),ifnull(prog_timespan,0),ifnull(prog_acot,'Unknow'),ifnull(prog_describe,'Unknow'),ifnull(publisher,'nopop.jpg') from prog_info where prog_id='" + prog_id+"'");
if(rs != null && rs.next())
{
	prog_path     = rs.getString(1).trim();
	prog_name     = rs.getString(2).trim();
	director      = rs.getString(3).trim();
	prog_timespan = rs.getInt(4);
	prog_acot     = rs.getString(5).trim();
	prog_describe = rs.getString(6).trim();
	picture     = rs.getString(7).trim();
	if(picture.indexOf(",")!=-1)
		pic1=picture.substring(0,picture.indexOf(","));
	else 
		pic1=picture;
	prog_ip=getServerIp.getIpByPath(prog_path);
}
/*********************用darwin时的播放路径**********************/
//play_path="lrtsp://"+prog_path+"?"+account+"&"+password;
/*********************用helix时的播放路径***********************/
if(prog_path.substring(prog_path.lastIndexOf(".")).equals(".WMV"))
{
	play_path="mms://"+prog_ip+"/"+prog_path;
}
if(prog_path.substring(prog_path.lastIndexOf(".")).equals(".mp4"))
{
	play_path="rtsp://"+prog_ip+":555/"+prog_path;
}
/***************************************************************/
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
	t2.innerHTML = '<td align=center height=40 bgcolor=#3366ff><a class="style24b" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td align=center height=40><a class="style24w" ' + dat;
}

function keyDown(e)
{
	var keycode=e.which
	var key1 = keycode -48
	var realkey=String.fromCharCode(e.which)
	var patern=/^[1-3]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else
		{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		setTimeout("",200);
		location = document.links[key2];
	  }                             
	if(keycode==36) 
	{
		losefoc(key2);
		onfoc(2);
		location=document.links[2];
	}
	if(keycode==49) 
	{
		onfoc(0);
		location=document.links[0];
	}
	if(keycode==50) 
	{
		onfoc(1);
		location=document.links[1];
	}
	if(keycode==51) 
	{
		onfoc(2);
		location=document.links[2];
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=2;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>2) 
			key2=0;
		onfoc(key2)
	}
}    
document.onkeydown=keyDown


//-->
</script>

</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/vod/vod_introduce.jpg" onload="onfoc(0)" bgcolor="#0a56d">
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
	  <table width="560" border="0" cellpadding="0" cellspacing="0" height="430">
        <tr>
	      <td width="27" height="129">&nbsp;</td>
          <td width="164" height="129">&nbsp;</td>
          <td width="18" height="129">&nbsp;</td>
          <td width="282" height="129">&nbsp;</td>
	      <td width="69" height="129">&nbsp;</td>
</tr>
<tr>
	      <td width="27">&nbsp;</td>
          <td valign=center width="164"> 
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ff0000">
		<tr>
			<td height="30">&nbsp;</td>
		</tr>
		<tr id=0>
		  	<td align=center height=40><a class=style24w href='vod_haibao.jsp?typepage=<%=typepage%>&namepage=<%=namepage%>&dentry_id=<%=dentry_id%>&prog_id=<%=prog_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>&picture=<%=pic1%>'>１.看海报</a></td>
		</tr>
		<tr>
			<td height="10">&nbsp;</td>
		</tr>
		<tr id=1>
			<td align=center height=40><a class=style24w href="<%=play_path%>">２.播&nbsp;&nbsp;&nbsp;&nbsp;放</a></td>
		</tr>
		<tr>
			<td height="10">&nbsp;</td>
		</tr>
		<tr id=2>
			<td align=center height=40><a class=style24w href='vod_namelist.jsp?typepage=<%=typepage%>&page=<%=namepage%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>'>３.返&nbsp;&nbsp;&nbsp;&nbsp;回</a></td>
		</tr>
		
		</table>
	</td>
	      <td width="18">&nbsp;</td>
	      <td valign=top height=240 width="282"> 
            <div class="style24w">
		<marquee id=test width=320  height=240 direction="up" loop=-1 behavior="scroll" dataformatas="html"  scrolldelay="20" scrollamount="1" border="0">
		<%
		out.println("片名："+prog_name+"<br>");
		if(!director.equals(""))
			out.println("导演：" + director + "<br>");
		out.println("类型：" + dentry_name + "<br>");
		if(prog_timespan!=0)
			out.println("片长：" + prog_timespan + " 分钟<br>");
		if(!prog_acot.equals(""))
			out.println("主要演员：" + prog_acot + "<br>");
		%>
		<p align="justify" class="style22w">&nbsp;&nbsp;&nbsp;&nbsp;
		<%
		if(!prog_describe.equals("")) {
//			prog_describe = sr.newline(prog_describe);
//			prog_describe = sr.transHtml(prog_describe);
			out.println(prog_describe);
		}
		%>
		
		</marquee>
		</div></td>
          <td width="69">&nbsp;</td>
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
