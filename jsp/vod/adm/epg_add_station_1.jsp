<!-- ��ӵ���/��̨Ƶ��-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station.value=="")
	{
		alert("��������������");
		document.add.station.focus();
		return false;
	}
	if(window.document.add.path.value=="")
	{
		alert("����������·��");
		document.add.path.focus();
		return false;
	}
	return true;
}
</script>
<form action=epg_add_station_2.jsp method=post name=add><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>��ӵ���/��̨Ƶ��</caption>
<tr bgcolor=white>
	<td width="25%" align=right>ѡ������:</td>
	<td><input type=radio name=type value=tv checked>����̨&nbsp;&nbsp;
		<input type=radio name=type value=radio>��̨</td>
</tr>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input type=text name=station></td>
</tr>
<tr bgcolor=white>
	<td align=right>����·��</td>
	<td><input type=text name=path size=50></td>
</tr>
<tr bgcolor=white>
	<td></td>
	<td><input type=submit value=�ύ></td>
</tr>
</table>
</form>
