<script language="javascript">
function check()
{
	if(window.document.add.title.value=="")
	{
		alert("�����˱���");
		document.add.title.focus();
		return false;
	}
	if(window.document.add.type.value=="")
	{
		alert("������ѡ������");
		return false;
	}
	return true;
}
</script>
<form action="zw_add_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>���"��������"����</caption>
<tr bgcolor=white>
	<td align=right width="12%">���⣺</td>
	<td colspan=2><input type=text name=title size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right rowspan=5>ѡ������:</td>
	<td align=left colspan=2><input type=radio name=select_type onfocus="document.add.type.value='yaowen';">����Ҫ��(http://www.snsina.com/gov/affair/index.html)</td>
</tr>
<tr bgcolor=white>
	<td align=left rowspan=4 width="10%">��ҵ����</td>
	<td align=left><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='xiangmu';">Ͷ����Ŀ</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='huanjing';">Ͷ�ʻ���</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='youhui';">�Ż�����</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type0.value='qiye',document.add.type.value='fuwu';">�������</input></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ݣ�</td>
	<td colspan=2><textarea rows=16 name=info cols=60></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=type0 value="">
<input type=hidden name=type value="">
</form>
