<script language="javascript">
function check()
{
	if(window.document.add.title.value=="")
	{
		alert("您忘了标题");
		document.add.title.focus();
		return false;
	}
	if(window.document.add.type.value=="")
	{
		alert("您忘了选择类型");
		return false;
	}
	return true;
}
</script>
<form action="zw_add_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加"电子政务"内容</caption>
<tr bgcolor=white>
	<td align=right width="12%">标题：</td>
	<td colspan=2><input type=text name=title size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right rowspan=5>选择类型:</td>
	<td align=left colspan=2><input type=radio name=select_type onfocus="document.add.type.value='yaowen';">政务要闻(http://www.snsina.com/gov/affair/index.html)</td>
</tr>
<tr bgcolor=white>
	<td align=left rowspan=4 width="10%">企业服务</td>
	<td align=left><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='xiangmu';">投资项目</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='huanjing';">投资环境</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='youhui';">优惠政策</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='fuwu';">服务机构</input></td>
</tr>
<tr bgcolor=white>
	<td align=right>内容：</td>
	<td colspan=2><textarea rows=16 name=info cols=60></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=type0 value="">
<input type=hidden name=type value="">
</form>
