<!-- ������ֽ�Ŀ-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("������ѡ�����!");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("��������������!");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_path.value=="")
	{
		alert("����������·��!");
		document.add.prog_path.focus();
		return false;
	}
	str=window.document.add.prog_path.value;
	str=str.substring(str.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(str))
	{
		alert("�ļ������ܺ��к����ַ�");
		document.add.prog_path.focus();
		return false;
	}
	if(/[\x20]/g.test(str))
	{
		alert("�ļ������ܺ��пո�");
		document.add.prog_path.focus();
		return false;
	}
	return true;
}

</script>

<form action="music_add_prog_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>��Ӹ���(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>ѡ�����:</td>
	<td><select name=singer_id onchange="document.add.select_flag.value=1">
		<option value="">��ѡ��</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select singer_id,singer_name from singer_info order by type_other_id desc,binary singer_name";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select><span class=small>(��ʾ:�������ȷ������,����ѡ�����Ӧ������)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ���ļ�:</td>
	<td><input type=file name=prog_path size=30><span class=small>(�ļ������ܰ�������)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>�Ƿ�����:</td>
	<td><input type=radio name=zoom_falg value=1 checked>����&nbsp;<input type=radio name=zoom_falg value=0>������&nbsp;(����Ƶ�ֱ���Ϊ640*480ʱ,����Ҫ����,��������Ҫ)</td>
</tr>
<tr bgcolor=white>
	<td align=right>ӰƬ����:</td>
	<td><input type=radio name=quality value=1>��&nbsp;<input type=radio name=quality value=2 checked>��&nbsp;<input type=radio name=quality value=3>��<span class=small>(��:720*540;��:640*480;��:320*240)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input type=text name=prog_size value=0 size=3>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input type=text name=pubdate value="0000-00-00"></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag><input type=hidden name=prog_describe value=""></td>
	<td><input type=submit value=�ύ></td>
</tr>
</table>
</form>
