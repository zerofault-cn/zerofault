<html>
<head>
<title>上传图片</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<script language="javascript">
function check()
{
	if(window.document.upload.pic.value!="")
	{
		photo_file=window.document.upload.pic.value;
		photo_file_ext=photo_file.substring(photo_file.lastIndexOf("."));
		if(photo_file_ext!='.jpg'&&photo_file_ext!='.JPG'&&photo_file_ext!='.gif'&&photo_file_ext!='.GIF'&&photo_file_ext!='.BMP'&&photo_file_ext!='.BMP')
		{
			alert("最好上传jpg,gif或bmp格式的图片");
			return false;
		}
		else
			return true;
	}
	else
	{
		alert("您没有选择文件");
		return false;
	}
}

</script>
<body bgcolor=#9ACD32>
<form name=upload method=POST action="pic_upload_2.php" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>给"<span style="color:blue"><?=$name?></span>"上传图片</caption>
<tr bgcolor=white>
	<td align=right>选择图片:</td>
	<td><INPUT TYPE=FILE NAME=pic SIZE=40></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center>
	<input type=hidden name=pic_type value="<?=$pic_type?>">
	<input type=hidden name=id value="<?=$id?>">
	<input type=submit value="&nbsp;上传&nbsp;">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消上传"></td>
</tr>
</table>
</form>
</body>
</html>