<script language="javascript">
function check()
{
	if(window.document.add.title.value=="")
	{
		alert("�����˱���");
		document.add.title.focus();
		return false;
	}
	return true;
}
</script>
<form action="vote_add_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>���"ͶƱ"����</caption>
<tr bgcolor=white>
	<td align=right width="12%">���⣺</td>
	<td><input type=text name=title size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ʼ����</td>
	<td><input name=begin_date value=<?=date("Y-m-d")?>>(Ĭ��Ϊ����)</td>
</tr>
<tr bgcolor=white>
	<td align=right>��������</td>
	<td><input name=end_date value=<?=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+10,date("Y")))?>>(Ĭ��Ϊ10���)</td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ�<br>(ÿ��Ϊһ��)</td>
	<td><textarea rows=7 name=item_text cols=29></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ��ʽ��</td>
	<td><input type=radio name=mode value=checkbox>��ѡ&nbsp;&nbsp;<input type=radio name=mode value=radio checked>��ѡ
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;" ></td>
</tr>
</table>
</form>
