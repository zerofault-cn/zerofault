<!-- ��Ӹ�����Ϣ-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_area.value!=1)
	{
		alert("������ѡ��������!");
		return false;
	}
	if(window.document.add.select_chorus.value!=1)
	{
		alert("������ѡ�ݳ���ʽ!");
		return false;
	}
	if(window.document.add.select_other.value!=1)
	{
		alert("������ѡ��������!");
		return false;
	}
	if(window.document.add.singer_name.value=="")
	{
		alert("�����������������!");
		document.add.singer_name.focus();
		return false;
	}
	if(window.document.add.singer_name_fc.value=="")
	{
		alert("���������������������ĸ!");
		document.add.singer_name_fc.focus();
		return false;
	}
	if(window.document.add.photo.value!="")
	{
		photo_file=window.document.add.photo.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("����ϴ�jpg,gif��bmp��ʽ��ͼƬ");
			document.add.photo.focus();
			return false;
		}
	}
	return true;
}

</script>
<form name=add method=POST action="music_add_singer_2.php" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>��������¼��(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>������:</td>
	<td><input type=text name=singer_name>&nbsp;&nbsp;&nbsp;&nbsp;������������ĸ:<input name=singer_name_fc size=1></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>���෽ʽ:</td>
	<td><select name=type_area_id onchange="document.add.select_area.value=1">
		<option value="">���������</option>
		<option value="">----------</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select type_id,type_name from singer_type where type_label=1 order by type_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select>
		<select name=type_chorus_id onchange="document.add.select_chorus.value=1">
		<option value="">�ݳ���ʽ</option>
		<option value="">--------</option>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=2 order by type_id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select>
		<select name=type_other_id onchange="document.add.select_other.value=1">
		<option value="">������ʽ</option>
		<option value="">--------</option>
		<?
		$sql3="select type_id,type_name from singer_type where type_label=5 order by type_id";
		$result3=mysql_query($sql3);
		while($r=mysql_fetch_array($result3))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ϴ���Ƭ:</td>
	<td><INPUT TYPE=FILE NAME=photo SIZE=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ּ��:</td>
	<td><textarea name=introduce cols=60 rows=15>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=select_area><input type=hidden name=select_chorus><input type=hidden name=select_other></td>
	<td><input type=submit value="&nbsp;�ύ&nbsp;" name=B2></td>
</tr>
</table>
</form>