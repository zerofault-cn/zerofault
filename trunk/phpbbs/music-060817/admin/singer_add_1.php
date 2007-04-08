<!-- 添加歌手信息-1 -->
<script language="javascript">
function check()
{
	if(window.document.form1.select_area.value!=1)
	{
		alert("您忘了选地区分类!");
		return false;
	}
	if(window.document.form1.select_chorus.value!=1)
	{
		alert("您忘了选演唱方式!");
		return false;
	}
	if(window.document.form1.singer_name.value=="")
	{
		alert("您忘了输入歌手名称!");
		document.form1.singer_name.focus();
		return false;
	}
	if(window.document.form1.singer_name_fc.value=="")
	{
		alert("您忘了输入歌手名称首字母!");
		document.form1.singer_name_fc.focus();
		return false;
	}
	if(window.document.form1.singer_photo.value!="")
	{
		photo_file=window.document.form1.singer_photo.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.png'&&photo_file_ext!='.PNG'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("只能上传jpg,gif,png或bmp格式的图片");
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
<caption>歌手资料录入(<span style="color:red">*</span>为必填)</caption>
<tr>
	<td><span style="color:red">*</span>歌手名:</td>
	<td><input type=text name="singer_name">&nbsp;&nbsp;&nbsp;&nbsp;歌手名首字母:<input name="singer_name_fc" size=1></td>
</tr>
<tr>
	<td><span style="color:red">*</span>分类方式:</td>
	<td><select name="singer_area_id" onchange="document.form1.select_area.value=1">
		<option value="">地区分类</option>
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
		<option value="">演唱方式</option>
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
	<td>上传照片:</td>
	<td><input type=file name="singer_photo" size=50></td>
</tr>
<tr>
	<td>歌手简介:</td>
	<td><textarea name="singer_intro" cols="60" rows="15">暂无</textarea></td>
</tr>
<tr>
	<td><input type="hidden" name="select_area">
	<input type="hidden" name="select_chorus">
	</td>
	<td><input type="submit"  name="submit1" value="&nbsp;提交&nbsp;"></td>
</tr>
</table>
</form>