<!-- 添加歌手信息-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_area.value!=1)
	{
		alert("您忘了选地区分类!");
		return false;
	}
	if(window.document.add.select_chorus.value!=1)
	{
		alert("您忘了选演唱方式!");
		return false;
	}
	if(window.document.add.select_other.value!=1)
	{
		alert("您忘了选其他分类!");
		return false;
	}
	if(window.document.add.singer_name.value=="")
	{
		alert("您忘了输入歌手名称!");
		document.add.singer_name.focus();
		return false;
	}
	if(window.document.add.singer_name_fc.value=="")
	{
		alert("您忘了输入歌手名称首字母!");
		document.add.singer_name_fc.focus();
		return false;
	}
	if(window.document.add.photo.value!="")
	{
		photo_file=window.document.add.photo.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("最好上传jpg,gif或bmp格式的图片");
			document.add.photo.focus();
			return false;
		}
	}
	return true;
}

</script>
<form name=add method=POST action="music_add_singer_2.php" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>歌手资料录入(<span style="color:red">*</span>为必填)</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>歌手名:</td>
	<td><input type=text name=singer_name>&nbsp;&nbsp;&nbsp;&nbsp;歌手名称首字母:<input name=singer_name_fc size=1></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>分类方式:</td>
	<td><select name=type_area_id onchange="document.add.select_area.value=1">
		<option value="">地区及组合</option>
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
		<option value="">演唱方式</option>
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
		<option value="">其他方式</option>
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
	<td align=right>上传照片:</td>
	<td><INPUT TYPE=FILE NAME=photo SIZE=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌手简介:</td>
	<td><textarea name=introduce cols=60 rows=15>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=select_area><input type=hidden name=select_chorus><input type=hidden name=select_other></td>
	<td><input type=submit value="&nbsp;提交&nbsp;" name=B2></td>
</tr>
</table>
</form>