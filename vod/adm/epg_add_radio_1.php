<!-- ��ӵ���/��̨Ƶ��-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station_name.value=="")
	{
		alert("��������������");
		document.add.station_name.focus();
		return false;
	}
	if(window.document.add.station_path.value=="")
	{
		alert("����������·��");
		document.add.station_path.focus();
		return false;
	}
	return true;
}
</script>
<form action="epg_add_radio_2.php" method=post name=add>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>��ӵ�̨</caption>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input type=text name=station_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>����·��</td>
	<td><input type=text name=station_path size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ŀ����ַ</td>
	<td><input type=text name=schedule_url size=50>(����Ϊ��)</td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=type value=radio></td>
	<td><input type=submit value=�ύ></td>
</tr>
</table>
</form>
