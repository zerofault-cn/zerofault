<!-- 添加电视/电台频道-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station_name.value=="")
	{
		alert("您忘了输入名称");
		document.add.station_name.focus();
		return false;
	}
	if(window.document.add.station_path.value=="")
	{
		alert("您忘了输入路径");
		document.add.station_path.focus();
		return false;
	}
	return true;
}
</script>
<form action="epg_add_radio_2.php" method=post name=add>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加电台</caption>
<tr bgcolor=white>
	<td align=right>名称:</td>
	<td><input type=text name=station_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=station_path size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单网址</td>
	<td><input type=text name=schedule_url size=50>(可以为空)</td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=type value=radio></td>
	<td><input type=submit value=提交></td>
</tr>
</table>
</form>
