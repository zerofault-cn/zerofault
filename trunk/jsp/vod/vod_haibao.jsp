<%@ page contentType="text/html;charset=gb2312" %>
<%@ page import="goldsoft.*,java.sql.*,java.net.*"%>
<%@ page errorPage="error.jsp" %>
<%
String namepage = request.getParameter("namepage");
String typepage = request.getParameter("typepage");
String prog_id=request.getParameter("prog_id");
String dentry_id=request.getParameter("dentry_id");
String dentry_name=request.getParameter("dentry_name");

String picture = request.getParameter("picture");
int pic_i=0;
String str_pic_i=request.getParameter("pic_i");
if(str_pic_i!=null)
{
	pic_i=java.lang.Integer.parseInt(str_pic_i);
}

Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs = opendb.executeQuery("select ifnull(publisher,'nopop.jpg') from prog_info where prog_id='"+prog_id+"'");
rs.next();
String pic = rs.getString(1).trim();
%>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>看海报</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/vod/vod_haibao.jpg" bgcolor="#0a56d">
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
  <!--DWLayoutTable-->
  <tr>
    <td width="157" height="47">&nbsp;</td>
   
    
    <td width="319">&nbsp;</td>
    <td width=84>&nbsp;</td>
  </tr>
  <tr>
    <td height="303">&nbsp;</td>
    <td valign="top"><img src="/pictures/<%=picture%>" width=310 height="300"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan=3 height=30></td>
	</tr>
  <tr>
	<td></td>
	<td>
		<table border=0 cellpadding=0 cellspacing=0 width="100%">
		<tr>
			
			<td class="style22b">
			<%
			String[] pics = null;
			if(!pic.equals(picture)) 
			{
			 	pics = pic.split(",");
		 		for(int i = 0; i < pics.length; i++) 
				{
		 			out.print("第");
					if(pic_i==i)
						out.print("<span style='font-size:24px;color:#ff0000'>" + (i+1) + "</span>");
					else
						out.print("<span style='font-size:24px;color:#ff0000'>" + (i+1) + "</span>");
					out.print("页&nbsp;");
				}
		  	}
			%>
			</td>
			<td align=right class=style24w>返回</td>
			<td width=10></td>
		</tr>
		</table>
	</td>
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

<script language="JavaScript" type="text/JavaScript">
<!--
function keyDown(e){
	var keycode=e.which
	<%
	if(!pic.equals(picture)) 
	{
		for(int i = 0; i < pics.length; i++)
		{
			out.println("if(keycode==" + (49 + i) + ") location='?typepage="+typepage+"&namepage="+namepage+"&dentry_id="+dentry_id+"&prog_id="+prog_id+"&dentry_name="+URLEncoder.encode(dentry_name,"iso8859-1")+"&pic_i="+i+"&picture="+pics[i]+"'");
		}
	}
	%>
	if(keycode==36) location='vod_introduce.jsp?typepage=<%=typepage%>&namepage=<%=namepage%>&prog_id=<%=prog_id%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>';
}    
document.onkeydown=keyDown
//-->
</script>
</html>
<%
opendb.dbclose();
%>