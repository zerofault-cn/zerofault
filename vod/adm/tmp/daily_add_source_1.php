<script language="javascript">
function check()
{
	if(window.document.add_source.select_flag.value!=1)
	{
		alert("��ѡ������");
		return false;
	}
	if(window.document.add_source.title.value=="")
	{
		alert("���������");
		document.add_source.title.focus();
		return false;
	}
	if(window.document.add_source.source.value=="")
	{
		alert("��ѡ���ļ�");
		document.add_source.source.focus();
		return false;
	}
	if(window.document.add_source.source.value!="")
	{
		source_file=window.document.add_source.source.value;
		source_file_ext=source_file.substring(source_file.lastIndexOf("."));	if(source_file_ext!='.wmv'&&source_file_ext!='.WMV'&&source_file_ext!='.rm'&&source_file_ext!='.RM')
		{
			alert("Ŀǰֻ���ϴ�wmv��rm��ʽ���ļ�");
			document.add_source.source.focus();
			return false;
		}
	}
	if(window.document.add_source.descr.value=="")
	{
		alert("�������Ҫ����");
		document.add_source.descr.focus();
		return false;
	}
	return true;
}
</script>
<form method=post action="daily_add_source_2.php" name="add_source" onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>���"��������"����</caption>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td align=left>
	<select name=type onchange="document.add_source.select_flag.value=1">
	<option>-��ѡ��-</option>
	<?
	include_once "../include/mysql_connect.php";
	$sql1="select * from daily_type where del_flag=1";
	$result1=mysql_query($sql1);
	while($r=mysql_fetch_array($result1))
	{
		?>
		<option value="<?=$r["id"]?>"><?=$r["type_name"]?></option>
		<?
	}
	?>
	</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>���ű���:</td>
	<td align=left><INPUT TYPE="text" NAME="title" size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>ѡ��rm��wmv�ļ�:</td>
	<td align=left><INPUT TYPE=file NAME="source" size=30>(�ļ�����Ҫ���������ַ�)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>��Ҫ����:</td>
	<td><textarea name=descr rows=15 cols=56></textarea></td>
</tr>

<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=select_flag><input type="submit" value="&nbsp;�ϴ�&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;����&nbsp;"></td>
</tr>
</table>
</form>