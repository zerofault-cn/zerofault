<script language="javascript">
function check()
{
	if(window.document.add.title.value=="")
	{
		alert("您忘了标题");
		document.add.title.focus();
		return false;
	}
	return true;
}
</script>
<form action="vote_add_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加"投票"主题</caption>
<tr bgcolor=white>
	<td align=right width="12%">主题：</td>
	<td><input type=text name=title size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>开始日期</td>
	<td><input name=begin_date value=<?=date("Y-m-d")?>>(默认为今天)</td>
</tr>
<tr bgcolor=white>
	<td align=right>结束日期</td>
	<td><input name=end_date value=<?=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+10,date("Y")))?>>(默认为10天后)</td>
</tr>
<tr bgcolor=white>
	<td align=right>选项：<br>(每行为一项)</td>
	<td><textarea rows=7 name=item_text cols=29></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right>选择方式：</td>
	<td><input type=radio name=mode value=checkbox>多选&nbsp;&nbsp;<input type=radio name=mode value=radio checked>单选
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;" ></td>
</tr>
</table>
</form>
