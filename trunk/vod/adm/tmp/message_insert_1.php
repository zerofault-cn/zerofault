<script language="javascript">
function check()
{
	if(window.document.message.user.value=="")
	{
		alert("请输入留言人");
		document.message.user.focus();
		return false;
	}
	if(window.document.message.title.value=="")
	{
		alert("请输入留言标题");
		document.message.title.focus();
		return false;
	}
	if(window.document.message.info.value=="")
	{
		alert("您忘了写留言内容");
		document.message.info.focus();
		return false;
	}
	return true;
}
</script>

<form method=post action="message_insert_2.php" name=message onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加留言</caption>
<tr bgcolor=white>
	<td width="20%" align=right><span class=red>*</span>留言人:</td>
	<td width="80%"><input type=text name=user size=20></td></tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>留言标题:</td>
	<td align=left><INPUT TYPE="text" NAME="title"size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>留言内容:</td>
	<td><textarea name=info rows=10 cols=50></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="reset" value="重写">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type=button value="查看留言" onclick="javascript:window.location='index.php?content=message_index'"></td>
</tr>
</table>
</form>
