<!-- ��ӵ�Ӱ��Ŀ-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("������ѡ�����");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("��������������");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_file.value=="")
	{
		alert("����������·��");
		document.add.prog_file.focus();
		return false;
	}
	str=window.document.add.prog_file.value;
	str=str.substring(str.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(str))
	{
		alert("�ļ������ܺ��к����ַ�");
		document.add.prog_file.focus();
		return false;
	}
	if(/[\x20]/g.test(str))
	{
		alert("�ļ������ܺ��пո�");
		document.add.prog_file.focus();
		return false;
	}
	return true;
}

</script>

<form action="vod_add_prog_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�����Ƶ�㲥��Ŀ(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>ѡ������:</td>
	<td><select name=prog_kindthr onchange="document.add.select_flag.value=1">
		<option value="">��ѡ��</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��ӰƬ��:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ���ļ�:</td>
	<td><input type=file name=prog_file size=30><span class=small>(�ļ������ܺ����ĺͿո�)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>�Ƿ�����:</td>
	<td><input type=radio name=zoom_flag value=1>����&nbsp;<input type=radio name=zoom_flag value=0 checked>������&nbsp;(����Ƶ�ֱ���Ϊ640*480ʱ,����Ҫ����,��������Ҫ)</td>
</tr>
<tr bgcolor=white>
	<td align=right>ӰƬ����:</td>
	<td><input type=radio name=quality value=1>��&nbsp;<input type=radio name=quality value=2 checked>��&nbsp;<input type=radio name=quality value=3>��<span class=small>(��:720*540;��:640*480;��:320*240)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input type=text name=prog_size value=0 size=5>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>����ʱ��:</td>
	<td><input type=text name=prog_timespan value=0></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input type=text name=pubdate value="0000-00-00"><span class=small>(������³����Ƭ��,����Ϊ���������)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input type=text name=director value="δ֪"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ҫ��Ա:</td>
	<td><input type=text name=prog_acot value="δ֪"></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ݼ��:</td>
	<td><textarea name=prog_describe rows=12 cols=60>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag></td>
	<td><input type=submit value=�ύ></td>
</tr>
</table>
</form>
