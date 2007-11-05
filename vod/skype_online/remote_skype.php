<?
if(''==$iframe_src)
{
	$iframe_src='skype_friend_list';
}
$my_id=54;
?>
<html>
<head>
<title>remote skype</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard 网络名片 电子名片 语音留言 自动答录 电子名片">
<script language="JavaScript" type="text/JavaScript">

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
function call(user_skype)
{
	if(''!=user_skype)
	{
	//	location="callto:"+skype;
		document.frames("ifm_send").location="send_code.php?device=w90_1&code=1250&para1=goldsoft01&para2="+user_skype;
		document.getElementById('statusbar').innerHTML='正在发送指令...';
		window.setTimeout("document.getElementById('statusbar').innerHTML=''",4000);
	}
	else
	{
		if(window.document.all.skypeoutnum.value.length>1)
		{
			document.frames("ifm_send").location="send_code.php?device=w90_1&code=1250&para1=goldsoft01&para2="+document.all.skypeoutnum;
			document.getElementById('statusbar').innerHTML='正在发送指令...';
			window.setTimeout("document.getElementById('statusbar').innerHTML=''",4000);
		}
		else
		{
			alert('您没有选择呼叫对象');
		}
	}
}
function calloff()
{
	document.frames("ifm_send").location="send_code.php?device=w90_1&code=1222";
	document.getElementById('statusbar').innerHTML='正在发送指令...';
	window.setTimeout("document.getElementById('statusbar').innerHTML=''",4000);
}
function pop_user_info(user_id)
{
	if(''!=user_id)
	{
		window.open('user_info.php?user_id='+user_id,'','width=450,height=400,toolbar=no,status=no,scrollbars=yes,resizable=no');
	}
	else
	{
		alert('您没有选择对象');
	}
}
function add_friend(user_id)
{
	if(''!=user_id)
	{
		document.frames("skype_friend_find").location="user_info.php?action=addFriend&my_id=<?=$my_id?>&user_id="+user_id;
	}
	else
	{
		alert('您没有选择对象');
	}
}

function changeFunction(a)
{
	if(a=='list')
	{
		document.getElementById("skype_friend_list").style.display="";
		document.getElementById("skype_friend_find").style.display="none";
		document.Image3.src="image/skype/title1_2.gif";
		document.Image4.src="image/skype/title2_1.gif";
		document.getElementById('callfunction').innerHTML='<a href="#" onclick=\'call(document.frames("skype_friend_list").document.getElementById("s_user_skype").innerHTML)\'><img src="image/skype/icon3_2.gif" name=Image5 border=0></a><span style="margin-left:7em"></span><a href="#" onclick="calloff()"><img src="image/skype/icon4_2.gif" name=Image6 border=0></a>';
		document.getElementById('functionbar').innerHTML='<a href="javascript:void(0)" onclick="pop_user_info(document.frames(\'skype_friend_list\').document.getElementById(\'s_user_id\').innerHTML)"><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image1\',\'\',\'image/skype/icon1_2.gif\',1)" src="image/skype/icon1_1.gif" name=Image1 border=0></a><img src="image/skype/icon2_0.gif" name=Image2 border=0>';
	}
	if(a=='find')
	{
		document.getElementById("skype_friend_list").style.display="none";
		document.getElementById("skype_friend_find").style.display="";
		document.Image3.src="image/skype/title1_1.gif";
		document.Image4.src="image/skype/title2_2.gif";
		document.getElementById('callfunction').innerHTML='<img src="image/skype/icon3_1.gif" name=Image5 border=0><span style="margin-left:7em"></span><a href="#" onclick="calloff()"><img src="image/skype/icon4_2.gif" name=Image6 border=0></a>';
		document.getElementById('functionbar').innerHTML='<a href="javascript:void(0)" onclick="pop_user_info(document.frames(\'skype_friend_find\').document.getElementById(\'s_user_id\').innerHTML)"><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image1\',\'\',\'image/skype/icon1_2.gif\',1)" src="image/skype/icon1_1.gif" name=Image1 border=0></a><a href="javascript:void(0)" onclick="add_friend(document.frames(\'skype_friend_find\').document.getElementById(\'s_user_id\').innerHTML)"><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image2\',\'\',\'image/skype/icon2_2.gif\',1)" src="image/skype/icon2_1.gif" name=Image2 border=0></a>';
	}
}
function changeFrame(){
  alert (document.all.skype_friend_list.src);
  document.all.skype_friend_list.src="http://www.microsoft.com/";
  alert (document.all.skype_friend_list.src);
}
</script>
</head>
<body topmargin=0 leftmargin=0 background="image/skype/skype_bg.jpg" style="background-repeat: no-repeat;background-attachment:fixed">
<table width="329" height="496" border=0 cellpadding=0 cellspacing=0 >
<tr>
	<td width=5></td>
	<td width=100 height=30>&nbsp;</td>
	<td >&nbsp;</td>
	<td width=5></td>
</tr>
<tr>
	<td></td>
	<td colspan=3 height=20>&nbsp;</td>
</tr>
<tr>
	<td></td>
	<td height=50 colspan=2><span id=functionbar><a href="javascript:void(0)" onclick='pop_user_info(document.frames("skype_friend_list").document.getElementById("s_user_id").innerHTML)'><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','image/skype/icon1_2.gif',1)" src="image/skype/icon1_1.gif" name=Image1 border=0></a><img src="image/skype/icon2_0.gif" name=Image2 border=0></span><a href="javascript:void(0)" onclick="showModalDialog('skype_add_meeting.php','','dialogWidth:572px;dialogHeight:469px;center:yes;status:no;scroll:no;help:no');"><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','image/skype/icon5_2.gif',1)" src="image/skype/icon5_1.gif" name=Image7 border=0></a><img onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','image/skype/icon6_2.gif',1)" src="image/skype/icon6_1.gif" name=Image8 border=0></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td height=21 colspan=2>
	<a href="javascript:void(0)" onclick="changeFunction('list');blur();"><img src="image/skype/title1_2.gif" name=Image3 border=0></a><a href="javascript:void(0)" onclick="changeFunction('find');blur();"><img src="image/skype/title2_1.gif" name=Image4 border=0></a>
	</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td height=263 colspan=2 valign=top>
	<iframe id="skype_friend_list" name="skype_friend_list" frameborder=0 width="100%" height="100%" src="skype_friend_list.php" allowTransparency="true" style="display:"></iframe>
	<iframe id="skype_friend_find" name="skype_friend_find" frameborder=0 width="100%" height="100%" src="skype_friend_list.php?list=user" allowTransparency="true" style="display:none"></iframe>
	</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td height=20 colspan=2 style="border-top:1px solid #919ba5"><input type=text name=skypeoutnum size=51 style="border:#919ba5 0px solid;background-color:white;"></input></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td height=58 colspan=2 align=center id=callfunction>
	<a href="#" onclick='call(document.frames("skype_friend_list").document.getElementById("s_user_skype").innerHTML)'><img  src="image/skype/icon3_2.gif" name=Image5 border=0></a><span style="margin-left:7em"></span><a href="#" onclick="calloff()"><img src="image/skype/icon4_2.gif" name=Image6 border=0></a>
	</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td height=27 colspan=2><span id="statusbar" style="margin-left:40px"></span></td>
	<td></td>
</tr>
</table>
<div style="display:none"><iframe id="ifm_send" name="ifm_send" width="0" height="0" src=""></iframe></div>
</body>
</html>
