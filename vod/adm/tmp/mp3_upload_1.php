<!-- ���MP3����-1 -->
<script language="javascript">
function check()
{
	if(window.document.addmp3.mp3file.value=="")
	{
		alert("������ѡ���ļ�");
		document.addmp3.mp3file.focus();
		return false;
	}
	str=window.document.addmp3.mp3file.value;
	str=str.substring(str.lastIndexOf('\\')+1);
//		if(/[^\x00-\xff]/g.test(str))
		{
//			alert("�ļ������ܺ��к����ַ�");
//			document.addmp3.mp3file.focus();
//			return false;
		}
	if(/[\x27]/g.test(str))
	{
		alert("�ļ������ܺ��е�����");
		document.addmp3.mp3file.focus();
		return false;
	}
	return true;
}

</script>

<form ENCTYPE="multipart/form-data" method=post name=addmp3 action="mp3_upload_2.php" onsubmit="return check()">
<table align=center width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�����ϴ�MP3�ļ�</caption>
<tr bgcolor=white>
	<td align=right>�������ƣ�</td>
	<td><?=$singer_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right>ר�����ƣ�</td>
	<td><?=$album_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right>�������ƣ�</td>
	<td><?=$song_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right width="25%"><span style="color:red">*</span>ѡ���µ�MP3�ļ���</td>
	<td><input type=file name="mp3file" size=34></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type=hidden name=mp3_id value=<?=$mp3_id?>><input type=submit value="&nbsp;��&nbsp&nbsp��&nbsp;"></td>
</tr>
<tr bgcolor=white>
	<td colspan=2>ע��:ֻ�����������ϴ���ǰ���е�mp3�������ǰ����ȥ���ļ��Ǵ���ģ����߲��Ų��ˣ����������������</td>
</tr>
</table>
</form>
