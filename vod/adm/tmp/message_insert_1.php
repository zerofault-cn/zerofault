<script language="javascript">
function check()
{
	if(window.document.message.user.value=="")
	{
		alert("������������");
		document.message.user.focus();
		return false;
	}
	if(window.document.message.title.value=="")
	{
		alert("���������Ա���");
		document.message.title.focus();
		return false;
	}
	if(window.document.message.info.value=="")
	{
		alert("������д��������");
		document.message.info.focus();
		return false;
	}
	return true;
}
</script>

<form method=post action="message_insert_2.php" name=message onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�������</caption>
<tr bgcolor=white>
	<td width="20%" align=right><span class=red>*</span>������:</td>
	<td width="80%"><input type=text name=user size=20></td></tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>���Ա���:</td>
	<td align=left><INPUT TYPE="text" NAME="title"size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>��������:</td>
	<td><textarea name=info rows=10 cols=50></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type="submit" value="�ύ">&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="reset" value="��д">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type=button value="�鿴����" onclick="javascript:window.location='index.php?content=message_index'"></td>
</tr>
</table>
</form>
