<script language="javascript">
function mysubmit()
{
	if(window.document.search.key_prog_name.value=="")
	{
		alert("��������������");
		document.search.key_prog_name.focus();
		return;
	}
	else
	{
		var key_prog_name=window.document.search.key_prog_name.value;
		location="?content=music_search_prog_2&key_prog_name="+key_prog_name;
	}
	
}
function check()
{
	if(window.document.search.key_prog_name.value=="")
	{
		alert("��������������");
		document.search.key_prog_name.focus();
		return false;
	}
	return true;
}
</script>
<center>
<form action="index.php?content=music_search_prog_2" method=post name=search onsubmit="return check()">
<table width="70%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>���ֿ�������</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
	<td><input type=text name=key_prog_name>(����ؼ��ּ���)</td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="��ʼ����"></td>
</tr>
</table>
</form>
</center>
