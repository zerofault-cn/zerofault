<!-- 添加歌手信息-1 -->
<script language="javascript">
function check()
{
	if(window.document.form1.album_name.value=="")
	{
		alert("您忘了输入专辑名称!");
		document.form1.album_name.focus();
		return false;
	}
	if(window.document.form1.album_photo.value!="")
	{
		photo_file=window.document.form1.album_photo.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.png'&&photo_file_ext!='.PNG'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("只能上传jpg,gif,png或bmp格式的图片");
			document.form1.album_photo.focus();
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
<form name="form1" method="POST" action="album_add_2.php" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1>
<caption>添加专辑(<span style="color:red">*</span>为必填)</caption>
<tr>
	<td><span style="color:red">*</span>专辑名:</td>
	<td><input type=text name="album_name"></td>
</tr>
<tr>
	<td>专辑发布日期:</td>
	<td><input type=text name="album_pubdate" size=10></td>
</tr>
<tr>
	<td>专辑照片:</td>
	<td><input type=file name="album_photo" size=50></td>
</tr>
<tr>
	<td>专辑简介:</td>
	<td><textarea name="album_intro" cols="60" rows="15">暂无</textarea></td>
</tr>
<tr>
	<td><input type="hidden" name="singer_id" value="<?=$_REQUEST['singer_id']?>">
	</td>
	<td><input type="submit"  name="submit1" value="&nbsp;提交&nbsp;"></td>
</tr>
</table>
</form>