<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>主菜单-1</title>
<link rel="stylesheet" href="style.css" type="text/css">
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
var key2=0;
function setkey2(i)
{
	key2=i;
}
if(document.all)
{
	var ie=1;
	var ns=0;
}
else
{
	var ns=1;
	var ie=0;
}
function keyDown(e)
{
	if (ns)
	{ 
		var keycode=e.which
	} 
	if (ie)
	{ 
		var keycode=event.keyCode; 
	}
	var key1 = keycode -48;
	var patern=/^[1-4]$/; 
	if (patern.exec(key1)) {
		document.links[key1-1].focus();
		location = document.links[key1 - 1];
		
	}
	if(keycode==13)
	{
		location=document.links[key1-1];
	}
	if(keycode==36)
	{
		location="zw_index.php";
	}
	if(keycode==38)
	{
		key2--;
		if(key2<0)
		{
			key2=3;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==40)
	{
		key2++;
		if(key2>3)
		{
			key2=0;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
}    
document.onkeydown=keyDown

//-->
</script>

</head>

<body leftMargin=0 topMargin=0 background="image/zw/zw1_bg.jpg" onload="setkey2(0);document.links[0].focus()" style="background-Attachment:fixed;background-repeat:no-repeat;">
<table width="800" height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20></td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=276 height=125>&nbsp;</td>
		<td width=205>&nbsp;</td>
		<td width=279>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
		<tr>
			<td height=58><a href="zw_news_title.php?type0=qiye&type=youhui" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image1','','image/zw/qiye1_2.gif',1);setkey2(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','image/zw/qiye1_2.gif',1)"><img src="image/zw/qiye1_1.gif" name="Image1" border="0"></a></td>
		</tr>
		<tr>
			<td height=58><a href="zw_news_title.php?type0=qiye&type=xiangmu" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image2','','image/zw/qiye2_2.gif',1);setkey2(1)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','image/zw/qiye2_2.gif',1)"><img src="image/zw/qiye2_1.gif" name="Image2" border="0"></a></td>
		</tr>
		<tr>
			<td height=58><a href="zw_news_title.php?type0=qiye&type=huanjing" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image3','','image/zw/qiye3_2.gif',1);setkey2(2)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','image/zw/qiye3_2.gif',1)"><img src="image/zw/qiye3_1.gif" name="Image3" border="0"></a></td>
		</tr>
		<tr>
			<td height=58><a href="zw_news_title.php?type0=qiye&type=fuwu" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image4','','image/zw/qiye4_2.gif',1);setkey2(3)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','image/zw/qiye4_2.gif',1)"><img src="image/zw/qiye4_1.gif" name="Image4" border="0"></a></td>
		</tr>
		</table></td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('zw_index.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>

</table>

</body>
</html>
