<!-- ��Ӹ�����Ϣ-1 -->
<script language="javascript">
function check()
{
	if(window.document.form1.select_area.value!=1)
	{
		alert("������ѡ��������!");
		return false;
	}
	if(window.document.form1.select_chorus.value!=1)
	{
		alert("������ѡ�ݳ���ʽ!");
		return false;
	}
	if(window.document.form1.singer_name.value=="")
	{
		alert("�����������������!");
		document.form1.singer_name.focus();
		return false;
	}
	if(window.document.form1.singer_name_fc.value=="")
	{
		alert("���������������������ĸ!");
		document.form1.singer_name_fc.focus();
		return false;
	}
	if(window.document.form1.singer_photo.value!="")
	{
		photo_file=window.document.form1.singer_photo.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.png'&&photo_file_ext!='.PNG'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("ֻ���ϴ�jpg,gif,png��bmp��ʽ��ͼƬ");
			document.form1.singer_photo.focus();
			return false;
		}
	}
	return true;
}

</script>
<style>
table
{
	background-color:#000000;
}
tr
{
	background-color:#ffffff;
}
</style>
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
?>
<form name="form1" method="POST" action="singer_add_2.php" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1>
<caption>��������¼��(<span style="color:red">*</span>Ϊ����)</caption>
<tr>
	<td><span style="color:red">*</span>������:</td>
	<td><input type=text name="singer_name">&nbsp;&nbsp;&nbsp;&nbsp;����������ĸ:<input name="singer_name_fc" size=1></td>
</tr>
<tr>
	<td><span style="color:red">*</span>���෽ʽ:</td>
	<td><select name="singer_area_id" onchange="document.form1.select_area.value=1">
		<option value="">��������</option>
		<option value="">----------</option>
		<?
		$sql1="select type_id,type_name from singer_type where type_label=1 order by type_id";
		$result1=$db->sql_query($sql1);
		while($r=$db->sql_fetchrow($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select>
		<select name="singer_chorus_id" onchange="document.form1.select_chorus.value=1">
		<option value="">�ݳ���ʽ</option>
		<option value="">--------</option>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=2 order by type_id";
		$result2=$db->sql_query($sql2);
		while($r=$db->sql_fetchrow($result2))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select>
		</td>
</tr>
<tr>
	<td>�ϴ���Ƭ:</td>
	<td><input type=file name="singer_photo" size=50></td>
</tr>
<tr>
	<td>���ּ��:</td>
	<td><textarea name="singer_intro" cols="60" rows="15">����</textarea></td>
</tr>
<tr>
	<td><input type="hidden" name="select_area">
	<input type="hidden" name="select_chorus">
	</td>
	<td><input type="submit"  name="submit1" value="&nbsp;�ύ&nbsp;"></td>
</tr>
</table>
</form>