<%@ page contentType="text/html; charset=gb2312" %>
<%@ page isErrorPage="true" %>
<%@ page import="goldsoft.*" %>
<%
String wrong="";
wrong=request.getParameter("wrong");
if(wrong==null)
	wrong="error";
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
document.links[0].focus();
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function keyDown(e){
　　var keycode=e.which
　　if(keycode==36) location="javascript:history.back()";
		}    
document.onkeydown=keyDown
//document.captureEvents(Event.KEYDOWN)
//-->
</script>
</head>

<body background="file:///usr/suit/newebox/image/bg/error_bg.jpg" bgcolor="#0a56d">
<table width="630" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="182" height="216">&nbsp;</td>
    <td width="191">&nbsp;</td>
    <td width="249">&nbsp;</td>
  </tr>
  <tr>
    <td height="80">&nbsp;</td>
    <td class=style32b align=center>
    <%
    if(wrong.equals("account"))
		out.println("用户名错误！");
	if(wrong.equals("password"))
		out.println("密码错误！");
	if(wrong.equals("error"))
		out.println("服务器出错!");
	%>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td align="center" valign="top"><div align="center"><a href="javascript:history.back()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image1','','file:///usr/suit/newebox/image/fh2.png',1)"  onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///usr/suit/newebox/image/fh2.png',1)"><img src="file:///usr/suit/newebox/image/fh1.png" name="Image1" border="0"></a></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
