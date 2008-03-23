<div id="login">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#ffffff">
<form name="form1" method="post" action="login_act.php">
<tr>
	<td height="34" colspan="2"><span style="margin-left:18px;color:#fddd04;font-family:WST_ENGl">WWW.PANSKY.NET</span></td>
</tr>
<tr>
	<td height="20" colspan="2"><span style="margin-left:54px">用户登录</span></td>
</tr>
<tr>
	<td width="65" height="16"></td><td></td>
</tr>
<tr>
	<td height="24" align="right">帐号：</td>
	<td><input type="text" name="account" size="16" class="input_text"></td>
</tr>
<tr>
	<td height="24" align="right">密码：</td>
	<td><input type="password" name="password" size="16" class="input_text"></td>
</tr>
<!-- <tr>
	<td height="24" align="right">验证码：</td>
	<td><input type="text" name="validate" size="6" class="input_text"> <img src="image/src/vali.jpg" align="absmiddle"></td>
</tr>
 -->
 <tr>
	<td height="24" colspan="2"><span style="margin-left:16px">记住帐号：</span><input type="checkbox" name="keepme" value="1">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit1" value=" 登 录 " style="background-image:url('image/index1_04.gif')"></td>
</tr>
<tr>
	<td height="24" colspan="2" align="center"><input type="button" name="button1" value="注册">&nbsp;&nbsp;<input type="button" name="button2" value="忘记密码"></td>
</tr>
</form>
</table>
</div>

<div id="login_info">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#ffffff">
<tr>
	<td height="34" colspan="2"><span style="margin-left:18px;color:#fddd04;font-family:WST_ENGl">WWW.PANSKY.NET</span></td>
</tr>
<tr>
	<td height="20" colspan="2"><span style="margin-left:54px">用户信息</span></td>
</tr>
<tr>
	<td width="65" height="16"></td><td></td>
</tr>
<tr>
	<td height="24" align="center" colspan=2><span id="account1"></span><br>已经登录</td>
</tr>
</table>
</div>

<div style="display:none"><iframe name="login_frame" width="0" height="0" src=""></iframe></div>
<script>
function getCookieVal (offset)
{
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1)
		endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) 
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) 
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return getCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break; 
	}
	return null;
}
//alert(GetCookie("account"));
if(GetCookie("account")!='' && GetCookie("account")!=null)
{
	login.style.display="none";
	login_info.style.display="";
}
else
{
	login.style.display="";
	login_info.style.display="none";
}
document.getElementById('account1').innerHTML=GetCookie("account");

//alert(document.referrer);
</script>