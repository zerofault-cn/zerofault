<html>
<head>
<title>添加图片</title>
</head>
<script language="javascript">
	function Validator( a )
	{
		if( "" == a.flash_pic.value )
		{
			alert("请选择图片!");
			return(false);
		}
		if( "" == a.pic_name.value )
		{
			alert("图片名称不能为空!");
			a.pic_name.focus();
			return(false);
		}
		if( "" == a.pic_url.value )
		{
			alert("图片链接不能为空!");
			a.pic_url.focus();
			return(false);
		}
		return(true);

	}
</script>
<body>
<br>
<br>
<form action="main.php?do=flash_pic_do_add_new" name="subject_form" method="post" enctype='multipart/form-data' onSubmit="return Validator(this)">
	<input type="file" name="flash_pic">
	<br><br>
	<br>
	<br>
	<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
	<input type="hidden" name="flash_path" value="<?php
echo $_obj['flash_path'];
?>
">
	<input type="hidden" name="flash_id" value="<?php
echo $_obj['flash_id'];
?>
">
	<br><br>
	<center><input type="submit" name="submit" value="提交"></center>
</form>
</body>
</html>