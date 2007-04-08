<%@ page contentType="text/html;charset=gb2312" %>
<%
String account = request.getParameter("account");
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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

password0 = '<span class="style24b" style="font-family:verdana">';
password1 = '';
password2 = '</span>';
function img_click() 
{	
	t1 = document.getElementById("password");
	if(password1.length>13||password1.length<1)
	{ 
		password1='' ;
		t1.innerHTML = '';
	}            
	else 
		location="pz44.jsp?account=<%=account%>&password=" + password1;
}

function img_click_1() {
	history.go(-1);
}
var shift=1;
function img_click_2(m,n) {
	if(shift==0)
		password1 += m;
	else 
		password1 += n;
	var p2 = '';
	for(i=0;i<password1.length;i++) 
		p2 += '*'
	t1 = document.getElementById("password");
	t1.innerHTML = password0 + p2 + password2;
    if(password1.length==14)
	{ 
		password1='' ;
		t1.innerHTML = '';
	}
}
function img_click_3() {
	if(shift==0) 
		shift = 1;
	else 
		shift = 0;
}
function img_click_4() {
	var password4 = password1;
	password4 = password4.substring(0,password4.length - 1);
	password1=password4;
	var p2 = '';
	for(i=0;i<password1.length;i++) 
		p2 += '*'
	t1 = document.getElementById("password");
	t1.innerHTML = password0 + p2 + password2;
}
function keyPress(e){
　　var keycode=e.which;
    if (keycode==0)
       keycode=e.keyCode;
    if(keycode==8)   
       img_click_4();       
    var realkey=String.fromCharCode(e.which)
　	if(keycode==36)  img_click_1();
	if(keycode==35)  img_click();
	if(keycode==13)  img_click_2(m,n);
	if ((keycode>=48&&keycode<=57)||(keycode>=97&&keycode<=122)||(keycode>=65&&keycode<=90)) {
		password1 += realkey
		var p2 = '';
		for(i=0;i<password1.length;i++) 
			p2 += '*'
	    t1 = document.getElementById("password");
	    t1.innerHTML = password0 + p2 + password2;
	    if(password1.length>13||password1.length<1)
		{ 
			password1='' ;
			t1.innerHTML = '';
		}
	}
	if(keycode!=9)
	    if(keycode>40||keycode<37)
		   return false;  //屏蔽按键对文本输入框的影响
}    

document.onkeypress=keyPress; 
//-->
</script>
</head>

<body leftMargin=0 topMargin=0 bgcolor="#0a56d" background="file:///usr/suit/newebox/image/keyboard/bohao_bg.jpg">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>&nbsp;</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="225" height="30" >&nbsp;</td>
	<td width="209" >&nbsp;</td>
	<td width="173"></td>
</tr>
<tr>
	<td height="70"></td>
	<td align=center class=style24b>&nbsp;</td>
	<td></td>
</tr>

<tr>
	<td height=32 align="right"><img src="file:///usr/suit/newebox/image/keyboard/password.png" width="150" height="40"></td>
	<td class=style24b id="password" bgcolor="#ffffff"></td>
	<td></td>
</tr>
<tr>
	<td colspan=3 height=12></td>
</tr>
<tr>
	<td colspan=3 align="center" ><a href="#" onclick="img_click()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image57','','file:///usr/suit/newebox/image/keyboard/queding_2.gif',1)"  onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image57','','file:///usr/suit/newebox/image/keyboard/queding_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/queding_1.gif" name="Image57" width="122" height="41" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="img_click_1()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image66','','file:///usr/suit/newebox/image/keyboard/fanhui_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image66','','file:///usr/suit/newebox/image/keyboard/fanhui_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/fanhui_1.gif" name="Image66" width="122" height="41" border="0"></a></td>
    
