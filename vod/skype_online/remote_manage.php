<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
<title>远程网关管理</title>
<style>
td
{
	font-size:12pt;
}
</style>
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

var i=0,is_up=0;//is_up为0表示未拨号
var j=0;
var phone1='';
function hangon()
{
	if(phone1.length!=0)
	{
		is_up=1;
		location="";
	}
}

function hangoff()
{
	is_up=0;
	location="";
}


function dial(n) 
{
	phone1+=n;
//	t1=document.getElementById("phone");
//	t1.innerHTML=phone1;
	document.all.phone.value=phone1;
}

//-->
</script>
</head>

<body>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
	<td width=300 valign="top">
	<table border=1 cellspacing=0 cellpadding=0>
	<caption>网关控制</caption>
	<tr>
		<td width=150><a href="send_code.php?device=w90_1&code=0056" target=0056>网关版本</a></td>
		<td width=150><iframe name="0056" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=0400" target=0400>网关挂机</a></td>
		<td><iframe name="0400" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=0500" target=0500>网关摘机</a></td>
		<td><iframe name="0500" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=0600" target=0600>连接LINE口电话</a></td>
		<td><iframe name="0600" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=0700" target=0700>断开LINE口电话</a></td>
		<td><iframe name="0700" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	</table>
	<table border=1 cellspacing=0 cellpadding=0>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1001" target=gw>连接网关</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1002" target=gw>重启Skype</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1101" target=gw>查询网关版本</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1102" target=gw>GW OnHook</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1103" target=gw>GW OffHook</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1104" target=gw>GW LINE口连接电话</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1105" target=gw>GW LINE口断开电话</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1106" target=gw>GW转接Skype</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1107" target=gw>GW转接短信猫</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1108" target=gw>GW转接外网电话</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1109" target=gw>GW转接内网电话</a></td>
		<td></td>
	</tr>
	<tr>
		<td><a href="send_code.php?device=w90_1&code=1110" target=gw>GW转接语音信箱</a></td>
		<td></td>
	</tr>
	<tr>
		<td colspan=2><iframe name="gw" width="100%" height="24" src="send_code.php"></iframe></td>
	</tr>
	</table>
	</td>
	<td width=279 align=center valign=top>
	<iframe name="remote_phone" width="100%" height="383" frameborder=0 src="remote_phone.php"></iframe>
	</td>
	<td width=333 align=center valign=top>
	<iframe name="remote_skype" width="100%" height="500" frameborder=0 src="remote_skype.php"></iframe>
	</td>
</tr>
</table>
</body>
</html>
