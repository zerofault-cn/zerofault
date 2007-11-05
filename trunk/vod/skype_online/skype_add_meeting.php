<html>
<head>
<title>add to meeting</title>
<link rel="stylesheet" href="sstyle.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
</head>
<body topmargin=0 leftmargin=0 background="image/skype/add_meeting_bg.jpg" style="background-repeat: no-repeat;background-attachment:fixed">
<table border=0 width="572" cellspacing=0 cellpadding=0>
<tr>
	<td width=67 height=136>&nbsp;</td>
	<td width=214>&nbsp;</td>
	<td width=40>&nbsp;</td>
	<td width=215>&nbsp;</td>
	<td width=35>&nbsp;</td>
</tr>
<tr>
	<td></td>
	<td height=202 valign=top>
	<iframe id="skype_friend_list" name="skype_friend_list" frameborder=0 width="213" height="100%" src="skype_friend_list.php" allowTransparency="true" style="display:"></iframe>
	</td>
	<td></td>
	<td valign=top id=meeting_list>
	</td>
	<td></td>
</tr>
<tr>
	<td height=24 colspan=5></td>
</tr>
<tr>
	<td height=40></td>
	<td align=center valign=top><input type=button name=add onclick='add(document.frames("skype_friend_list").document.getElementById("s_user_skype").innerHTML,document.frames("skype_friend_list").document.getElementById("s_user_info").innerHTML)' style="padding:1px" value="    添加 >>    "></td>
	<td></td>
	<td align=center valign=top><input type=button name=remove onclick='remove(document.getElementById("s_i").innerHTML)' style="padding:1px" value="    << 删除    "></td>
	<td></td>
</tr>
	<td height=40 colspan=4 align=right valign=top><input type=button name=start disabled onclick="start_meeting();" value="  启动  ">&nbsp;&nbsp;<input type=button name=close onclick="javascript:window.close()" value="  取消  "></td>
	<td></td>
</tr>
</table>
</body>
<script language="javascript">
var n=0;
var send_info='goldsoft01';//会议发起者
function add(skype,dat)
{
	if(n>=4)
	{
		alert('会议名额已满');
	}
	else
	{
		if(send_info.search(skype)!='-1')
		{
			alert('所选择的对象已经添加过了');
		}
		else
		{
			send_info+='|'+skype;
			dat2='<div id='+n+' style="padding:1px" onclick="clicki('+n+');" onMouseOver=this.style.backgroundColor="#c7e0ff" onMouseOut=this.style.backgroundColor="">'+dat+'</div>';
			document.getElementById("meeting_list").innerHTML+=dat2;
			n++;
		}
	}
	if(n>0)
	{
		document.all.start.disabled=false;
	}
}
function remove(i)
{
	if(''==i)
	{
		alert('您没有选择对象');
	}
	else
	{
		document.getElementById(i).style.display="none";
		document.getElementById('s_i').innerHTML="";
		n--;
	}
}
function clicki(i)
{
	document.getElementById('s_i').innerHTML=i;
//	alert(i);
	reset();
	show(i);
}
function reset()
{
	for(var j=0;j<n;j++)
	{
		document.getElementById(j).style.backgroundColor="";
	}
}
function show(i)
{
	document.getElementById(i).style.backgroundColor="#c7e0ff";
}
function start_meeting()
{
	document.frames("ifm_send").location="send_code.php?device=w90_1&code=1250&para1=goldsoft01&para2="+send_info;
	window.close();
}
</script>
<span style="display:none" id=s_i></span>
<div style="display:none"><iframe id="ifm_send" name="ifm_send" width="0" height="0" src=""></iframe></div>
</html>