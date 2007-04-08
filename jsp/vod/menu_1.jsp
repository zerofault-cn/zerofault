<%@ page errorPage="error.jsp" %>
<%
//Cookie cookies[]=request.getCookies();
//Cookie sCookie=null;
//String sname=null;
//String svalue=null;
//if(cookies!=null&&cookies.length!=0)
//{
//	sCookie=cookies[0];
//	sname=sCookie.getName();
//	svalue=sCookie.getValue();
//}
//if(sname==null||svalue==null||!sname.equals("goldsoft")||!svalue.equals("vod"))
//{
//	response.sendRedirect("login_1.jsp");
//}
//else
{
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>主菜单-1</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
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

function onfoc(key)
{
	document.links[key].focus();
}
function loc(url)
{
	location=url;
}
function keyPress(e)
{
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48;
	var patern=/^[1-8]$/; 
	if (patern.exec(key1)) {
		document.links[key1-1].focus();
		location = document.links[key1 - 1];
		
	}
	if(keycode==13)
	{
		location=document.links[key1-1];
	}

	if(keycode==59)
	{
		location="logoff.jsp";
	}
	
}    
document.onkeypress=keyPress

//-->
</script>

</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/bg/totalmenu.jpg" bgcolor="#0a56d" onload="document.links[0].focus();MM_preloadImages('file:///usr/suit/newebox/image/menu/tqyb2.png','file:///usr/suit/newebox/image/menu/ksdh2.png','file:///usr/suit/newebox/image/menu/vod2.png','file:///usr/suit/newebox/image/menu/music2.png','file:///usr/suit/newebox/image/menu/wlds2.png','file:///usr/suit/newebox/image/menu/wldt2.png','file:///usr/suit/newebox/image/menu/ssxw2.png')">
<table width="630" height="460" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=33 height=15></td>
	<td width=560></td>
	<td width=37></td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width=560 height=430 cellspacing=0 cellpadding=0>
	<tr>
		<td width=27 height=22></td>
		<td width=190></td>
		<td width=28></td>
		<td width=300></td>
		<td width=15></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
		<tr>
			<td height=10></td>		
		</tr>
		<!-- <tr>
			<td height=40><a href="weatherpage.htm" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image1','','newebox/image/menu/tqyb2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','newebox/image/menu/tqyb2.png',1)"><img src="newebox/image/menu/tqyb1.png" name="Image1" width=194 height=50 border="0"></a></td>
		</tr> -->
		<tr>
			<td height=60><a href="file:///usr/suit/newebox/phone1.htm" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image2','','file:///usr/suit/newebox/image/menu/ksdh2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','file:///usr/suit/newebox/image/menu/ksdh2.png',1)"><img src="file:///usr/suit/newebox/image/menu/ksdh1.png" name="Image2" width=194 height=50  border="0"></a></td>
		</tr>
		<tr>
			<td height=60><a href="vod_typelist.jsp" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image3','','file:///usr/suit/newebox/image/menu/vod2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','file:///usr/suit/newebox/image/menu/vod2.png',1)"><img src="file:///usr/suit/newebox/image/menu/vod1.png" name="Image3" width=194 height=50 border="0"></a></td>
		</tr>
		<tr>
			<td height=60><a href="music_index.jsp" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image4','','file:///usr/suit/newebox/image/menu/music2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','file:///usr/suit/newebox/image/menu/music2.png',1)"><img src="file:///usr/suit/newebox/image/menu/music1.png" name="Image4" width=194 height=50 border="0"></a></td>
		</tr>
		
		<tr>
			<td height=60><a href="epg_station.jsp?type=tv" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image5','','file:///usr/suit/newebox/image/menu/wlds2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','file:///usr/suit/newebox/image/menu/wlds2.png',1)"><img src="file:///usr/suit/newebox/image/menu/wlds1.png" name="Image5" width=194 height=50 border="0"></a></td>
		</tr>
		<tr>
			<td height=60><a href="epg_station.jsp?type=radio" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image6','','file:///usr/suit/newebox/image/menu/wldt2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','file:///usr/suit/newebox/image/menu/wldt2.png',1)"><img src="file:///usr/suit/newebox/image/menu/wldt1.png" name="Image6" width=194 height=50 border="0"></a></td>
		</tr>
		<!-- <tr>
			<td height=40><a href="news_index.jsp" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image7','','newebox/image/menu/ssxw2.png',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','newebox/image/menu/ssxw2.png',1)"><img src="newebox/image/menu/ssxw1.png" name="Image7" width=194 height=50  border="0"></a></td>
		</tr> -->
		</table></td>
		<td>&nbsp;</td>
		<td valign=top>
			<table border=0 cellpadding="0" cellspacing="0">
			<tr>
				<td height=25></td>
			</tr>
			<tr>
				<td><embed src="file:///usr/suit/newebox/list/list__menu1" width="300" height="225" type="application/x-mplayer2"></embed></td>
			</tr>
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
	<td height=15></td>
	<td></td>
	<td></td>
</tr>
</table>

</body>
</html>
<%
}
%>