</tr>
<tr>
	<td height="235" colspan="3" valign="top" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0" background="img/kb.gif">
    <tr>
		<td width="19" height="3"></td>
		<td width="590"></td>
		<td width="21"></td></tr>
	<tr>
		<td height="42"></td>
		<td valign="top">
		<a href="#1" onClick="img_click_2('`','~')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image60','','file:///usr/suit/newebox/image/keyboard/`_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image60','','file:///usr/suit/newebox/image/keyboard/`_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/`_1.gif" name="Image60" width="42" height="42" border="0"></a><a href="#2" onClick="img_click_2('1','!')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image4','','file:///usr/suit/newebox/image/keyboard/1_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','file:///usr/suit/newebox/image/keyboard/1_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/1_1.gif" name="Image4" width="42" height="42" border="0"></a><a href="#3" onClick="img_click_2('2','@')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image5','','file:///usr/suit/newebox/image/keyboard/2_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','file:///usr/suit/newebox/image/keyboard/2_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/2_1.gif" name="Image5" width="42" height="42" border="0"></a><a href="#4" onClick="img_click_2('3','#')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image6','','file:///usr/suit/newebox/image/keyboard/3_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','file:///usr/suit/newebox/image/keyboard/3_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/3_1.gif" name="Image6" width="42" height="42" border="0"></a><a href="#5" onClick="img_click_2('4','$')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image7','','file:///usr/suit/newebox/image/keyboard/4_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','file:///usr/suit/newebox/image/keyboard/4_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/4_1.gif" name="Image7" width="42" height="42" border="0"></a><a href="#6" onClick="img_click_2('5','%')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image8','','file:///usr/suit/newebox/image/keyboard/5_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','file:///usr/suit/newebox/image/keyboard/5_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/5_1.gif" name="Image8" width="42" height="42" border="0"></a><a href="#7" onClick="img_click_2('6','^')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image9','','file:///usr/suit/newebox/image/keyboard/6_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','file:///usr/suit/newebox/image/keyboard/6_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/6_1.gif" name="Image9" width="42" height="42" border="0"></a><a href="#8" onClick="img_click_2('7','&')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image10','','file:///usr/suit/newebox/image/keyboard/7_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','file:///usr/suit/newebox/image/keyboard/7_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/7_1.gif" name="Image10" width="42" height="42" border="0"></a><a href="#9" onClick="img_click_2('8','*')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image11','','file:///usr/suit/newebox/image/keyboard/8_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','file:///usr/suit/newebox/image/keyboard/8_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/8_1.gif" name="Image11" width="42" height="42" border="0"></a><a href="#10" onClick="img_click_2('9','(')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image12','','file:///usr/suit/newebox/image/keyboard/9_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12','','file:///usr/suit/newebox/image/keyboard/9_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/9_1.gif" name="Image12" width="42" height="42" border="0"></a><a href="#11" onClick="img_click_2('0',')')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image13','','file:///usr/suit/newebox/image/keyboard/0_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image13','','file:///usr/suit/newebox/image/keyboard/0_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/0_1.gif" name="Image13" width="42" height="42" border="0"></a><a href="#12" onClick="img_click_2('-','_')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image58','','file:///usr/suit/newebox/image/keyboard/__2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image58','','file:///usr/suit/newebox/image/keyboard/__2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/__1.gif" name="Image58" width="42" height="42" border="0"></a><a href="#13" onClick="img_click_2('=','+')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image59','',file:///usr/suit/newebox/image/keyboard/deng_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image59','','file:///usr/suit/newebox/image/keyboard/deng_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/deng_1.gif" name="Image59" width="42" height="42" border="0"></a><a href="#14" onClick="img_click_4()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image16','','file:///usr/suit/newebox/image/keyboard/backspace_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','file:///usr/suit/newebox/image/keyboard/backspace_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/backspace_1.gif" name="Image16" width="42" height="42" border="0"></a></td>
		<td></td>
	</tr>
	<tr>
		<td height="42"></td>
		<td valign="top">
		<a href="#15" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image70','','file:///usr/suit/newebox/image/keyboard/tab_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/tab_1.gif" name="Image70" width="42" height="42" border="0"></a><a href="#16" onClick="img_click_2('q','Q')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image18','','file:///usr/suit/newebox/image/keyboard/Q_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','file:///usr/suit/newebox/image/keyboard/Q_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/Q_1.gif" name="Image18" width="42" height="42" border="0"></a><a href="#17" onClick="img_click_2('w','W')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image19','','file:///usr/suit/newebox/image/keyboard/W_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image19','','file:///usr/suit/newebox/image/keyboard/W_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/W_1.gif" name="Image19" width="42" height="42" border="0"></a><a href="#18" onClick="img_click_2('e','E')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image20','','file:///usr/suit/newebox/image/keyboard/E_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','file:///usr/suit/newebox/image/keyboard/E_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/E_1.gif" name="Image20" width="42" height="42" border="0"></a><a href="#19" onClick="img_click_2('r','R')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image21','','file:///usr/suit/newebox/image/keyboard/R_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','file:///usr/suit/newebox/image/keyboard/R_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/R_1.gif" name="Image21" width="42" height="42" border="0"></a><a href="#20" onClick="img_click_2('t','T')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image22','','file:///usr/suit/newebox/image/keyboard/T_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image22','','file:///usr/suit/newebox/image/keyboard/T_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/T_1.gif" name="Image22" width="42" height="42" border="0"></a><a href="#21" onClick="img_click_2('y','Y')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image23','','file:///usr/suit/newebox/image/keyboard/Y_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image23','','file:///usr/suit/newebox/image/keyboard/Y_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/Y_1.gif" name="Image23" width="42" height="42" border="0"></a><a href="#22" onClick="img_click_2('u','U')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image24','','file:///usr/suit/newebox/image/keyboard/U_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image24','','file:///usr/suit/newebox/image/keyboard/U_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/U_1.gif" name="Image24" width="42" height="42" border="0"></a><a href="#23" onClick="img_click_2('i','I')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image25','','file:///usr/suit/newebox/image/keyboard/I_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image25','','file:///usr/suit/newebox/image/keyboard/I_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/I_1.gif" name="Image25" width="42" height="42" border="0"></a><a href="#24" onClick="img_click_2('o','O')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image26','','img/O2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image26','','img/O2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/O_1.gif" name="Image26" width="42" height="42" border="0"></a><a href="#25" onClick="img_click_2('p','P')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image27','','file:///usr/suit/newebox/image/keyboard/P_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image27','','file:///usr/suit/newebox/image/keyboard/P_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/P_1.gif" name="Image27" width="42" height="42" border="0"></a><a href="#26" onClick="img_click_2('[','{')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image61','','file:///usr/suit/newebox/image/keyboard/[_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image61','','file:///usr/suit/newebox/image/keyboard/[_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/[_1.gif" name="Image61" width="42" height="42" border="0"></a><a href="#27" onClick="img_click_2(']','}')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image62','','file:///usr/suit/newebox/image/keyboard/]_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image62','',file:///usr/suit/newebox/image/keyboard/]_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/]_1.gif" name="Image62" width="42" height="42" border="0"></a><a href="#28" onClick="img_click_2('\','|')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image30','','file:///usr/suit/newebox/image/keyboard/rightslash_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image30','','file:///usr/suit/newebox/image/keyboard/rightslash_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/rightslash_1.gif" name="Image30" width="42" height="42" border="0"></a></td>
		<td></td>
	</tr>
	<tr>
		<td height="42"></td>
		<td valign="top">
		<a href="#29" onClick="img_click_3()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image31','','file:///usr/suit/newebox/image/keyboard/caps_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image31','','file:///usr/suit/newebox/image/keyboard/caps_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/caps_1.gif" name="Image31" width="42" height="42" border="0"></a><a href="#30" onClick="img_click_2('a','A')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image32','','file:///usr/suit/newebox/image/keyboard/A_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image32','','file:///usr/suit/newebox/image/keyboard/A_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/A_1.gif" name="Image32" width="42" height="42" border="0"></a><a href="#31" onClick="img_click_2('s','S')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image33','','file:///usr/suit/newebox/image/keyboard/S_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image33','','file:///usr/suit/newebox/image/keyboard/S_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/S_1.gif" name="Image33" width="42" height="42" border="0"></a><a href="#32" onClick="img_click_2('d','D')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image34','','file:///usr/suit/newebox/image/keyboard/D_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image34','','file:///usr/suit/newebox/image/keyboard/D_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/D_1.gif" name="Image34" width="42" height="42" border="0"></a><a href="#33" onClick="img_click_2('f','F')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image35','','file:///usr/suit/newebox/image/keyboard/F_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image35','','file:///usr/suit/newebox/image/keyboard/F_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/F_1.gif" name="Image35" width="42" height="42" border="0"></a><a href="#34" onClick="img_click_2('g','G')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image36','','file:///usr/suit/newebox/image/keyboard/G_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image36','','file:///usr/suit/newebox/image/keyboard/G_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/G_1.gif" name="Image36" width="42" height="42" border="0"></a><a href="#35" onClick="img_click_2('h','H')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image37','','file:///usr/suit/newebox/image/keyboard/H_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image37','','file:///usr/suit/newebox/image/keyboard/H_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/H_1.gif" name="Image37" width="42" height="42" border="0"></a><a href="#36" onClick="img_click_2('j','J')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image38','','file:///usr/suit/newebox/image/keyboard/J_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image38','','file:///usr/suit/newebox/image/keyboard/J_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/J_1.gif" name="Image38" width="42" height="42" border="0"></a><a href="#37" onClick="img_click_2('k','K')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image39','',file:///usr/suit/newebox/image/keyboard/K_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image39','','file:///usr/suit/newebox/image/keyboard/K_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/K_1.gif" name="Image39" width="42" height="42" border="0"></a><a href="#38" onClick="img_click_2('l','L')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image40','','file:///usr/suit/newebox/image/keyboard/L_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image40','','file:///usr/suit/newebox/image/keyboard/L_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/L_1.gif" name="Image40" width="42" height="42" border="0"></a><a href="#39" onClick="img_click_2(';',':')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image63','','file:///usr/suit/newebox/image/keyboard/fenhao_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image63','','file:///usr/suit/newebox/image/keyboard/fenhao_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/fenhao_1.gif" name="Image63" width="42" height="42" border="0"></a><a href="#40" onClick="img_click_2(',','"')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image64','',file:///usr/suit/newebox/image/keyboard/yinhao_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image64','','file:///usr/suit/newebox/image/keyboard/yinhao_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/yinhao_1.gif" name="Image64" width="42" height="42" border="0"></a><a href="#41" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image67','','file:///usr/suit/newebox/image/keyboard/enter_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/enter_1.gif" name="Image67" width="84" height="42" border="0"></a></td>
		<td></td>
	</tr>
	<tr>
		<td height="42"></td>
		<td valign="top" align="center">
		<a href="#42" onClick="img_click_2('z','Z')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image44','','file:///usr/suit/newebox/image/keyboard/Z_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image44','','file:///usr/suit/newebox/image/keyboard/Z_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/Z_1.gif" name="Image44" width="42" height="42" border="0"></a><a href="#43" onClick="img_click_2('x','X')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image45','','file:///usr/suit/newebox/image/keyboard/X_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image45','','file:///usr/suit/newebox/image/keyboard/X_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/X_1.gif" name="Image45" width="42" height="42" border="0"></a><a href="#44" onClick="img_click_2('c','C')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image46','','file:///usr/suit/newebox/image/keyboard/C_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image46','','file:///usr/suit/newebox/image/keyboard/C_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/C_1.gif" name="Image46" width="42" height="42" border="0"></a><a href="#45" onClick="img_click_2('v','V')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image47','','file:///usr/suit/newebox/image/keyboard/V_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image47','','file:///usr/suit/newebox/image/keyboard/V_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/V_1.gif" name="Image47" width="42" height="42" border="0"></a><a href="#46" onClick="img_click_2('b','B')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image48','','file:///usr/suit/newebox/image/keyboard/B_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image48','','file:///usr/suit/newebox/image/keyboard/B_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/B_1.gif" name="Image48" width="42" height="42" border="0"></a><a href="#47" onClick="img_click_2('n','N')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image49','','file:///usr/suit/newebox/image/keyboard/N_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image49','','file:///usr/suit/newebox/image/keyboard/N_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/N_1.gif" name="Image49" width="42" height="42" border="0"></a><a href="#48" onClick="img_click_2('m','M')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image50','','file:///usr/suit/newebox/image/keyboard/M_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image50','','file:///usr/suit/newebox/image/keyboard/M_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/M_1.gif" name="Image50" width="42" height="42" border="0"></a><a href="#49" onClick="img_click_2(',','<')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image51','','file:///usr/suit/newebox/image/keyboard/douhao_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image51','','file:///usr/suit/newebox/image/keyboard/douhao_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/douhao_1.gif" name="Image51" width="42" height="42" border="0"></a><a href="#50" onClick="img_click_2('.','>')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image52','','file:///usr/suit/newebox/image/keyboard/dianhao_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image52','','file:///usr/suit/newebox/image/keyboard/dianhao_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/dianhao_1.gif" name="Image52" width="42" height="42" border="0"></a><a href="#51" onClick="img_click_2('/','?')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image65','','file:///usr/suit/newebox/image/keyboard/leftslash_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image65','','file:///usr/suit/newebox/image/keyboard/leftslash_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/leftslash_1.gif" name="Image65" width="42" height="42" border="0"></a><a href="#52" onClick="img_click_3()" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image53','','file:///usr/suit/newebox/image/keyboard/shift_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image53','','file:///usr/suit/newebox/image/keyboard/shift_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/shift_1.gif" name="Image53" width="84" height="42" border="0"></a></td>
		<td></td>
	</tr>
	<tr>
		<td height="42"></td>
		<td valign="top" align="center">
		<a href="#53" onClick="img_click_2(' ',' ')" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image54','','file:///usr/suit/newebox/image/keyboard/space_2.gif',1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image54','','file:///usr/suit/newebox/image/keyboard/space_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/space_1.gif" name="Image54" width="210" height="42" border="0"></a><a href="#54" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image68','','file:///usr/suit/newebox/image/keyboard/insert_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/insert_1.gif" name="Image68" width="84" height="42" border="0"></a><a href="#55" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image69','','file:///usr/suit/newebox/image/keyboard/del_2.gif',1)"><img src="file:///usr/suit/newebox/image/keyboard/del_1.gif" name="Image69" width="84" height="42" border="0"></a></td>
		<td></td>
	</tr>
	<tr>
		<td height="14"></td>
		<td></td>
		<td></td>
	</tr>
    </table></td>
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
