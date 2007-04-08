<!-- 添加电视/电台频道-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station.value=="")
	{
		alert("您忘了输入名称");
		document.add.station.focus();
		return false;
	}
	if(window.document.add.path.value=="")
	{
		alert("您忘了输入路径");
		document.add.path.focus();
		return false;
	}
	return true;
}
</script>
<form action=epg_add_station_2.jsp method=post name=add><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加电视/电台频道</caption>
<tr bgcolor=white>
	<td width="25%" align=right>选择类型:</td>
	<td><input type=radio name=type value=tv checked>电视台&nbsp;&nbsp;
		<input type=radio name=type value=radio>电台</td>
</tr>
<tr bgcolor=white>
	<td align=right>名称:</td>
	<td><input type=text name=station></td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=path size=50></td>
</tr>
<tr bgcolor=white>
	<td></td>
	<td><input type=submit value=提交></td>
</tr>
</table>
</form>
